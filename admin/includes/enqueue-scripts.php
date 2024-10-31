<?php
 if ( ! defined( 'ABSPATH' ) ) exit;
function askaques_enqueue_styles_scripts($hook)
{
  if($hook == 'toplevel_page_netweb-ask-a-question-settings') {
  wp_enqueue_style('askaques-bootstrap-css', ASKAQUES_PLUGIN_PATH_URL . 'assets/bootstrap_v5/css/bootstrap-v5-min.css', null, '1.0.0');
  wp_enqueue_style('askaques-custom-css', ASKAQUES_PLUGIN_PATH_URL . 'assets/css/style.css', null, '1.0.0');
  wp_enqueue_script('askaques-bootstrap-js', ASKAQUES_PLUGIN_PATH_URL . 'assets/bootstrap_v5/js/bootstrap-v5-min.js', null, '1.0.0', true);
  wp_enqueue_script('askaques-custom-js', ASKAQUES_PLUGIN_PATH_URL . 'assets/js/script.js', array('jquery'), '1.0.0', true);
  wp_localize_script('askaques-custom-js', 'askaques_ajax', array('url' => admin_url('admin-ajax.php'), 'nonce' => wp_create_nonce('askaques_secure_data')));
}
}
add_action('admin_enqueue_scripts', 'askaques_enqueue_styles_scripts');

function askaques_enqueue_styles_scripts_custom()
{
  global $wp;
  if (is_page('netweb-ask-question-enquiry') || (is_account_page() && isset($wp->query_vars['netweb-ask-question-enquiry'])) || is_product()) {
    wp_enqueue_style('askaques-bootstrap-csss', ASKAQUES_PLUGIN_PATH_URL . 'assets/bootstrap_v5/css/bootstrap-v5-min.css', null, '1.0.0');
    wp_enqueue_style('askaques-custom-csss', ASKAQUES_PLUGIN_PATH_URL . 'assets/css/style.css', null, '1.0.0');
    wp_enqueue_script('askaques-bootstrap-jss', ASKAQUES_PLUGIN_PATH_URL . 'assets/bootstrap_v5/js/bootstrap-v5-min.js', null, '1.0.0', true);
    wp_enqueue_script('askaques-custom-jss', ASKAQUES_PLUGIN_PATH_URL . 'assets/js/script.js', array('jquery'), '1.0.0', true);
    wp_localize_script('askaques-custom-jss', 'askaques_ajax', array('url' => admin_url('admin-ajax.php'), 'nonce' => wp_create_nonce('askaques_secure_data')));
  }
}
add_action('wp_enqueue_scripts', 'askaques_enqueue_styles_scripts_custom');

