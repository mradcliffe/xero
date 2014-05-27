<?php
/**
 * @file
 * Provides \Drupal\xero\TypedData\Definition\JournalDefinition.
 */

namespace Drupal\xero\TypedData\Definition;

use Drupal\Core\TypeDdata\ListDataDefinition;
use Drupal\Core\TypedData\DataDefinition;
use Drupal\Core\TypedData\ComplexDataDefinitionBase;

/**
 * Xero Journal data definition
 */
class JournalDefinition extends ComplexDataDefinitionBase {
  /**
   * {@inheritdoc}
   */
  public function getPropertyDefinitions() {
    if (!isset($this->propertyDefinitions)) {
      $info = &$this->propertyDefinitions;

      // All properties are read-only.
      $info['JournalID'] = DataDefinition::create('uuid')->setLabel('Journal ID')->setReadOnly();
      $info['JournalDate'] = DataDefinition::create('string')->setLabel('Date')->setReadOnly();
      $info['JournalNumber'] = DataDefiniton::create('string')->setLabel('Journal #')->setReadOnly();
      $info['CreatedDateUTC'] = DataDefinition::create('datetime_iso8601')->setLabel('Created Date')->setReadOnly();
      $info['Reference'] = DataDefinition::create('string')->setLabel('Reference')->setReadOnly();
      $info['JournalLines'] = ListDataDefinition::create('xero_journal_line')->setLabel('Journal Lines')->setReadOnly();
    }
    return $this->propertyDefinitions;
  }
}
