<?php
// $Id: theme-settings.php,v 1.1.2.4 2009/03/18 17:12:06 njt1982 Exp $

/**
 * @file
 * The theme settings file is the home of the hook_settings() function for providing extra theme settings options.
 */

/**
 * Implementation of THEMEHOOK_settings() function.
 *
 * @param $saved_settings
 *   array An array of saved settings for this theme.
 * @return
 *   array A form array.
 */
function phptemplate_settings($saved_settings) {
  // Empty the cached css...
  cache_clear_all('abessive_custom_css', 'cache');

  $form = array();

  require_once path_to_theme() .'/abessive_settings.php';

  // Add Farbtastic color picker
  drupal_add_css('misc/farbtastic/farbtastic.css', 'module', 'all', FALSE);
  drupal_add_js('misc/farbtastic/farbtastic.js');
  drupal_add_js(path_to_theme() .'/theme-settings.js');

  $defaults = _abessive_default_settings();
  $settings = array_merge($defaults, $saved_settings);

  $form['abessive_picker'] = array(
    '#type' => 'markup',
    '#value' => '<div id="picker"></div>',
  );

  $form['abessive_background_color'] = array(
    '#type' => 'textfield',
    '#title' => t('Background Color'),
    '#description' => t('What colour should the body background behind all the containers be? Default: %val', array('%val' => $defaults['abessive_background_color'])),
    '#default_value' => $settings['abessive_background_color'],
    '#size' => 7,
    '#maxlength' => 7,
    '#prefix' => '<div class="container-inline">',
    '#suffix' => '</div>',
    '#attributes' => array('class' => 'form-item-use-colorpicker'),
    '#element_validate' => array('abessive_validate_hex_field'),
  );

  $form['abessive_border_color'] = array(
    '#type' => 'textfield',
    '#title' => t('Border Color'),
    '#description' => t('What colour should the border around all the containers be? Default: %val', array('%val' => $defaults['abessive_border_color'])),
    '#default_value' => $settings['abessive_border_color'],
    '#size' => 7,
    '#maxlength' => 7,
    '#prefix' => '<div class="container-inline">',
    '#suffix' => '</div>',
    '#attributes' => array('class' => 'form-item-use-colorpicker'),
    '#element_validate' => array('abessive_validate_hex_field'),
  );

  $form['abessive_content_background_color'] = array(
    '#type' => 'textfield',
    '#title' => t('Content Background Color'),
    '#description' => t('What colour should the background of all the containers be? Default: %val', array('%val' => $defaults['abessive_content_background_color'])),
    '#default_value' => $settings['abessive_content_background_color'],
    '#size' => 7,
    '#maxlength' => 7,
    '#prefix' => '<div class="container-inline">',
    '#suffix' => '</div>',
    '#attributes' => array('class' => 'form-item-use-colorpicker'),
    '#element_validate' => array('abessive_validate_hex_field', 'abessive_calculate_gradient'),
  );
  $form['abessive_content_background_color']['abessive_r5'] = $form['abessive_content_background_color']['abessive_r4'] =$form['abessive_content_background_color']['abessive_r3'] =$form['abessive_content_background_color']['abessive_r2'] = array(
    '#type' => 'value',
    '#default_value' => 0,
  );

  $form['abessive_text_color'] = array(
    '#type' => 'textfield',
    '#title' => t('Text Color'),
    '#description' => t('What colour should the text be? Default: %val', array('%val' => $defaults['abessive_text_color'])),
    '#default_value' => $settings['abessive_text_color'],
    '#size' => 7,
    '#maxlength' => 7,
    '#prefix' => '<div class="container-inline">',
    '#suffix' => '</div>',
    '#attributes' => array('class' => 'form-item-use-colorpicker'),
    '#element_validate' => array('abessive_validate_hex_field'),
  );

  $form['abessive_link_color'] = array(
    '#type' => 'textfield',
    '#title' => t('Hyperlink Color'),
    '#description' => t('What colour should hyperlinks be? Default: %val', array('%val' => $defaults['abessive_link_color'])),
    '#default_value' => $settings['abessive_link_color'],
    '#size' => 7,
    '#maxlength' => 7,
    '#prefix' => '<div class="container-inline">',
    '#suffix' => '</div>',
    '#attributes' => array('class' => 'form-item-use-colorpicker'),
    '#element_validate' => array('abessive_validate_hex_field'),
  );

  $form['abessive_link_hover_color'] = array(
    '#type' => 'textfield',
    '#title' => t('Hyperlink Hover Color'),
    '#description' => t('What colour should hyperlinks be when hovered over? Default: %val', array('%val' => $defaults['abessive_link_hover_color'])),
    '#default_value' => $settings['abessive_link_hover_color'],
    '#size' => 7,
    '#maxlength' => 7,
    '#prefix' => '<div class="container-inline">',
    '#suffix' => '</div>',
    '#attributes' => array('class' => 'form-item-use-colorpicker'),
    '#element_validate' => array('abessive_validate_hex_field'),
  );

  $form['abessive_link_active_color'] = array(
    '#type' => 'textfield',
    '#title' => t('Hyperlink Active Color'),
    '#description' => t('What colour should active hyperlinks be? Default: %val', array('%val' => $defaults['abessive_link_active_color'])),
    '#default_value' => $settings['abessive_link_active_color'],
    '#size' => 7,
    '#maxlength' => 7,
    '#prefix' => '<div class="container-inline">',
    '#suffix' => '</div>',
    '#attributes' => array('class' => 'form-item-use-colorpicker'),
    '#element_validate' => array('abessive_validate_hex_field'),
  );


  $form['abessive_left_width'] = array(
    '#type' => 'textfield',
    '#title' => t('Left Column Width'),
    '#description' => t('How wide should the left column be? Default: %val', array('%val' => $defaults['abessive_left_width'])),
    '#default_value' => $settings['abessive_left_width'],
    '#size' => 3,
    '#maxlength' => 3,
    '#prefix' => '<div class="container-inline">',
    '#suffix' => '</div>',
    '#field_suffix' => 'px',
    '#element_validate' => array('abessive_validate_numeric_field'),
  );

  $form['abessive_right_width'] = array(
    '#type' => 'textfield',
    '#title' => t('Right Column Width'),
    '#description' => t('How wide should the right column be? Default: %val', array('%val' => $defaults['abessive_right_width'])),
    '#default_value' => $settings['abessive_right_width'],
    '#size' => 3,
    '#maxlength' => 3,
    '#prefix' => '<div class="container-inline">',
    '#suffix' => '</div>',
    '#field_suffix' => 'px',
    '#element_validate' => array('abessive_validate_numeric_field'),
  );

  $form['#submit'][] = 'abessive_submit_settings';

  return $form;
}


