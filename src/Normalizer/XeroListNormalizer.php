<?php
/**
 * @file
 * Contains \Drupal\xero\Normalizer\XeroListNormalizer.
 */

namespace Drupal\xero\Normalizer;

use Drupal\serialization\Normalizer\ComplexDataNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Implement normalization of Xero data types wrapped in XeroListItem because
 * Drupal's ListNormalizer is explicitly for field data and does not pass in
 * plugin id as context.
 */
class XeroListNormalizer extends ComplexDataNormalizer implements NormalizerInterface {

  protected $supportedInterfaceOrClass = 'Drupal\xero\Plugin\DataType\XeroItemList';

  /**
   * {@inheritdoc}
   */
  public function normalize($object, $format = NULL, array $context = array()) {
    // Get the array map.
    $items = array();
    $ret = array();
    $item_class = $object->getItemDefinition()->getClass();

    // Derive the Xero type from the item list item definition.
    if (isset($item_class::$plural_name) && isset($item_class::$xero_name)) {
      $plural_name = $item_class::$plural_name;
      $name = $item_class::$xero_name;
    }
    else {
      throw new \InvalidArgumentException('Invalid xero type used in object.');
    }

    /** @var \Drupal\xero\TypedData\XeroTypeInterface $item */
    foreach ($object as $n => $item) {
      $plugin_id = $item->getDataDefinition()->getDataType();

      $data = parent::normalize($item, $format, ['plugin_id' => $plugin_id]);
      $data = $this->reduceEmpty($data);
      $items[] = $data;
    }

    if ($format === 'xml') {
      $ret[$name] = count($items) === 1 ? $items[0] : $items;
    }
    else {
      $ret[$plural_name] = [$name => NULL];
      $ret[$plural_name][$name] = count($items) === 1 ? $items[0] : $items;
    }

    return $ret;
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
