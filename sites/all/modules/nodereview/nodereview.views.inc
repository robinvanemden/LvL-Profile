<?php
  /**
   * @file
   * This is to implement view functionality
   */

function nodereview_views_data() {
  $data['nodereview']['table']['group']  =t('Node Review');
  $data['nodereview']['table']['join']['node'] = array(
    'left_field' => 'nid',
    'field' => 'nid',
  );

  $data['nodereview']['reviewed_nid'] = array(
    'title' => t('Reviewed Node'),
    'help' => t('The node which is reviewed.'),
    'relationship' => array( //this creates the relationship with node reviewed linking all available fields from the node table
      'base' => 'node',
      'field' => 'nid',
      'handler' => 'views_handler_relationship',
      'label' => t('Reviewed Node'),
    ),
    'filter' => array(
      'handler' => 'views_handler_filter_numeric',
      'numeric' => TRUE,
    ),
    'argument' => array(
      'handler' => 'views_handler_argument_numeric',
      'numeric' => TRUE,
    ),

  );
  return $data;
}


