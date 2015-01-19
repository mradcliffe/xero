<?php
/**
 * @file
 * Provides \Drupal\xero\Plugin\DataType\Expense.
 */

namespace Drupal\xero\Plugin\DataType;

/**
 * Xero Expense type.
 *
 * @DataType(
 *   id = "xero_expense",
 *   label = @Translation("Xero Expense Claim"),
 *   definition_class = "\Drupal\xero\TypedData\Definition\ExpenseDefinition"
 * )
 */
class Expense extends XeroTypeBase {

  static public $guid_name = 'ExpenseClaimID';
  static public $xero_name = 'ExpenseClaim';
  static public $plural_name = 'ExpenseClaims';
  static public $label = 'ExpenseClaimID';

}
