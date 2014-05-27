<?php
/**
 * @file
 * Provides \Drupal\xero\TypedData\Plugin\DataType\CreditNote.
 */

namespace Drupal\xero\TypedData\Plugin\DataType;

/**
 * Xero CreditNote type.
 *
 * @DataType(
 *   "id" => "xero_credit_note",
 *   "label" => @Translation("Xero Credit Note"),
 *   "definition_class" => "\Drupal\xero\TypedData\Definition\CreditDefinition"
 * )
 */
class CreditNote extends XeroTypeBase {

  static protected $guid_name = 'CreditNoteID';
  static protected $plural_name = 'CreditNotes';
  static protected $label = 'CreditNoteNumber';

  /**
   * {@inheritdoc}
   */
  protected function getPropertyDefinitions() {
    return $this->definition->getPropertyDefinitions();
  }

}
