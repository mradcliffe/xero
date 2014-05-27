<?php
/**
 * @file
 * Provides \Drupal\xero\TypedData\Plugin\DataType\Employee.
 */

namespace Drupal\xero\TypedData\Plugin\DataType;

/**
 * Xero Employee type.
 *
 * @DataType(
 *   "id" => "xero_employee",
 *   "label" => @Translation("Xero Employee"),
 *   "definition_class" => "\Drupal\xero\TypedData\Definition\EmployeeDefinition"
 * )
 */
class Employee extends XeroTypeBase {

  static protected $guid_name = 'EmployeeID';
  static protected $plural_name = 'Employees';
  static protected $label = 'LastName';

  /**
   * {@inheritdoc}
   */
  protected function getPropertyDefinitions() {
    return $this->definition->getPropertyDefinitions();
  }

  /**
   * Is the employee active?
   *
   * @return boolean
   *   TRUE if the employee is active.
   */
  public function isActive() {
    return $this->get('Status') == 'ACTIVE';
  }

}
