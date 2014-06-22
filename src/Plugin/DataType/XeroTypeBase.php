<?php
/**
 * @file
 * Provides \Drupal\xero\Plugin\DataType\XeroTypeBase.
 */

namespace Drupal\xero\Plugin\DataType;

use Drupal\Core\TypedData\Plugin\DataType\Map;
use Drupal\xero\TypedData\XeroTypeInterface;

/**
 * Xero base type for all complex xero types to inherit that need to have
 * GUID and Plural properties.
 */
abstract class XeroTypeBase extends Map implements XeroTypeInterface {

  static public $guid_name;
  static public $xero_name;
  static public $plural_name;
  static public $label;

  /**
   * {@inheritdoc}
   */
  protected function getPropertyDefinitions() {
    return $this->definition->getPropertyDefinitions();
  }

  /**
   * {@inheritdoc}
   */
  public function getGUIDName() {
    return self::$guid_name;
  }

  /**
   * {@inheritdoc}
   */
  public function getPluralName() {
    return self::$plural_name;
  }

  /**
   * {@inheritdoc}
   */
  public function getLabelName() {
    return self::$label;
  }

}
