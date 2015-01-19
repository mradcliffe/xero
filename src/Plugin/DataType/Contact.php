<?php
/**
 * @file
 * Provides \Drupal\xero\Plugin\DataType\Contact.
 */

namespace Drupal\xero\Plugin\DataType;

/**
 * Xero Contact type.
 *
 * @DataType(
 *   id = "xero_contact",
 *   label = @Translation("Xero Contact"),
 *   definition_class = "\Drupal\xero\TypedData\Definition\ContactDefinition"
 * )
 */
class Contact extends XeroTypeBase {

  static public $guid_name = 'ContactID';
  static public $xero_name = 'Contact';
  static public $plural_name = 'Contacts';
  static public $label = 'Name';

  /**
   * Find if the contact is a customer. The value returned and set by the API
   * is a string, but hopefully that is normalized by Serializer as a boolean.
   *
   * @return boolean
   *   TRUE if the contact is a customer.
   */
  public function isCustomer() {
    $isCustomer = $this->get('isCustomer');

    return $isCustomer == TRUE;
  }

  /**
   * Find if the contact is a supplier.
   *
   * @return boolean
   *   TRUE if the contact is a supplier.
   */
  public function isSupplier() {
    $isSupplier = $this->get('isSupplier');

    return $isSupplier == TRUE;
  }

}
