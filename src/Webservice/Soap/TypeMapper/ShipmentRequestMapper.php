<?php
/**
 * See LICENSE.md for license details.
 */

namespace Dhl\Express\Webservice\Soap\TypeMapper;

use Dhl\Express\Api\Data\Request\PackageInterface;
use Dhl\Express\Api\Data\Request\Shipment\LabelOptionsInterface;
use Dhl\Express\Api\Data\ShipmentRequestInterface;
use Dhl\Express\Model\Request\Package;
use Dhl\Express\Model\Request\Shipment\ShipmentDetails;
use Dhl\Express\Webservice\Soap\Type\Common\Billing;
use Dhl\Express\Webservice\Soap\Type\Common\Packages\RequestedPackages\Dimensions;
use Dhl\Express\Webservice\Soap\Type\Common\SpecialServices;
use Dhl\Express\Webservice\Soap\Type\Common\SpecialServices\Service;
use Dhl\Express\Webservice\Soap\Type\Common\UnitOfMeasurement;
use Dhl\Express\Webservice\Soap\Type\ShipmentRequest\DangerousGoods;
use Dhl\Express\Webservice\Soap\Type\ShipmentRequest\DangerousGoods\Content;
use Dhl\Express\Webservice\Soap\Type\ShipmentRequest\DocumentImages\DocumentImage;
use Dhl\Express\Webservice\Soap\Type\ShipmentRequest\InternationalDetail;
use Dhl\Express\Webservice\Soap\Type\ShipmentRequest\LabelOptions;
use Dhl\Express\Webservice\Soap\Type\ShipmentRequest\Packages;
use Dhl\Express\Webservice\Soap\Type\ShipmentRequest\Packages\RequestedPackages;
use Dhl\Express\Webservice\Soap\Type\ShipmentRequest\RequestedShipment;
use Dhl\Express\Webservice\Soap\Type\ShipmentRequest\Ship;
use Dhl\Express\Webservice\Soap\Type\ShipmentRequest\Ship\Address;
use Dhl\Express\Webservice\Soap\Type\ShipmentRequest\ShipmentInfo;
use Dhl\Express\Webservice\Soap\Type\SoapShipmentRequest;

/**
 * Shipment Request Mapper.
 *
 * Transform the shipment request object into SOAP types suitable for API communication.
 *
 * @author Ronny Gertler <ronny.gertler@netresearch.de>
 * @link   https://www.netresearch.de/
 */
