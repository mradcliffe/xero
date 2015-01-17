<?php
/**
 * @file
 * Provides \DrupalTests\xero\Plugin\DataType\LinkTest.
 */

namespace Drupal\Tests\xero\Plugin\DataType;

use Drupal\Core\TypedData\Plugin\DataType\Uri;
use Drupal\Core\TypedData\DataDefinition;
use Drupal\xero\TypedData\Definition\LinkDefinition;
use Drupal\xero\Plugin\DataType\Link;
use Drupal\Core\TypedData\Plugin\DataType\String;

/**
 * Assert setting and getting Link properties.
 *
 * @coversDefaultClass \Drupal\xero\Plugin\DataType\Link
 * @group Xero
 */
class LinkTest extends TestBase {

  const XERO_TYPE = 'xero_link';
  const XERO_TYPE_CLASS = '\Drupal\xero\Plugin\DataType\Link';
  const XERO_DEFINITION_CLASS = '\Drupal\xero\TypedData\Definition\LinkDefinition';

  protected $link;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();

    // Create data type.
    $type_class = self::XERO_TYPE_CLASS;
    $this->link = new $type_class($this->dataDefinition, self::XERO_TYPE);
  }

  /**
   * Test getPropertyDefinitions.
   */
  public function testPropertyDefinitions() {
    $properties = $this->link->getProperties();

    $this->assertArrayHasKey('Url', $properties);
    $this->assertArrayHasKey('Description', $properties);
  }
}
