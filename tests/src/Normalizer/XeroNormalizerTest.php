<?php
/**
 * @file
 * Provides \Drupal\Tests\xero\Normalizer\XeroNormalizerTest.
 */

namespace Drupal\Tests\xero\Normalizer;

use Drupal\xero\Plugin\DataType\Account;
use Drupal\xero\TypedData\Definition\AccountDefinition;
use Drupal\xero\Normalizer\XeroNormalizer;
use Drupal\serialization\Normalizer\ComplexDataNormalizer;
use Drupal\serialization\Normalizer\TypedDataNormalizer;
use Drupal\Core\TypedData\ListDataDefinition;
use Drupal\Core\TypedData\DataDefinition;
use Drupal\Core\TypedData\Plugin\DataType\ItemList;
use Drupal\Core\TypedData\Plugin\DataType\StringData;
use Drupal\Core\TypedData\Plugin\DataType\IntegerData;
use Drupal\Core\TypedData\TypedData;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Tests\UnitTestCase;
use Symfony\Component\Serializer\Serializer;

/**
 * Test cases for Xero Normalization.
 *
 * @covers \Drupal\xero\Normalizer\XeroNormalizer
 * @group Xero
 */
class XeroNormalizerTest extends UnitTestCase {

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    // Account data definition setup.
    $this->accountDefinition = AccountDefinition::create('xero_account');

    // Typed Data Manager setup.
    $this->typedDataManager = $this->getMockBuilder('\Drupal\Core\TypedData\TypedDataManager')
      ->disableOriginalConstructor()
      ->getMock();
    $this->typedDataManager->expects($this->any())
      ->method('createDataDefinition')
      ->with('xero_account')
      ->will($this->returnValue($this->accountDefinition));

    // Mock the container.
    $container = new ContainerBuilder();
    $container->set('typed_data_manager', $this->typedDataManager);
    \Drupal::setContainer($container);

    // Now do list data definition creation mocking.
    $this->listDefinition = ListDataDefinition::create('xero_account');
    $this->listDefinition->setClass('\Drupal\Core\TypedData\Plugin\DataType\ItemList');
    $this->typedDataManager->expects($this->any())
      ->method('createListDataDefinition')
      ->with('xero_account')
      ->will($this->returnValue($this->listDefinition));

    // Create a normalizer.
    $this->typeddata_normalizer = new TypedDataNormalizer();
    $this->complex_normalizer = new ComplexDataNormalizer();
    $this->normalizer = new XeroNormalizer($this->typedDataManager);
    $this->normalizer->setSerializer(new Serializer([$this->complex_normalizer, $this->normalizer, $this->typeddata_normalizer]));