function abessive_validate_hex_field($element, &$form_state) {
  // Get and tidy the hex string into a variable for easy access
  $hex = drupal_strtoupper(trim($element['#value']));

  // Validate the length (including prefixes hash). If the length is 4, expand to a 6 character hex string. If it's 7 then it's ok. Otherwise it's not, throw and error and return.
  switch ($len = drupal_strlen($hex)) {
    case 4 : $hex = preg_replace('/#(.)(.)(.)/', '#\\1\\1\\2\\2\\3\\3', $hex); break;
    case 7 : break;
    default : form_set_error($element['#name'], t('Invalid hex colour length (!val). %name must be either 3 or 6 characters', array('!val' => $len, '%name' => $element['#title']))); return;
  }

  // Sanity check the hex string to make sure its A-F, 0-9 (ie, 0123456789ABCDEF)
  if (!preg_match('/^#[A-F0-9]{6}$/', $hex)) {
    form_set_error($element['#name'], t('Invalid hex string for %name. <code>#%val</code> is not valid.', array('%name' => $element['#title'], '%val' => $element['#value'], )));
  }
  else {
    // Set the colour to the $hex value - this covers if it's been changed into a 6 character hex string
    form_set_value($element, $hex, $form_state);
  }
}

function abessive_validate_numeric_field($element, &$form_state) {
  if (!preg_match('/^[0-9]+$/', $element['#value'])) {
    form_set_error($element['#name'], t('Invalid number (!val). %name must only contain numeric character.', array('!val' => $element['#value'], '%name' => $element['#title'])));
  }
}


/**
 * Calculates the gradient in the top and bottom of all "blocks".
 */
