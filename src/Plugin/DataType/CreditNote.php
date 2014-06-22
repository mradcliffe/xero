<?php
/**
 * @file
 * Provides \Drupal\xero\Plugin\DataType\CreditNote.
 */

namespace Drupal\xero\Plugin\DataType;

/**
 * Xero CreditNote type.
 *
 * @DataType(
 *   id = "xero_credit_note",
 *   label = @Translation("Xero Credit Note"),
 *   definition_class = "\Drupal\xero\TypedData\Definition\CreditDefinition"
 * )
 */
class CreditNote extends XeroTypeBase {

  static public $guid_name = 'CreditNoteID';
  static public $plural_name = 'CreditNotes';
  static public $label = 'CreditNoteNumber';

  /**
   * {@inheritdoc}
   */
  protected function getPropertyDefinitions() {
    return $this->definition->getPropertyDefinitions();
  }

}
