<?php
/**
 * @file
 * Provides \Drupal\xero\Plugin\DataType\Receipt.
 */

namespace Drupal\xero\Plugin\DataType;

/**
 * Xero Receipt type.
 *
 * @DataType(
 *   id = "xero_receipt",
 *   label = @Translation("Xero Receipt"),
 *   definition_class = "\Drupal\xero\TypedData\Definition\ReceiptDefinition"
 * )
 */
class Receipt extends XeroTypeBase {

  static public $guid_name = 'ReceiptID';
  static public $xero_name = 'Receipt';
  static public $plural_name = 'Receipts';
  static public $label = 'ReceiptNumber';

  /**
   * {@inheritdoc}
   */
  protected function getPropertyDefinitions() {
    return $this->definition->getPropertyDefinitions();
  }

}
