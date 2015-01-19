<?php
/**
 * @file
 * Provides \DrupalTests\xero\TypedData\JournalDefinitionTest.
 */

namespace Drupal\Tests\xero\TypedData;

use Drupal\Core\TypedData\DataDefinition;
use Drupal\xero\TypedData\Definition\JournalDefinition;
use Drupal\xero\Plugin\DataType\Journal;
use Drupal\Tests\xero\Plugin\DataType\TestBase;

/**
 * Assert setting and getting Journal properties.
 *
 * @coversDefaultClass \Drupal\xero\TypedData\Definition\JournalDefinition
 * @group Xero
 */
class JournalDefinitionTest extends TestBase {

  const XERO_TYPE = 'xero_journal';
  const XERO_TYPE_CLASS = '\Drupal\xero\Plugin\DataType\Journal';
  const XERO_DEFINITION_CLASS = '\Drupal\xero\TypedData\Definition\JournalDefinition';

  protected $journal;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();

    // Create data type.
    $type_class = self::XERO_TYPE_CLASS;
    $this->journal = new $type_class($this->dataDefinition, self::XERO_TYPE);
  }

  /**
   * Test getPropertyDefinitions.
   */
  public function testPropertyDefinitions() {
    $properties = $this->journal->getProperties();

    $this->assertArrayHasKey('JournalID', $properties);
    $this->assertArrayHasKey('JournalDate', $properties);
    $this->assertArrayHasKey('JournalNumber', $properties);
    $this->assertArrayHasKey('CreatedDateUTC', $properties);
    $this->assertArrayHasKey('Reference', $properties);
    $this->assertArrayHasKey('JournalLines', $properties);
  }
}
