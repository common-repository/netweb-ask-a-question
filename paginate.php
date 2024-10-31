<?php
 if ( ! defined( 'ABSPATH' ) ) exit;
 
function askaques_custom_paginate()
{
  if(wp_doing_ajax() && !wp_verify_nonce(sanitize_text_field(wp_unslash($_GET['nonce'] ?? null)), 'askaques_secure_data')) {
    wp_send_json(['status' => false,'message' => 'Sorry Session expired. Please refresh page']);
  } 

  global $wpdb;
  $query_form_table = ASKAQUES_QUERY_FORM_TABLE;
  $query_status_table = ASKAQUES_QUERY_STATUS_TABLE;
  $query_label_config_table = ASKAQUES_LABEL_CONFIG_TABLE;
  $current_user_id = get_current_user_id();
  
  $sql = "select $query_form_table.*, $wpdb->posts.post_title, $query_status_table.status from $query_form_table inner join $wpdb->posts on $query_form_table.product_id = $wpdb->posts.id inner join $query_status_table on $query_form_table.status = $query_status_table.id ";

  $ques_type = sanitize_text_field(wp_unslash($_GET['type'] ?? 'all_ques'));
  
  if (current_user_can('manage_options') && $ques_type == 'all_ques') {

    $sql .= "order by created_at desc";
  } elseif (current_user_can('manage_options') && $ques_type == 'new_ques') {

    $sql .= "where $query_form_table.created_at >= CURRENT_DATE AND $query_form_table.created_at < CURRENT_DATE + INTERVAL 1 DAY";
  } else {
    $sql .= "where user_id=%d order by created_at desc";
  }

  $page_number = sanitize_text_field(wp_unslash($_GET['page_no'] ?? 1 ));
  $total_rows = null;
  if(current_user_can('manage_options')) {
    $total_rows = count($wpdb->get_results($sql));
  } else {
    $total_rows = count($wpdb->get_results($wpdb->prepare($sql, $current_user_id)));
  }

  $limit = 10;
  $offset = ($page_number - 1) * $limit;
  $total_pages = ceil($total_rows / $limit);
  $queries = null;
  $sql .= " limit %d, %d";
  if(current_user_can('manage_options')) {
    $queries = $wpdb->get_results($wpdb->prepare($sql, $offset, $limit));
  } else {
    $queries = $wpdb->get_results($wpdb->prepare($sql, $current_user_id, $offset, $limit));
  }

  $label_config = $wpdb->get_row("select * from $query_label_config_table");

  ob_start();
  include_once ASKAQUES_PLUGIN_ABS_PATH . 'includes/asked_questions_list.php';
  echo ob_get_clean();

  if (wp_doing_ajax()) {
    wp_die();
  }
}
add_action('wp_ajax_askaques_custom_paginate', 'askaques_custom_paginate');
