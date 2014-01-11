<?php
/**
 * @file
 */


/**
 * Administrative settings form callback
 */
function xero_admin_settings() {
  $form = array();
  $xero_loaded = FALSE;

  try {
    $xero = xero_php_load();
    $xero_loaded = TRUE;
  }
  catch (XeroException $e) {
    $xero_loaded = FALSE;
    drupal_set_message(t('Error: @message', array('@message' => $e->getMessage())), 'error');
    watchdog_exception('xero', $e, 'Xero certificate is missing.');
  }

  $items = array(
    l(t('Add Xero Application on Xero.com'), 'https://api.xero.com/Application/Add'),
    l(t('Verify Xero Installation'), 'admin/reports/status'),
  );

  $form['help'] = array(
    '#type' => 'markup',
    '#value' => '<p>'. theme('item_list', $items) .'</p>'
  );

  // Open the fieldset if there was a problem loading the library.
  $form['xero'] = array(
    '#type' => 'fieldset',
    '#title' => t('Xero Configuration'),
    '#collapsible' => TRUE,
    '#collapsed' => (empty($xero_loaded)) ? FALSE : $xero->verify(),
  );

  $form['xero']['xero_consumer_key'] = array(
    '#type' => 'textfield',
    '#title' => t('Xero Consumer Key'),
    '#description' => t('Provide the consumer key for your private application on xero.'),
    '#default_value' => variable_get('xero_consumer_key', ''),
    '#required' => TRUE,
  );

  $form['xero']['xero_consumer_secret'] = array(
    '#type' => 'textfield',
    '#title' => t('Xero Consumer Secret'),
    '#description' => t('Provide the consumer secret for your private application on xero.'),
    '#default_value' => variable_get('xero_consumer_secret', ''),
    '#required' => TRUE,
  );

  $form['xero']['xero_cert_path'] = array(
    '#type' => 'textfield',
    '#title' => t('Xero Certificate Path'),
    '#description' => t('Provide the full path and file name to your Xero certificate.'),
    '#default_value' => variable_get('xero_cert_path', ''),
    '#element_validate' => array('xero_admin_settings_validate_exists'),
    '#required' => TRUE,
  );

  $form['xero']['xero_key_path'] = array(
    '#type' => 'textfield',
    '#title' => t('Xero Key Path'),
    '#description' => t('Provide the full path and file name to your Xero certificate private key.'),
    '#default_value' => variable_get('xero_key_path', ''),
    '#element_validate' => array('xero_admin_settings_validate_exists'),
    '#required' => TRUE,
  );

  if (!empty($xero_loaded) && $xero->verify()) {
    // Only display defaults if configured correctly.

    $form['defaults'] = array(
      '#type' => 'fieldset',
      '#title' => t('Xero API Defaults'),
      '#collapsible' => TRUE,
    );

    $accounts = xero_get_cache('Accounts');
    foreach ($accounts['Account'] as $account) {
      $account_options[$account['Code']] = check_plain($account['Name']);
    }
    $form['defaults']['xero_default_account'] = array(
      '#type' => 'select',
      '#title' => t('Default Account'),
      '#description' => t('Choose a default account.'),
      '#options' => $account_options,
      '#default_value' => variable_get('xero_default_account', ''),
    );
  }

  return system_settings_form($form);
}

/**
 * Validation callback for xero_admin_settings().  Verifies that the field's file exists and is readable.
 */
function xero_admin_settings_validate_exists($element, &$form_state) {
  if (!@file_exists($element['#value'])) {
    form_error($element, t('The specified file either does not exist, or is not accessible to the web server.'));
  }
}

/**
 * Xero Autocomplete Contacts page callback
 * @param $string the string to search
 */
function xero_autocomplete_contacts($string = '') {
  $contacts = xero_get_cache('Contacts');
  $matches = array();

  if (!empty($contacts['Contact'])) {
    foreach ($contacts['Contact'] as $item) {
      if (!empty($string) && is_string(stristr($item['Name'], $string))) {
        $id = $item['ContactID'];
        $matches[$id] = check_plain($item['Name']);
      }
    }
  }

  drupal_json($matches);
}

/**
 * Xero Autocomplete Invoices page callback
 * @param $string the string to search
 */
function xero_autocomplete_invoices($string = '') {
  $invoices = xero_get_cache('Invoices');
  $matches = array();

  if (!empty($invoices['Invoice'])) {
    foreach ($invoices['Invoice'] as $item) {
      if (!empty($string) && is_string(stristr($item['InvoiceNumber'], $string))) {
        $id = $item['InvoiceNumber'];
        $matches[$id] = check_plain($item['InvoiceNumber']);
      }
    }
  }

  drupal_json($matches);
}
