<?php
/**
 * @file
 * Provides \DrupalTests\xero\TypedData\PaymentDefinitionTest.
 */

namespace Drupal\Tests\xero\TypedData;

use Drupal\Core\TypedData\DataDefinition;
use Drupal\xero\TypedData\Definition\PaymentDefinition;
use Drupal\xero\Plugin\DataType\Payment;
use Drupal\Tests\xero\Plugin\DataType\TestBase;

/**
 * Assert setting and getting Payment properties.
 *
 * @coversDefaultClass \Drupal\xero\TypedData\Definition\PaymentDefinition
 * @group Xero
 */
class PaymentDefinitionTest extends TestBase {

  const XERO_TYPE = 'xero_payment';
  const XERO_TYPE_CLASS = '\Drupal\xero\Plugin\DataType\Payment';
  const XERO_DEFINITION_CLASS = '\Drupal\xero\TypedData\Definition\PaymentDefinition';

  protected $payment;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();

    // Create data type.
    $type_class = self::XERO_TYPE_CLASS;
    $this->payment = new $type_class($this->dataDefinition, self::XERO_TYPE);
  }

  /**
   * Test getPropertyDefinitions.
   */
  public function testPropertyDefinitions() {
    $properties = $this->payment->getProperties();

    $this->assertArrayHasKey('Invoice', $properties);
    $this->assertArrayHasKey('Account', $properties);
    $this->assertArrayHasKey('Date', $properties);
    $this->assertArrayHasKey('Amount', $properties);
    $this->assertArrayHasKey('CurrencyRate', $properties);
    $this->assertArrayHasKey('Reference', $properties);
    $this->assertArrayHasKey('IsReconciled', $properties);
  }
}
