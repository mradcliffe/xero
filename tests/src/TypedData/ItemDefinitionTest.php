<?php
/**
 * @file
 * Provides \DrupalTests\xero\TypedData\ItemDefinitionTest.
 */

namespace Drupal\Tests\xero\TypedData;

use Drupal\Core\TypedData\DataDefinition;
use Drupal\xero\TypedData\Definition\ItemDefinition;
use Drupal\xero\TypedData\Definition\DetailDefinition;
use Drupal\xero\Plugin\DataType\Item;
use Drupal\xero\Plugin\DataType\Detail;
use Drupal\Core\TypedData\Plugin\DataType\String;
use Drupal\Tests\xero\Plugin\DataType\TestBase;

/**
 * Assert setting and getting Item properties.
 *
 * @coversDefaultClass \Drupal\xero\TypedData\Definition\ItemDefinition
 * @group Xero
 */
class ItemDefinitionTest extends TestBase {

  const XERO_TYPE = 'xero_item';
  const XERO_TYPE_CLASS = '\Drupal\xero\Plugin\DataType\Item';
  const XERO_DEFINITION_CLASS = '\Drupal\xero\TypedData\Definition\ItemDefinition';

  protected $item;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();

    // Create data type.
    $type_class = self::XERO_TYPE_CLASS;
    $this->item = new $type_class($this->dataDefinition, self::XERO_TYPE);
  }

  /**
   * Test getPropertyDefinitions.
   */
  public function testPropertyDefinitions() {
    $properties = $this->item->getProperties();

    $this->assertArrayHasKey('Code', $properties);
    $this->assertArrayHasKey('Description', $properties);
    $this->assertArrayHasKey('PurchaseDetails', $properties);
    $this->assertArrayHasKey('SalesDetails', $properties);
  }
}
