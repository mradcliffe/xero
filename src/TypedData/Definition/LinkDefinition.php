<?php
/**
 * @file
 * Provides \Drupal\xero\TypedData\Definition\LinkDefinition.
 */

namespace Drupal\xero\TypedData\Definition;

use Drupal\Core\TypedData\DataDefinition;
use Drupal\Core\TypedData\ComplexDataDefinitionBase;

/**
 * Link data definition.
 */
class LinkDefinition extends ComplexDataDefinitionBase {
  /**
   * {@inheritdoc}
   */
  public function getPropertyDefinitions() {
    if (!isset($this->propertyDefinitions)) {
      $info = &$this->propertyDefinitions;
      $info['Url'] = DataDefinition::create('url')->setLabel('Url')->setRequired(TRUE);
      $info['Description'] = DataDefinition::create('string')->setLabel('Description');
    }
    return $this->propertyDefinitions;
  }
}
