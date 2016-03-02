<?php

/**
 * @file
 * Contains BrandingThemeDefinition.php
 */

namespace Drupal\xero\TypedData\Definition;


use Drupal\Core\TypedData\ComplexDataDefinitionBase;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Xero Branding Theme definition
 */
class BrandingThemeDefinition extends ComplexDataDefinitionBase {

  /**
   * {@inheritdoc}
   */
  public function getPropertyDefinitions() {
    if (!isset($this->propertyDefinitions)) {
      $info = &$this->propertyDefinitions;

      $info['BrandingThemeID'] = DataDefinition::create('string')
        ->setLabel('Branding Theme ID')
        ->addConstraint('XeroGuidConstraint')
        ->setReadOnly(TRUE);
      $info['Name'] = DataDefinition::create('string')
        ->setLabel('Label')
        ->setReadOnly(TRUE);
      $info['SortOrder'] = DataDefinition::create('integer')
        ->setLabel('Sort Order')
        ->setReadOnly(TRUE);
      $info['CreatedDateUTC'] = DataDefinition::create('datetime_iso8601')
        ->setLabel('Created Date')
        ->setReadOnly(TRUE);
    }
    return $this->propertyDefinitions;
  }
}