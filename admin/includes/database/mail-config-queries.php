<?php
 if ( ! defined( 'ABSPATH' ) ) exit;
function askaques_handle_mail_config() {
  if(!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'] ?? null)), 'askaques_secure_data')) {
    wp_send_json(['status' => false, 'message' => 'Your session has expired or is invalid. Please refresh the page and try again']);
  }
  $mail_subject = sanitize_text_field(wp_unslash($_POST['mail_subject'] ?? null));
  $mail_content = wp_kses_post(wp_unslash($_POST['mail_content'] ?? null));
  $id = sanitize_text_field(wp_unslash($_POST['id'] ?? null));
  $data = [
   'mail_subject' => $mail_subject,
   'mail_content' => $mail_content,
  ];
 
  include_once ASKAQUES_PLUGIN_ABS_PATH . 'admin/includes/validate-inputs.php';
  askaques_validate_form_input($data);
 
  global $wpdb;
  $table_name = ASKAQUES_MAIL_CONFIG_TABLE;
  $result = null;
 
  $result = (empty($id)) ? $wpdb->insert($table_name, $data, array('%s', '%s')) : $wpdb->update($table_name, $data, array('id' => $id), array('%s','%s'), array('%d'));
  
  if($result >=0) {
   wp_send_json(['status' => true, 'message' => 'Mail Configurations saved']);
  } else {
   wp_send_json(['status' => false, 'message' => 'Something went wrong']);
  }
 }
 add_action('wp_ajax_askaques_handle_mail_config', 'askaques_handle_mail_config');
?>