<?php
// $Id$

/**		
 * @file
 * Contains theme override functions and preprocess functions for the theme.
 *
 */

/**
 * Implementation of HOOK_theme().
 */
function lvl(&$existing, $type, $theme, $path) {
  $hooks = fusion_core($existing, $type, $theme, $path);
  return $hooks;
}


/**
* Remove the comment filters' tips
*/
function lvl_filter_tips($tips, $long = FALSE, $extra = '') {
  return '';
}
/**
* Remove the comment filter's more information tips link
*/
function lvl_filter_tips_more_info () {
  return '';
}


/**
 * Theme a "you can't post comments" notice.
 *
 * @param $node
 *   The comment node.
 * @ingroup themeable
 */
function lvl_comment_post_forbidden($node) {
  global $user;
  static $authenticated_post_comments;

  if (!$user->uid) {
    if (!isset($authenticated_post_comments)) {
      // We only output any link if we are certain, that users get permission
      // to post comments by logging in. We also locally cache this information.
      $authenticated_post_comments = array_key_exists(DRUPAL_AUTHENTICATED_RID, user_roles(TRUE, 'post comments') + user_roles(TRUE, 'post comments without approval'));
    }

    if ($authenticated_post_comments) {
      // We cannot use drupal_get_destination() because these links
      // sometimes appear on /node and taxonomy listing pages.
      if (variable_get('comment_form_location_'. $node->type, COMMENT_FORM_SEPARATE_PAGE) == COMMENT_FORM_SEPARATE_PAGE) {
        $destination = 'destination='. rawurlencode("comment/reply/$node->nid#comment-form");
      }
      else {
        $destination = 'destination='. rawurlencode("node/$node->nid#comment-form");
      }

      if (variable_get('user_register', 1)) {
        // Users can register themselves.
        return t('<a href="@login"><span>Login</span></a> <span class="regulat-text">or</span> <a href="@register"><span>register</span></a> <span class="regulat-text">to post comments</span>', array('@login' => url('user/login', array('query' => $destination)), '@register' => url('user/register', array('query' => $destination))));
      }
      else {
        // Only admins can add new users, no public registration.
        return t('<a href="@login"><span>Login</span></a> to post comments', array('@login' => url('user/login', array('query' => $destination))));
      }
    }
  }
}


/**
 * Process variables for forums.tpl.php
 *
 * The $variables array contains the following arguments:
 * - $forums
 * - $topics
 * - $parents
 * - $tid
 * - $sortby
 * - $forum_per_page
 *
 * @see forums.tpl.php
 */
function lvl_preprocess_forums(&$variables) {
  global $user;
  if (isset($variables['links']['login'])) {
    $variables['links']['login']['title'] = str_replace('to post new content in the forum.','<span class="regular_text">to post new content in the forum.</span>',$variables['links']['login']['title']);
  }
}


/**
 * Adds spans and useful ID's to the links below post.
 *
 */
function lvl_links($links, $attributes = array('class' => 'links')) {
  $output = '';
  if (count($links) > 0) {
    $output = '<ul'. drupal_attributes($attributes) .'>';
    $num_links = count($links);
    $i = 1;
    foreach ($links as $key => $link) {
      $class = $key;

      // Add first, last and active classes to the list of links to help out themers.
      if ($i == 1) {
        $class .= ' first';
      }
      if ($i == $num_links) {
        $class .= ' last';
      }
      if (isset($link['href']) && $link['href'] == $_GET['q']) {
        $class .= ' active';
      }
      $output .= '<li class="'. $class .'">';
      if (isset($link['href'])) {

        // Pass in $link as $options, they share the same keys.
        $link['html'] = TRUE;
        $output .= l('<span>'. $link['title'] .'</span>', $link['href'], $link);
      }
      else if (!empty($link['title'])) {

        // Some links are actually not links, but we wrap these in <span> for adding title and class attributes
        if (empty($link['html'])) {
          $link['title'] = check_plain($link['title']);
        }
        $span_attributes = '';
        if (isset($link['attributes'])) {
          $span_attributes = drupal_attributes($link['attributes']);
        }
        $output .= '<span'. $span_attributes .'>'. $link['title'] .'</span>';
      }
      $i++;
      $output .= "</li>\n";
    }
    $output .= '</ul>';
  }
  return $output;
}


