<?php

  /**
   * @file
   * This is to implement theme functions for nodereview module
   */

/**
 * Implementation of theme_nodereview_configure_axes()
 * We declare this function to theme the axes in table
 * format
 */
function theme_nodereview_configure_axes($form) {

  $rows = array();
  $output = '';
  foreach (element_children($form['axes']) as $key) {
    $row = array();
    // Strip out the labels on each form element, since they're redundant with the header
    $form['axes'][$key]['use']['#title'] = '';
    $form['axes'][$key]['tag']['#title'] = '';
    $form['axes'][$key]['description']['#title'] = '';
    $form['axes'][$key]['description_required']['#title'] = '';
    $form['axes'][$key]['weight']['#title'] = '';

    $row[] = drupal_render($form['axes'][$key]['aid']) . drupal_render($form['axes'][$key]['use']);
    $row[] = drupal_render($form['axes'][$key]['tag']);
    $row[] = drupal_render($form['axes'][$key]['description']);
    $row[] = drupal_render($form['axes'][$key]['description_required']);
    $row[] = drupal_render($form['axes'][$key]['weight']);
    $rows[] = $row;
  }

  $header = array('use', 'name', 'description', 'require vote comments', 'weight');

  // This is how we get the table to be "inside" the fieldset
  $form['axes']['#children'] = theme('table', $header, $rows);

  $output .= drupal_render($form);
  return $output;
}

/**
 * Implementation of  theme_nodereview_review_body
 * We declare this function to theme the full node
 * view
 *
 */

function theme_nodereview_review_body($review, $node) {
  //Logger::debug_var('review', $review);
  $maxrating = variable_get('nodereview_maxrating', 5);
  $fivestar = '';
  $title = $review['tag'];
  if (NODEREVIEW_FIVESTAR_ENABLE) {
    $fivestar = theme('fivestar_static', $review['score'], variable_get('nodereview_maxrating', 5));
  }
  elseif (NODEREVIEW_LABEL_ENABLE) {
    $title .= ' ' . variable_get('nodereview_rating_label' . round($review['score']/10), '');
  }  
  else {
    $title .= ': ' . $review['score']/10 . '/' . $maxrating;
  }
  $output = theme('box', $title, $fivestar . $review['review']);

  return $output;
}


/**
 * Implementation of  theme_nodereview_review_preview
 * We declare this function to theme the node preview
 *
 */

function theme_nodereview_review_preview($review, $node) {
  $output = '';
  $maxrating = variable_get('nodereview_maxrating', 5);
  $title = $review['tag'];
  $fivestar = '';
  if (NODEREVIEW_FIVESTAR_ENABLE) {
    $fivestar = theme('fivestar_static', $review['score']);
  }
  elseif (NODEREVIEW_LABEL_ENABLE) {
    $title .= ' ' . variable_get('nodereview_rating_label' . round($review['score']/10), '');
  }
  else {
    $title .= ': ' . $review['score']/10 . '/' . $maxrating;
  }
  $output = theme('box', $title, $fivestar . check_markup($review['review'], $node->format));

  return $output;
}


/**
 * Implementation of  theme_nodereview_teaser
 * We declare this function to theme the node teaser
 * view
 *
 */

function theme_nodereview_teaser($node) {
  $output = '';
  static $header;
  $maxrating = variable_get('nodereview_maxrating', 5);
  // Presumably teaser will be called multiple times on different nodes
  // on the same page, so static cache the static strings
  if (!isset($header)) {
    $header = array(t('axis'), t('score'), t('review'));
  }
  $count=0;
  foreach ($node->reviews as $review) {
    $count++;
    $row = array();
    $row[] = $review['tag'];
    if (NODEREVIEW_FIVESTAR_ENABLE) {
      $row[] = theme('fivestar_static', $review['score'], variable_get('nodereview_maxrating', 5));
    }
    elseif (NODEREVIEW_LABEL_ENABLE) {
      $row[] = variable_get('nodereview_rating_label' . round($review['score']/10), '') ;
    }      
    else {
      $row[] = $review['score']/10 . '/' . $maxrating;
    }
    $row[] = truncate_utf8($review['review'], 50, TRUE, TRUE);
    $rows[] = array('data'=> $row, 'class'=>'row'.$count);
  }

  $output .= theme('table', $header, $rows, array('class' => 'review-teaser'));
  return $output;
}
