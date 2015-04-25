<?php
/**
 * @file
 * Provides \DrupalTests\xero\TypedData\JournalLineDefinitionTest.
 */

namespace Drupal\Tests\xero\TypedData;

use Drupal\Core\TypedData\DataDefinition;
use Drupal\xero\TypedData\Definition\JournalLineDefinition;
use Drupal\xero\Plugin\DataType\JournalLine;
use Drupal\Core\TypedData\Plugin\DataType\StringData;
use Drupal\Core\TypedData\Plugin\DataType\Float;
use Drupal\Tests\xero\Plugin\DataType\TestBase;

/**
 * Assert setting and getting JournalLine properties.
 *
 * @coversDefaultClass \Drupal\xero\TypedData\Definition\JournalLineDefinition
 * @group Xero
 */
class JournalLineDefinitionTest extends TestBase {

  const XERO_TYPE = 'xero_journal_line';
  const XERO_TYPE_CLASS = '\Drupal\xero\Plugin\DataType\JournalLine';
  const XERO_DEFINITION_CLASS = '\Drupal\xero\TypedData\Definition\JournalLineDefinition';

  protected $journal_line;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();

    // Create data type.
    $type_class = self::XERO_TYPE_CLASS;
    $this->journal_line = new $type_class($this->dataDefinition, self::XERO_TYPE);
  }

  /**
   * Test getPropertyDefinitions.
   */
  public function testPropertyDefinitions() {
    $properties = $this->journal_line->getProperties();

    $this->assertArrayHasKey('JournalLineID', $properties);
    $this->assertArrayHasKey('AccountID', $properties);
    $this->assertArrayHasKey('AccountCode', $properties);
    $this->assertArrayHasKey('AccountType', $properties);
    $this->assertArrayHasKey('AccountName', $properties);
    $this->assertArrayHasKey('NetAmount', $properties);
    $this->assertArrayHasKey('GrossAmount', $properties);
    $this->assertArrayHasKey('TaxAmount', $properties);
    $this->assertArrayHasKey('TaxType', $properties);
    $this->assertArrayHasKey('TaxName', $properties);
    $this->assertArrayHasKey('TrackingCategories', $properties);
  }
}
