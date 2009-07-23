<?php
// $Id: template.php,v 1.1.2.1.2.6 2009/03/18 17:15:14 njt1982 Exp $

/**
 * Sets the body-tag class attribute.
 *
 * Adds 'sidebar-left', 'sidebar-right' or 'sidebars' classes as needed.
 */
function phptemplate_body_class($sidebar_left, $sidebar_right) {
  if ($sidebar_left != '' && $sidebar_right != '') {
    $class = 'sidebars';
  }
  else {
    if ($sidebar_left != '') {
      $class = 'sidebar-left';
    }
    if ($sidebar_right != '') {
      $class = 'sidebar-right';
    }
  }

  if (isset($class)) {
    print ' class="'. $class .'"';
  }
}

/**
 * Return a themed breadcrumb trail.
 *
 * @param $breadcrumb
 *   An array containing the breadcrumb links.
 * @return a string containing the breadcrumb output.
 */

function phptemplate_breadcrumb($breadcrumb) {
  if (!empty($breadcrumb)) {
    return '<div class="breadcrumb">'. implode('&nbsp;//&nbsp;', $breadcrumb) .'</div>';
  }
}

/**
 * Customize some of the page tempalte variables
 */
function abessive_preprocess_page(&$variables) {
  $variables['footer_message'] = trim($variables['footer_message']);
  _abessive_custom_css_settings($variables['styles']);
}

/**
 * Private function to modify the styles section of the page variables.
 */
function _abessive_custom_css_settings(&$styles) {
  if ($css = cache_get('abessive_custom_css')) {
    $css = $css->data;
  }
  else {
    // Declare the $css variable to be added.
    $css = '';

    $left_width = $right_width = FALSE;

    // Get the default settings
    require_once path_to_theme() .'/abessive_settings.php';
    $defaults = _abessive_default_settings();

    // Loop over over all the default settings and try to get the cutom settings for it. If the custom settings differ to the default, append it onto the custom $css variable.
    foreach ($defaults as $key => $default_setting) {
      if (($custom_setting = theme_get_setting($key)) && ($custom_setting != $default_setting)) {
        switch ($key) {
          case 'abessive_background_color' : $css .= 'body { background-color:'. $custom_setting .';} '; break;
          case 'abessive_border_color' : $css .= '.block .content, #center .content, #header .content, #footer .content, div.r2, div.r3, div.r4, div.r5 { border-color:'. $custom_setting .';} div.r1 { background-color:'. $custom_setting .';} '; break;
          case 'abessive_content_background_color' : $css .= '.block .content, #center .content, #header .content, #footer .content { background-color:'. $custom_setting .'} '; break;
          case 'abessive_r2' : $css .= 'div.r2 { background-color:'. $custom_setting .'; }'; break;
          case 'abessive_r3' : $css .= 'div.r3 { background-color:'. $custom_setting .'; }'; break;
          case 'abessive_r4' : $css .= 'div.r4 { background-color:'. $custom_setting .'; }'; break;
          case 'abessive_r5' : $css .= 'div.r5 { background-color:'. $custom_setting .'; }'; break;

          case 'abessive_text_color' : $css .= 'body, p, td { color:'. $custom_setting .'} '; break;
          case 'abessive_link_color' : $css .= 'a:link, a:visited { color:'. $custom_setting .'} '; break;
          case 'abessive_link_hover_color' : $css .= 'a:hover { color:'. $custom_setting .'} '; break;
          case 'abessive_link_active_color' : $css .= 'a:active, a.active, li a.active { color:'. $custom_setting .'} '; break;

          case 'abessive_left_width'  : $left_width = $custom_setting; break;
          case 'abessive_right_width' : $right_width = $custom_setting; break;

          default: break;
        }
      }
    }

    // If Left or Right widths are not set, set them to default
    if (!$left_width) $left_width = $defaults['abessive_left_width'];
    if (!$right_width) $right_width = $defaults['abessive_right_width'];

    // For sanity, cast them to int's
    $left_width = (int)$left_width;
    $right_width = (int)$right_width;

    // Changed picks up what's changed.
    // 0 = default/no change, 1 = left changed, 2 = right changed, 3 = both changed
    $changed  = 0;
    $changed += ($left_width == $defaults['abessive_left_width'])   ? 0 : 1;
    $changed += ($right_width == $defaults['abessive_right_width']) ? 0 : 2;

    // CSS to apply if either cols have changed...
    if ($changed > 0) {
      $css .= 'body.sidebars { padding:0 '. ($right_width+20) .'px 0 '. ($left_width+20) .'px; } .sidebars #header, .sidebars #footer { margin-left:-'. ($left_width+10) .'px; margin-right:-'. ($right_width+10) .'px; } #left { width:'. $left_width .'px; right:'. ($left_width+20) .'px; } #right { width:'. $right_width .'px; margin-right:-'. ($right_width+20) .'px; } ';
    }

    // CSS to apply if left changed
    if ($changed & 1) {
      $css .= 'body.sidebar-left { padding:0  15px 0 '. ($left_width+20) .'px; } .sidebar-left  #header, .sidebar-left  #footer { margin-left:-'. ($left_width+10) .'px; } ';
    }

    // CSS to apply if right changed
    if ($changed & 2) {
      $css .= 'body.sidebar-right { padding:0 '. ($right_width+20) .'px 0  10px; } .sidebar-right #header, .sidebar-right #footer { margin-right:-'. ($right_width+10) .'px; } ';
    }
    cache_set('abessive_custom_css', $css);
  }

  // If $css isn't empty them we need to add a little inline CSS to the head.
  if (!empty($css)) {
    $styles .= "\n<style type=\"text/css\">$css</style>\n";
  }
}
