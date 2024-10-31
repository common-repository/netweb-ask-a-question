<?php
 if ( ! defined( 'ABSPATH' ) ) exit;
function askaques_handle_general_config()
{
  if(!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'] ?? null)), 'askaques_secure_data')) {
    wp_send_json(['status' => false, 'message' => 'Your session has expired or is invalid. Please refresh the page and try again']);
  }

  $email = sanitize_text_field(wp_unslash($_POST['email'] ?? null)) ;
  $id = sanitize_text_field(wp_unslash($_POST['id'] ?? null));
  $data = [
    'email' => $email,
  ];


  include_once ASKAQUES_PLUGIN_ABS_PATH . 'admin/includes/validate-inputs.php';
  askaques_validate_form_input($data);

  global $wpdb;
  $table = ASKAQUES_GENERAL_CONFIG_TABLE;
  $result = null;

  $result = (empty($id)) ? $wpdb->insert($table, $data, array('%s')) : $wpdb->update($table, $data, array('id' => $id), array('%s'), array('%d'));

  if ($result >= 0) {
    wp_send_json(['status' => true, 'message' => 'General Configurations Saved']);
    
  } else {
    wp_send_json(['status' => false, 'message' => 'Something went wrong']);
  }
}

add_action('wp_ajax_askaques_handle_general_config', 'askaques_handle_general_config');

