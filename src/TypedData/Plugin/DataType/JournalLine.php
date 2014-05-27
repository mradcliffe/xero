<?php
/**
 * @file
 * Provides \Drupal\xero\TypedData\Plugin\DataType\JournalLine.
 */

namespace Drupal\xero\TypedData\Plugin\DataType;

use Drupal\Core\TypedData\Plugin\DataType\Map;

/**
 * Xero journal line item type
 *
 * @DataType(
 *   "id" => "xero_journal_line",
 *   "label" => @Translation("Xero Journal Line"),
 *   "definition_class" => "\Drupal\xero\TypedData\Definition\JournalLineDefinition"
 * )
 */
class JournalLine extends Map {

  /**
   * {@inheritdoc}
   */
  protected function getPropertyDefinitions() {
    return $this->definition->getPropertyDefinitions();
  }

}
