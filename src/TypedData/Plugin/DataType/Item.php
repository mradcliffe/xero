<?php
/**
 * @file
 * Provides \Drupal\xero\TypedData\Plugin\DataType\Item.
 */

namespace Drupal\xero\TypedData\Plugin\DataType;

/**
 * Xero Item type.
 *
 * @DataType(
 *   "id" => "xero_item",
 *   "label" => @Translation("Xero Item"),
 *   "definition_class" => "\Drupal\xero\TypedData\Definition\ItemDefinition"
 * )
 */
class Item extends XeroTypeBase {

  static protected $guid_name = 'ItemID';
  static protected $plural_name = 'Items';
  static protected $label = 'Code';

  /**
   * {@inheritdoc}
   */
  protected function getPropertyDefinitions() {
    return $this->definition->getPropertyDefinitions();
  }

}
