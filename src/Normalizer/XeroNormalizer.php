<?php
/**
 * @file
 * Provides \Drupal\xero\Normalizer\XeroNormalizer.
 */

namespace Drupal\xero\Normalizer;

use Drupal\serialization\Normalizer\ComplexDataNormalizer;
use Drupal\Core\TypedData\TypeDataManager;
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
    var_dump($context);
    var_dump($class);
    var_dump($data);
    exit;

    // Get the Data Definition for the DataType in $class.

    // Get the plural name for the Datatype in $class.
    $plural_name = $class::$plural_name;

    // go through $data->{$plural_name} and do TypedDataManager::create().
  }

}
