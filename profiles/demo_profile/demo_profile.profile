<?php

/**
 * Return an array of the modules to be enabled when this profile is installed.
 *
 * @return
 *   An array of modules to enable.
 */
function demo_profile_profile_modules() {
  return array('demo');
}

/**
 * Return a description of the profile for the initial installation screen.
 *
 * @return
 *   An array with keys 'name' and 'description' describing this profile,
 *   and optional 'language' to override the language selection for
 *   language-specific profiles.
 */
function demo_profile_profile_details() {
  return array(
    'name' => 'LvL MediaMosa install profile',
    'description' => 'Select this profile to install LvoorL.',
  );
}

/**
 * Implementation of hook_form_alter().
 *
 * Allows the profile to alter the site-configuration form. This is
 * called through custom invocation, so $form_state is not populated.
 */
function demo_profile_form_alter(&$form, $form_state, $form_id) {
  if ($form_id == 'install_configure') {

    // These settings arn't used, so add some default values and hide the elements.
    $form['site_information']['site_name']['#value'] = 'Drupal';
    $form['site_information']['site_mail']['#value'] = 'drupal@drupal.org';
    $form['admin_account']['account']['name']['#value'] = 'Drupal';
    $form['admin_account']['account']['mail']['#value'] = 'drupal@drupal.org';
    $form['admin_account']['account']['pass']['#value'] = 'drupal';
    $form['site_information']['#access'] = FALSE;
    $form['admin_account']['#access'] = FALSE;
    $form['server_settings']['#access'] = FALSE;

    // Display the available database dumps.
    module_load_include('inc', 'demo', 'demo.admin'); 
    $form['demo'] = array(
      '#type' => 'fieldset',
      '#title' => t('Demonstration site'),
      '#description' => t('Which database dump would you like to restore from?'),
      demo_get_dumps(),
    );
    $form['#submit'][] = 'demo_profile_form_submit';
  }
}

/**
 * Submit handler for the "install_configure" form.
 */
function demo_profile_form_submit($form, &$form_state) {
  // Restore the database dump and redirect to the homepage.
  module_load_include('inc', 'demo', 'demo.admin');
  demo_reset($form_state['clicked_button']['#post']['filename'], FALSE);
  drupal_goto('<front>');
}
