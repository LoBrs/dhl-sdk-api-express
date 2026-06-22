<?php

namespace Dhl\Express\Webservice\Soap\Type\ShipmentRequest\InternationalDetail\ExportDeclaration\ExportLineItems;

use Dhl\Express\Webservice\Soap\Type\Common\CurrencyCode;
use Dhl\Express\Webservice\Soap\Type\ShipmentRequest\InternationalDetail\ExportDeclaration\RequestTaxesPaid;

class ExportLineItem
{
    const UOM_QUANTITY_UOM = 'UOM';
    const UOM_QUANTITY_PCS = 'PCS';
    const UOM_QUANTITY_BOX = 'BOX';
    const UOM_QUANTITY_2GM = '2GM';
    const UOM_QUANTITY_2M = '2M';
    const UOM_QUANTITY_2M3 = '2M3';
    const UOM_QUANTITY_3M3 = '3M3';
    const UOM_QUANTITY_M3 = 'M3';
    const UOM_QUANTITY_DPR = 'DPR';
    const UOM_QUANTITY_DOZ = 'DOZ';
    const UOM_QUANTITY_2NO = '2NO';
    const UOM_QUANTITY_GM = 'GM';
    const UOM_QUANTITY_GRS = 'GRS';
    const UOM_QUANTITY_KG = 'KG';
    const UOM_QUANTITY_L = 'L';
    const UOM_QUANTITY_M = 'M';
    const UOM_QUANTITY_3GM = '3GM';
    const UOM_QUANTITY_3L = '3L';
    const UOM_QUANTITY_X = 'X';
    const UOM_QUANTITY_NO = 'NO';
    const UOM_QUANTITY_2KG = '2KG';
    const UOM_QUANTITY_PRS = 'PRS';
    const UOM_QUANTITY_2L = '2L';
    const UOM_QUANTITY_3KG = '3KG';
    const UOM_QUANTITY_CM2 = 'CM2';
    const UOM_QUANTITY_2M2 = '2M2';
    const UOM_QUANTITY_3M2 = '3M2';
    const UOM_QUANTITY_M2 = 'M2';
    const UOM_QUANTITY_4M2 = '4M2';
    const UOM_QUANTITY_3M = '3M';
    const UOM_QUANTITY_CM = 'CM';
    const UOM_QUANTITY_CONE = 'CONE';
    const UOM_QUANTITY_CT = 'CT';
    const UOM_QUANTITY_EA = 'EA';
    const UOM_QUANTITY_LBS = 'LBS';
    const UOM_QUANTITY_RILL = 'RILL';
    const UOM_QUANTITY_ROLL = 'ROLL';
    const UOM_QUANTITY_SET = 'SET';
    const UOM_QUANTITY_TU = 'TU';
    const UOM_QUANTITY_YDS = 'YDS';

    const REASON_TYPE_PERMANENT = 'PERMANENT';
    const REASON_TYPE_TEMPORARY = 'TEMPORARY';
    const REASON_TYPE_RETURN = 'RETURN';

    /** @var string Commodity code for the shipment at item line level */
    private $CommodityCode;

    /** @var string ECCN (Export Control Classification Number) info */
    private $ECCN;

    /** @var string Export reason code (Permanent, Temporary, Return) */
    private $ExportReasonType;

    /** @var int Number of pieces of a particular line item */
    private $Quantity;

    /** @var string */
    private $QuantityUnitOfMeasurement;

    /** @var string Serial number for the items */
    private $ItemNumber = '';

    /** @var string */
    private $ItemDescription = '';

    /** @var float */
    private $UnitPrice;

    /** @var string */
    private $UnitPriceCurrencyCode = 'USD';

    /** @var float */
    private $NetWeight;

    /** @var float */
    private $GrossWeight;

    /** @var string Manufacturing ISO (2) country code */
    private $ManufacturingCountryCode;

    /** @var RequestTaxesPaid */
    private $TaxesPaid;

    public function __construct(
        string  $number,
        string  $description,
        float   $unitPrice,
        float   $netWeight,
        float   $grossWeight,
        int     $quantity,
        string  $quantityUOM = self::UOM_QUANTITY_PCS,
        string  $unitPriceCurrencyCode = 'EUR'
    )
    {
        $this->setItemNumber($number);
        $this->setItemDescription($description);
        $this->setUnitPrice($unitPrice);
        $this->setUnitPriceCurrencyCode($unitPriceCurrencyCode);
        $this->setNetWeight($netWeight);
        $this->setGrossWeight($grossWeight);
        $this->setQuantity($quantity);
        $this->setQuantityUnitOfMeasurement($quantityUOM);
    }

