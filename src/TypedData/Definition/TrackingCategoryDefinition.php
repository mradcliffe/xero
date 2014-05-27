<?php
/**
 * @file
 * Provides \Drupal\xero\TypedData\Definition\TrackingCategoryDefinition.
 */

namespace Drupal\xero\TypedData\Definition;

use Drupal\Core\TypedData\DataDefinition;
use Drupal\Core\TypedData\ComplexDataDefinitionBase;

/**
 * Tracking Category data definition.
 */
class TrackingCategoryDefinition extends ComplexDataDefinitionBase {
  /**
   * {@inheritdoc}
   *
   * @todo TrackingCategory options.
   */
  public function getPropertyDefinitions() {
    if (!isset($this->propertyDefinitions)) {
      $info = &$this->propertyDefinitions;

      $info['Name'] = DataDefinition::create('string')->setLabel('Name')->setRequired();
      $info['Status'] = DataDefinition::create('string')->setLabel('Status');
      $info['TrackingCategoryID'] = DataDefinition::create('uuid')->setLabel('Tracking Category ID');
      // $info['Options'] = ListDataDefinition::create('xero_tracking_options')->setLabel('Options');
    }
    return $this->propertyDefinitions;
  }
}
