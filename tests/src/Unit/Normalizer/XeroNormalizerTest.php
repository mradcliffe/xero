<?php
/**
 * @file
 * Provides \Drupal\Tests\xero\Normalizer\XeroNormalizerTest.
 */

namespace Drupal\Tests\xero\Unit\Normalizer;

use Drupal\xero\TypedData\Definition\AccountDefinition;
use Drupal\xero\Normalizer\XeroNormalizer;
use Drupal\xero\Plugin\DataType\XeroItemList;
use Drupal\serialization\Normalizer\ComplexDataNormalizer;
use Drupal\serialization\Normalizer\TypedDataNormalizer;
use Drupal\Core\TypedData\ListDataDefinition;
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
   * @property array $data
   */
  protected $data;

  /**
   * @property \Drupal\xero\Normalizer\XeroNormalizer $normalizer
   */
  protected $normalizer;

  /**
   * @property \Drupal\xero\TypedData\Definition\AccountDefinition $accountDefinition
   */
  protected $accountDefinition;

  /**
   * @property \Drupal\Core\TypedData\ListDataDefinitionInterface $listDefinition
   */
  protected $listDefinition;

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
    $this->listDefinition->setClass('\Drupal\xero\Plugin\DataType\XeroItemList');
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
   * Create a GUID.
   *
   * @param boolean $braces
   *   Whether to wrap the GUID in braces.
   * @return string
   *   A valid globally-unique identifier.
   */
  protected function createGuid($braces = TRUE) {
    $hash = strtoupper(hash('ripemd128', md5($this->getRandomGenerator()->string(100))));
    $guid = substr($hash, 0, 8) . '-' . substr($hash, 8, 4) . '-' . substr($hash, 12, 4);
    $guid .= '-' . substr($hash, 16, 4) . '-' . substr($hash, 20, 12);

    // A Guid string representation should be output as lower case per UUIDs
    // and GUIDs Network Working Group INTERNET-DRAFT 3.3.
    $guid = strtolower($guid);

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
    $itemList = XeroItemList::createInstance($this->listDefinition);

    $this->typedDataManager->expects($this->any())
      ->method('create')
      ->with($this->listDefinition, $this->data['Accounts']['Account'])
      ->will($this->returnValue($itemList));

    $items = $this->normalizer->denormalize($this->data, '\Drupal\xero\Plugin\DataType\Account', NULL, array('plugin_id' => 'xero_account'));
    $this->assertTrue(is_a($items, '\Drupal\xero\Plugin\DataType\XeroItemList'));
    $this->assertTrue(is_a($items->getItemDefinition(), '\Drupal\xero\TypedData\Definition\AccountDefinition'));
  }

  /**
   * Assert that returns a list of 1 account.
   */
  public function testDenormalizeOne() {
    $itemList = XeroItemList::createInstance($this->listDefinition);

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
    $this->assertTrue(is_a($items, '\Drupal\xero\Plugin\DataType\XeroItemList'));
    $this->assertTrue(is_a($items->getItemDefinition(), '\Drupal\xero\TypedData\Definition\AccountDefinition'));
  }
}
