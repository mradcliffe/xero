<?php
/**
 * @file
 * Provides \Drupal\xero\Form\XeroConfigurationForm.
 */

namespace Drupal\xero\Form;

use Drupal\Core\Form\ConfigFormBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provide configuration form for user to provide Xero API information for a
 * private application.
 */
class XeroConfigurationForm extends ConfigFormBase implements ContainerInjectionInterface {

  protected $client = FALSE;

  /**
   * {@inheritdoc}
   */
  public function __construct(ConfigFactoryInterface $config_factory, XeroClient $client) {
    $this->setConfigFactory($config_factory);
    $this->client = $client;
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, array &$form_state) {

    // Open the fieldset if there was a problem loading the library.
    $form['xero'] = array(
      '#type' => 'fieldset',
      '#title' => t('Xero Configuration'),
      '#collapsible' => TRUE,
      '#collapsed' => $this->client !== FALSE,
    );

    $form['xero']['xero_consumer_key'] = array(
      '#type' => 'textfield',
      '#title' => t('Xero Consumer Key'),
      '#description' => t('Provide the consumer key for your private application on xero.'),
      '#default_value' => variable_get('xero_consumer_key', ''),
      '#required' => TRUE,
    );

    $form['xero']['xero_consumer_secret'] = array(
      '#type' => 'textfield',
      '#title' => t('Xero Consumer Secret'),
      '#description' => t('Provide the consumer secret for your private application on xero.'),
      '#default_value' => variable_get('xero_consumer_secret', ''),
      '#required' => TRUE,
    );

    $form['xero']['xero_cert_path'] = array(
      '#type' => 'textfield',
      '#title' => t('Xero Certificate Path'),
      '#description' => t('Provide the full path and file name to your Xero certificate.'),
      '#default_value' => variable_get('xero_cert_path', ''),
      // '#element_validate' => array('xero_admin_settings_validate_exists'),
      '#required' => TRUE,
    );

    $form['xero']['xero_key_path'] = array(
      '#type' => 'textfield',
      '#title' => t('Xero Key Path'),
      '#description' => t('Provide the full path and file name to your Xero certificate private key.'),
      '#default_value' => variable_get('xero_key_path', ''),
      // '#element_validate' => array('xero_admin_settings_validate_exists'),
      '#required' => TRUE,
    );

    parent::buildForm($form, $form_state);

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static($container->get('config.factory'), $container->get('xero.client'));
  }
}
