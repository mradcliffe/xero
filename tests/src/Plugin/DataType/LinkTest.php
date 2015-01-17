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

    $values = array(
      'Url' => 'http://example.com'
    );

    $url_definition = DataDefinition::create('uri');
    $url = new Uri($url_definition);

    // Create data type.
    $typed_data_manager = $this->typedDataManager;
    $type_class = self::XERO_TYPE_CLASS;
    $this->link = new $type_class($this->dataDefinition, self::XERO_TYPE);

    $this->typedDataManager->expects($this->any())
      ->method('getPropertyInstance')
      ->with($this->link, 'Url')
      ->willReturn($url);

  }

  /**
   * Test instantiation.
   */
  public function testObject() {
    $this->link->set('Url', 'http://example.com');

    $this->assertEquals('http://example.com', $this->link->get('Url')->getValue());
  }
}
