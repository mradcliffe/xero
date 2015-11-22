<?php
/**
 * @file
 * Provides \Drupal\xero\TypedData\XeroTypeInterface.
 */

namespace Drupal\xero\TypedData;

use Drupal\Core\TypedData\TypedDataInterface;

/**
 * Interface to describe methods useful for Xero API integration that Xero
 * complex data types in Drupal must adhere (i.e. Contacts, but not LineItems).
 */
interface XeroTypeInterface extends TypedDataInterface {

  /**
   * Get the GUID property name.
   *
   * @param string
   *   The name of the Xero GUID field for this type.
   */
  public function getGUIDName();

  /**
   * Get the Plural property name.
   *
   * @param string
   *   The plural for this type.
   */
  public function getPluralName();

  /**
   * Get the Label property.
   *
   * @param string
   *   The Label property for this type, if any.
   */
  public function getLabelName();

  /**
   * Render the typed data into a render element.
   *
   * @return array
   *   A render array.
   */
  public function view();
}
