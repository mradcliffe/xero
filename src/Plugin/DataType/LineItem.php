<?php

namespace Drupal\xero\Plugin\DataType;

use Drupal\Core\TypedData\Plugin\DataType\Map;

/**
 * Xero line item type
 *
 * @DataType(
 *   id = "xero_line_item",
 *   label = @Translation("Xero Line Item"),
 *   definition_class = "\Drupal\xero\TypedData\Definition\LineItemDefinition",
 *   list_class = "\Drupal\xero\Plugin\DataType\XeroItemList"
 * )
 */
class LineItem extends Map {

  static public $xero_name = 'LineItem';
  static public $plural_name = 'LineItems';

}
