<?php
/**
 * @file
 * Provides \Drupal\xero\TypedData\Plugin\DataType\Payment.
 */

namespace Drupal\xero\TypedData\Plugin\DataType;

/**
 * Xero Payment type.
 *
 * @DataType(
 *   "id" => "xero_payment",
 *   "label" => @Translation("Xero Payment"),
 *   "definition_class" => "\Drupal\xero\TypedData\Definition\PaymentDefinition"
 * )
 */
class Payment extends XeroTypeBase {

  static protected $guid_name = 'PaymentID';
  static protected $plural_name = 'Payments';
  static protected $label = 'PaymentID';

  /**
   * {@inheritdoc}
   */
  protected function getPropertyDefinitions() {
    return $this->definition->getPropertyDefinitions();
  }

}
