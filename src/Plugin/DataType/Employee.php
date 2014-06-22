<?php
/**
 * @file
 * Provides \Drupal\xero\Plugin\DataType\Employee.
 */

namespace Drupal\xero\Plugin\DataType;

/**
 * Xero Employee type.
 *
 * @DataType(
 *   id = "xero_employee",
 *   label = @Translation("Xero Employee"),
 *   definition_class = "\Drupal\xero\TypedData\Definition\EmployeeDefinition"
 * )
 */
class Employee extends XeroTypeBase {

  static public $guid_name = 'EmployeeID';
  static public $xero_name = 'Employee';
  static public $plural_name = 'Employees';
  static public $label = 'LastName';

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
