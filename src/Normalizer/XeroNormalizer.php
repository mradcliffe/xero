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
  public function normalize($object, $format = NULL, array $context = array()) {
    // Get the array map.
    $data = array();
    $items = array();
    $ret = array();

    foreach ($object as $n => $item) {
      if (!isset($plural_name)) {
        $plural_name = $item::$plural_name;
        $name = $item::$xero_name;
      }

      $data = parent::normalize($item, $format, $context);
      $data = $this->reduceEmpty($data);
      $items[] = $data;
    }
    $ret[$plural_name] = [$name => NULL];

    if (count($items) === 1) {
      $ret[$plural_name][$name] = $items[0];
    }
    else {
      $ret[$plural_name][$name] = $items;
    }

    return $ret;
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

    // Wrap the data an array if there is a singular object returned.
    if (count(array_filter(array_keys($data[$plural_name][$name]), 'is_string'))) {
      $data[$plural_name][$name] = array($data[$plural_name][$name]);
    }

    $list_definition = $this->typedDataManager->createListDataDefinition($context['plugin_id']);
    $items = $this->typedDataManager->create($list_definition, $data[$plural_name][$name]);

    return $items;
  }

  /**
   * Remove null values from normalized items.
   *
   * @param $value
   *   The value to reduce.
   * @return mixed
   *   Either FALSE or the value.
   */
  protected function reduceEmpty($value) {
    if (is_array($value)) {
      foreach ($value as $n => $item) {
        $item = $this->reduceEmpty($item);
        if ($item) {
          $value[$n] = $item;
        }
        else {
          unset($value[$n]);
        }
      }
    }
    else if (empty($value)) {
      return FALSE;
    }

    return $value;
  }

}
