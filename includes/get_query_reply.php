<?php
 if ( ! defined( 'ABSPATH' ) ) exit;
function askaques_get_query_reply()
{
  if(!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'] ?? null)), 'askaques_secure_data')) {
    wp_send_json('Sorry Session expired. Please refresh page');
   
  } 
  global $wpdb;
  $query_reply_table = ASKAQUES_QUERY_REPLY_TABLE;
  $query_form_table = ASKAQUES_QUERY_FORM_TABLE;
  $query_status_table = ASKAQUES_QUERY_STATUS_TABLE;
  $query_id = sanitize_text_field(wp_unslash($_POST['query_id'] ?? null));

  $replies = $wpdb->get_results($wpdb->prepare("select $query_reply_table.*, $wpdb->users.user_nicename from $query_reply_table inner join $wpdb->users on $query_reply_table.user_id = $wpdb->users.id where $query_reply_table.query_id= %d order by created_at", $query_id));

  $result = $wpdb->get_row($wpdb->prepare("select $query_form_table.customer_name, $query_form_table.title, $query_form_table.description, $query_form_table.user_id, $wpdb->users.user_nicename, $query_form_table.status from $query_form_table inner join $wpdb->users on $query_form_table.user_id = $wpdb->users.id where $query_form_table.id=%d" , $query_id));
  
  
  

  ob_start();
  include_once ASKAQUES_PLUGIN_ABS_PATH . 'includes/reply_query_details.php';
  $res['replies'] = ob_get_clean();
  $res['customer_name'] = esc_html($result->customer_name);
  $res['title'] = esc_html($result->title);
  $res['user_name'] = esc_html(($result->user_id == get_current_user_id()) ? 'You' : $result->user_nicename);
  $res['description'] = esc_html($result->description);
  $res['query_id'] = esc_html($query_id);
  $res['status'] = esc_html($result->status);
  wp_send_json($res);
}
add_action('wp_ajax_askaques_get_query_reply', 'askaques_get_query_reply');