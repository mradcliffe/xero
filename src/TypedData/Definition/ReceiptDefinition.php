<?php
/**
 * @file
 * Provides \Drupal\xero\TypedData\Definition\ReceiptDefinition.
 */

namespace Drupal\xero\TypedData\Definition;

use Drupal\Core\TypeDdata\ListDataDefinition;
use Drupal\Core\TypedData\DataDefinition;
use Drupal\Core\TypedData\ComplexDataDefinitionBase;

/**
 * Xero Receipt data definition
 */
class ReceiptDefinition extends ComplexDataDefinitionBase {
  /**
   * {@inheritdoc}
   */
  public function getPropertyDefinitions() {
    if (!isset($this->propertyDefinitions)) {
      $info = &$this->propertyDefinitions;

      $line_type_options = array('choices' => array('Exclusive', 'Inclusive', 'NoTax'));

      // UUID is read only.
      $info['ReceiptID'] = DataDefinition::create('uuid')->setLabel('Receipt ID')->setReadOnly();

      // Writeable properties.
      $info['Date'] = DataDefinition::create('string')->setLabel('Date')->addConstraint('Date')->setRequired();
      $info['Contact'] = DataDefinition::create('xero_contact')->setRequired()->setLabel('Contact');
      $info['LineItems'] = ListDataDefinition::create('xero_line_item')->setRequired()->setLabel('Line Items');
      $info['User'] = DataDefinition::create('xero_user')->setRequired()->setLabel('User');

      // Optional
      $info['Reference'] = DataDefinition::create('string')->setLabel('Reference');
      $info['LineAmountTypes'] = DataDefinition::create('string')->setLabel('Line Amount Type')->addConstraint('Choice', $line_type_options);
      $info['SubTotal'] = DataDefinition::create('float')->setLabel('Sub-Total');
      $info['TotalTax'] = DataDefinition::create('float')->setLabel('Total Tax');
      $info['Total'] = DataDefinition::create('float')->setLabel('Total');

      // Read-only
      $info['ReceiptNumber'] = DataDefinition::create('string')->setLabel('Receipt #')->setReadOnly();
      $info['Url'] = DataDefinition::create('url')->setLabel('URL')->setReadOnly();
      $info['Status'] = DataDefinition::create('string')->setLabel('Status')->setReadOnly();
      $info['UpdatedDateUTC'] = DataDefinition::create('datetime_iso8601')->setLabel('Updated Date')->setReadOnly();
      $info['HasAttachments'] = DataDefinition::create('boolean')->setLabel('Has Attachments?')->setReadOnly();
    }
    return $this->propertyDefinitions;
  }
}
