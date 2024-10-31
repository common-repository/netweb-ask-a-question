<?php
/*
Plugin Name: NetWeb Ask A Question
Description: Customers can ask questions about a product from the store owner using the Ask A Question plugin, even before they make a purchase. Through the use of this app, the owner of the shop enables customers to ask inquiries or pose any queries regarding the product being sold, and the admin will respond with a suitable response.
Version: 1.0.0
Requires at least: 6.5.0
Requires PHP: 7.0
Author: Netweb
Author URI: https://netwebtechnologies.com/
Requires Plugins: woocommerce
License: GPL v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

if (!defined('ABSPATH')) {
  exit;
}

global $wpdb;

define('ASKAQUES_PLUGIN_PATH_URL', plugin_dir_url(__FILE__));
define('ASKAQUES_PLUGIN_ABS_PATH', plugin_dir_path(__FILE__));

$general_config_table = $wpdb->prefix . 'askaques_ask_general_configuration';
$label_config_table = $wpdb->prefix . 'askaques_ask_label_configuration';
$mail_config_table = $wpdb->prefix . 'askaques_ask_mail_configuration';
$query_form_table = $wpdb->prefix . 'askaques_ask_query_form';
$query_reply_table = $wpdb->prefix . 'askaques_ask_query_reply';
$query_status_table = $wpdb->prefix . 'askaques_ask_query_status';

define('ASKAQUES_GENERAL_CONFIG_TABLE', $general_config_table);
define('ASKAQUES_LABEL_CONFIG_TABLE', $label_config_table);
define('ASKAQUES_MAIL_CONFIG_TABLE', $mail_config_table);
define('ASKAQUES_QUERY_FORM_TABLE', $query_form_table);
define('ASKAQUES_QUERY_REPLY_TABLE', $query_reply_table);
define('ASKAQUES_QUERY_STATUS_TABLE', $query_status_table);

include_once ASKAQUES_PLUGIN_ABS_PATH . 'admin/includes/enqueue-scripts.php';
include_once ASKAQUES_PLUGIN_ABS_PATH . 'admin/includes/admin-menu-option.php';

function askaques_display_app_settings()
{
  ob_start();
  include_once ASKAQUES_PLUGIN_ABS_PATH . 'admin/ask_admin_menu.php';
  echo ob_get_clean();
}

include_once ASKAQUES_PLUGIN_ABS_PATH . 'admin/includes/database/database-tables.php';
include_once ASKAQUES_PLUGIN_ABS_PATH . 'admin/includes/enquiry-page.php';
function askaques_plugin_activation()
{
  askaques_create_database_tables();
  askaques_create_enquiry_page();
}

register_activation_hook(__FILE__, 'askaques_plugin_activation');

function askaques_plugin_deactivate()
{
  $page = get_page_by_path('netweb-ask-question-enquiry');
  if ($page != null) {
    wp_update_post(array(
      'ID'            =>  $page->ID,
      'post_status'   =>  'draft'
    ));
  }
}
register_deactivation_hook(__FILE__, 'askaques_plugin_deactivate');

include_once ASKAQUES_PLUGIN_ABS_PATH . 'admin/includes/database/general-config-queries.php';
include_once ASKAQUES_PLUGIN_ABS_PATH . 'admin/includes/database/user-product-queries.php';
include_once ASKAQUES_PLUGIN_ABS_PATH . 'admin/includes/database/label-config-queries.php';
include_once ASKAQUES_PLUGIN_ABS_PATH . 'admin/includes/database/reply-queries.php';

include_once ASKAQUES_PLUGIN_ABS_PATH . 'includes/get_query_reply.php';

include_once ASKAQUES_PLUGIN_ABS_PATH . 'admin/includes/database/mail-config-queries.php';

function askaques_query_btn()
{
  include_once ASKAQUES_PLUGIN_ABS_PATH . 'includes/user_query_form.php';
}

function askaques_check_user_login_status()
{
  if (get_current_user_id() > 0) {
    add_action('woocommerce_single_product_summary', 'askaques_query_btn',10);
  }
}
add_action('init', 'askaques_check_user_login_status');

include_once ASKAQUES_PLUGIN_ABS_PATH . 'admin/send_email.php';

include_once ASKAQUES_PLUGIN_ABS_PATH . 'admin/includes/update_query_status.php';

include_once ASKAQUES_PLUGIN_ABS_PATH . 'paginate.php';


