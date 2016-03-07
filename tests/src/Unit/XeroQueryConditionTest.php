<?php
/**
 * @file
 * Provides \Drupal\Tests\xero\XeroQueryConditionTest.
 */

namespace Drupal\Tests\xero\Unit;

use Drupal\Tests\xero\UnitXeroQueryTestBase;

/**
 * @group Xero
 */
class XeroQueryConditionTest extends XeroQueryTestBase {

  /**
   * @expectedException InvalidArgumentException
   */
  public function testBadCondition() {
    $this->query->addCondition('Name', 'a', 'garbage');
  }

  /**
   * @expectedException InvalidArgumentException
   */
  public function testBadLogicalOperator() {
    $this->query->addOperator('NOT');
  }

  /**
   * Assert logical operator.
   *
   * @todo should this protect against making poor queries to Xero API?
   */
  public function testLogicalOperator() {
    $this->query->addOperator('OR');
    $conditions = $this->query->getConditions();
    $this->assertEquals('OR', $conditions[0]);
  }

  /**
   * Assert that operators work correctly.
   *
   * @dataProvider operatorProvider
   */
  public function testOperators($operator, $value, $expected) {
    $this->query->addCondition('Name', $value, $operator);
    $conditions = $this->query->getConditions();
    $this->assertEquals(1, count($conditions));
    $this->assertEquals($expected, $conditions[0]);
  }

  /**
   * Assert that Guid operator works correctly.
   */
  public function testGuidOperator() {
    $guid = $this->createGuid();
    $this->query->addCondition('ContactID', $guid, 'guid');
    $conditions = $this->query->getConditions();
    $this->assertEquals('ContactID= Guid("' . $guid . '")', $conditions[0]);
  }

  /**
   * Provide options for testing operators.
   *
   * @return []
   *   An array of coditions
   */
  public function operatorProvider() {
    return [
      ['==', 'a', 'Name=="a"'],
      ['==', FALSE, 'Name=="false"'],
      ['!=', 'a', 'Name!="a"'],
      ['StartsWith', 'a', 'Name.StartsWith("a")'],
      ['EndsWith', 'a', 'Name.EndsWith("a")'],
      ['Contains', 'a', 'Name.Contains("a")'],
    ];
  }

}
