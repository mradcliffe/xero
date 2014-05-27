<?php
/**
 * @file
 * Provides \Drupal\xero\TypedData\Definition\ItemDefinition.php
 */

namespace Drupal\xero\TypedData\Definition;

use Drupal\Core\TypedData\DataDefinition;
use Drupal\Core\TypedData\ComplexDataDefinitionBase;

/**
 * Xero Item data definition.
 */
class ItemDefinition extends ComplexDataDefinitionBase {

  /**
   * {@inheritdoc}
   *
   * @todo additional properties for items - http://developer.xero.com/documentation/api/items/
   */
  public function getPropertyDefinitions() {
    if (!isset($this->propertyDefinitions)) {
      $info = &$this->propertyDefinitions;

      // Writeable
      $info['Code'] = DataDefinition::create('string')->setRequired()->setLabel('Code')->addConstraint('Length', array('max' => 30));

      // Recommended
      $info['Description'] = DataDefinition::create('string')->setLabel('Description');
      $info['PurchaseDetails'] = DataDefinition::create('xero_details')->setLabel('Purchase Details');
      $info['SalesDetails'] = DataDefinition::create('xero_details')->setLabel('Sales Details');
    }
    return $this->propertyDefinitions;
  }
}
