<?php
/**
 * @file
 * Provides \Drupal\xero\TypedData\Definition\BankTransactionDefinition.
 */

namespace Drupal\xero\TypedData\Definition;

use Drupal\Core\TypeDdata\ListDataDefinition;
use Drupal\Core\TypedData\DataDefinition;
use Drupal\Core\TypedData\ComplexDataDefinitionBase;

/**
 * Xero BankTransaction data definition
 */
class BankTransactionDefinition extends ComplexDataDefinitionBase {
  /**
   * {@inheritdoc}
   */
  public function getPropertyDefinitions() {
    if (!isset($this->propertyDefinitions)) {
      $info = &$this->propertyDefinitions;

      $type_options = array('choices' => array('RECEIVE', 'SPEND'));
      $line_type_options = array('choices' => array('Exclusive', 'Inclusive', 'NoTax'));
      $status_options = array('choices' => array('DELETED', 'AUTHORISED'));

      // UUID is read only.
      $info['BankTransactionID'] = DataDefinition::create('uuid')->setLabel('Bank Transaction ID')->setReadOnly();

      // Writeable properties.
      $info['Type'] = DataDefinition::create('string')->setRequired()->setLabel('Type')->addConstraint('Choice', $type_options);
      $info['Contact'] = DataDefinition::create('xero_contact')->setRequired()->setLabel('Contact');
      $info['LineItems'] = ListDataDefinition::create('xero_line_item')->setRequired()->setLabel('Line Items');
      $info['BankAccount'] = DataDefinition::create('xero_account')->setRequired()->setLabel('Bank Account');

      $info['DueDate'] = DataDefinition::create('string')->setLabel('Due Date')->addConstraint('Date');
      $info['LineAmountTypes'] = DataDefinition::create('string')->setLabel('Line Amount Type')->addConstraint('Choice', $line_type_options);

      // Optional
      $info['IsReconciled'] = DataDefinition::create('boolean')->setLabel('Is reconciled?');
      $info['Date'] = DataDefinition::create('string')->setLabel('Date')->addConstraint('Date');
      $info['Reference'] = DataDefinition::create('string')->setLabel('Reference');
      $info['CurrencyRate'] = DataDefinition::create('float')->setLabel('Currency rate');
      $info['Url'] = DataDefinition::create('url')->setLabel('URL');
      $info['Status'] = DataDefinition::create('string')->setLabel('Status')->addConstraint('Choice', $status_options);
      $info['SubTotal'] = DataDefinition::create('float')->setLabel('Sub-Total');
      $info['TotalTax'] = DataDefinition::create('float')->setLabel('Total Tax');
      $info['Total'] = DataDefinition::create('float')->setLabel('Total');

      // Read-only
      $info['UpdatedDateUTC'] = DataDefinition::create('datetime_iso8601')->setLabel('Updated Date')->setReadOnly();
    }
    return $this->propertyDefinitions;
  }
}
