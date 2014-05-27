<?php
/**
 * @file
 * Provides \Drupal\xero\TypedData\Definition\PhoneDefinition.
 */

namespace Drupal\xero\TypedData\Definition;

use Drupal\Core\TypedData\DataDefinition;
use Drupal\Core\TypedData\ComplexDataDefinitionBase;

/**
 * Xero Phone Number data definition
 */
class PhoneDefinition extends ComplexDataDefinitionBase {
  /**
   * {@inheritdoc}
   */
  public function getPropertyDefinitions() {
    if (!isset($this->propertyDefinitions)) {
      $info = &$this->propertyDefinitions;
      $options = array('choices' => array('DEFAULT', 'DDI', 'MOBILE', 'FAX'));
      $info['PhoneType'] = DataDefinition::create('string')->setLabel('Type')->setRequired()->addConstraint('Choice', $options);
      $info['PhoneNumber'] = DataDefinition::create('string')->setLabel('Number');
      $info['PhoneAreaCode'] = DataDefinition::create('string')->setLabel('Area code');
      $info['PhoneCountryCode'] = DataDefinition::create('string')->setLabel('Country code');
    }
    return $this->propertyDefinitions;
  }
}
