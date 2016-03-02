<?php
/**
 * @file
 * Provides \Drupal\Tests\xero\XeroClientFactoryTest
 */

namespace Drupal\Tests\xero\Unit;

use Drupal\xero\XeroClientFactory;
use Drupal\Core\Logger\LoggerChannelFactory;
use Drupal\Tests\UnitTestCase;
use Symfony\Component\HttpKernel\Log\NullLogger;

/**
 * Tests getting the XeroClient class.
 *
 * @coversDefaultClass \Drupal\xero\XeroClientFactory;
 * @group Xero
 */
class XeroClientFactoryTest extends UnitTestCase {

  protected $pemFile;

  /**
   * {@inheritdoc}
   */
  protected function setUp() {

    $null_logger = new NullLogger();
    $this->loggerFactory = new LoggerChannelFactory();
    $this->loggerFactory->addLogger($null_logger);

    // Mock config object.
    $this->config = $this->getMockBuilder('\Drupal\Core\Config\ImmutableConfig')
      ->disableOriginalConstructor()
      ->getMock();

    // Mock config factory because it looks like a pain to invoke on null
    // storage just for a test.
    $this->configFactory = $this->getMockBuilder('\Drupal\Core\Config\ConfigFactory')
      ->disableOriginalConstructor()
      ->getMock();

    $this->configFactory->expects($this->any())
      ->method('get')
      ->with('xero.settings')
      ->will($this->returnValue($this->config));

    $this->factory = new XeroClientFactory();
  }

  /**
   * {@inheritdoc}
   */
  protected function tearDown() {
    if (file_exists($this->pemFile)) {
      unlink($this->pemFile);
    }

    parent::tearDown();
  }

  /**
   * Create a private key in memory for tests.
   *
   * @return string
   *   A memory stream wrapper for the private key data that can be used with
   *   file_get_contents().
   *
   * @see \BlackOptic\Bundle\XeroBundle\XeroClient::__construct().
   */
  private function createPrivateKey() {
    $output = '';
    $this->pemFile = $this->getRandomGenerator()->word(15) . '.pem';
    $resource = openssl_pkey_new(['digest_alg' => 'sha1', 'private_key_bits' => 1024, 'private_key_type' => OPENSSL_KEYTYPE_RSA]);
    openssl_pkey_export($resource, $output);

    file_put_contents($this->pemFile, $output);

    return $this->pemFile;
  }

  /**
   * Get xero configuration dummy data.
   *
   * @return []
   *   An associative array of cofiguration values to use.
   */
  protected function getConfiguration() {
    return [
      'consumer_key' => $this->getRandomGenerator()->string(32),
      'consumer_secret' => $this->getRandomGenerator()->string(32),
      'private_key' => $this->createPrivateKey(),
    ];
  }

  /**
   * Test with valid configuration.
   */
  public function testValid() {
    $xero_config = $this->getConfiguration();

    $this->config->expects($this->any())
      ->method('get')
      ->will($this->onConsecutiveCalls(
        $xero_config['consumer_key'],
        $xero_config['consumer_secret'],
        $xero_config['consumer_key'],
        $xero_config['consumer_secret'],
        $xero_config['private_key']
      ));

    if (!class_exists('\BlackOptic\Bundle\XeroBundle\XeroClient')) {
      $this->assertTrue(FALSE, 'XeroClient class is not found. Aborting test.');
      return;
    }

    $client = $this->factory->get($this->configFactory, $this->loggerFactory);
    $this->assertTrue(is_a($client, '\BlackOptic\Bundle\XeroBundle\XeroClient'));
  }


  /**
   * Test with no configuration.
   */
  public function testNotValid() {
    $this->config->expects($this->any())
      ->method('get')
      ->will($this->returnValue(NULL));

    if (!class_exists('\BlackOptic\Bundle\XeroBundle\XeroClient')) {
      $this->assertTrue(FALSE, 'XeroClient class is not found. Aborting test.');
      return;
    }

    $client = $this->factory->get($this->configFactory, $this->loggerFactory);
    $this->assertFalse($client, print_r($client, TRUE));
  }
}
