<?php

if (!defined('WP_UNINSTALL_PLUGIN')) {
  die();
}

global $wpdb;
$table_prefix = $wpdb->prefix;

$wpdb->query("DROP TABLE IF EXISTS $table_prefix" . 'askaques_ask_general_configuration');
$wpdb->query("DROP TABLE IF EXISTS $table_prefix" . 'askaques_ask_label_configuration');
$wpdb->query("DROP TABLE IF EXISTS $table_prefix" . 'askaques_ask_mail_configuration');
$wpdb->query("DROP TABLE IF EXISTS $table_prefix" . 'askaques_ask_query_reply');
$wpdb->query("DROP TABLE IF EXISTS $table_prefix" . 'askaques_ask_query_form');
$wpdb->query("DROP TABLE IF EXISTS $table_prefix" . 'askaques_ask_query_status');

function askaques_remove_page_by_slug()
{
  $page_slug = 'netweb-ask-question-enquiry';
  $page = get_page_by_path($page_slug);
  if ($page) {
    wp_delete_post($page->ID, true);
    flush_rewrite_rules();
  }
};
askaques_remove_page_by_slug();
