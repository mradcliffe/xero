<?php
/**
 * @file
 *   Field API definitions for Xero API.
 */


/**
 * Implements hook_field_info().
 */
function xero_field_info() {
  return array(
    'xero_reference' => array(
      'label' => t('Xero reference'),
      'description' => t('A reference to a Xero data type such as a Contact, Account, BankTransaction, etc... stored as a globally-unique identifier.'),
      'instance_settings' => array(
        'xero_type' => '',
      ),
      'default_widget' => 'xero_autocomplete',
      'default_formatter' => 'xero_reference',
    ),
  );
}

/**
 * Implements hook_field_widget_info().
 */
function xero_field_widget_info() {
  return array(
    'xero_autocomplete' => array(
      'label' => t('Xero autocomplete'),
      'description' => t('Use an autocomplete textfield to search Xero.'),
      'field types' => array('xero_reference'),
      'settings' => array(),
      'behaviors' => array(
        'multiple_values' => FIELD_BEHAVIOR_CUSTOM,
      ),
    ),
    'xero_textfield' => array(
      'label' => t('Xero textfield'),
      'description' => t('Use a plain text field to enter reference to globally-unique identifier and labels.'),
      'field types' => array('xero_reference'),
      'settings' => array(),
      'behaviors' => array(
        'multiple_values' => FIELD_BEHAVIOR_DEFAULT,
      ),
    ),
  );
}

/**
 * Implements hook_field_formatter_info().
 */
function xero_field_formatter_info() {
  return array(
    'xero_reference' => array(
      'label' => t('Xero reference'),
      'description' => t('Display as a link to xero.com'),
      'field types' => array('xero_reference'),
      'settings' => array(),
    ),
  );
}

/**
 * Implements hook_field_is_empty().
 */
function xero_field_is_empty($item, $field) {
  if (empty($item) || empty($item['guid'])) {
    return TRUE;
  }
}

/**
 * Implements hook_field_validate().
 *
 * Validating the existance of a xero object would be WAY too expensive for
 * private applications against the daily API limit. This will not be done.
 */
function xero_field_validate($entity_type, $entity, $field, $instance, $langcode, $items, &$errors) {

  $field_name = $field['field_name'];
  $guid_regex = '/^\{?[A-Fa-f0-9]{8}-(?:[A-Fa-f0-9]{4}-){3}[A-Fa-f0-9]{12}\}?$/';

  foreach ($items as $delta => $item) {
    if (!empty($item['guid'])) {

      if (!preg_match($guid_regex, $item['guid'])) {
        // Not a globally-unique identifier.
        $errors[$field_name][$langcode][$delta][] = array(
          'error' => 'guid_error',
          'message' => t('%name: %value is not a globally-unique identifier.', array('%name' => $instance['label'], '%value' => $item['guid'])),
        );
      }

      if (strlen($item['label']) > 255) {
        // Label is too long.
        $errors[$field_name][$langcode][$delta][] = array(
          'error' => 'label_length_error',
          'message' => t('%name: must be 255 characters or less.', array('%name' => $isntance['label'])),
        ); 
      }
    }
  }
}

/**
 * Implements hook_field_presave().
 */
function xero_field_presave($entity_type, $entity, $field, $instance, $langcode, &$items) {

  foreach (element_children($items) as $delta) {
    // Remove brackets from guid before save.
    $items[$delta] = preg_replace('/[\{\}]/', '', $items[$delta]);
  }

}

/**
 * Implements hook_field_instance_settings_form().
 */
function xero_field_instance_settings_form($field, $instance) {

  $xero_types = array();
  $types = xero_get_data_types();
  foreach ($types as $name => $type) {
    $xero_types[$name] = $type['title'];
  }

  $form['xero_type'] = array(
    '#type' => 'select',
    '#title' => t('Xero data type'),
    '#description' => t('Select the Xero data type to use for this field. Example: Contact, Account, etc...'),
    '#options' => $xero_types,
    '#required' => TRUE,
    '#default_value' => isset($instance['settings']['xero_type']) ? $instance['settings']['xero_type'] : '',
    '#weight' => -10,
  );

  return $form;
}

