<?php
/**
 * @file
 * Provides \Drupal\xero\TypedData\Definition\JournalLineDefinition.php
 */

namespace Drupal\xero\TypedData\Definition;

use Drupal\Core\TypedData\ListDataDefinition;
use Drupal\Core\TypedData\DataDefinition;
use Drupal\Core\TypedData\ComplexDataDefinitionBase;

/**
 * Xero Journal Line Item data definition.
 */
class JournalLineDefinition extends ComplexDataDefinitionBase {

  /**
   * {@inheritdoc}
   */
  public function getPropertyDefinitions() {
    if (!isset($this->propertyDefinitions)) {
      $info = &$this->propertyDefinitions;

      // All journal items are read-only.
      $info['JournalLineID'] = DataDefinition::create('uuid')->setLabel('Journal Line ID')->setReadOnly();
      $info['AccountID'] = DataDefinition::create('uuid')->setLabel('Account ID')->setReadOnly();
      $info['AccountCode'] = DataDefinition::create('string')->setLabel('Account code')->setReadOnly();
      $info['AccountType'] = DataDefinition::create('string')->setLabel('Account type')->setReadOnly();
      $info['AccountName'] = DataDefinition::create('string')->setLabel('Account name')->setReadOnly();
      $info['NetAmount'] = DataDefinition::create('float')->setLabel('Net')->setReadOnly();
      $info['GrossAmount'] = DataDefinition::create('float')->setLabel('Gross')->setReadOnly();
      $info['TaxAmount'] = DataDefinition::create('float')->setLabel('Tax')->setReadOnly();
      $info['TaxType'] = DataDefinition::create('string')->setLabel('Tax type')->setReadOnly();
      $info['TaxName'] = DataDefinition::create('string')->setLabel('Tax name')->setReadOnly();
      $info['TrackingCategories'] = ListDataDefinition::create('xero_tracking')->setLabel('Tracking Categories')->setReadOnly();
    }
    return $this->propertyDefinitions;
  }
}
