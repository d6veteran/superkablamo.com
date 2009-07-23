<?php
//See http://drupal.org/node/177868

// An example themes/andreas/theme-settings.php file.

/**
* Implementation of THEMEHOOK_settings() function.
*
* @param $saved_settings
*   array An array of saved settings for this theme.
* @return
*   array A form array.
*/
function phptemplate_settings($saved_settings) {
  /*
   * The default values for the theme variables. Make sure $defaults exactly
   * matches the $defaults in the template.php file.
   */
  $defaults = array(             // <-- change this array
    'andreas_basecolour' => 'Blue',
  );

  // Merge the saved variables and their default values
  $settings = array_merge($defaults, $saved_settings);

  // Create the form widgets using Forms API
  $form['andreas_basecolour'] = array(
    '#type'          => 'radios',
    '#title'         => t('Base Colour'),
    '#options'       => array(
                          'Blue' 	=> t('Blue') ,
			  'Green' 	=> t('Green') ,
			  'Orange' 	=> t('Orange') ,
			  'Purple' 	=> t('Purple') ,
			  'Red' 	=> t('Red') ,
			  'Black' 	=> t('Black') ,                          
                        ),
    '#default_value' => $settings['andreas_basecolour'],
  );
  $form['andreas_layout'] = array(
    '#type'          => 'radios',
    '#title'         => t('Layout method'),
    '#options'       => array(
                          'Liquid' => t('Liquid layout') ,
                          'Fixed' => t('Fixed layout') ,
                        ),
    '#default_value' => $settings['andreas_layout'],
  );

  // Return the additional form widgets
  return $form;
}
?>