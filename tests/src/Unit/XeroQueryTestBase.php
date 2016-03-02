<?php
/**
 * @file
 * Provides \Drupal\Tests\xero\XeroQueryTestBase.
 */

namespace Drupal\Tests\xero\Unit;

use Drupal\Core\Cache\NullBackend;
use Drupal\xero\XeroQuery;
use Drupal\Core\Logger\LoggerChannelFactory;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Tests\UnitTestCase;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpKernel\Log\NullLogger;

class XeroQueryTestBase extends UnitTestCase {

  /**
   * @var \Drupal\Core\TypedData\TypedDataManager
   */
  protected $typedDataManager;

  /**
   * @var \Symfony\Component\Serializer\Serializer
   */
  protected $serializer;

  /**
   * @var \Psr\Log\LoggerInterface;
   */
  protected $loggerFactory;

  /**
   * @var \BlackOptic\Bundle\XeroBundle\XeroClient
   */
  protected $client;

  /**
   * @var \Drupal\xero\XeroQuery
   */
  protected $query;

  protected function setUp() {
    parent::setUp();

    // Setup the Serializer component class.
    $this->serializer = new Serializer();

    // Setup a Null cache backend.
    $cache = new NullBackend('xero_query');

    // Setup LoggerChannelFactory.
    $this->loggerFactory = new LoggerChannelFactory();
    $this->loggerFactory->addLogger(new NullLogger());

    // Mock the Typed Data Manager.
    $this->typedDataManager = $this->getMockBuilder('Drupal\Core\TypedData\TypedDataManager')
      ->disableOriginalConstructor()
      ->getMock();

    // Mock XeroClient.
    $this->client = $this->getMockBuilder('BlackOptic\Bundle\XeroBundle\XeroClient')
      ->disableOriginalConstructor()
      ->getMock();

    // Setup the container.
    $container = new ContainerBuilder();
    $container->set('typed_data_manager', $this->typedDataManager);
    \Drupal::setContainer($container);

    $this->query = new XeroQuery($this->client, $this->serializer, $this->typedDataManager, $this->loggerFactory, $cache);
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

    // A Guid string representation should be output as lower case per UUIDs
    // and GUIDs Network Working Group INTERNET-DRAFT 3.3.
    $guid = strtolower($guid);

    return $guid;
  }
}