/**
 * Return a themed breadcrumb trail.
 *
 * @param $breadcrumb
 *   An array containing the breadcrumb links.
 * @return a string containing the breadcrumb output.
 */
function lvl_breadcrumb($breadcrumb) {
  if (!empty($breadcrumb)) {
    return '<div class="breadcrumb">'. implode('', $breadcrumb) .'</div>';
  }
}


/**
 * Override or insert variables into the page templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 */
function lvl_preprocess_page(&$vars) {
  $theme_color_style = theme_get_setting('theme_color_style');
  $theme_background = theme_get_setting('theme_background');
  $css_color_style_path = path_to_theme() .'/css/colors/'. $theme_color_style .'/'. $theme_color_style .'.css';
  if (!file_exists($css_color_style_path)) {
    $css_color_style_path = drupal_get_path('theme', 'lvl') .'/css/colors/'. $theme_color_style .'/'. $theme_color_style .'.css';
  }
  $background_color_style_path = path_to_theme() .'/css/background/'. $theme_background .'/'. $theme_background .'.css';
  if (!file_exists($background_color_style_path)) {
    $background_color_style_path = drupal_get_path('theme', 'lvl') .'/css/background/'. $theme_background .'/'. $theme_background .'.css';
  }
  $themes = array();
  foreach ($vars['css']['all']['theme'] as $key => $value) {
    $themes[$key] = $value;
    if ($key ==  drupal_get_path('theme', 'lvl') .'/css/lvl.css') {
      $themes[$css_color_style_path] = 1;
      $themes[$background_color_style_path] = 1;
    }
  }
  $vars['css']['all']['theme'] = $themes;
  $vars['styles'] = drupal_get_css($vars['css']);
  if (!module_exists('conditional_styles')) {
    $vars['styles'] .= $vars['conditional_styles'] = variable_get('conditional_styles_'. $GLOBALS['theme'], '');
  }


  $body_classes = split(' ', $vars['body_classes']);
  // Add class to body depends on selected primary menu from theme settings. 
  $vars['body_classes_array'] = $body_classes;
  $body_classes[] = 'color-'. $theme_color_style;
  $body_classes[] = 'bg-'. $theme_background;

  if(empty($vars['preface_upper_top'])){
  $body_classes[] ='no-preface-upper-top';
  }
  $vars['body_classes'] = implode(' ', $body_classes); // Concatenate with spaces.
}


// Adding default name in Search Box
drupal_add_js("$(document).ready(function() {
  $('#edit-search-block-form-1').val('". t('Search')."');
  $('#edit-search-block-form-1').focus(function() { if ($(this).val() == '". t('Search')."') $(this).val(''); });
  $('#edit-search-block-form-1').blur(function() { if ($(this).val() == '') $(this).val('". t('Search')."'); });});
", 'inline', 'footer');


// Contact form
// name
drupal_add_js("$(document).ready(function() {
  $('#edit-submitted-name').val('". t('name')."');
  $('#edit-submitted-name').focus(function() { if ($(this).val() == '". t('name')."') $(this).val(''); });
  $('#edit-submitted-name').blur(function() { if ($(this).val() == '') $(this).val('". t('name')."'); });});
", 'inline', 'footer');

// email
drupal_add_js("$(document).ready(function() {
  $('#edit-submitted-email').val('". t('e-mail')."');
  $('#edit-submitted-email').focus(function() { if ($(this).val() == '". t('e-mail')."') $(this).val(''); });
  $('#edit-submitted-email').blur(function() { if ($(this).val() == '') $(this).val('". t('e-mail')."'); });});
", 'inline', 'footer');

// message
drupal_add_js("$(document).ready(function() {
  $('#edit-submitted-message').val('". t('message')."');
  $('#edit-submitted-message').focus(function() { if ($(this).val() == '". t('message')."') $(this).val(''); });
  $('#edit-submitted-message').blur(function() { if ($(this).val() == '') $(this).val('". t('message')."'); });});
", 'inline', 'footer');