<?php
/**
 * Implementation of hook_views_plugins
 */
function views_ticker_views_plugins() {
  return array(
    'style' => array(
      'views_ticker' => array(
        'title' => t('Views Ticker'),
        'theme' => 'views_ticker_style_unformatted',
        'help' => t('Generate a bbc type ticker'),
        'handler' => 'views_ticker_plugin_style_unformatted',
//        'uses row plugin' => TRUE,
        'uses fields' => TRUE,
        'uses options' => TRUE,
        'type' => 'normal', 
        'parent' => 'default'
      ),
    ),
  );
}

