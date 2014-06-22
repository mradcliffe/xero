<?php
/**
 * @file
 * Provides \Drupal\xero\Plugin\DataType\Journal.
 */

namespace Drupal\xero\Plugin\DataType;

/**
 * Xero Journal type.
 *
 * @DataType(
 *   id = "xero_journal",
 *   label = @Translation("Xero Journal"),
 *   definition_class = "\Drupal\xero\TypedData\Definition\JournalDefinition"
 * )
 */
class Journal extends XeroTypeBase {

  static public $guid_name = 'JournalID';
  static public $xero_name = 'Journal';
  static public $plural_name = 'Journals';
  static public $label = 'JournalNumber';

  /**
   * {@inheritdoc}
   */
  protected function getPropertyDefinitions() {
    return $this->definition->getPropertyDefinitions();
  }

}
