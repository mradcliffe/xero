<?php
/**
 * @file
 * Provides \DrupalTests\xero\TypedData\ReceiptDefinitionTest.
 */

namespace Drupal\Tests\xero\TypedData;

use Drupal\Core\TypedData\DataDefinition;
use Drupal\xero\TypedData\Definition\ReceiptDefinition;
use Drupal\xero\Plugin\DataType\Receipt;
use Drupal\Tests\xero\Plugin\DataType\TestBase;

/**
 * Assert setting and getting Receipt properties.
 *
 * @coversDefaultClass \Drupal\xero\TypedData\Definition\ReceiptDefinition
 * @group Xero
 */
class ReceiptDefinitionTest extends TestBase {

  const XERO_TYPE = 'xero_receipt';
  const XERO_TYPE_CLASS = '\Drupal\xero\Plugin\DataType\Receipt';
  const XERO_DEFINITION_CLASS = '\Drupal\xero\TypedData\Definition\ReceiptDefinition';

  protected $receipt;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();

    // Create data type.
    $type_class = self::XERO_TYPE_CLASS;
    $this->receipt = new $type_class($this->dataDefinition, self::XERO_TYPE);
  }

  /**
   * Test getPropertyDefinitions.
   */
  public function testPropertyDefinitions() {
    $properties = $this->receipt->getProperties();

    $this->assertArrayHasKey('ReceiptID', $properties);
    $this->assertArrayHasKey('Date', $properties);
    $this->assertArrayHasKey('Contact', $properties);
    $this->assertArrayHasKey('LineItems', $properties);
    $this->assertArrayHasKey('User', $properties);
    $this->assertArrayHasKey('Reference', $properties);
    $this->assertArrayHasKey('LineAmountTypes', $properties);
    $this->assertArrayHasKey('SubTotal', $properties);
    $this->assertArrayHasKey('TotalTax', $properties);
    $this->assertArrayHasKey('Total', $properties);
    $this->assertArrayHasKey('ReceiptNumber', $properties);
    $this->assertArrayHasKey('Url', $properties);
    $this->assertArrayHasKey('Status', $properties);
    $this->assertArrayHasKey('UpdatedDateUTC', $properties);
    $this->assertArrayHasKey('HasAttachments', $properties);
  }
}
