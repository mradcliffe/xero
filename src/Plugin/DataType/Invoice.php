<?php
/**
 * @file
 * Provides \Drupal\xero\Plugin\DataType\Invoice.
 */

namespace Drupal\xero\Plugin\DataType;

/**
 * Xero Invoice type.
 *
 * @DataType(
 *   id = "xero_invoice",
 *   label = @Translation("Xero Invoice"),
 *   definition_class = "\Drupal\xero\TypedData\Definition\InvoiceDefinition"
 * )
 */
class Invoice extends XeroTypeBase {

  static public $guid_name = 'InvoiceID';
  static public $xero_name = "Invoice";
  static public $plural_name = 'Invoices';
  static public $label = 'InvoiceNumber';

  /**
   * {@inheritdoc}
   */
  protected function getPropertyDefinitions() {
    return $this->definition->getPropertyDefinitions();
  }

}