/**
 * Implements hook_field_widget_form().
 */
function xero_field_widget_form(&$form, $form_state, $field, $instance, $langcode, $items, $delta, $element) {

  $type_name = empty($instance['settings']['xero_type']) ? 'Contact' : $instance['settings']['xero_type'];
  $type = xero_get_data_types($type_name);
  $label = empty($type['label']) ? $type['guid'] : $type['label'];

  if ($instance['widget']['type'] == 'xero_autocomplete') {
    $guids = array();
    $label_key = empty($type['label']) ? 'guid' : 'label';

    foreach ($items as $delta => $item) {
      $guids[] = isset($item['guid']) ? $item[$label_key] : '';
    }

    $element += array(
      '#type' => 'textfield',
      '#description' => t('Type a Xero %type %field to search for an available record.', array('%type' => $type['name'], '%field' => $label)),
      '#autocomplete_path' => 'xero/autocomplete/' . $instance['settings']['xero_type'],
      '#element_validate' => array('xero_field_autocomplete_validate'),
      '#field_parents' => array('guid'),
      '#default_value' => !empty($guids) ? implode(', ', $guids) : '',
      '#maxlength' => 1024,
      '#size' => 60,
    );
  }
  else {

    $element += array(
      '#type' => 'container',
      '#tree' => TRUE,
      'guid' => array(
        '#type' => 'textfield',
        '#title' => t('GUID'),
        '#description' => t('Provide the globally-unique identifier for the Xero %title.', array('%title' => $type['title'])),
        '#default_value' => !empty($items) ? $items[$delta]['guid'] : '',
        '#maxlength' => 38,
        '#size' => 60,
      ),
      'label' => array(
        '#type' => 'textfield',
        '#title' => t('Description'),
        '#description' => t('Describe the reference to the Xero %title.', array('%title' => $type['title'])),
        '#default_value' => !empty($items) ? $items[$delta]['label'] : '',
        '#maxlength' => 255,
        '#size' => 60,
      ),
    );
  }

  return $element;
}

/**
 * Xero autocomplete field widget validate.
 *
 * The autocomplete data must be processed into form state array
 * with the correct keys, guid and label.
 */
function xero_field_autocomplete_validate($element, &$form_state) {
  if (!empty($element['#value']) && !is_array($element['#value'])) {
    // Autocomplete field widget must be expanded into an array.
    preg_match('/(\S+) \((\S+)\)/', $element['#value'], $matches);
    $item = array(
      'guid' => $matches[1],
      'label' => $matches[2],
    );
    form_set_value($element, $item, $form_state);
  }
}

/**
 * Implements hook_field_formatter_view().
 */
function xero_field_formatter_view($entity_type, $entity, $field, $instance, $langcode, $items, $display) {

  switch ($display['type']) {
    case 'xero_reference':

      $type = xero_get_data_types($instance['settings']['xero_type']);
      $element = array(
        '#type' => 'container',
        '#attributes' => array(
          'class' => array('field', 'field-' . str_replace('_', '-', $field['field_name']), 'xero-field', 'xero-field-' . $type['name']),
        ),
      );

      foreach ($items as $delta => $item) {
        $element[$delta] = array(
          '#type' => 'container',
          '#attributes' => array(
            'class' => array('field-item', 'field-item-' . $delta, 'xero-field-item-' . $delta, 'xero-field-' . $type['name'] . '-item'),
            'id' => $item['guid'],
          ),
        );

        if ($type['label']) {
          // Only add label if the data type has a label.
          $element[$delta]['label'] = array(
            '#theme' => 'html_tag',
            '#tag' => 'span',
            '#value' => check_plain($item['label']) . ': ',
            '#attributes' => array(
              'class' => array('xero-' . $type['name'] . '-label'),
            ),
          );
        }
        
        $element[$delta]['guid'] = array(
          '#theme' => 'html_tag',
          '#tag' => 'span',
          '#value' => $item['guid'],
          '#attributes' => array(
            'class' => array('xero-' . $type['name'] . '-guid'),
          ),
        );
      }

      break;
  }
 
  return $element;
}
