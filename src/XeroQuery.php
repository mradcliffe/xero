<?php
/**
 * @file
 * Provides \Drupal\xero\XeroQuery.
 */

namespace Drupal\xero;

use Symfony\Component\Serializer\Serializer;
use BlackOptic\Bundle\XeroBundle\XeroClient;
use Drupal\Core\TypedData\TypedDataManager;
use Drupal\Component\Uuid;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\Component\Plugin\Exception\PluginNotFoundException;
use Guzzle\Http\Exception\RequestException;
use Guzzle\Http\Exception\ClientErrorResponseException;
// use Drupal\xero\XeroQueryInterface;

/**
 * Provides a query builder service for HTTP requests to Xero.
 *
 * This matches functionality provided by Drupal 7 xero module and the old
 * PHP-Xero library.
 */
class XeroQuery /*implements XeroQueryInterface */ {

  static protected $operators = array('==', '!=', 'StartsWith', 'EndsWith', 'Contains', 'guid');

  /**
   * The options to pass into guzzle.
   */
  protected $options;

  /**
   * The conditions for the where query parameter.
   */
  protected $conditions;

  /**
   * The output format. One of json, xml, or pdf.
   */
  protected $format = 'xml';

  /**
   * The xero method to use.
   */
  protected $method = 'get';

  /**
   * The xero UUID to use for a quick filter in get queries.
   */
  protected $uuid;

  /**
   * The xero type plugin id.
   */
  protected $type;

  /**
   * The xero data type type definition.
   */
  protected $type_definition;

  /**
   * Construct a Xero Query object.
   *
   * @param $client
   *   The xero client object to make requests.
   * @param $serializer
   *   The serialization service to handle normalization and denormalization.
   * @param $typed_data
   *   The Typed Data manager for retrieving definitions of xero types.
   * @param $logger_factory
   *   The logger factory service for error logging.
   */
  public function __construct(XeroClient $client, Serializer $serializer, TypedDataManager $typed_data, LoggerChannelFactoryInterface $logger_factory) {
    $this->client = $client;
    $this->serializer = $serializer;
    $this->typed_data = $typed_data;
    $this->logger = $logger_factory->get('xero');
  }

  /**
   * Set the xero type by plugin id.
   *
   * @param $type
   *   The plugin id corresponding to a xero type i.e. xero_account.
   * @return this
   *   The query object for chaining.
   */
  public function setType($type) {
    try {
      $this->type_definition = $this->typed_data->getDefinition($type);
      $this->type = $type;
    }
    catch (PluginNotFoundException $e) {
      throw $e;
    }

    return $this;
  }

  /**
   * Set which http method to use for the query. This is "type" from xero_query().
   *
   * @param $method
   *   The method to use, which is one of "get" or "post". The HTTP PUT method
   *   will be automatically used for updating records.
   * @return this
   *   The query object for chaining.
   */
  public function setMethod($method) {
    if (!in_array($method, array('get', 'post'))) {
      throw new \InvalidArgumentException('Invalid method given.');
    }
    $this->method = $method;

    // Set the content type to x-www-form-urlencoded per Xero API.
    if ($this->method == 'post') {
      $this->addHeader('Content-Type', 'application/x-www-form-urlencoded');
      $this->setFormat('xml');
    }

    return $this;
  }

  /**
   * Set the format to use for the query. This is "method" from xero_query().
   *
   * @todo support pdf format.
   *
   * @param $format
   *   The format ot use, which is one of "xml", "json", or "pdf".
   * @return this
   *   The query object for chaining.
   */
  public function setFormat($format) {
    if (!in_array($format, array('json', 'xml', 'pdf'))) {
      throw new \InvalidArgumentException('Invalid format given.');
    }
    $this->format = $format;

    $this->addHeader('Accept', 'application/' . $this->format);

    return $this;
  }

  /**
   * Set the Xero UUID for the request. Useful only in get method.
   *
   * @param $uuid
   *   The universally-unique ID.
   * @return this
   *   The query object for chaining.
   */
  public function setId($uuid) {
    if (!Uuid::isValid($uuid)) {
      throw new \InvalidArgumentException('UUID is not valid');
    }
    $this->uuid = $uuid;

    return $this;
  }

  /**
   * Set the modified-after filter.
   *
   * @param $timestamp
   *   A UNIX timestamp to use. Should be UTC.
   * @return $this
   *   The query object for chaining.
   */
  public function setModifiedAfter($timestamp) {
    $this->addHeader('If-Modified-Since', $timestamp);

    return $this;
  }

