<?php
/**
 * @file
 * Provides \Drupal\xero\Plugin\DataType\LineItem.
 */

namespace Drupal\xero\Plugin\DataType;

use Drupal\Core\TypedData\Plugin\DataType\Map;

/**
 * Xero line item type
 *
 * @DataType(
 *   id = "xero_line_item",
 *   label = @Translation("Xero Line Item"),
 *   definition_class = "\Drupal\xero\TypedData\Definition\LineItemDefinition"
 * )
 */
class LineItem extends Map {

  /**
   * {@inheritdoc}
   */
  protected function getPropertyDefinitions() {
    return $this->definition->getPropertyDefinitions();
  }

}
