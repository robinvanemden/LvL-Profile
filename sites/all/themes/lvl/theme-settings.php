<?php  
// $Id$
/**
 * @file
 * theme-settings.php
 */
include_once './'. drupal_get_path('theme', 'fusion_core') .'/theme-settings.php';


/**
 * Implementation of THEMEHOOK_settings() function.
 *
 * @param $saved_settings
 *   An array of saved settings for this theme.
 * @return
 *   A form array. 
 */
function lvl_settings($saved_settings) {
  $form = array();
  // Get the default values from the .info file.
  $defaults = fusion_core_default_theme_settings('lvl');
  $settings = array_merge($defaults, $saved_settings);

  // Add the base theme's settings.
  $form += phptemplate_settings($saved_settings, $defaults);

  $form['tnt_container']['general_settings']['theme_grid_config']['theme_color_style'] = array(
    '#type' => 'select',
    '#title' => t('Color/Style'),
    '#default_value' => $settings['theme_color_style'],
    '#options' => array(
    'aqua' => t('Aqua'),
    'ash' => t('Ash'),
	  'blue' => t('Blue'),
	  'green' => t('Green'),
    'limegreen' => t('limegreen'),
	  'orange' => t('Orange'),
	  'pink' => t('Pink'),
	  'purple' => t('Purple'),
	  'red' => t('Red'),
	  'teal' => t('Teal'),
	  'yellow' => t('Yellow')
    ),
  );

  $form['tnt_container']['general_settings']['theme_grid_config']['theme_background'] = array(
    '#type' => 'select',
    '#title' => t('Background'),
    '#default_value' => $settings['theme_background'],
    '#options' => array(
    'aqua' => t('Aqua'),
    'ash' => t('Ash'),
	  'blue' => t('Blue'),
	  'green' => t('Green'),
    'limegreen' => t('limegreen'),
	  'orange' => t('Orange'),
	  'pink' => t('Pink'),
	  'purple' => t('Purple'),
	  'red' => t('Red'),
	  'teal' => t('Teal'),
	  'yellow' => t('Yellow')
    ),
  );


  // Return the form 
  return $form;
}