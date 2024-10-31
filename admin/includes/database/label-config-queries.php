<?php
 if ( ! defined( 'ABSPATH' ) ) exit;
function askaques_handle_label_config() {
  if(!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'] ?? null)), 'askaques_secure_data')) {
    wp_send_json(['status' => false, 'message' => 'Your session has expired or is invalid. Please refresh the page and try again']);
  }
  $ask_btn_content = sanitize_text_field(wp_unslash($_POST['ask_btn_content'] ?? null));
  $name_label = sanitize_text_field(wp_unslash($_POST['name_label'] ?? null));
  $email_label = sanitize_text_field(wp_unslash($_POST['email_label'] ?? null));
  $title_label = sanitize_text_field(wp_unslash($_POST['title_label'] ?? null));
  $submit_btn_content = sanitize_text_field(wp_unslash($_POST['submit_btn_content'] ?? null));
  $success_msg_label = sanitize_text_field(wp_unslash($_POST['success_msg_label'] ?? null));
  $field_err_msg = sanitize_text_field(wp_unslash($_POST['field_err_msg'] ?? null));
  $email_validation_msg = sanitize_text_field(wp_unslash($_POST['email_validation_msg'] ?? null));
  $description_label = sanitize_text_field(wp_unslash($_POST['description_label'] ?? null));
  $heading = sanitize_text_field(wp_unslash($_POST['heading'] ?? null));
  $sub_heading = sanitize_text_field(wp_unslash($_POST['sub_heading'] ?? null));
  $view_query_btn = sanitize_text_field(wp_unslash($_POST['view_query_btn'] ?? null));
  $cancel_btn_content = sanitize_text_field(wp_unslash($_POST['cancel_btn_content'] ?? null));
  $reply_btn_content = sanitize_text_field(wp_unslash($_POST['reply_btn_content'] ?? null));
  $id = sanitize_text_field(wp_unslash($_POST['id'] ?? null));

  $data = [
    'ask_btn_content' => $ask_btn_content,
    'name_label' => $name_label,
    'email_label' => $email_label,
    'title_label' => $title_label,
    'submit_btn_content' => $submit_btn_content,
    'success_msg_label' => $success_msg_label,
    'field_err_msg' => $field_err_msg,
    'email_validation_msg' => $email_validation_msg,
    'description_label' => $description_label,
    'heading' => $heading,
    'sub_heading' => $sub_heading,
    'view_query_btn' => $view_query_btn,
    'cancel_btn_content' => $cancel_btn_content,
    'reply_btn_content' => $reply_btn_content,
  ];

  global $wpdb;
  $table_name = ASKAQUES_LABEL_CONFIG_TABLE;
  $result = null;
  
  include_once ASKAQUES_PLUGIN_ABS_PATH . 'admin/includes/validate-inputs.php';
  askaques_validate_form_input($data);

  $result = (empty($id)) ? $wpdb->insert($table_name,$data, array('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')) : $wpdb->update($table_name, $data, array('id' => $id), array('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s'), array('%s'));

  if($result >=0) {
    wp_send_json(['status' => true, 'message' => 'Label Configurations saved']);
   
  }
  wp_send_json(['status' => false, 'message' => 'Something went wrong']);
}

add_action('wp_ajax_askaques_handle_label_config', 'askaques_handle_label_config');
?>