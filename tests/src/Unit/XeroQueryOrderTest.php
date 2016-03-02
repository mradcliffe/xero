<?php
/**
 * @file
 * Provides \Drupal\Tests\xero\XeroQueryOrderTest.
 */

namespace Drupal\Tests\xero\Unit;

use Drupal\Tests\xero\UnitXeroQueryTestBase;

class XeroQueryOrderTest extends XeroQueryTestBase {

  /**
   * Assert order by method.
   *
   * @dataProvider directionProvider
   */
  public function testOrderBy($direction, $expected) {
    $this->query->orderBy('Name', $direction);
    $options = $this->query->getOptions();
    $this->assertEquals($expected, $options['query']['order']);
  }

  /**
   * Provide options for testing order by directions.
   *
   * @return []
   *   An array of directions and expected values.
   */
  public function directionProvider() {
    return [
      ['ASC', 'Name'],
      ['DESC', 'Name DESC']
    ];
  }

}
