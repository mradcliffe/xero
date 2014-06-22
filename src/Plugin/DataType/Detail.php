<?php
/**
 * @file
 * Provides \Drupal\xero\Plugin\DataType\Detail.
 */

namespace Drupal\xero\Plugin\DataType;

use Drupal\Core\TypedData\Plugin\DataType\Map;

/**
 * Xero detail item type
 *
 * @DataType(
 *   id = "xero_detail",
 *   label = @Translation("Xero Detail"),
 *   definition_class = "\Drupal\xero\TypedData\Definition\DetailDefinition"
 * )
 */
class Detail extends Map {

  /**
   * {@inheritdoc}
   */
  protected function getPropertyDefinitions() {
    return $this->definition->getPropertyDefinitions();
  }

}
