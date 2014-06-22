<?php
/**
 * @file
 * Provides \Drupal\xero\Plugin\DataType\Account.
 */

namespace Drupal\xero\Plugin\DataType;

use Drupal\Core\TypedData\Annotation\DataType;
use Drupal\Core\TypedData\Annotation\Translation;

/**
 * Xero Account type.
 *
 * @DataType(
 *   id = "xero_account",
 *   label = @Translation("Xero Account"),
 *   definition_class = "\Drupal\xero\TypedData\Definition\AccountDefinition"
 * )
 */
class Account extends XeroTypeBase {

  static public $guid_name = 'AccountID';
  static public $xero_name = 'Account';
  static public $plural_name = 'Accounts';
  static public $label = 'AccountCode';

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
