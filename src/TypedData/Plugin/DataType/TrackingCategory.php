<?php
/**
 * @file
 * Provides \Drupal\xero\TypedData\Plugin\DataType\TrackingCategory.
 */

namespace Drupal\xero\TypedData\Plugin\DataType;

use Drupal\Core\TypedData\Plugin\DataType\Map;

/**
 * Xero line item type
 *
 * @DataType(
 *   "id" => "xero_tracking",
 *   "label" => @Translation("Xero Tracking Category"),
 *   "definition_class" => "\Drupal\xero\TypedData\Definition\TrackingCategoryDefinition"
 * )
 */
class TrackingCategory extends Map {

  /**
   * {@inheritdoc}
   */
  protected function getPropertyDefinitions() {
    return $this->definition->getPropertyDefinitions();
  }

}
