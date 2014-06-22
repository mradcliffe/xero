<?php
/**
 * @file
 * Provides \Drupal\xero\Plugin\DataType\BankTransaction.
 */

namespace Drupal\xero\Plugin\DataType;

/**
 * Xero BankTransaction type.
 *
 * @DataType(
 *   id = "xero_bank_transaction",
 *   label = @Translation("Xero Bank Transaction"),
 *   definition_class = "\Drupal\xero\TypedData\Definition\BankTransactionDefinition"
 * )
 */
class BankTransaction extends XeroTypeBase {

  static public $guid_name = 'BankTransactionID';
  static public $xero_name = 'BankTransaction';
  static public $plural_name = 'BankTransactions';
  static public $label;

  /**
   * {@inheritdoc}
   */
  protected function getPropertyDefinitions() {
    return $this->definition->getPropertyDefinitions();
  }

}