function abessive_calculate_gradient($form, &$form_state) {
  if (count(form_set_error()) > 0) return;

  $b = _abessive_color_rgb2hsl(_abessive_color_unpack($form_state['values']['abessive_content_background_color'], TRUE));

  // If the background lightness is too dark then we cannot make the gradient tend towards darker - so we make it tend towards lighter instead
  if ($b[2] < 0.5) {
    form_set_value($form['abessive_r5'], _abessive_color_pack(_abessive_color_hsl2rgb(array($b[0], $b[1], $b[2] + ( 8 / 255))), TRUE), $form_state);
    form_set_value($form['abessive_r4'], _abessive_color_pack(_abessive_color_hsl2rgb(array($b[0], $b[1], $b[2] + (16 / 255))), TRUE), $form_state);
    form_set_value($form['abessive_r3'], _abessive_color_pack(_abessive_color_hsl2rgb(array($b[0], $b[1], $b[2] + (24 / 255))), TRUE), $form_state);
    form_set_value($form['abessive_r2'], _abessive_color_pack(_abessive_color_hsl2rgb(array($b[0], $b[1], $b[2] + (32 / 255))), TRUE), $form_state);
  }
  else {
    form_set_value($form['abessive_r5'], _abessive_color_pack(_abessive_color_hsl2rgb(array($b[0], $b[1], $b[2] - ( 8 / 255))), TRUE), $form_state);
    form_set_value($form['abessive_r4'], _abessive_color_pack(_abessive_color_hsl2rgb(array($b[0], $b[1], $b[2] - (16 / 255))), TRUE), $form_state);
    form_set_value($form['abessive_r3'], _abessive_color_pack(_abessive_color_hsl2rgb(array($b[0], $b[1], $b[2] - (24 / 255))), TRUE), $form_state);
    form_set_value($form['abessive_r2'], _abessive_color_pack(_abessive_color_hsl2rgb(array($b[0], $b[1], $b[2] - (32 / 255))), TRUE), $form_state);
  }
}

/**
 * color functions borrowed from color.module
 */

/**
 * Convert a hex color into an RGB triplet.
 */
function _abessive_color_unpack($hex, $normalize = FALSE) {
  if (drupal_strlen($hex) == 4) {
    $hex = $hex[1] . $hex[1] . $hex[2] . $hex[2] . $hex[3] . $hex[3];
  }
  $c = hexdec($hex);
  for ($i = 16; $i >= 0; $i -= 8) {
    $out[] = (($c >> $i) & 0xFF) / ($normalize ? 255 : 1);
  }
  return $out;
}

/**
 * Convert an RGB triplet to a hex color.
 */
function _abessive_color_pack($rgb, $normalize = FALSE) {
  $out = 0;
  foreach ($rgb as $k => $v) {
    $out |= (($v * ($normalize ? 255 : 1)) << (16 - $k * 8));
  }
  return '#'. str_pad(drupal_strtoupper(dechex($out)), 6, 0, STR_PAD_LEFT);
}

/**
 * Convert a HSL triplet into RGB
 */
function _abessive_color_hsl2rgb($hsl) {
  $h = $hsl[0];
  $s = $hsl[1];
  $l = $hsl[2];
  $m2 = ($l <= 0.5) ? $l * ($s + 1) : $l + $s - $l*$s;
  $m1 = $l * 2 - $m2;
  return array(
    _abessive_color_hue2rgb($m1, $m2, $h + 0.33333),
    _abessive_color_hue2rgb($m1, $m2, $h),
    _abessive_color_hue2rgb($m1, $m2, $h - 0.33333),
  );
}

/**
 * Helper function for _abessive_color_hsl2rgb().
 */
function _abessive_color_hue2rgb($m1, $m2, $h) {
  $h = ($h < 0) ? $h + 1 : (($h > 1) ? $h - 1 : $h);
  if ($h * 6 < 1) return $m1 + ($m2 - $m1) * $h * 6;
  if ($h * 2 < 1) return $m2;
  if ($h * 3 < 2) return $m1 + ($m2 - $m1) * (0.66666 - $h) * 6;
  return $m1;
}

/**
 * Convert an RGB triplet to HSL.
 */
function _abessive_color_rgb2hsl($rgb) {
  $r = $rgb[0];
  $g = $rgb[1];
  $b = $rgb[2];
  $min = min($r, min($g, $b));
  $max = max($r, max($g, $b));
  $delta = $max - $min;
  $l = ($min + $max) / 2;
  $s = 0;
  if ($l > 0 && $l < 1) {
    $s = $delta / ($l < 0.5 ? (2 * $l) : (2 - 2 * $l));
  }
  $h = 0;
  if ($delta > 0) {
    if ($max == $r && $max != $g) $h += ($g - $b) / $delta;
    if ($max == $g && $max != $b) $h += (2 + ($b - $r) / $delta);
    if ($max == $b && $max != $r) $h += (4 + ($r - $g) / $delta);
    $h /= 6;
  }
  return array($h, $s, $l);
}
