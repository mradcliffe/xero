<?php
/**
 * @file
 * Provides \Drupal\xero\TypedData\Plugin\DataType\Expense.
 */

namespace Drupal\xero\TypedData\Plugin\DataType;

/**
 * Xero Expense type.
 *
 * @DataType(
 *   "id" => "xero_expense",
 *   "label" => @Translation("Xero Expense Claim"),
 *   "definition_class" => "\Drupal\xero\TypedData\Definition\ExpenseDefinition"
 * )
 */
class Expense extends XeroTypeBase {

  static protected $guid_name = 'ExpenseClaimID';
  static protected $plural_name = 'ExpenseClaims';
  static protected $label = 'ExpenseClaimID';

  /**
   * {@inheritdoc}
   */
  protected function getPropertyDefinitions() {
    return $this->definition->getPropertyDefinitions();
  }

}
