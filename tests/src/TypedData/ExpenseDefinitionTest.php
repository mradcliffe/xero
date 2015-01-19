<?php
/**
 * @file
 * Provides \DrupalTests\xero\TypedData\ExpenseDefinitionTest.
 */

namespace Drupal\Tests\xero\TypedData;

use Drupal\Core\TypedData\DataDefinition;
use Drupal\xero\TypedData\Definition\ExpenseDefinition;
use Drupal\xero\Plugin\DataType\Expense;
use Drupal\Tests\xero\Plugin\DataType\TestBase;

/**
 * Assert setting and getting Expense properties.
 *
 * @coversDefaultClass \Drupal\xero\TypedData\Definition\ExpenseDefinition
 * @group Xero
 */
class ExpenseDefinitionTest extends TestBase {

  const XERO_TYPE = 'xero_expense';
  const XERO_TYPE_CLASS = '\Drupal\xero\Plugin\DataType\Expense';
  const XERO_DEFINITION_CLASS = '\Drupal\xero\TypedData\Definition\ExpenseDefinition';

  protected $expense;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();

    // Create data type.
    $type_class = self::XERO_TYPE_CLASS;
    $this->expense = new $type_class($this->dataDefinition, self::XERO_TYPE);
  }

  /**
   * Test getPropertyDefinitions.
   */
  public function testPropertyDefinitions() {
    $properties = $this->expense->getProperties();

    $this->assertArrayHasKey('ExpenseClaimID', $properties);
    $this->assertArrayHasKey('User', $properties);
    $this->assertArrayHasKey('Receipts', $properties);
    $this->assertArrayHasKey('ExpenseNumber', $properties);
    $this->assertArrayHasKey('Status', $properties);
    $this->assertArrayHasKey('UpdatedDateUTC', $properties);
    $this->assertArrayHasKey('Total', $properties);
    $this->assertArrayHasKey('AmountDue', $properties);
    $this->assertArrayHasKey('PaymentDueDate', $properties);
    $this->assertArrayHasKey('ReportingDate', $properties);
  }
}
