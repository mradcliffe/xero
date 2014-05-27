<?php
/**
 * @file
 * Provides \Drupal\xero\TypedData\Plugin\DataType\Invoice.
 */

namespace Drupal\xero\TypedData\Plugin\DataType;

/**
 * Xero Invoice type.
 *
 * @DataType(
 *   "id" => "xero_invoice",
 *   "label" => @Translation("Xero Invoice"),
 *   "definition_class" => "\Drupal\xero\TypedData\Definition\InvoiceDefinition"
 * )
 */
class Invoice extends XeroTypeBase {

  static protected $guid_name = 'InvoiceID';
  static protected $plural_name = 'Invoices';
  static protected $label = 'InvoiceNumber';

  /**
   * {@inheritdoc}
   */
  protected function getPropertyDefinitions() {
    return $this->definition->getPropertyDefinitions();
  }

}
