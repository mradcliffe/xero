<?php
/**
 * @file
 * Provides \Drupal\xero\Plugin\DataType\Link.
 */

namespace Drupal\xero\Plugin\DataType;

use Drupal\Core\TypedData\Plugin\DataType\Map;

/**
 * Xero link
 *
 * @DataType(
 *   id = "xero_link",
 *   label = @Translation("Xero Link"),
 *   definition_class = "\Drupal\xero\TypedData\Definition\LinkDefinition"
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
