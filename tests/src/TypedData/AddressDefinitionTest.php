<?php
/**
 * @file
 * Provides \DrupalTests\xero\TypedData\AddressDefinitionTest.
 */

namespace Drupal\Tests\xero\TypedData;

use Drupal\Core\TypedData\DataDefinition;
use Drupal\xero\TypedData\Definition\AddressDefinition;
use Drupal\xero\Plugin\DataType\Address;
use Drupal\Core\TypedData\Plugin\DataType\String;
use Drupal\Tests\xero\Plugin\DataType\TestBase;

/**
 * Assert setting and getting Address properties.
 *
 * @coversDefaultClass \Drupal\xero\TypedData\Definition\AddressDefinition
 * @group Xero
 */
class AddressDefinitionTest extends TestBase {

  const XERO_TYPE = 'xero_address';
  const XERO_TYPE_CLASS = '\Drupal\xero\Plugin\DataType\Address';
  const XERO_DEFINITION_CLASS = '\Drupal\xero\TypedData\Definition\AddressDefinition';

  protected $address;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();

    // Create data type.
    $type_class = self::XERO_TYPE_CLASS;
    $this->address = new $type_class($this->dataDefinition, self::XERO_TYPE);
  }

  /**
   * Test getPropertyDefinitions.
   */
  public function testPropertyDefinitions() {
    $properties = $this->address->getProperties();

    $this->assertArrayHasKey('AddressType', $properties);
    $this->assertArrayHasKey('AddressLine1', $properties);
    $this->assertArrayHasKey('AddressLine2', $properties);
    $this->assertArrayHasKey('AddressLine3', $properties);
    $this->assertArrayHasKey('AddressLine4', $properties);
    $this->assertArrayHasKey('City', $properties);
    $this->assertArrayHasKey('Region', $properties);
    $this->assertArrayHasKey('PostalCode', $properties);
    $this->assertArrayHasKey('Country', $properties);
    $this->assertArrayHasKey('AttentionTo', $properties);
  }
}
