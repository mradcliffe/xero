<?php
/**
 * @file
 * Provides \Drupal\xero\TypedData\Definition\PaymentDefinition.php
 */

namespace Drupal\xero\TypedData\Definition;

use Drupal\Core\TypedData\DataDefinition;
use Drupal\Core\TypedData\ComplexDataDefinitionBase;

/**
 * Xero Line Item data definition.
 */
class PaymentDefinition extends ComplexDataDefinitionBase {

  /**
   * {@inheritdoc}
   *
   * @todo additional properties for line items - http://developer.xero.com/documentation/api/payments/
   */
  public function getPropertyDefinitions() {
    if (!isset($this->propertyDefinitions)) {
      $info = &$this->propertyDefinitions;

      $info['Invoice'] = DataDefinition::create('xero_invoice')->setRequired(TRUE)->setLabel('Invoice');
      $info['Account'] = DataDefinition::create('xero_account')->setRequired(TRUE)->setLabel('Account');
      // datetime_iso8601 is dumb and always does times so this is a string. DrupalWTF.
      $info['Date'] = DataDefinition::create('string')->setRequired(TRUE)->setLabel('Date');
      $info['Amount'] = DataDefinition::create('float')->setRequired(TRUE)->setLabel('Amount');
      $info['CurrencyRate'] = DataDefinition::create('string')->setLabel('Currency rate');
      $info['Reference'] = DataDefinition::create('string')->setLabel('Reference');
      $info['IsReconciled'] = DataDefinition::create('boolean')->setLabel('Is reconciled?');
    }
    return $this->propertyDefinitions;
  }
}
