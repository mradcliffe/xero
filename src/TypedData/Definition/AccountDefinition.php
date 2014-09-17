<?php
/**
 * @file
 * Provides \Drupal\xero\TypedData\Definition\AccountDefinition.
 */

namespace Drupal\xero\TypedData\Definition;

use Drupal\Core\TypedData\DataDefinition;
use Drupal\Core\TypedData\ComplexDataDefinitionBase;

/**
 * Xero Account data definition
 */
class AccountDefinition extends ComplexDataDefinitionBase {
  /**
   * {@inheritdoc}
   */
  public function getPropertyDefinitions() {
    if (!isset($this->propertyDefinitions)) {
      $info = &$this->propertyDefinitions;
      $type_options = array('choices' => $this->getAccountTypes());
      $tax_type_options = array('choices' => $this->getTaxTypes());
      $class_options = array('choices' => array('ASSET', 'EQUITY', 'EXPENSE', 'LIABILITY', 'REVENUE'));
      $status_options = array('choices' => array('ACTIVE', 'ARCHIVED'));

      // UUID is read only.
      $info['AccountID'] = DataDefinition::create('uuid')->setLabel('Account ID')->setReadOnly(TRUE);

      // Writeable properties.
      $info['Code'] = DataDefinition::create('string')->setRequired()->setLabel('Code');
      $info['Name'] = DataDefinition::create('string')->setRequired()->setLabel('Name');
      $info['Type'] = DataDefinition::create('string')->setRequired()->setLabel('Type')->addConstraint('Choice', $type_options);
      $info['Description'] = DataDefinition::create('string')->setLabel('Description');
      $info['TaxType'] = DataDefinition::create('string')->setLabel('Tax type')->addConstraint('Choice', $tax_type_options);
      $info['EnablePaymentsToAccount'] = DataDefinition::create('boolean')->setLabel('May have payments');
      $info['ShowInExpenseClaims'] = DataDefinition::create('boolean')->setLabel('Shown in expense claims');

      // Read-only properties.
      $info['Class'] = DataDefinition::create('string')->setLabel('Class')->setReadOnly(TRUE)->addConstraint('Choice', $class_options);
      $info['ReportingCode'] = DataDefinition::create('string')->setReadOnly(TRUE)->setLabel('Reporting code');
      $info['Status'] = DataDefinition::create('string')->setLabel('Status')->setReadOnly(TRUE)->addConstraint('Choice', $status_options);
      $info['SystemAccount'] = DataDefinition::create('string')->setLabel('System account')->setReadOnly(TRUE);
      $info['BankAccountNumber'] = DataDefinition::create('string')->setLabel('Bank account')->setReadOnly(TRUE);
      $info['CurrencyCode'] = DataDefinition::create('string')->setLabel('Currency code')->setReadOnly(TRUE);
      $info['ReportingCode'] = DataDefinition::create('string')->setLabel('Reporting code')->setReadOnly(TRUE);
      $info['ReportingCodeName'] = DataDefinition::create('string')->setLabel('Reporting code name')->setReadOnly(TRUE);
    }
    return $this->propertyDefinitions;
  }

  /**
   * Provide the correct Xero Account Types for validation.
   */
  protected function getAccountTypes() {
    return array(
      'BANK', 'CURRENT', 'CURRLIAB', 'DEPRECIATN', 'DIRECTCOSTS', 'EQUITY',
      'EXPENSE', 'FIXED', 'LIABILITY', 'NONCURRENT', 'OTHERINCOME',
      'OVERHEADS', 'PREPAYMENT', 'REVENUE', 'SALES', 'TERMLIAB',
      'PAYGLIABILITY', 'SUPERANNUATIONEXPENSE', 'SUPERANNUATIONLIABILITY',
      'WAGESEXPENSE',
    );
  }

  /**
   * Provide the correct Xero Tax Types for validation.
   */
  protected function getTaxTypes() {
    return array(
      // Global types
      'INPUT', 'OUTPUT', 'NONE', 'GSTONIMPORTS',
      // Aussie
      'CAPEXINPUT', 'EXEMPTEXPORT', 'EXEMPTEXPENSES', 'EXEMPTCAPITAL',
      'EXEMPTOUTPUT', 'INPUTTAXED', 'BASEXCLUDED', 'GSTONCAPIMPORTS',
      'GSTONIMPORTS',
      // Kiwi
      'INPUT2', 'OUTPUT2', 'ZERORATED',
      // Brit
      'CAPEXINPUT2', 'CAPEXOUTPUT', 'CAPEXOUTPUT2', 'CAPEXSRINPUT',
      'CAPEXSROUTPUT', 'ECZRINPUT', 'ECZROUTPUT', 'ECZROUTPUTSERVICES',
      'EXEMPTINPUT', 'RRINPUT', 'RROUTPUT', 'SRINPUT', 'SROUTPUT',
      'ZERORATEDINPUT', 'ZERORATEDOUTPUT',
    );
  }
}
