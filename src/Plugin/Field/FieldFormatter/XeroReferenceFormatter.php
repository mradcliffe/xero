<?php
/**
 * @file
 * Provides \Drupal\xero\Plugin\Field\FieldFormatter\XeroReferenceFormatter.
 */

namespace Drupal\xero\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\TypedData\TypedDataManagerInterface;

/**
 * Xero Reference field formatter.
 *
 * @FieldFormatter(
 *   id = "xero_reference",
 *   label = @Translation("Xero Reference"),
 *   field_types = {
 *     "xero_reference",
 *   },
 * )
 */
class XeroReferenceFormatter extends FormatterBase implements ContainerFactoryPluginInterface {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return array(
      'display' => array('guid' => 'guid', 'label' => 'label', 'type' => 'type'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public static function create(\Symfony\Component\DependencyInjection\ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $plugin_id,
      $plugin_definition,
      $configuration['field_definition'],
      $configuration['settings'],
      $configuration['label'],
      $configuration['view_mode'],
      $configuration['third_party_settings'],
      $container->get('typed_data_manager')
    );
  }

  /**
   * Get the typed data manager from \Drupal. This cannot use type hinting
   * because TypedDataManager must be mocked in PHPUnit. DrupalWTF.
   *
   * {@inheritdoc}
   */
  public function __construct($plugin_id, $plugin_definition, FieldDefinitionInterface $definition, array $settings, $label, $view_mode, array $third_party_settings, $typed_data_manager) {

    parent::__construct($plugin_id, $plugin_definition, $definition, $settings, $label, $view_mode, $third_party_settings);
    $this->typedDataManager = $typed_data_manager;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $form['display'] = array(
      '#type' => 'select',
      '#title' => t('Display fields'),
      '#options' => array('guid' => t('GUID'), 'label' => t('Label'), 'type' => t('Xero type')),
      '#multiple' => TRUE,
      '#default_value' => $this->getSetting('display'),
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $settings = array();

    $guid = in_array('guid', $this->getSetting('display')) ? 'Visible' : 'Hidden';
    $type = in_array('type', $this->getSetting('display')) ? 'Visible' : 'Hidden';
    $label = in_array('label', $this->getSetting('display')) ? 'Visible' : 'Hidden';

    $settings[] = t('Guid: @setting', array('@setting' => $guid));
    $settings[] = t('Type: @setting', array('@setting' => $type));
    $settings[] = t('Label: @setting', array('@setting' => $label));

    return $settings;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = array();

    foreach ($items as $delta => $item) {
      $definition = $this->typedDataManager->getDefinition($item->type);
      $elements[$delta] = array(
        '#theme' => 'xero_reference',
        '#item' => $item,
        '#delta' => $delta,
        '#definition' => $definition,
        '#settings' => $this->getSettings(),
        '#attributes' => array(
          'class' => array('field-item', 'field-item--xero-reference', 'field-item--' . str_replace('_', '-', $item->type)),
        ),
      );
    }

    return $elements;
  }
}
