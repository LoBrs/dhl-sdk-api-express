<?php
/**
 * See LICENSE.md for license details.
 */

namespace Dhl\Express\Api\Data\Request\Shipment;

/**
 * LabelOptions Interface.
 *
 * DHL Express allows to pass label options with the shipment request:
 * - CustomerLogo
 * - CustomerBarcode
 * - PrinterDPI
 * - RequestWaybillDocument
 * - HideAccountInWaybillDocument
 * - NumberOfWaybillDocumentCopies
 * - RequestDHLCustomsInvoice
 * - DHLCustomsInvoiceLanguageCode
 * - DHLCustomsInvoiceType
 * - RequestShipmentReceipt
 * - DetachOptions
 *
 * Currently only the waybill document request flag is supported.
 *
 * @api
 * @author Daniel Fairbrother <dfairbrother@datto.com>
 * @link   https://www.datto.com/
 */
interface LabelOptionsInterface
{
    /**
     * Returns whether a waybill document is requested or not.
     *
     * @return bool
     */
    public function isWaybillDocumentRequested(): bool;

    public function isDHLCustomsInvoiceRequested(): bool;

    public function getDHLCustomsInvoiceType(): ?string;

    public function isBarCodeInfoRequested(): bool;

    public function isDHLLogoOnLabelRequested(): bool;

    public function getCustomerLogo();

    public function getCustomerLogoFormat();

    public function getLabelType();

    public function setLabelType(string $labelType);
}
