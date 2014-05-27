<?php
/**
 * @file
 * Provides \Drupal\xero\TypedData\Plugin\DataType\Account.
 */

namespace Drupal\xero\TypedData\Plugin\DataType;

/**
 * Xero Account type.
 *
 * @DataType(
 *   "id" => "xero_account",
 *   "label" => @Translation("Xero Account"),
 *   "definition_class" => "\Drupal\xero\TypedData\Definition\AccountDefinition"
 * )
 */
class Account extends XeroTypeBase {

  static protected $guid_name = 'AccountID';
  static protected $plural_name = 'Accounts';
  static protected $label = 'AccountCode';

  /**
   * {@inheritdoc}
   */
  protected function getPropertyDefinitions() {
    return $this->definition->getPropertyDefinitions();
  }

  /**
   * See if an account can be used as a revenue account.
   *
   * @return boolean
   *   Return TRUE if the account is revenue-based.
   */
  public function isRevenue() {
    $class = $this->get('AccountClass');
    if ($class && $class == 'REVENUE') {
      return TRUE;
    }
    elseif (!$class) {
      throw new \Exception('Invalid use of isRevenue method');
    }

    return FALSE;
  }

  /**
   * See if an account is a bank account.
   *
   * @retun boolean
   *   Return TRUE if the account is a bank account.
   */
  public function isBankAccount() {
    $type = $this->get('Type');

    return $type == 'BANK';
  }

}
