<?php
/**
 * @file
 * Provides \Drupal\xero\TypedData\Plugin\DataType\Journal.
 */

namespace Drupal\xero\TypedData\Plugin\DataType;

/**
 * Xero Journal type.
 *
 * @DataType(
 *   "id" => "xero_journal",
 *   "label" => @Translation("Xero Journal"),
 *   "definition_class" => "\Drupal\xero\TypedData\Definition\JournalDefinition"
 * )
 */
class Journal extends XeroTypeBase {

  static protected $guid_name = 'JournalID';
  static protected $plural_name = 'Journals';
  static protected $label = 'JournalNumber';

  /**
   * {@inheritdoc}
   */
  protected function getPropertyDefinitions() {
    return $this->definition->getPropertyDefinitions();
  }

}
