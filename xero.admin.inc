<?php
/**
 * @file
 */


/**
 * Administrative settings form callback
 * @param $form the form array
 * @param &$form_state the form state array
 * @return array the form array.
 */
function xero_admin_settings($form, &$form_state) {
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
    array(
      'title' => t('Add Xero Application on Xero.com'), 
      'href' => 'https://api.xero.com/Application/Add',
    ),
    array(
      'title' => t('Verify Xero Installation'),
      'href' => 'admin/reports/status',
    ),
  );

  $form['help'] = array(
    '#theme' => 'links',
    '#links' => $items,
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
      // Bank accounts do not have a code, exclude them.
      if (!empty($account['Code'])) {
        $account_options[$account['Code']] = $account['Name'];
      }
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
 * Xero Autocomplete page callback.
 *
 * @param $type
 *   The xero data type array.
 * @param $string
 *   The string to search for.
 */
function xero_autocomplete($type, $string = '') {
  $matches = array();
  $items = xero_get_cache($type['plural']);
  $guid_key = $type['guid'];
  $label_key = !empty($type['label']) ? $type['label'] : $type['guid'];

  foreach ($items[$type['name']] as $item) {
    if (!empty($string) && is_string(stristr($item[$label_key], $string))) {
      $id = $item[$guid_key];
      $matches[$id . ' (' . $item[$label_key] . ')'] = check_plain($item[$label_key]);
    }
  }

  drupal_json_output($matches);
}
