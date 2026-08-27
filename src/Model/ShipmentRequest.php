<?php
/**
 * See LICENSE.md for license details.
 */

namespace Dhl\Express\Model;

use Dhl\Express\Api\Data\Request\InsuranceInterface;
use Dhl\Express\Api\Data\Request\PackageInterface;
use Dhl\Express\Api\Data\Request\RecipientInterface;
use Dhl\Express\Api\Data\Request\Shipment\BuyerInterface;
use Dhl\Express\Api\Data\Request\Shipment\DangerousGoods\DryIceInterface;
use Dhl\Express\Api\Data\Request\Shipment\LabelOptionsInterface;
use Dhl\Express\Api\Data\Request\Shipment\ShipmentDetailsInterface;
use Dhl\Express\Api\Data\Request\Shipment\ShipperInterface;
use Dhl\Express\Api\Data\ShipmentRequestInterface;
use Dhl\Express\Model\Request\Recipient;
use Dhl\Express\Model\Request\Shipment\Broker;
use Dhl\Express\Model\Request\Shipment\Buyer;
use Dhl\Express\Model\Request\Shipment\Shipper;
use Dhl\Express\Webservice\Soap\Type\Common\SpecialServices;
use Dhl\Express\Webservice\Soap\Type\ShipmentRequest\InternationalDetail\ExportDeclaration\ExportDeclaration;

/**
 * Shipment Request.
 *
 * @author Ronny Gertler <ronny.gertler@netresearch.de>
 * @link   https://www.netresearch.de/
 */
class ShipmentRequest implements ShipmentRequestInterface
{
    /**
     * @var ShipmentDetailsInterface
     */
    private $shipmentDetails;

    /**
     * @var string
     */
    private $payerAccountNumber;

    /**
     * @var Shipper
     */
    private $shipper;

    /**
     * @var Recipient
     */
    private $recipient;

    /**
     * @var Buyer
     */
    private $buyer;

    /**
     * @var Broker
     */
    private $broker;

    /**
     * @var PackageInterface[]
     */
    private $packages;

    /**
     * @var null|string
     */
    private $billingAccountNumber;

    /**
     * @var null|string
     */
    private $dutyAndTaxPayerAccountNumber;

    /**
     * @var null|InsuranceInterface
     */
    private $insurance;

    /**
     * @var null|DryIceInterface
     */
    private $dryIce;

    /**
     * @var null|LabelOptionsInterface
     */
    private $labelOptions;

    /**
     * @var SpecialServices[}
     */
    private $specialServices = [];

    /**
     * @var ExportDeclaration
     */
    private $exportDeclaration;

    /**
     * SoapShipmentRequest constructor.
     *
     * @param ShipmentDetailsInterface $shipmentDetails
     * @param string $payerAccountNumber
     * @param Shipper $shipper
     * @param Recipient $recipient
     * @param PackageInterface[] $packages
     */
    public function __construct(
        ShipmentDetailsInterface $shipmentDetails,
        string $payerAccountNumber,
        ShipperInterface $shipper,
        RecipientInterface $recipient,
        array $packages,
        Buyer $buyer = null,
        Broker $broker = null
    )
    {
        $this->shipmentDetails = $shipmentDetails;
        $this->payerAccountNumber = $payerAccountNumber;
        $this->shipper = $shipper;
        $this->recipient = $recipient;
        $this->buyer = $buyer;
        $this->broker = $broker;
        $this->packages = $packages;
    }

    public function getShipmentDetails(): ShipmentDetailsInterface
    {
        return $this->shipmentDetails;
    }

    public function getPayerAccountNumber(): string
    {
        return (string)$this->payerAccountNumber;
    }

    public function getShipper(): ShipperInterface
    {
        return $this->shipper;
    }

    public function getRecipient(): RecipientInterface
    {
        return $this->recipient;
    }

    public function getBuyer(): ?BuyerInterface
    {
        return $this->buyer;
    }

    public function getBroker(): ?Broker
    {
        return $this->broker;
    }

    public function getPackages(): array
    {
        return $this->packages;
    }

    public function getBillingAccountNumber(): string
    {
        return (string)$this->billingAccountNumber;
    }

    public function getDutyAndTaxPayerAccountNumber(): string
    {
        return (string)$this->dutyAndTaxPayerAccountNumber;
    }

    public function getInsurance(): ?InsuranceInterface
    {
        return $this->insurance;
    }

    public function getDryIce(): ?DryIceInterface
    {
        return $this->dryIce;
    }

    public function getLabelOptions(): ?LabelOptionsInterface
    {
        return $this->labelOptions;
    }

    /**
     * Sets the billing account number.
     *
     * @param string $billingAccountNumber The billing account number
     *
     * @return ShipmentRequest
     */
    public function setBillingAccountNumber(string $billingAccountNumber): ShipmentRequestInterface
    {
        $this->billingAccountNumber = $billingAccountNumber;

        return $this;
    }

    /**
     * Sets the duty and tax payer account number.
     *
     * @param string $dutyAndTaxPayerAccountNumber The duty and tax payer account number
     *
     * @return ShipmentRequest
     */
    public function setDutyAndTaxPayerAccountNumber(string $dutyAndTaxPayerAccountNumber): ShipmentRequestInterface
    {
        $this->dutyAndTaxPayerAccountNumber = $dutyAndTaxPayerAccountNumber;

        return $this;
    }

    /**
     * Sets the insurance instance.
     *
     * @param InsuranceInterface $insurance The insurance instance
     *
     * @return ShipmentRequest
     */
    public function setInsurance(InsuranceInterface $insurance): ShipmentRequestInterface
    {
        $this->insurance = $insurance;

        return $this;
    }

    /**
     * Sets the dry ice instance.
     *
     * @param DryIceInterface $dryIce The dry ice instance
     *
     * @return ShipmentRequest
     */
    public function setDryIce(DryIceInterface $dryIce): ShipmentRequestInterface
    {
        $this->dryIce = $dryIce;

        return $this;
    }

    /**
     * Sets the label options instance.
     *
     * @param LabelOptionsInterface $labelOptions The label options instance
     *
     * @return ShipmentRequest
     */
    public function setLabelOptions(LabelOptionsInterface $labelOptions): ShipmentRequestInterface
    {
        $this->labelOptions = $labelOptions;

        return $this;
    }

    /**
     * @return SpecialServices\Service[]
     */
    public function getSpecialServices(): array
    {
        return $this->specialServices;
    }

    /**
     * @return SpecialServices\Service[]
     */
    public function setSpecialServices(array $services): ShipmentRequestInterface
    {
        $this->specialServices = $services;

        return $this;
    }

    public function getExportDeclaration(): ?ExportDeclaration
    {
        return $this->exportDeclaration;
    }

    public function setExportDeclaration(ExportDeclaration $exportDeclaration)
    {
        $this->exportDeclaration = $exportDeclaration;

        return $this;
    }
}
