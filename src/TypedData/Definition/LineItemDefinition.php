<?php
/**
 * @file
 * Provides \Drupal\xero\TypedData\Definition\LineItemDefinition.php
 */

namespace Drupal\xero\TypedData\Definition;

use Drupal\Core\TypedData\DataDefinition;
use Drupal\Core\TypedData\ComplexDataDefinitionBase;

/**
 * Xero Line Item data definition.
 */
class LineItemDefinition extends ComplexDataDefinitionBase {

  /**
   * {@inheritdoc}
   *
   * @todo additional properties for line items - http://developer.xero.com/documentation/api/invoices/
   */
  public function getPropertyDefinitions() {
    if (!isset($this->propertyDefinitions)) {
      $info = &$this->propertyDefinitions;
      $info['Description'] = DataDefinition::create('string')->setRequired(TRUE)->setLabel('Description');
      $info['Quantity'] = DataDefinition::create('float')->setLabel('Quantity');
      $info['UnitAmount'] = DataDefinition::create('float')->setLabel('Unit amount');
      $info['ItemCode'] = DataDefinition::create('string')->setLabel('Item code')->setDescription('User-defined item code');
      $info['AccountCode'] = DataDefinition::create('string')->setLabel('Account code')->setDescription('User-defined account code');
    }
    return $this->propertyDefinitions;
  }
}
