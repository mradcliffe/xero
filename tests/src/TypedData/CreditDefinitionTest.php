<?php
/**
 * @file
 * Provides \DrupalTests\xero\TypedData\CreditDefinitionTest.
 */

namespace Drupal\Tests\xero\TypedData;

use Drupal\Core\TypedData\DataDefinition;
use Drupal\xero\TypedData\Definition\CreditDefinition;
use Drupal\xero\Plugin\DataType\CreditNote;
use Drupal\Tests\xero\Plugin\DataType\TestBase;

/**
 * Assert setting and getting CreditNote properties.
 *
 * @coversDefaultClass \Drupal\xero\TypedData\Definition\CreditDefinition
 * @group Xero
 */
class CreditDefinitionTest extends TestBase {

  const XERO_TYPE = 'xero_credit_note';
  const XERO_TYPE_CLASS = '\Drupal\xero\Plugin\DataType\CreditNote';
  const XERO_DEFINITION_CLASS = '\Drupal\xero\TypedData\Definition\CreditDefinition';

  protected $credit_note;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();

    // Create data type.
    $type_class = self::XERO_TYPE_CLASS;
    $this->credit_note = new $type_class($this->dataDefinition, self::XERO_TYPE);
  }

  /**
   * Test getPropertyDefinitions.
   */
  public function testPropertyDefinitions() {
    $properties = $this->credit_note->getProperties();

    $this->assertArrayHasKey('CreditNoteID', $properties);
    $this->assertArrayHasKey('Type', $properties);
    $this->assertArrayHasKey('Contact', $properties);
    $this->assertArrayHasKey('Date', $properties);
    $this->assertArrayHasKey('LineAmountTypes', $properties);
    $this->assertArrayHasKey('LineItems', $properties);
    $this->assertArrayHasKey('Reference', $properties);
    $this->assertArrayHasKey('Status', $properties);
    $this->assertArrayHasKey('CreditNoteNumber', $properties);
    $this->assertArrayHasKey('SubTotal', $properties);
    $this->assertArrayHasKey('TotalTax', $properties);
    $this->assertArrayHasKey('Total', $properties);
    $this->assertArrayHasKey('CurrencyCode', $properties);
    $this->assertArrayHasKey('BrandingThemeID', $properties);
    $this->assertArrayHasKey('SentToContact', $properties);
    $this->assertArrayHasKey('UpdatedDateUTC', $properties);
    $this->assertArrayHasKey('FullyPaidOnDate', $properties);
  }
}
