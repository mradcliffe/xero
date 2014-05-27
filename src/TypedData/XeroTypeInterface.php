<?php
/**
 * @file
 * Provides \Drupal\xero\TypedData\XeroTypeInterface.
 */

namespace Drupal\xero\TypedData;

/**
 * Interface to describe methods useful for Xero API integration that Xero
 * complex data types in Drupal must adhere (i.e. Contacts, but not LineItems).
 */
interface XeroTypeInterface {

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
}
