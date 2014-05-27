<?php
/**
 * @file
 * Provides \Drupal\xero\TypedData\Plugin\DataType\User.
 */

namespace Drupal\xero\TypedData\Plugin\DataType;

/**
 * Xero User type.
 *
 * @DataType(
 *   "id" => "xero_user",
 *   "label" => @Translation("Xero User"),
 *   "definition_class" => "\Drupal\xero\TypedData\Definition\UserDefinition"
 * )
 *
 * @todo user roles?
 */
class User extends XeroTypeBase {

  static protected $guid_name = 'UserID';
  static protected $plural_name = 'Users';
  static protected $label = 'EmailAddress';

  /**
   * {@inheritdoc}
   */
  protected function getPropertyDefinitions() {
    return $this->definition->getPropertyDefinitions();
  }

  /**
   * Is the user account a subscriber?
   *
   * @return boolean
   *   Return TRUE if the user is a subscriber.
   */
  public function isSubscriber() {
    return $this->get('isSubscriber');
  }

}
