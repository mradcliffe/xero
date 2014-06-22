<?php
/**
 * @file
 * Provides \Drupal\xero\Normalizer\XeroNormalizer.
 */

namespace Drupal\xero\Normalizer;

use Drupal\serialization\Normalizer\ComplexDataNormalizer;
use Drupal\Core\TypedData\TypedDataManager;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * Implement denormalization for Xero complex data as core's
 * ComplexDataNormalizer does not support denormalization.
 */
class XeroNormalizer extends ComplexDataNormalizer implements DenormalizerInterface {

  protected $supportedInterfaceOrClass = 'Drupal\xero\TypedData\XeroTypeInterface';

  public function __construct(TypedDataManager $typed_data_manager) {
    $this->typedDataManager = $typed_data_manager;
  }

  /**
   * {@inheritdoc}
   */
  public function denormalize($data, $class, $format = NULL, array $context = array()) {
    // The context array requires the Xero data type to be known. If not, then
    // cannot do anything. This is consistent with Entity normalization.
    if (!isset($context['plugin_id']) || empty($context['plugin_id'])) {
      throw new UnexpectedValueException('Plugin id parameter must be included in context.');
    }

    $name = $class::$xero_name;
    $plural_name = $class::$plural_name;

    $list_definition = $this->typedDataManager->createListDataDefinition($context['plugin_id']);
    $items = $this->typedDataManager->create($list_definition, $data[$plural_name][$name]);

    return $items;
  }

}
