<?php

namespace Drupal\xero\Plugin\DataType;

use Drupal\Core\TypedData\Plugin\DataType\Map;

/**
 * Xero journal line item type
 *
 * @DataType(
 *   id = "xero_journal_line",
 *   label = @Translation("Xero Journal Line"),
 *   definition_class = "\Drupal\xero\TypedData\Definition\JournalLineDefinition",
 *   list_class = "\Drupal\xero\Plugin\DataType\XeroItemList"
 * )
 */
class JournalLine extends Map {

  static public $xero_name = 'JournalLine';
  static public $plural_name = 'JournalLines';

}
