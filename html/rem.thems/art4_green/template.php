<?php

/**
 * ABOUT
 *
 *  The template.php file is one of the most useful files when creating or modifying Drupal themes.
 *  You can add new regions for block content, modify or override Drupal's theme functions, 
 *  intercept or make additional variables available to your theme, and create custom PHP logic.
 *  For more information, please visit the Theme Developer's Guide on Drupal.org:
 *  http://drupal.org/node/509
 */

 
/**
* MODIFYING OR CREATING REGIONS
*
* Regions are areas in your theme where you can place blocks.
* The default regions used in themes  are "left sidebar", "right sidebar", "header", and "footer",  although you can create
* as many regions as you want.  Once declared, they are made available to the page.tpl.php file as a variable.  
* For instance, we use <?php print $header ?> for the placement of the "header" region in page.tpl.php.
* 
* By going to  the administer > site building > blocks page you can choose which regions various blocks should be placed.
* New regions you define here will automatically show up in the drop-down list by their human readable name.
 */
 
 
/**
 * Declare the available regions implemented by this engine.
 *
 * @return
 *    An array of regions.  The first array element will be used as the default region for themes.
 *    Each array element takes the format: variable_name => t('human readable name')
 */
function bluebreeze_regions() {
  return array(
       'left' => t('left sidebar'),
       'right' => t('right sidebar'),
       'content_top' => t('content top'),
       'content_bottom' => t('content bottom'),
       'header' => t('header'),
       'footer' => t('footer')
  );
} 

/**
 * OVERRIDING THEME FUNCTIONS
 *
 *  The Drupal theme system uses special theme functions to generate HTML output automatically.
 *  Often we wish to customize this HTML output.  To do this, we have to override the theme function.
 *  You have to first find the theme function that generates the output, and then "catch" it and modify it here.
 *  The easiest way to do it is to copy the original function in its entirety and paste it here, changing
 *  the prefix from theme_ to zen_.  For example:
 *
 *   original:  theme_breadcrumb() 
 *   theme override:   bluebreeze_breadcrumb()
 *
 *  See the following example. In this theme, we want to change all of the breadcrumb separator links from  >> to ::
 *
 */

/**
  * Return a themed breadcrumb trail.
  *
  * @param $breadcrumb
  *   An array containing the breadcrumb links.
  * @return a string containing the breadcrumb output.
  */
/* function bluebreeze_breadcrumb($breadcrumb) {
   if (!empty($breadcrumb)) {
     return '<div class="breadcrumb">'. implode(' :: ', $breadcrumb) .'</div>';
   }
 } */
 
 
/** 
 * CREATE OR MODIFY VARIABLES FOR YOUR THEME
 *
 *  The most powerful function available to themers is the _phptemplate_variables() function. It allows you
 *  to pass newly created variables to different template (tpl.php) files in your theme. Or even unset ones you don't want
 *  to use.
 *
 *  It works by switching on the hook, or name of the theme function, such as:
 *    - page
 *    - node
 *    - comment
 *    - block
 *
 * By switching on this hook you can send different variables to page.tpl.php file, node.tpl.php
 * (and any other derivative node template file, like node-forum.tpl.php), comment.tpl.php, and block.tpl.php
 *
 */

 
/**
 * Intercept template variables
 *
 * @param $hook
 *   The name of the theme function being executed
 * @param $vars
 *   A sequential array of variables passed to the theme function.
 */

function _phptemplate_variables($hook, $vars = array()) {
  switch ($hook) {
    // Send a new variable, $has_terms, to see wether the current node has any terms
    case 'node':   
      if(count(taxonomy_node_get_terms($vars['node']->nid)))
        $vars['has_terms'] = TRUE;
      else
        $vars['has_terms'] = FALSE;
  }
  
  return $vars;
}
