<?php

namespace Dhl\Express\Webservice\Soap\Type\Common\Ship;

class RegistrationNumber
{

    /** @var string */
    var $Number;

    /** @var string Registration number type : VAT, EOR, EIN.... */
    var $NumberTypeCode;

    /** @var */
    var $NumberIssuerCountryCode;

    /** CNPJ/CPF Federal Tax */
    const CNP = 'CNP';

    /** Deferment Account Duties Only */
    const DAN = 'DAN';

    /** Deferment Account Duties, Taxes and Fees Only */
    const DTF = 'DTF';

    /** Data Universal Numbering System */
    const DUN = 'DUN';

    /** Employer Identification Number */
    const EIN = 'EIN';

    /** Economic Operator Registration ID */
    const EOR = 'EOR';

    /** Federal Tax ID */
    const FED = 'FED';

    /** Free Trade Zone ID */
    const FTZ = 'FTZ';

    /** Manufacturers Identification Code */
    const MID = 'MID';

    /** National Identity Card */
    const NID = 'NID';

    /** Passport */
    const PAS = 'PAS';

    /** EU Registered Exporters Registration ID */
    const RGP = 'RGP';

    /** Import One-Stop-Shop */
    const SDT_IOSS = 'SDT';

    /** Overseas Registered Supplier */
    const SDT_OVERSEAS_REGISTERED_SUPPLIER = 'SDT';

    /** AUSid GST Registration */
    const SDT_AUSID_GST_REGISTRATION = 'SDT';

    /** GB VAT Foreign Registration */
    const SDT_GB_VAT_FOREIGN_REGISTRATION = 'SDT';

    /** VAT on E-Commerce */
    const SDT_VAT_ON_ECOMMERCE = 'SDT';

    /** OVR GSTN */
    const SDT_OVR_GSTN = 'SDT';

    /** LVG Registration Number */
    const SDT_LVG_REGISTRATION_NUMBER = 'SDT';

    /** Social Security Number */
    const SSN = 'SSN';

    /** State Tax ID */
    const STA_STATE_TAX_ID = 'STA';

    /** Brazil State Tax ID IE/RG */
    const STA_BRAZIL_STATE_TAX_ID = 'STA';

    /** Subsidiary Number */
    const SUB = 'SUB';

    /** Deferment Account Tax Only */
    const TAN = 'TAN';

    /** VAT Registration */
    const VAT = 'VAT';

    /** Internal Market Scheme */
    const IMS = 'IMS';

    /** eInvoice Carrier */
    const EIC = 'EIC';

    public function __construct($number, $numberTypeCode, $countryCode)
    {
        $this->Number = $number;
        $this->NumberTypeCode = $numberTypeCode;
        $this->NumberIssuerCountryCode = $countryCode;
    }

}