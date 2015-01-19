<?php
/**
 * @file
 * Provides \DrupalTests\xero\TypedData\DetailDefinitionTest.
 */

namespace Drupal\Tests\xero\TypedData;

use Drupal\Core\TypedData\DataDefinition;
use Drupal\xero\TypedData\Definition\DetailDefinition;
use Drupal\xero\Plugin\DataType\Detail;
use Drupal\Core\TypedData\Plugin\DataType\String;
use Drupal\Core\TypedData\Plugin\DataType\Float;
use Drupal\Tests\xero\Plugin\DataType\TestBase;

/**
 * Assert setting and getting Detail properties.
 *
 * @coversDefaultClass \Drupal\xero\TypedData\Definition\DetailDefinition
 * @group Xero
 */
class DetailDefinitionTest extends TestBase {

  const XERO_TYPE = 'xero_detail';
  const XERO_TYPE_CLASS = '\Drupal\xero\Plugin\DataType\Detail';
  const XERO_DEFINITION_CLASS = '\Drupal\xero\TypedData\Definition\DetailDefinition';

  protected $detail;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();

    // Create data type.
    $type_class = self::XERO_TYPE_CLASS;
    $this->detail = new $type_class($this->dataDefinition, self::XERO_TYPE);
  }

  /**
   * Test getPropertyDefinitions.
   */
  public function testPropertyDefinitions() {
    $properties = $this->detail->getProperties();

    $this->assertArrayHasKey('UnitPrice', $properties);
    $this->assertArrayHasKey('AccountCode', $properties);
    $this->assertArrayHasKey('TaxType', $properties);
  }
}
