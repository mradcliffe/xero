<?php
/**
 * @file
 * Provides \DrupalTests\xero\TypedData\BankTransactionDefinitionTest.
 */

namespace Drupal\Tests\xero\TypedData;

use Drupal\Core\TypedData\DataDefinition;
use Drupal\xero\TypedData\Definition\BankTransactionDefinition;
use Drupal\xero\Plugin\DataType\BankTransaction;
use Drupal\Tests\xero\Plugin\DataType\TestBase;

/**
 * Assert setting and getting BankTransaction properties.
 *
 * @coversDefaultClass \Drupal\xero\TypedData\Definition\BankTransactionDefinition
 * @group Xero
 */
class BankTransactionDefinitionTest extends TestBase {

  const XERO_TYPE = 'xero_bank_transaction';
  const XERO_TYPE_CLASS = '\Drupal\xero\Plugin\DataType\BankTransaction';
  const XERO_DEFINITION_CLASS = '\Drupal\xero\TypedData\Definition\BankTransactionDefinition';

  protected $bank_transaction;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();

    // Create data type.
    $type_class = self::XERO_TYPE_CLASS;
    $this->bank_transaction = new $type_class($this->dataDefinition, self::XERO_TYPE);
  }

  /**
   * Test getPropertyDefinitions.
   */
  public function testPropertyDefinitions() {
    $properties = $this->bank_transaction->getProperties();

    $this->assertArrayHasKey('BankTransactionID', $properties);
    $this->assertArrayHasKey('Type', $properties);
    $this->assertArrayHasKey('Contact', $properties);
    $this->assertArrayHasKey('LineItems', $properties);
    $this->assertArrayHasKey('BankAccount', $properties);
    $this->assertArrayHasKey('DueDate', $properties);
    $this->assertArrayHasKey('LineAmountTypes', $properties);
    $this->assertArrayHasKey('IsReconciled', $properties);
    $this->assertArrayHasKey('Date', $properties);
    $this->assertArrayHasKey('Reference', $properties);
    $this->assertArrayHasKey('CurrencyRate', $properties);
    $this->assertArrayHasKey('Url', $properties);
    $this->assertArrayHasKey('Status', $properties);
    $this->assertArrayHasKey('SubTotal', $properties);
    $this->assertArrayHasKey('Total', $properties);
    $this->assertArrayHasKey('TotalTax', $properties);
    $this->assertArrayHasKey('UpdatedDateUTC', $properties);
  }
}
