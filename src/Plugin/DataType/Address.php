<?php
/**
 * @file
 * Provides \Drupal\xero\Plugin\DataType\Address.
 */

namespace Drupal\xero\Plugin\DataType;

use Drupal\Core\TypedData\Plugin\DataType\Map;

/**
 * Xero address type
 *
 * @DataType(
 *   id = "xero_address",
 *   label = @Translation("Xero Address"),
 *   definition_class = "\Drupal\xero\TypedData\Definition\AddressDefinition",
 *   list_class = "\Drupal\xero\Plugin\DataType\XeroItemList"
 * )
 */
class Address extends Map {

  static public $xero_name = 'Address';
  static public $plural_name = 'Addresses';

}
