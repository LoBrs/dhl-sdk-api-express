<?php
/**
 * See LICENSE.md for license details.
 */

namespace Dhl\Express\Webservice\Soap\Type\ShipmentRequest\InternationalDetail\ExportDeclaration;

use Dhl\Express\Api\Data\Request\ExportDeclarationInterface;
use Dhl\Express\Webservice\Soap\Type\ShipmentRequest\InternationalDetail\ExportDeclaration\ExportLineItems\ExportLineItem;

/**
 *
 */
class ExportDeclaration implements ExportDeclarationInterface
{
    /** @var string Destination port details */
    private $DestinationPort;

    /** @var string Exporter Code */
    private $ExporterCode;

    /** @var string Exporter ID */
    private $ExporterID;

    /** @var string ExportLicense */
    private $ExporterLicense;

    /** @var ExportLineItems Specifics about each of the export line item */
    private $ExportLineItems;

    /** @var string Export Reason */
    private $ExportReason;

    /** @var string Consignee import license */
    private $ImportReason;

    /**
     * @var string The date component must be in the format: YYYY-MM-DD.
     * This field is mandatory when RequestCommercialInvoice = Y
     */
    private $InvoiceDate;

    /** @var string Invoice number.
     * This field is mandatory when RequestCommercialInvoice = Y.
     */
    private $InvoiceNumber;

    /** @var string Additional Declaration text in invoice */
    private $InvoiceDeclarationTexts;

    /** @var InvoiceSignatureDetails Additional Declaration text in invoice */
    private $InvoiceSignatureDetails;

    /** @var string Payer GST VAT details */
    private $PayerGSTVAT;

    /** @var string Recipient reference */
    private $RecipientReference;

    /** @var string Customs Invoice Remarks */
    private $Remarks;

    /** @var string Terms of payment */
    private $TermsOfPayment;

    public function __construct(array $exportDeclarationItems = []) {

        $this->setExportLineItems($exportDeclarationItems);
    }

    /**
     * @return string
     */
    public function getDestinationPort(): string {
        return $this->DestinationPort;
    }

    /**
     * @param string $destinationPort
     * @return ExportDeclaration
     */
    public function setDestinationPort(string $destinationPort): ExportDeclaration {
        $this->DestinationPort = $destinationPort;
        return $this;
    }

    /**
     * @return string
     */
    public function getExporterCode(): string {
        return $this->ExporterCode;
    }

