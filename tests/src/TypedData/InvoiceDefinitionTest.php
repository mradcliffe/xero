<?php
/**
 * @file
 * Provides \DrupalTests\xero\TypedData\InvoiceDefinitionTest.
 */

namespace Drupal\Tests\xero\TypedData;

use Drupal\Core\TypedData\DataDefinition;
use Drupal\xero\TypedData\Definition\InvoiceDefinition;
use Drupal\xero\Plugin\DataType\Invoice;
use Drupal\Tests\xero\Plugin\DataType\TestBase;

/**
 * Assert setting and getting Invoice properties.
 *
 * @coversDefaultClass \Drupal\xero\TypedData\Definition\InvoiceDefinition
 * @group Xero
 */
class InvoiceDefinitionTest extends TestBase {

  const XERO_TYPE = 'xero_invoice';
  const XERO_TYPE_CLASS = '\Drupal\xero\Plugin\DataType\Invoice';
  const XERO_DEFINITION_CLASS = '\Drupal\xero\TypedData\Definition\InvoiceDefinition';

  protected $invoice;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();

    // Create data type.
    $type_class = self::XERO_TYPE_CLASS;
    $this->invoice = new $type_class($this->dataDefinition, self::XERO_TYPE);
  }

  /**
   * Test getPropertyDefinitions.
   */
  public function testPropertyDefinitions() {
    $properties = $this->invoice->getProperties();

    $this->assertArrayHasKey('InvoiceID', $properties);
    $this->assertArrayHasKey('Type', $properties);
    $this->assertArrayHasKey('Contact', $properties);
    $this->assertArrayHasKey('LineItems', $properties);
    $this->assertArrayHasKey('Date', $properties);
    $this->assertArrayHasKey('DueDate', $properties);
    $this->assertArrayHasKey('LineAmountTypes', $properties);
    $this->assertArrayHasKey('InvoiceNumber', $properties);
    $this->assertArrayHasKey('Reference', $properties);
    $this->assertArrayHasKey('BrandingThemeID', $properties);
    $this->assertArrayHasKey('Url', $properties);
    $this->assertArrayHasKey('CurrencyCode', $properties);
    $this->assertArrayHasKey('CurrencyRate', $properties);
    $this->assertArrayHasKey('Status', $properties);
    $this->assertArrayHasKey('SentToContact', $properties);
    $this->assertArrayHasKey('ExpectedPaymentDate', $properties);
    $this->assertArrayHasKey('PlannedPaymentDate', $properties);
    $this->assertArrayHasKey('SubTotal', $properties);
    $this->assertArrayHasKey('TotalTax', $properties);
    $this->assertArrayHasKey('Total', $properties);
    $this->assertArrayHasKey('HasAttachments', $properties);
    $this->assertArrayHasKey('Payments', $properties);
    $this->assertArrayHasKey('AmountDue', $properties);
    $this->assertArrayHasKey('AmountPaid', $properties);
    $this->assertArrayHasKey('AmountCredited', $properties);
    $this->assertArrayHasKey('UpdatedDateUTC', $properties);
  }
}