class ShipmentRequestMapper
{
    /**
     * @param ShipmentRequestInterface $request
     *
     * @return SoapShipmentRequest
     * @throws \Exception
     */
    public function map(ShipmentRequestInterface $request)
    {
        $this->checkConsistentUOM($request->getPackages());

        // Since we checked that all packages use the same UOMs, we can just take them from any package
        $weightUOM = $request->getPackages()[0]->getWeightUOM();
        $dimensionsUOM = $request->getPackages()[0]->getDimensionsUOM();

        // Create shipment info
        $shipmentInfo = new ShipmentInfo(
            $this->getDropOfTypeFromShipDetails(
                $request->getShipmentDetails()->isUnscheduledPickup()
            ),
            $request->getShipmentDetails()->getServiceType(),
            $request->getShipmentDetails()->getCurrencyCode(),
            $this->mapUOM($weightUOM, $dimensionsUOM)
        );

        if (!empty($request->getShipmentDetails()->getSpecialShipmentInstructions())) {
            $shipmentInfo->setSpecialPickupInstructions($request->getShipmentDetails()->getSpecialShipmentInstructions());
        }

        if (!empty($request->getShipmentDetails()->getPaperlessEncodedStringDocument())) {
            $shipmentInfo->setPaperlessTradeEnabled(true);
            $shipmentInfo->setPaperlessTradeImage($request->getShipmentDetails()->getPaperlessEncodedStringDocument());
        }

        if (!empty($request->getShipmentDetails()->getTransportDocumentImageEncodedString())) {
            $shipmentInfo->setDocumentImages(
                new DocumentImage(
                    $request->getShipmentDetails()->getTransportDocumentImageEncodedString(),
                    $request->getShipmentDetails()->getTransportDocumentImageFormat(),
                    $request->getShipmentDetails()->getTransportDocumentImageType()
                )
            );
        }

        $buyerContactInfo = null;
        if ($request->getBuyer()) {
            $buyerContactInfo = new Ship\BuyerContactInfo(
                new Ship\Contact(
                    $request->getBuyer()->getName(),
                    $request->getBuyer()->getCompany(),
                    $request->getBuyer()->getPhone()
                ),
                new Ship\BuyerAddress(
                    $request->getBuyer()->getStreetLines()[0],
                    $request->getBuyer()->getCity(),
                    $request->getBuyer()->getPostalCode(),
                    $request->getBuyer()->getCountryCode()
                )
            );
        }

        $recipientContactInfo = new Ship\ContactInfo(
            new Ship\Contact(
                $request->getRecipient()->getName(),
                $request->getRecipient()->getCompany(),
                $request->getRecipient()->getPhone()
            ),
            new Address(
                $request->getRecipient()->getStreetLines()[0],
                $request->getRecipient()->getCity(),
                $request->getRecipient()->getPostalCode(),
                $request->getRecipient()->getCountryCode()
            ),
            $request->getRecipient()->getRegistrationNumbers()
        );

        $shipperContactInfo = new Ship\ContactInfo(
            new Ship\Contact(
                $request->getShipper()->getName(),
                $request->getShipper()->getCompany(),
                $request->getShipper()->getPhone()
            ),
            new Address(
                $request->getShipper()->getStreetLines()[0],
                $request->getShipper()->getCity(),
                $request->getShipper()->getPostalCode(),
                $request->getShipper()->getCountryCode()
            ),
            $request->getShipper()->getRegistrationNumbers()
        );

        $commodities = new InternationalDetail\Commodities(
            $request->getShipmentDetails()->getDescription()
        );

        $commodities->setNumberOfPieces($request->getShipmentDetails()->getNumberOfPieces());
        $commodities->setCustomsValue($request->getShipmentDetails()->getCustomsValue());

        // Create shipment
        $requestedShipment = new RequestedShipment(
            $shipmentInfo,
            $request->getShipmentDetails()->getReadyAtTimestamp(),
            $request->getShipmentDetails()->getTermsOfTrade(),
            new InternationalDetail(
                $commodities,
                $request->getExportDeclaration()
            ),
            new Ship(
                $shipperContactInfo,
                $recipientContactInfo,
                $buyerContactInfo
            ),
            new Packages(
                $this->mapPackages($request->getPackages())
            )
        );

        $shipperStreetLines = $request->getShipper()->getStreetLines();
        if ((count($shipperStreetLines) > 1) && !empty($shipperStreetLines[1])) {
            $requestedShipment->getShip()->getShipper()->getAddress()->setStreetLines2($shipperStreetLines[1]);
        }

        if ((count($shipperStreetLines) > 2) && !empty($shipperStreetLines[2])) {
            $requestedShipment->getShip()->getShipper()->getAddress()->setStreetLines3($shipperStreetLines[2]);
        }

        $shipperEmail = $request->getShipper()->getEmail();
        if (!empty($shipperEmail)) {
            $requestedShipment->getShip()->getShipper()->getContact()->setEmailAddress($shipperEmail);
        }

        $recipientStreetLines = $request->getRecipient()->getStreetLines();
        if ((count($recipientStreetLines) > 1) && !empty($recipientStreetLines[1])) {
            $requestedShipment->getShip()->getRecipient()->getAddress()->setStreetLines2($recipientStreetLines[1]);
        }

        if ((count($recipientStreetLines) > 2) && !empty($recipientStreetLines[2])) {
            $requestedShipment->getShip()->getRecipient()->getAddress()->setStreetLines3($recipientStreetLines[2]);
        }

        $recipientEmail = $request->getRecipient()->getEmail();
        if (!empty($recipientEmail)) {
            $requestedShipment->getShip()->getRecipient()->getContact()->setEmailAddress($recipientEmail);
        }

        $shippingPaymentType = $request->getBillingAccountNumber()
            ? Billing\ShippingPaymentType::R
            : Billing\ShippingPaymentType::S;

        $requestedShipment->getShipmentInfo()->setBilling(
            new Billing(
                $request->getPayerAccountNumber(),
                $shippingPaymentType,
                $request->getBillingAccountNumber()
            )
        );

        $requestedShipment->getInternationalDetail()->setContent(
            $request->getShipmentDetails()->getContentType()
        );

        // initialize with existing special services
        $specialServicesList = $request->getSpecialServices();
        if ($insurance = $request->getInsurance()) {
            $insuranceService = new Service(SpecialServices\ServiceType::TYPE_INSURANCE);
            $insuranceService->setServiceValue($insurance->getValue());
            $insuranceService->setCurrencyCode($insurance->getCurrencyCode());
            $specialServicesList[] = $insuranceService;
        }

        if ($shipmentInfo->getPaperlessTradeEnabled()) {
            $paperlessTradeService = new Service(SpecialServices\ServiceType::TYPE_PLT);
            $specialServicesList[] = $paperlessTradeService;
        }

        if (!empty($specialServicesList)) {
            $specialServices = new SpecialServices($specialServicesList);
            $requestedShipment->getShipmentInfo()->setSpecialServices($specialServices);
        }

        // Create dangerous goods
        if ($dryIce = $request->getDryIce()) {
            $requestedShipment->setDangerousGoods(
                new DangerousGoods(
                    new Content(
                        $dryIce->getContentId(),
                        number_format($dryIce->getWeight(), 2),
                        $dryIce->getUNCode()
                    )
                )
            );
        }

        // Add waybill document option
        $labelOptionsData = $request->getLabelOptions();
        if ($labelOptionsData instanceof LabelOptionsInterface) {

            $labelOptions = new LabelOptions();
            $labelOptions->setRequestWaybillDocument(
                new LabelOptions\RequestWaybillDocument($labelOptionsData->isWaybillDocumentRequested())
            );

            if ($labelOptionsData->isDHLCustomsInvoiceRequested()) {
                $labelOptions->setRequestDHLCustomsInvoice(
                    new LabelOptions\RequestDHLCustomsInvoice($labelOptionsData->isDHLCustomsInvoiceRequested()),
                    new LabelOptions\DhlCustomsInvoiceType($labelOptionsData->getDHLCustomsInvoiceType()),
                    new LabelOptions\DHLCustomsInvoiceLanguageCode($labelOptionsData->getDHLCustomsInvoiceLanguageCode())
                );
            }

            $labelOptions->setRequestBarcodeInfo(new LabelOptions\RequestBarcodeInfo($labelOptionsData->isBarcodeInfoRequested()));
            $labelOptions->setRequestDHLLogoOnLabel(new LabelOptions\RequestDHLLogoOnLabel($labelOptionsData->isDHLLogoOnLabelRequested()));
            $labelOptions->setDhlCustomsInvoiceLanguageCode(new LabelOptions\DHLCustomsInvoiceLanguageCode($labelOptionsData->getDhlCustomsInvoiceLanguageCode()));
            $labelOptions->setRequestShipmentReceipt(new LabelOptions\RequestShipmentReceipt($labelOptionsData->isShipmentReceiptRequested()));

            if (!empty($labelOptionsData->getCustomerLogo())) {
                $labelOptions->setCustomerLogo(new LabelOptions\CustomerLogo($labelOptionsData->getCustomerLogo(), $labelOptionsData->getCustomerLogoFormat()));
            }

            if ($labelOptionsData->getLabelType()) {
                $shipmentInfo->setLabelType($labelOptionsData->getLabelType());
            }

            $requestedShipment->getShipmentInfo()->setLabelOptions($labelOptions);
        }

        return new SoapShipmentRequest($requestedShipment);
    }

