<?php
 if ( ! defined( 'ABSPATH' ) ) exit;
 
function askaques_create_database_tables()
{
  global $wpdb;

  $charset = $wpdb->get_charset_collate();

  $general_config_sql = "CREATE TABLE IF NOT EXISTS " . ASKAQUES_GENERAL_CONFIG_TABLE . "(
     id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
     email text NOT NULL,
     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
     updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
     PRIMARY KEY (id)
    ) $charset;";

  $label_config_sql = "CREATE TABLE IF NOT EXISTS " . ASKAQUES_LABEL_CONFIG_TABLE . "(
      id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
      ask_btn_content VARCHAR(255) NOT NULL,
      name_label VARCHAR(255) NOT NULL,
      email_label VARCHAR(255) NOT NULL,
      title_label VARCHAR(255) NOT NULL,
      submit_btn_content VARCHAR(255) NOT NULL,
      success_msg_label VARCHAR(255) NOT NULL,
      field_err_msg VARCHAR(255) NOT NULL,
      email_validation_msg VARCHAR(255) NOT NULL,
      description_label text NOT NULL,
      heading VARCHAR(255) NOT NULL,
      sub_heading VARCHAR(255) NOT NULL,
      view_query_btn VARCHAR(255) NOT NULL,
      cancel_btn_content VARCHAR(255) NOT NULL,
      reply_btn_content VARCHAR(255) NOT NULL,
      created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (id)
      ) $charset;";

  $mail_config_sql = "CREATE TABLE IF NOT EXISTS " . ASKAQUES_MAIL_CONFIG_TABLE . "(
        id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        mail_subject text NOT NULL,
        mail_content text NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
        ) $charset;";

  $query_status_sql = "CREATE TABLE IF NOT EXISTS " . ASKAQUES_QUERY_STATUS_TABLE . "(
        id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        status varchar(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
        ) $charset;";

  $query_form_sql = "CREATE TABLE IF NOT EXISTS " . ASKAQUES_QUERY_FORM_TABLE . "(
        id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        customer_name text NOT NULL,
        customer_email text NOT NULL,
        product_id bigint(20) unsigned NOT NULL,
        user_id bigint(20) unsigned NOT NULL,
        title text NOT NULL,
        description text NOT NULL,
        status bigint(20) unsigned NOT NULL DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        FOREIGN KEY (product_id) REFERENCES $wpdb->posts(ID) ON UPDATE CASCADE ON DELETE CASCADE,
        FOREIGN KEY (user_id) REFERENCES $wpdb->users(ID) ON UPDATE CASCADE ON DELETE CASCADE,
        FOREIGN KEY (status) REFERENCES " . ASKAQUES_QUERY_STATUS_TABLE . "(id)
        ) $charset;";

  $query_reply_sql = "CREATE TABLE IF NOT EXISTS " . ASKAQUES_QUERY_REPLY_TABLE . "(
        id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        query_id bigint(20) unsigned NOT NULL,
        user_id bigint(20) unsigned NOT NULL,
        reply text NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        FOREIGN KEY (query_id) REFERENCES " . ASKAQUES_QUERY_FORM_TABLE . "(id) ON UPDATE CASCADE ON DELETE CASCADE,
        FOREIGN KEY (user_id) REFERENCES $wpdb->users(ID) ON UPDATE CASCADE ON DELETE CASCADE
        ) $charset;";

  $insert_query_status_sql = "INSERT INTO " . ASKAQUES_QUERY_STATUS_TABLE . " (status) values('pending'), ('success');";

  $insert_label_sql = "INSERT INTO " . ASKAQUES_LABEL_CONFIG_TABLE . " (ask_btn_content, name_label, email_label, title_label, submit_btn_content, success_msg_label, field_err_msg, email_validation_msg, description_label, heading, sub_heading, view_query_btn, cancel_btn_content, reply_btn_content) values('Ask Question', 'Name', 'Email', 'Title', 'Submit', 'Query Sent Successfully', 'Required', 'Invalid Email format', 'Description', 'Heading', 'Ask your query related to product', 'View', 'Cancel', 'Reply');";

  $insert_mail_config_label = "INSERT INTO " . ASKAQUES_MAIL_CONFIG_TABLE . " (mail_subject, mail_content) values('Your query has been received', 'Thanks for your query. We will get back to you soon');";

  $admin_email = get_option('admin_email');
  $insert_general_config_label = "INSERT INTO " . ASKAQUES_GENERAL_CONFIG_TABLE . " (email) values('$admin_email');";;

  require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

  dbDelta($general_config_sql);
  dbDelta($label_config_sql);
  dbDelta($mail_config_sql);
  dbDelta($query_status_sql);
  dbDelta($query_form_sql);
  dbDelta($query_reply_sql);

  $query_status_table = ASKAQUES_QUERY_STATUS_TABLE;
  $label_config_table = ASKAQUES_LABEL_CONFIG_TABLE;
  $mail_config_table = ASKAQUES_MAIL_CONFIG_TABLE;
  $general_config_table = ASKAQUES_GENERAL_CONFIG_TABLE;

  if ($wpdb->get_var("select count(*) from $query_status_table") == 0) {
    dbDelta($insert_query_status_sql);
  }
  if ($wpdb->get_var("select count(*) from $label_config_table") == 0) {
    dbDelta($insert_label_sql);
  }
  if ($wpdb->get_var("select count(*) from $mail_config_table") == 0) {
    dbDelta($insert_mail_config_label);
  }
  if ($wpdb->get_var("select count(*) from $general_config_table") == 0) {
    dbDelta($insert_general_config_label);
  }
}
