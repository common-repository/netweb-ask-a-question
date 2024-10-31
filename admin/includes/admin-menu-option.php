<?php 
 if ( ! defined( 'ABSPATH' ) ) exit;
function askaques_app_settings() {
  add_menu_page(
    'NetWeb Ask A Question',
    'NetWeb Ask A Question',
    'manage_options',
    'netweb-ask-a-question-settings',
    'askaques_display_app_settings',
    'dashicons-admin-settings',
    '50'
  );
}

add_action('admin_menu', 'askaques_app_settings');


?>