    // Setup account data to emulate deserialization.
    $this->data = array(
      'Accounts' => array(
        'Account' => array(
          array(
            'AccountID' => $this->createGuid(),
            'Name' => $this->getRandomGenerator()->word(10),
            'Code' => '200',
            'Type' => 'BANK'
          ),
        ),
      ),
    );
  }

  /**
   * Create a Guid.
   *
   * @return string
   *   A valid globally-unique identifier.
   */
  protected function createGuid($braces = TRUE) {
    $hash = strtoupper(hash('ripemd128', md5($this->getRandomGenerator()->string(100))));
    $guid = substr($hash, 0, 8) . '-' . substr($hash, 8, 4) . '-' . substr($hash, 12, 4);
    $guid .= '-' . substr($hash, 16, 4) . '-' . substr($hash, 20, 12);
    return $guid;
  }

  /**
   * Assert that exception is thrown for missing plugin id argument.
   *
   * @expectedException \Symfony\Component\Serializer\Exception\UnexpectedValueException
   */
  public function testMissingPluginId() {
    $this->normalizer->denormalize(NULL, '\Drupal\xero\Plugin\DataType\Account', NULL, array());
  }

  /**
   * Assert that returns a list of accounts.
   *
   * @covers \Drupal\xero\Normalizer\XeroNormalizer::denormalize
   */
  public function testDenormalize() {
    $itemList = ItemList::createInstance($this->listDefinition);

    $this->typedDataManager->expects($this->any())
      ->method('create')
      ->with($this->listDefinition, $this->data['Accounts']['Account'])
      ->will($this->returnValue($itemList));

    $items = $this->normalizer->denormalize($this->data, '\Drupal\xero\Plugin\DataType\Account', NULL, array('plugin_id' => 'xero_account'));
    $this->assertTrue(is_a($items, '\Drupal\Core\TypedData\Plugin\DataType\ItemList'));
    $this->assertTrue(is_a($items->getItemDefinition(), '\Drupal\xero\TypedData\Definition\AccountDefinition'));
  }

  /**
   * Assert that returns a list of 1 account.
   */
  public function testDenormalizeOne() {
    $itemList = ItemList::createInstance($this->listDefinition);

    $data = array(
      'Accounts' => array(
        'Account' => $this->data['Accounts']['Account'][0],
      ),
    );

    $this->typedDataManager->expects($this->any())
      ->method('create')
      ->with($this->listDefinition, $this->data['Accounts']['Account'])
      ->will($this->returnValue($itemList));

    $items = $this->normalizer->denormalize($data, '\Drupal\xero\Plugin\DataType\Account', NULL, array('plugin_id' => 'xero_account'));
    $this->assertTrue(is_a($items, '\Drupal\Core\TypedData\Plugin\DataType\ItemList'));
    $this->assertTrue(is_a($items->getItemDefinition(), '\Drupal\xero\TypedData\Definition\AccountDefinition'));
  }

  /**
   * Assert that several Typed Data item can be normalized correctly.
   *
   * @covers \Drupal\xero\Normalizer\XeroNormalizer::normalize
   */
  public function testNormalize() {
    $this->data['Accounts']['Account'][] = array(
      'AccountID' => $this->createGuid(),
      'Name' => $this->getRandomGenerator()->word(10),
      'Code' => '200',
      'Type' => 'BANK'
    );
    $expect = $this->data;

    $string_def = DataDefinition::create('string');
    $integer_def = DataDefinition::create('integer');
    $guid[] = new StringData($string_def);
    $guid[] = new StringData($string_def);
    $name[] = new StringData($string_def);
    $name[] = new StringData($string_def);
    $code[] = new IntegerData($integer_def);
    $code[] = new IntegerData($integer_def);
    $type[] = new StringData($string_def);
    $type[] = new StringData($string_def);

    $guid[0]->setValue($this->data['Accounts']['Account'][0]['AccountID']);
    $name[0]->setValue($this->data['Accounts']['Account'][0]['Name']);
    $code[0]->setValue($this->data['Accounts']['Account'][0]['Code']);
    $type[0]->setValue($this->data['Accounts']['Account'][0]['Type']);
    $guid[1]->setValue($this->data['Accounts']['Account'][1]['AccountID']);
    $name[1]->setValue($this->data['Accounts']['Account'][1]['Name']);
    $code[1]->setValue($this->data['Accounts']['Account'][1]['Code']);
    $type[1]->setValue($this->data['Accounts']['Account'][1]['Type']);

    $itemList = ItemList::createInstance($this->listDefinition);
    $account = Account::createInstance($this->accountDefinition);
    $account->setValue($this->data['Accounts']['Account'][0], FALSE);

    $account2 = Account::createInstance($this->accountDefinition);
    $account2->setValue($this->data['Accounts']['Account'][1], FALSE);

    $this->typedDataManager->expects($this->any())
      ->method('create')
      ->with($this->listDefinition, $this->data['Accounts']['Account'])
      ->will($this->returnValue($itemList));

    $this->typedDataManager->expects($this->any())
      ->method('getPropertyInstance')
      ->withConsecutive(
        array($itemList, 0, $account),
        array($itemList, 1, $account2),
        array($account, 'AccountID', $this->data['Accounts']['Account'][0]['AccountID']),
        array($account, 'Code', $this->data['Accounts']['Account'][0]['Code']),
        array($account, 'Name', $this->data['Accounts']['Account'][0]['Name']),
        array($account, 'Type', $this->data['Accounts']['Account'][0]['Type']),
        array($account, 'Description', null),
        array($account, 'TaxType', null),
        array($account, 'EnablePaymentsToAccount', null),
        array($account, 'ShowInExpenseClaims', null),
        array($account, 'Class', null),
        array($account, 'Status', null),
        array($account, 'SystemAccount', null),
        array($account, 'BankAccountNumber', null),
        array($account, 'CurrencyCode', null),
        array($account, 'ReportingCode', null),
        array($account, 'ReportingCodeName', null),
        array($account2, 'AccountID', $this->data['Accounts']['Account'][1]['AccountID']),
        array($account2, 'Code', $this->data['Accounts']['Account'][1]['Code']),
        array($account2, 'Name', $this->data['Accounts']['Account'][1]['Name']),
        array($account2, 'Type', $this->data['Accounts']['Account'][1]['Type'])
      )
      ->will($this->onConsecutiveCalls(
        $account, $account2, $guid[0], $code[0], $name[0], $type[0],
        null, null, null, null, null, null, null, null, null, null, null,
        $guid[1], $code[1], $name[1], $type[1]
      ));

    $itemList->setValue([0 => $account, 1 => $account2]);

    $items = $this->typedDataManager->create($this->listDefinition, $this->data['Accounts']['Account']);

    $data = $this->normalizer->normalize($items, 'xml', array('plugin_id' => 'xero_account'));

    $this->assertArrayEquals($expect, $data, print_r($data, TRUE));
  }

  /**
   * Assert that one Typed Data item can be normalized correctly.
   *
   * @covers \Drupal\xero\Normalizer\XeroNormalizer::normalize
   */
  public function testNormalizeOne() {
    $expect = array(
      'Accounts' => array(
        'Account' => $this->data['Accounts']['Account'][0],
      ),
    );
    $string_def = DataDefinition::create('string');
    $integer_def = DataDefinition::create('integer');
    $guid = new StringData($string_def);
    $name = new StringData($string_def);
    $code = new IntegerData($integer_def);
    $type = new StringData($string_def);

    $guid->setValue($this->data['Accounts']['Account'][0]['AccountID']);
    $name->setValue($this->data['Accounts']['Account'][0]['Name']);
    $code->setValue($this->data['Accounts']['Account'][0]['Code']);
    $type->setValue($this->data['Accounts']['Account'][0]['Type']);

    $itemList = ItemList::createInstance($this->listDefinition);
    $account = Account::createInstance($this->accountDefinition);
    $account->setValue($this->data['Accounts']['Account'][0], FALSE);

    $this->typedDataManager->expects($this->any())
      ->method('create')
      ->with($this->listDefinition, $this->data['Accounts']['Account'])
      ->will($this->returnValue($itemList));

    $this->typedDataManager->expects($this->any())
      ->method('getPropertyInstance')
      ->withConsecutive(
        array($itemList, 0, $account),
        array($account, 'AccountID', $this->data['Accounts']['Account'][0]['AccountID']),
        array($account, 'Code', $this->data['Accounts']['Account'][0]['Code']),
        array($account, 'Name', $this->data['Accounts']['Account'][0]['Name']),
        array($account, 'Type', $this->data['Accounts']['Account'][0]['Type'])
      )
      ->will($this->onConsecutiveCalls($account, $guid, $code, $name, $type));

    $itemList->setValue([0 => $account]);

    $items = $this->typedDataManager->create($this->listDefinition, $this->data['Accounts']['Account']);

    $data = $this->normalizer->normalize($items, 'xml', array('plugin_id' => 'xero_account'));

    $this->assertArrayEquals($expect, $data, print_r($data, TRUE));
  }
}
