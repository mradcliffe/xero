<?php
/**
 * @file
 * Provides \Drupal\xero\TypedData\Plugin\DataType\Address.
 */

namespace Drupal\xero\TypedData\Plugin\DataType;

use Drupal\Core\TypedData\Plugin\DataType\Map;

/**
 * Xero address type
 *
 * @DataType(
 *   "id" => "xero_address",
 *   "label" => @Translation("Xero Address"),
 *   "definition_class" => "\Drupal\xero\TypedData\Definition\AddressDefinition"
 * )
 */
class Address extends Map {

  /**
   * {@inheritdoc}
   */
  protected function getPropertyDefinitions() {
    return $this->definition->getPropertyDefinitions();
  }

}
