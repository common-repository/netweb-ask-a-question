<?php
 if ( ! defined( 'ABSPATH' ) ) exit;
function askaques_create_enquiry_page()
{
  if (post_exists('NetWeb Ask A Question')) {
    $page = get_page_by_path('netweb-ask-question-enquiry');
    if ($page != null) {
      wp_update_post(array(
        'ID'            =>  $page->ID,
        'post_status'   =>  'publish',
      ));
      return;
    }
  }

  $args = array(
    'post_title' => 'NetWeb Ask A Question',
    'post_content' => '',
    'post_status' => 'publish',
    'post_name' => 'netweb-ask-question-enquiry',
    'post_type' => 'page',
  );

  wp_insert_post($args);
}

function askaques_custom_template_include($template)
{
  if (is_page('netweb-ask-question-enquiry')) {
    $template = ASKAQUES_PLUGIN_ABS_PATH . 'enquiry-page-template.php';
  }
  return $template;
}
add_filter('template_include', 'askaques_custom_template_include');

function askaques_add_enquiry_nav_menu($menu_links)
{

  $new_items = array();
  foreach ($menu_links as $key => $value) {
    if ($key != 'customer-logout') {
      $new_items[$key] = $value;
    } else {
      $new_items['netweb-ask-question-enquiry'] = 'NetWeb Ask A Question';
      $new_items[$key] = $value;
    }
  }
  return $new_items;
}
add_filter('woocommerce_account_menu_items', 'askaques_add_enquiry_nav_menu', 99, 1);

function askaques_add_enquiry_endpoint()
{
  add_rewrite_endpoint('netweb-ask-question-enquiry', EP_PAGES);
  flush_rewrite_rules();
}
add_action('init', 'askaques_add_enquiry_endpoint');

function askaques_enquiry_content()
{
  ob_start();
  include_once ASKAQUES_PLUGIN_ABS_PATH . 'enquiry-page-template.php';
  echo ob_get_clean();
}
add_action('woocommerce_account_netweb-ask-question-enquiry_endpoint', 'askaques_enquiry_content');
