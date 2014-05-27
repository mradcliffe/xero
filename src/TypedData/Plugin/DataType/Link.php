<?php
/**
 * @file
 * Provides \Drupal\xero\TypedData\Plugin\DataType\Link.
 */

namespace Drupal\xero\TypedData\Plugin\DataType;

use Drupal\Core\TypedData\Plugin\DataType\Map;

/**
 * Xero link
 *
 * @DataType(
 *   "id" => "xero_link",
 *   "label" => @Translation("Xero Link"),
 *   "definition_class" => "\Drupal\xero\TypedData\Definition\LinkDefinition"
 * )
 */
class Link extends Map {

  /**
   * {@inheritdoc}
   */
  protected function getPropertyDefinitions() {
    return $this->definition->getPropertyDefinitions();
  }

}