    /**
     * @param string $ExporterCode
     * @return ExportDeclaration
     */
    public function setExporterCode(string $ExporterCode): ExportDeclaration {
        $this->ExporterCode = $ExporterCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getExporterID(): string {
        return $this->ExporterID;
    }

    /**
     * @param string $ExporterID
     * @return ExportDeclaration
     */
    public function setExporterID(string $ExporterID): ExportDeclaration {
        $this->ExporterID = $ExporterID;
        return $this;
    }

    /**
     * @return string
     */
    public function getExporterLicense(): string {
        return $this->ExporterLicense;
    }

    /**
     * @param string $ExporterLicence
     * @return ExportDeclaration
     */
    public function setExporterLicence(string $ExporterLicence): ExportDeclaration {
        $this->ExporterLicense = $ExporterLicence;
        return $this;
    }

    /**
     * @return ExportLineItems
     */
    public function getExportLineItems(): ExportLineItems
    {
        return $this->ExportLineItems;
    }

    /**
     * @param ExportLineItem[] $exportLineItems
     * @return ExportDeclaration
     */
    public function setExportLineItems(array $exportLineItems): ExportDeclaration {
        $wrappedItems = [];

        foreach ($exportLineItems as $item) {
            $wrappedItems[] = new \SoapVar($item, SOAP_ENC_OBJECT, null, null, 'ExportLineItem');
        }

        $this->ExportLineItems = new \SoapVar(
            $wrappedItems,
            SOAP_ENC_OBJECT,
            null,
            null,
            'ExportLineItems'
        );

        return $this;
    }

    /**
     * @param string $number
     * @param string $description
     * @param float $unitPrice
     * @param float $netWeight
     * @param float $grossWeight
     * @param int $quantity
     * @param string $quantityUOM
     * @return $this
     */
    public function addExportLineItem(
        string $number,
        string $description,
        float $unitPrice,
        float $netWeight,
        float $grossWeight,
        int $quantity,
        string $quantityUOM
    ): ExportDeclaration {
        $item = new ExportLineItem($number, $description, $unitPrice, $netWeight, $grossWeight, $quantity, $quantityUOM);
        $this->ExportLineItems->addExportLine($item);
        return $this;
    }

    /**
     * @return string
     */
    public function getExportReason(): string {
        return $this->ExportReason;
    }

    /**
     * @param string $ExportReason
     * @return ExportDeclaration
     */
    public function setExportReason(string $ExportReason): ExportDeclaration {
        $this->ExportReason = $ExportReason;
        return $this;
    }

    /**
     * @return string
     */
    public function getImportReason(): string {
        return $this->ImportReason;
    }

    /**
     * @param string $ImportReason
     * @return ExportDeclaration
     */
    public function setImportReason(string $ImportReason): ExportDeclaration {
        $this->ImportReason = $ImportReason;
        return $this;
    }

    /**
     * @return string
     */
    public function getInvoiceDate(): string {
        return $this->InvoiceDate;
    }

    /**
     * @param string $InvoiceDate
     * @return ExportDeclaration
     */
    public function setInvoiceDate(string $InvoiceDate): ExportDeclaration {
        $this->InvoiceDate = $InvoiceDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getInvoiceNumber(): string {
        return $this->InvoiceNumber;
    }

    /**
     * @param string $InvoiceNumber
     * @return ExportDeclaration
     */
    public function setInvoiceNumber(string $InvoiceNumber): ExportDeclaration {
        $this->InvoiceNumber = $InvoiceNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getInvoiceDeclarationTexts(): string {
        return $this->InvoiceDeclarationTexts;
    }

    /**
     * @param string $InvoiceDeclarationTexts
     * @return ExportDeclaration
     */
    public function setInvoiceDeclarationTexts(string $InvoiceDeclarationTexts): ExportDeclaration {
        $this->InvoiceDeclarationTexts = $InvoiceDeclarationTexts;
        return $this;
    }

    /**
     * @return InvoiceSignatureDetails
     */
    public function getInvoiceSignatureDetails(): InvoiceSignatureDetails {
        return $this->InvoiceSignatureDetails;
    }

    /**
     * @param InvoiceSignatureDetails $InvoiceSignatureDetails
     * @return ExportDeclaration
     */
    public function setInvoiceSignatureDetails(InvoiceSignatureDetails $InvoiceSignatureDetails): ExportDeclaration {
        $this->InvoiceSignatureDetails = $InvoiceSignatureDetails;
        return $this;
    }

    /**
     * @return string
     */
    public function getPayerGSTVAT(): string {
        return $this->PayerGSTVAT;
    }

    /**
     * @param string $payerGSTVAT
     * @return ExportDeclaration
     */
    public function setPayerGSTVAT(string $payerGSTVAT): ExportDeclaration {
        $this->PayerGSTVAT = $payerGSTVAT;
        return $this;
    }

    /**
     * @return string
     */
    public function getRecipientReference(): string {
        return $this->RecipientReference;
    }

    /**
     * @param string $recipientReference
     * @return ExportDeclaration
     */
    public function setRecipientReference(string $recipientReference): ExportDeclaration {
        $this->RecipientReference = $recipientReference;
        return $this;
    }

    /**
     * @return string
     */
    public function getRemarks(): string {
        return $this->Remarks;
    }

    /**
     * @param string $remarks
     * @return ExportDeclaration
     */
    public function setRemarks(string $remarks): ExportDeclaration {
        $this->Remarks = new Remarks($remarks);
        return $this;
    }

    /**
     * @return string
     */
    public function getTermsOfPayment(): string {
        return $this->TermsOfPayment;
    }

    /**
     * @param string $termsOfPayment
     * @return ExportDeclaration
     */
    public function setTermsOfPayment(string $termsOfPayment): ExportDeclaration {
        $this->TermsOfPayment = $termsOfPayment;
        return $this;
    }

}
