<?php
/**
 * @file
 * Provides \Drupal\Tests\xero\XeroQueryClientTest.
 */

namespace Drupal\Tests\xero;

use Drupal\xero\XeroQuery;
use Drupal\Tests\xero\XeroQueryTestBase;

class XeroQueryClientTest extends XeroQueryTestBase {

  /**
   * Provider for client FALSE or with mocked client.
   *
   * @return []
   *   A set of arrays that contain the first argument for XeroQuery, and the
   *   expected result of XeroQuery::hasClient().
   */
  public function clientProvider() {
    return [
      [FALSE, FALSE],
      [$this->client, TRUE]
    ];
  }

  /**
   * Test XeroQuery::hasClient().
   *
   * @dataProvider clientProvider
   *
   * @group xero
   */
  public function testHasClient($client, $result) {
     $query = new XeroQuery($client, $this->serializer, $this->typedDataManager, $this->loggerFactory);
     $this->assertEquals($result, $query->hasClient());
  }
}
