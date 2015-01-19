<?php
/**
 * @file
 * Provides \DrupalTests\xero\TypedData\LineItemDefinitionTest.
 */

namespace Drupal\Tests\xero\TypedData;

use Drupal\Core\TypedData\DataDefinition;
use Drupal\xero\TypedData\Definition\LineItemDefinition;
use Drupal\xero\Plugin\DataType\LineItem;
use Drupal\Core\TypedData\Plugin\DataType\String;
use Drupal\Core\TypedData\Plugin\DataType\Float;
use Drupal\Tests\xero\Plugin\DataType\TestBase;

/**
 * Assert setting and getting LineItem properties.
 *
 * @coversDefaultClass \Drupal\xero\TypedData\Definition\LineItemDefinition
 * @group Xero
 */
class LineItemDefinitionTest extends TestBase {

  const XERO_TYPE = 'xero_line_item';
  const XERO_TYPE_CLASS = '\Drupal\xero\Plugin\DataType\LineItem';
  const XERO_DEFINITION_CLASS = '\Drupal\xero\TypedData\Definition\LineItemDefinition';

  protected $line_item;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();

    // Create data type.
    $type_class = self::XERO_TYPE_CLASS;
    $this->line_item = new $type_class($this->dataDefinition, self::XERO_TYPE);
  }

  /**
   * Test getPropertyDefinitions.
   */
  public function testPropertyDefinitions() {
    $properties = $this->line_item->getProperties();

    $this->assertArrayHasKey('Description', $properties);
    $this->assertArrayHasKey('Quantity', $properties);
    $this->assertArrayHasKey('UnitAmount', $properties);
    $this->assertArrayHasKey('ItemCode', $properties);
    $this->assertArrayHasKey('AccountCode', $properties);
  }
}
