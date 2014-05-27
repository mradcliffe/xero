<?php
/**
 * @file
 * Provides \Drupal\xero\TypedData\Definition\UserDefinition.
 */

namespace Drupal\xero\TypedData\Definition;

use Drupal\Core\TypedData\DataDefinition;
use Drupal\Core\TypedData\ComplexDataDefinitionBase;

/**
 * Xero User data definition
 */
class UserDefinition extends ComplexDataDefinitionBase {
  /**
   * {@inheritdoc}
   */
  public function getPropertyDefinitions() {
    if (!isset($this->propertyDefinitions)) {
      $info = &$this->propertyDefinitions;

      // All properties are read-only.
      $info['UserID'] = DataDefinition::create('uuid')->setLabel('User Id')->setReadOnly();
      $info['EmailAddress'] = DataDefinition::create('email')->setLabel('E-mail address')->setReadOnly();
      $info['FirstName'] = DataDefinition::create('string')->setLabel('First Name')->setReadOnly();
      $info['LastName'] = DataDefinition::create('string')->setLabel('Last Name')->setReadOnly();
      $info['UpdatedDateUTC'] = DataDefinition::create('datetime_iso8601')->setLabel('Updated Date')->setReadOnly();
      $info['IsSubscriber'] = DataDefinition::create('boolean')->setLabel('Subscriber?')->setReadOnly();
      $info['OrganisationRole'] = DataDefinition::create('string')->setLabel('Organisation Role')->setReadOnly();
    }
    return $this->propertyDefinitions;
  }
}
