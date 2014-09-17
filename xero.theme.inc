<?php
/**
 * @file
 * xero.theme.inc
 */

use Drupal\Core\Template\Attribute;

/**
 * Template preprocess for xero reference field item.
 *
 * @param &$variables
 *   The variables array.
 */
function template_preprocess_xero_reference(&$variables) {
  $variables['attributes'] = new Attribute($variables['attributes']);

  $variables['guid'] = in_array('guid', $variables['settings']['display']) ? $variables['item']->guid : FALSE;
  $variables['label'] = in_array('label', $variables['settings']['display']) ? $variables['item']->label : FALSE;
  $variables['type'] = $variables['item']->type;
  $variables['type_label'] = in_array('type', $variables['settings']['display']) ? $variables['definition']->getLabel() : FALSE;
}
