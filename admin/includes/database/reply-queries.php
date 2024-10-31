<?php 
 if ( ! defined( 'ABSPATH' ) ) exit;
function askaques_handle_query_reply() {
  if(!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'] ?? null)), 'askaques_secure_data')) {
    wp_send_json(['status' => false, 'message' => 'Your session has expired or is invalid. Please refresh the page and try again']);
  }
  global $wpdb;
  $table_name = ASKAQUES_QUERY_REPLY_TABLE;
  $data = [
    'query_id' => sanitize_text_field(wp_unslash($_POST['query_id'] ?? null)),
    'reply' => sanitize_textarea_field(wp_unslash($_POST['reply'] ?? null)),
    'user_id' => get_current_user_id(),
  ];

  include_once ASKAQUES_PLUGIN_ABS_PATH . 'admin/includes/validate-inputs.php';
  askaques_validate_form_input($data);
  $result = $wpdb->insert($table_name, $data, array('%d','%s', '%d'));
    if($result) {
      do_action('askaques_send_email_after_reply', $data);
      wp_send_json(['status' => true, 'message' => 'Replied successful']);
    }
     wp_send_json(['status' => false, 'message' => 'Something went wrong']);
}
add_action('wp_ajax_askaques_handle_query_reply', 'askaques_handle_query_reply');


?>