<?php
/**
 * @file
 * Provides \Drupal\xero\Controller\XeroAutocompleteController.
 */

namespace Drupal\xero\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\TypedData\TypedDataManager;
use Drupal\xero\XeroQuery;

/**
 * Xero autocomplete controller.
 */
class XeroAutocompleteController implements ContainerInjectionInterface {

  /**
   * Create a new instance of the controller with dependency injection.
   *
   * @param $query
   *   The xero query class.
   * @param $typedDataManager
   *   The typed data manager.
   */
  public function __construct(XeroQuery $query, TypedDataManager $typedDataManager) {
    $this->query = $query;
    $this->typedDataManager = $typedDataManager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('xero.query'),
      $container->get('typed_data_manager')
    );
  }

  /**
   * Controller method.
   *
   * @param $request
   *   The Symfony Request object.
   * @param $type
   *   The Xero type.
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   A JSON response of potential guid and label matches.
   */
  public function autocomplete(Request $request, $type) {
    $search = $request->query->get('q');
    $matches = array();

    $definition = $this->typedDataManager->getDefinition($type);
    $class = $definition['class'];

    $this->query
      ->setType($type)
      ->setMethod('get')
      ->setFormat('xml');

    if ($class::$label) {
      $this->query->addCondition($class::$label, $search, 'StartsWith');
    }
    else {
      $this->query->setId($search);
    }

    $items = $this->query->execute();

    if (!empty($items)) {
      foreach ($items as $item) {
        $key = $item->get($class::$guid_name)->getValue();
        $key .= $class::$label ? ' (' . $item->get($class::$label)->getValue() . ')' : '';

        $matches[$key] = $class::$label ? $item->get($class::$label)->getValue() : $key;
      }
    }

    return new JsonResponse($matches);
  }
}
