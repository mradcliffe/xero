<?php
/**
 * @file
 * Provides \Drupal\xero\Plugin\DataType\Payment.
 */

namespace Drupal\xero\Plugin\DataType;

/**
 * Xero Payment type.
 *
 * @DataType(
 *   id = "xero_payment",
 *   label = @Translation("Xero Payment"),
 *   definition_class = "\Drupal\xero\TypedData\Definition\PaymentDefinition"
 * )
 */
class Payment extends XeroTypeBase {

  static public $guid_name = 'PaymentID';
  static public $xero_name = 'Payment';
  static public $plural_name = 'Payments';
  static public $label = 'PaymentID';

  /**
   * {@inheritdoc}
   */
  protected function getPropertyDefinitions() {
    return $this->definition->getPropertyDefinitions();
  }

}