    /**
     * @param PackageInterface[] $packages
     *
     * @return RequestedPackages[]
     */
    private function mapPackages(array $packages)
    {
        $requestedPackages = [];

        foreach ($packages as $package) {
            $requestedPackages[] = new RequestedPackages(
                $package->getWeight(),
                new Dimensions(
                    $package->getLength(),
                    $package->getWidth(),
                    $package->getHeight()
                ),
                $package->getCustomerReferences(),
                $package->getSequenceNumber()
            );
        }

        return $requestedPackages;
    }

    /**
     * Returns whether the pickup is a scheduled one or not.
     *
     * @param bool $isUnscheduledPickup Whether the pickup is a scheduled one or not
     *
     * @return string
     */
    public function getDropOfTypeFromShipDetails($isUnscheduledPickup)
    {
        if ($isUnscheduledPickup) {
            return ShipmentDetails::UNSCHEDULED_PICKUP;
        }

        return ShipmentDetails::REGULAR_PICKUP;
    }

    /**
     * Check if all packages have the same units of measurement (UOM) for weight and dimensions.
     *
     * @param PackageInterface[] $packages The list of packages
     *
     * @return void
     * @throws \InvalidArgumentException
     */
    private function checkConsistentUOM(array $packages)
    {
        $weightUom = null;
        $dimensionsUOM = null;

        /** @var PackageInterface $package */
        foreach ($packages as $package) {
            if (!$weightUom) {
                $weightUom = $package->getWeightUOM();
            }

            if (!$dimensionsUOM) {
                $dimensionsUOM = $package->getDimensionsUOM();
            }

            if ($weightUom !== $package->getWeightUOM()) {
                throw new \InvalidArgumentException(
                    'All packages weights must have a consistent unit of measurement.'
                );
            }

            if ($dimensionsUOM !== $package->getDimensionsUOM()) {
                throw new \InvalidArgumentException(
                    'All packages dimensions must have a consistent unit of measurement.'
                );
            }
        }
    }

    /**
     * Maps the magento unit of measurement to the DHL express unit of measurement.
     *
     * @param string $weightUOM The unit of measurement for weight
     * @param string $dimensionsUOM The unit of measurement for dimensions
     *
     * @return string
     */
    private function mapUOM($weightUOM, $dimensionsUOM)
    {
        if (($weightUOM === Package::UOM_WEIGHT_KG) && ($dimensionsUOM === Package::UOM_DIMENSION_CM)) {
            return UnitOfMeasurement::SI;
        }

        if (($weightUOM === Package::UOM_WEIGHT_LB) && ($dimensionsUOM === Package::UOM_DIMENSION_IN)) {
            return UnitOfMeasurement::SU;
        }

        throw new \InvalidArgumentException(
            'All units of measurement have to be consistent (either metric system or US system).'
        );
    }
}
