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

      $info['Name'] = DataDefinition::create('string')->setLabel('Name')->setRequired(TRUE);
      $info['Status'] = DataDefinition::create('string')->setLabel('Status');
      $info['TrackingCategoryID'] = DataDefinition::create('string')->setLabel('Tracking Category ID')->addConstraint('XeroGuidConstraint');
      // $info['Options'] = ListDataDefinition::create('xero_tracking_options')->setLabel('Options');
    }
    return $this->propertyDefinitions;
  }
}
