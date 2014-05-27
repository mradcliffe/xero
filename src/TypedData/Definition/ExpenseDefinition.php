<?php
/**
 * @file
 * Provides \Drupal\xero\TypedData\Definition\ExpenseDefinition.
 */

namespace Drupal\xero\TypedData\Definition;

use Drupal\Core\TypeDdata\ListDataDefinition;
use Drupal\Core\TypedData\DataDefinition;
use Drupal\Core\TypedData\ComplexDataDefinitionBase;

/**
 * Xero Expense Claim data definition
 */
class ExpenseDefinition extends ComplexDataDefinitionBase {
  /**
   * {@inheritdoc}
   */
  public function getPropertyDefinitions() {
    if (!isset($this->propertyDefinitions)) {
      $info = &$this->propertyDefinitions;

      // UUID is read only.
      $info['ExpenseClaimID'] = DataDefinition::create('uuid')->setLabel('Expense Claim ID')->setReadOnly();

      // Writeable properties.
      $info['User'] = DataDefinition::create('xero_user')->setRequired()->setLabel('User');
      $info['Receipts'] = ListDataDefinition::create('xero_receipt')->setRequired()->setLabel('Receipts');

      // Read-only
      $info['ExpenseNumber'] = DataDefinition::create('string')->setLabel('Expense #')->setReadOnly();
      $info['Status'] = DataDefinition::create('string')->setLabel('Status')->setReadOnly();
      $info['UpdatedDateUTC'] = DataDefinition::create('datetime_iso8601')->setLabel('Updated Date')->setReadOnly();
      $info['Total'] = DataDefinition::create('float')->setLabel('Total')->setReadOnly();
      $info['AmountDue'] = DataDefinition::create('float')->setLabel('Amount Due')->setReadOnly();
      $info['AmountPaid'] = DataDefinition::create('float')->setLabel('Amount Paid')->setReadOnly();
      $info['PaymentDueDate'] = DataDefinition::create('string')->setLabel('Payment Due Date')->setReadOnly();
      $info['ReportingDate'] = DataDefinition::create('string')->setLabel('Reporting Date')->setReadOnly();
    }
    return $this->propertyDefinitions;
  }
}
