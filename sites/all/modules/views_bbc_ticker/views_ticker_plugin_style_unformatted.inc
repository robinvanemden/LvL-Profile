<?php
/**
 * implementaiton of views_plugin_style
 */

class views_ticker_plugin_style_unformatted extends views_plugin_style_default {
 
  /**
   * Set default options
   */
  function options(&$options) {
    parent::options($options);
    $options['startDelay'] = '';
    $options['placeHolder'] = '';
  }
 
  /**
   * Provide a form for setting options.
   *
   * @param array $form
   * @param array $form_state
   */ 
  function options_form(&$form, &$form_state) {
    parent::options_form($form, $form_state);
    $form['startDelay'] = array(
      '#type' => 'textfield',
      '#title' => t('Start Delay'),
      '#default_value' => $this->options['startDelay'],
    );
    $form['placeHolder'] = array(
      '#type' => 'textfield',
      '#title' => t('Place Holder'),
      '#default_value' => $this->options['placeHolder'],
    );
  }

}
