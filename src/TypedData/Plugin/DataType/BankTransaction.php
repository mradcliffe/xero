<?php
/**
 * @file
 * Provides \Drupal\xero\TypedData\Plugin\DataType\BankTransaction.
 */

namespace Drupal\xero\TypedData\Plugin\DataType;

/**
 * Xero BankTransaction type.
 *
 * @DataType(
 *   "id" => "xero_bank_transaction",
 *   "label" => @Translation("Xero Bank Transaction"),
 *   "definition_class" => "\Drupal\xero\TypedData\Definition\BankTransactionDefinition"
 * )
 */
class BankTransaction extends XeroTypeBase {

  static protected $guid_name = 'BankTransactionID';
  static protected $plural_name = 'BankTransactions';
  static protected $label;

  /**
   * {@inheritdoc}
   */
  protected function getPropertyDefinitions() {
    return $this->definition->getPropertyDefinitions();
  }

}
