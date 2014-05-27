<?php
/**
 * @file
 * Provides \Drupal\xero\XeroClientFactory.
 */

namespace Drupal\xero;

use BlackOptic\Bundle\XeroBundle\XeroClient;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;

/**
 * Xero client factory class.
 */
class XeroClientFactory {

  /**
   * Return a configured XeroClient object.
   */
  public function get(ConfigFactoryInterface $config_factory, LoggerChannelFactoryInterface $logger_factory) {
    $config = $config_factory->get('xero.settings');
    $xero_config = array(
      'base_url' => 'https://api.xero.com/api.xro/2.0',
      'token' => $config->get('xero_consumer_key', ''),
      'token_secret' => $config->get('xero_consumer_secret', ''),
      'consumer_key' => $config->get('xero_consumer_key', ''),
      'consumer_secret' => $config->get('xero_consumer_secret', ''),
      'private_key' => $config->get('xero_key_path', '')
    );

    try {
      $client = new XeroClient($xero_config);

      return $client;
    }
    catch (\Exception $e) {
      $logger = $logger_factory->get('xero');
      $logger->error($e->getMessage());
      return FALSE;
    }
  }
}
