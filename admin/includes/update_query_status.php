<?php
 if ( ! defined( 'ABSPATH' ) ) exit;
function askaques_update_query_status() {
  if(!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'] ?? null)), 'askaques_secure_data')) {
    wp_send_json('Sorry Session expired. Please refresh page');
  } 
  $status = sanitize_text_field(wp_unslash($_POST['status'] ?? null));
  $query_id = sanitize_text_field(wp_unslash($_POST['query_id'] ?? null));
  $data = [
    'status' => $status,
  ];
  global $wpdb;
  $table_name = ASKAQUES_QUERY_FORM_TABLE;
  $wpdb->update($table_name, $data, ['id' => $query_id], array('%s'), array('%d'));
  wp_send_json('status updated');
}
add_action('wp_ajax_askaques_update_query_status', 'askaques_update_query_status');