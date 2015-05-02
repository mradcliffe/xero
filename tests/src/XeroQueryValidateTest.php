<?php
/**
 * @file
 * Provides \Drupal\Tests\xero\XeroQueryValidateTest.
 */

namespace Drupal\Tests\xero;

use Drupal\xero\TypedData\Definition\AccountDefinition;
use Drupal\xero\TypedData\Definition\CreditDefinition;
use Drupal\xero\Plugin\DataType\Account;
use Drupal\xero\Plugin\DataType\CreditNote;
use Drupal\Tests\xero\XeroQueryTestBase;

class XeroQueryValidateTest extends XeroQueryTestBase {

  /**
   * @expectedException InvalidArgumentException
   */
  public function testNoType() {
    $this->query->validate();
  }

  /**
   * @dataProvider queryOptionsProvider
   * @expectedException InvalidArgumentException
   */
  public function testBadQuery($type, $method, $format = NULL, $headers = NULL, $has_condition = FALSE, $has_data = FALSE) {

    // Setup the xero type to use for this test.
    $definition = $this->setUpDefinition($type);

    $this->query->setType($type);
    $this->query->setMethod($method);

    if (isset($format)) {
      $this->query->setFormat($format);
    }

    if ($has_condition) {
      $this->query->addCondition('Name', '==', 'A');
    }

    if ($has_data) {
      $this->query->setData($this->typedDataManager->createInstance($type, array('name' => NULL, 'parent' => NULL)));
    }

    $this->query->validate();
  }

  /**
   * Provide various options to test validate method.
   *
   * @return []
   *   An array of indexed arrays of arguments to setup the query class with:
   *   type, method, format, header, hasCondition, hasData
   */
  public function queryOptionsProvider() {
    return [
      ['xero_credit_note', 'post', 'json', NULL, FALSE, TRUE],
      ['xero_credit_note', 'post', NULL, NULL, TRUE, TRUE],
      ['xero_credit_note', 'get', NULL, NULL, FALSE, TRUE],
      ['xero_account', 'get', 'pdf', NULL, NULL],
    ];
  }

  /**
   * Setup the definition for this test.
   *
   * @param $plugin_id
   *   The plugin id for the definition.
   * @return DataDefinitionInterface
   *   The data definition.
   */
  protected function setUpDefinition($plugin_id) {
    if ($plugin_id === 'xero_credit_note') {
      $definition = CreditDefinition::create($plugin_id);
      $definition->setClass('\Drupal\xero\Plugin\DataType\CreditNote');
      $data = new CreditNote($definition);
    }
    else {
      $definition = AccountDefinition::create($plugin_id);
      $definition->setClass('\Drupal\xero\Plugin\DataType\Account');
      $data = new Account($definition);
    }

    $this->typedDataManager->expects($this->any())
      ->method('getDefinition')
      ->with($plugin_id)
      ->willReturn($definition);
    $this->typedDataManager->expects($this->any())
      ->method('createInstance')
      ->with($plugin_id, array('name' => NULL, 'parent' => NULL))
      ->willReturn($data);

    return $definition;
  }

}
