<?php
/**
 * @file
 * Provides \DrupalTests\xero\TypedData\TrackingCategoryDefinitionTest.
 */

namespace Drupal\Tests\xero\TypedData;

use Drupal\Core\TypedData\DataDefinition;
use Drupal\xero\TypedData\Definition\TrackingCategoryDefinition;
use Drupal\xero\Plugin\DataType\TrackingCategory;
use Drupal\Core\TypedData\Plugin\DataType\String;
use Drupal\Tests\xero\Plugin\DataType\TestBase;

/**
 * Assert setting and getting TrackingCategory properties.
 *
 * @coversDefaultClass \Drupal\xero\TypedData\Definition\TrackingCategoryDefinition
 * @group Xero
 */
class TrackingCategoryDefinitionTest extends TestBase {

  const XERO_TYPE = 'xero_tracking';
  const XERO_TYPE_CLASS = '\Drupal\xero\Plugin\DataType\TrackingCategory';
  const XERO_DEFINITION_CLASS = '\Drupal\xero\TypedData\Definition\TrackingCategoryDefinition';

  protected $tracking;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();

    // Create data type.
    $type_class = self::XERO_TYPE_CLASS;
    $this->tracking = new $type_class($this->dataDefinition, self::XERO_TYPE);
  }

  /**
   * Test getPropertyDefinitions.
   */
  public function testPropertyDefinitions() {
    $properties = $this->tracking->getProperties();

    $this->assertArrayHasKey('Name', $properties);
    $this->assertArrayHasKey('Status', $properties);
    $this->assertArrayHasKey('TrackingCategoryID', $properties);
  }
}