    /**
     * @return string
     */
    public function getCommodityCode(): string
    {
        return $this->CommodityCode;
    }

    /**
     * @param string $CommodityCode
     * @return ExportLineItem
     */
    public function setCommodityCode(string $CommodityCode): ExportLineItem
    {
        $this->CommodityCode = $CommodityCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getECCN(): string
    {
        return $this->ECCN;
    }

    /**
     * @param string $ECCN
     * @return ExportLineItem
     */
    public function setECCN(string $ECCN): ExportLineItem
    {
        $this->ECCN = $ECCN;
        return $this;
    }

    /**
     * @return string
     */
    public function getExportReasonType(): string
    {
        return $this->ExportReasonType;
    }

    /**
     * @param string $ExportReasonType
     * @return ExportLineItem
     */
    public function setExportReasonType(string $ExportReasonType): ExportLineItem
    {
        $this->ExportReasonType = $ExportReasonType;
        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->Quantity;
    }

    /**
     * @param int $Quantity
     * @return ExportLineItem
     */
    public function setQuantity(int $Quantity): ExportLineItem
    {
        $this->Quantity = $Quantity;
        return $this;
    }

    /**
     * @return string
     */
    public function getQuantityUnitOfMeasurement(): string
    {
        return $this->QuantityUnitOfMeasurement;
    }

    /**
     * @param string $QuantityUnitOfMeasurement
     * @return ExportLineItem
     */
    public function setQuantityUnitOfMeasurement(string $QuantityUnitOfMeasurement): ExportLineItem
    {
        $this->QuantityUnitOfMeasurement = $QuantityUnitOfMeasurement;
        return $this;
    }

    /**
     * @return string
     */
    public function getItemNumber(): string
    {
        return $this->ItemNumber;
    }

    /**
     * @param string $ItemNumber
     * @return ExportLineItem
     */
    public function setItemNumber(string $ItemNumber): ExportLineItem
    {
        $this->ItemNumber = $ItemNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getItemDescription(): string
    {
        return $this->ItemDescription;
    }

    /**
     * @param string $ItemDescription
     * @return ExportLineItem
     */
    public function setItemDescription(string $ItemDescription): ExportLineItem
    {
        $this->ItemDescription = $ItemDescription;
        return $this;
    }

    /**
     * @return float
     */
    public function getUnitPrice(): float
    {
        return $this->UnitPrice;
    }

    /**
     * @return string
     */
    public function getUnitPriceCurrencyCode(): string
    {
        return $this->UnitPriceCurrencyCode;
    }

    /**
     * @param float $UnitPrice
     * @return ExportLineItem
     */
    public function setUnitPrice(float $UnitPrice): ExportLineItem
    {
        $this->UnitPrice = $UnitPrice;
        return $this;
    }


    /**
     * @param string $currencyCode
     * @return ExportLineItem
     */
    public function setUnitPriceCurrencyCode(string $currencyCode): ExportLineItem
    {
        $this->UnitPriceCurrencyCode = new CurrencyCode($currencyCode);
        return $this;
    }

    /**
     * @return float
     */
    public function getNetWeight(): float
    {
        return $this->NetWeight;
    }

    /**
     * @param float $NetWeight
     * @return ExportLineItem
     */
    public function setNetWeight(float $NetWeight): ExportLineItem
    {
        $this->NetWeight = $NetWeight;
        return $this;
    }

    /**
     * @return float
     */
    public function getGrossWeight(): float
    {
        return $this->GrossWeight;
    }

    /**
     * @param float $GrossWeight
     * @return ExportLineItem
     */
    public function setGrossWeight(float $GrossWeight): ExportLineItem
    {
        $this->GrossWeight = $GrossWeight;
        return $this;
    }

    /**
     * @return string
     */
    public function getManufacturingCountryCode(): string
    {
        return $this->ManufacturingCountryCode;
    }

    /**
     * @param string $ManufacturingCountryCode
     * @return ExportLineItem
     */
    public function setManufacturingCountryCode(string $ManufacturingCountryCode): ExportLineItem
    {
        $this->ManufacturingCountryCode = $ManufacturingCountryCode;
        return $this;
    }

    /**
     * @param bool $TaxesPaid
     */
    public function setTaxesPaid(bool $TaxesPaid = true)
    {
        $this->TaxesPaid = new RequestTaxesPaid($TaxesPaid);
    }

    /**
     * @return RequestTaxesPaid
     */
    public function getTaxesPaid()
    {
        return $this->TaxesPaid;
    }


}
