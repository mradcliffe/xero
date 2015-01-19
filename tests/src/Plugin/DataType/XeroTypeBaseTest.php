<?php
/**
 * @file
 * Provides \DrupalTests\xero\Plugin\DataType\XeroTypeBaseTest.
 */

namespace Drupal\Tests\xero\Plugin\DataType;

use Drupal\xero\Plugin\DataType\Payment;
use Drupal\xero\TypedData\Definition\PaymentDefinition;

/**
 * Assert setting and getting Payment properties.
 *
 * @coversDefaultClass \Drupal\xero\Plugin\DataType\XeroTypeBase
 * @group Xero
 */
class XeroTypeBaseTest extends TestBase {

  const XERO_TYPE = 'xero_payment';
  const XERO_TYPE_CLASS = '\Drupal\xero\Plugin\DataType\Payment';
  const XERO_DEFINITION_CLASS = '\Drupal\xero\TypedData\Definition\PaymentDefinition';

  /**
   * Test methods.
   */
  public function testMethods() {
    // Create data type.
    $type_class = self::XERO_TYPE_CLASS;
    $payment = new $type_class($this->dataDefinition, self::XERO_TYPE);

    $this->assertEquals('PaymentID', $payment->getGUIDName(), print_r($payment, TRUE));
    $this->assertEquals('Payments', $payment->getPluralName());
    $this->assertEquals('PaymentID', $payment->getLabelName());
  }
}
