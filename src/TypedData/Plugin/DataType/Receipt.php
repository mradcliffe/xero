<?php
/**
 * @file
 * Provides \Drupal\xero\TypedData\Plugin\DataType\Receipt.
 */

namespace Drupal\xero\TypedData\Plugin\DataType;

/**
 * Xero Receipt type.
 *
 * @DataType(
 *   "id" => "xero_receipt",
 *   "label" => @Translation("Xero Receipt"),
 *   "definition_class" => "\Drupal\xero\TypedData\Definition\ReceiptDefinition"
 * )
 */
class Receipt extends XeroTypeBase {

  static protected $guid_name = 'ReceiptID';
  static protected $plural_name = 'Receipts';
  static protected $label = 'ReceiptNumber';

  /**
   * {@inheritdoc}
   */
  protected function getPropertyDefinitions() {
    return $this->definition->getPropertyDefinitions();
  }

}