  /**
   * Add a condition to the query.
   *
   * @param $field
   * @param 4value
   * @param $op
   *   The operation to use, which is one of the following operators.
   *     - ==: Equal to the value
   *     - !=: Not equal to the value
   *     - StartsWith: Starts with the value
   *     - EndsWith: Ends with the value
   *     - Conains: Contains the value
   *     - guid: Equality for guid values. See Xero API.
   */
  public function addCondition($field, $value = '', $op = '==') {

    if (!in_array($op, self::$operators)) {
      throw new \InvalidArgumentException('Invalid operator');
    }

    // Change boolean into a string value of the same name.
    if (is_bool($value)) {
      $value = $value ? 'true' : 'false';
    }

    // Construction condition statement based on operator.
    if (in_array($op, array('==', '!='))) {
      $this->conditions[] = $field . $op . '"' . $value . '"';
    }
    elseif ($op == 'guid') {
      $this->conditions[] = $field . '= Guid("' . $value . '"';
    }
    else {
      $this->conditions[] = $field . '.' . $op . '("' . $value . '")';
    }

    return $this;
  }

  /**
   * Add a logical operator AND or OR to the conditions array.
   *
   * @param $op
   *   Operator AND or OR.
   * @return this
   *   The query object for chaining.
   */
  public function addOperator($op = 'AND') {
    if (!in_array($op, array('AND', 'OR'))) {
      throw new \InvalidArgumentException('Invalid logical operator.');
    }

    $this->conditions[] = $op;

    return $this;
  }

  /**
   * Add an order by to the query.
   *
   * @param $field
   *   The full field name to use. See Xero API.
   * @param $dir
   *   The direction. either ASC or DESC.
   * @return this
   *   The query object for chaining.
   */
  public function orderBy($field, $dir = 'ASC') {
    if ($dir == 'DESC') {
      $field . ' ' . $dir;
    }

    $this->addQuery('order', $field);

    return $this;
  }

  /**
   * Add a query parameter. This will overwrite any other value set for the
   * key.
   *
   * @param $key
   *   The query parameter key.
   * @param $value
   *   The query parameter value.
   */
  protected function addQuery($key, $value) {
    if (!isset($this->options['query'])) {
      $this->options['query'] = array();
    }

    $this->options['query'][$key] = $value;
  }

  /**
   * Set a header option. This will overwrite any other value set.
   *
   * @param $name
   *   The header option name.
   * @param $value
   *   The header option valu.
   */
  protected function addHeader($name, $value) {
    if (!isset($this->options['headers'])) {
      $this->options['headers'] = array();
    }

    $this->options['headers'][$name] = $value;
  }

  /**
   * Explode the conditions into a query parameter.
   */
  protected function explodeConditions() {
    if (!empty($this->conditions)) {
      $value = implode(' ', $this->conditions);
      $this->addQuery('where', $value);
    }
  }

  /**
   * Validate the query before execution to make sure that query parameters
   * make sense for the method for instance.
   *
   * @return boolean
   *   TRUE if the query should be validated. Otherwise an
   *   IllegalArgumentException will be thrown.
   */
  public function validate() {

    if ($type === NULL) {
      throw new \InvalidArgumentException('The query must have a type set.');
    }

    if ($this->method == 'post') {
      if ($this->format <> 'xml') {
        throw new \InvalidArgumentException('The format must be XML for creating or updating data.');
      }

      if ($this->options['headers']['Content-Type'] <> 'application/x-www-form-url-encoded') {
        throw new \InvalidArgumentException('The Content-Type must be application/x-www-form-url-encoded.');
      }

      if (!empty($this->conditions)) {
        throw new \InvalidArgumentException('Invalid use of conditions for creating or updating data.');
      }
    }

    if ($this->format == 'pdf' && !in_array($this->type, array('xero_invoice', 'xero_credit_note'))) {
      throw new \InvalidArgumentException('PDF format may only be used for invoices or credit notes.');
    }

    return TRUE;
  }

  /**
   * Execute the Xero query.
   *
   * @return mixed
   *   The TypedData object in the response.
   */
  public function execute() {
    try {
      $this->validate();

      // @todo Add summarizeErrors for post if posting multiple objects.

      $this->explodeConditions();

      // @todo Change to put for requests without id.

      $data_class = $this->type_definition->getClass();

      $endpoint = $data_class::$plural_name;
      $request = $this->client->{$this->method}($endpoint, $this->options);
      $response = $request->send();
      $context = array('plugin_id' => $this->type);
      $data = $this->serializer->deserialize($response->getBody(TRUE), $this->type_definition->getClass(), $this->format, $context);

      return $data;
    }
    catch (RequestException $e) {
      $this->logger->error('%message: %response', array('%message' => $e->getMessage(), '%response' => $e->getResponse()->getBody(TRUE)));
      return FALSE;
    }
    catch (\Exception $e) {
      $this->logger->error('%message', array('%message' => $e->getMessage()));
      return FALSE;
    }
  }
}
