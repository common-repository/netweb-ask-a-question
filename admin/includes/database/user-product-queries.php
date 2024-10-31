<?php
 if ( ! defined( 'ABSPATH' ) ) exit;
 
include_once ASKAQUES_PLUGIN_ABS_PATH . 'admin/send_email.php';
function askaques_handle_query() {
  if(!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'] ?? null)), 'askaques_secure_data')) {
    wp_send_json(['status' => false, 'message' => 'Your session has expired or is invalid. Please refresh the page and try again']);
  }
  $product_id = sanitize_text_field(wp_unslash($_POST['product_id'] ?? null));
  $user_id = sanitize_text_field(wp_unslash($_POST['user_id'] ?? null));
  $customer_name = sanitize_text_field(wp_unslash($_POST['customer_name'] ?? null));
  $customer_email = sanitize_text_field(wp_unslash($_POST['customer_email'] ?? null));
  $title = sanitize_text_field(wp_unslash($_POST['title'] ?? null));
  $description = sanitize_textarea_field(wp_unslash($_POST['description'] ?? null));

  $data = [
    'product_id' => $product_id,
    'user_id' => $user_id,
    'customer_name' => $customer_name,
    'customer_email' => $customer_email,
    'title' => $title,
    'description' => $description,
  ];

  global $wpdb;
  $label_config_table = ASKAQUES_LABEL_CONFIG_TABLE;
  $sql = "select success_msg_label, field_err_msg, email_validation_msg from " . ASKAQUES_LABEL_CONFIG_TABLE;
  $labels = $wpdb->get_row("select success_msg_label, field_err_msg, email_validation_msg from $label_config_table");
  $custom_labels = ['error_msg' => $labels->field_err_msg , 'email_err_msg' => $labels->email_validation_msg];
  include ASKAQUES_PLUGIN_ABS_PATH . 'admin/includes/validate-inputs.php';
  askaques_validate_form_input($data, $custom_labels);

  $table_name = ASKAQUES_QUERY_FORM_TABLE;
  $result = $wpdb->insert($table_name, $data, array('%d', '%d', '%s', '%s', '%s', '%s'));
  if($result) {
    $data['query_id'] = $wpdb->insert_id;
    do_action('askaques_send_email_after_query', $data);
    wp_send_json(['status' => true, 'message' => $labels->success_msg_label ??  'Query Sent Successfully']);;

  }
  wp_send_json(['status' => false, 'message' => "Something Went wrong"]);

}

add_action('wp_ajax_askaques_handle_query', 'askaques_handle_query');


?>