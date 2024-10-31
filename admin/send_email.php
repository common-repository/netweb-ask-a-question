<?php
 if ( ! defined( 'ABSPATH' ) ) exit;
function askaques_send_email_to_admin($data) {
    global $wpdb;
    $general_config_table = ASKAQUES_GENERAL_CONFIG_TABLE;
    $to = $wpdb->get_var($wpdb->prepare("select email from $general_config_table where id = %d",1));
    $subject = 'You have new product query';
    $body = 'Name: ' . $data['customer_name'] . '<br>' . 
    ' Email: ' .$data['customer_email'] . '<br>'. 
    ' Query Title: ' .$data['title'] . '<br>' .
    ' Query ID: ' .$data['query_id'];
    $headers = array('Content-Type: text/html; charset=UTF-8');
    wp_mail($to, $subject, $body, $headers);
}

function askaques_send_email_to_customer($data) {
    global $wpdb;
    $mail_config_table = ASKAQUES_MAIL_CONFIG_TABLE;
    $email_template = $wpdb->get_row("select * from $mail_config_table");

    $product = get_post($data['product_id']);
    $product_link = get_permalink($product->ID);
    $to = $data['customer_email'];
    $subject = $email_template->mail_subject;
    $body = $email_template->mail_content . '<br>Product Name: '.$product->post_title . '<br>'.'Product Link: '.$product_link .'<br>'.'Your Query Number: '.$data['query_id'] . '. <a href="' . site_url() . '/netweb-ask-question-enquiry">View Queries</a><br>';
    $headers = array('Content-Type: text/html; charset=UTF-8');
    wp_mail($to, $subject, $body, $headers);
}

function askaques_send_email_after_reply($data) {
    global $wpdb;
    $query_form_table = ASKAQUES_QUERY_FORM_TABLE;
    $general_config_table = ASKAQUES_GENERAL_CONFIG_TABLE;
    $query_data = $wpdb->get_row($wpdb->prepare("select * from $query_form_table where id=%d", $data['query_id']));
    $to = $query_data->customer_email;
    $subject = 'Your Query has new reply';
    $body = 'Hi ' . $query_data->customer_name . '<br>Your Query ID number ' . $data['query_id'] . ' has been answered. <a href="' . site_url() . '/netweb-ask-question-enquiry">View Queries</a><br>' .
        'Reply from Admin: ' . $data['reply'];

    if(!current_user_can('manage_options')) {
        $to = $wpdb->get_var("select email from $general_config_table") ?? get_option('admin_email');
        $body = 'Hi admin <br> You have new reply for Query ID ' .$data['query_id'] . '<br>' . 'Reply from customer: ' . $data['reply'];
    }
    $headers = array('Content-Type: text/html; charset=UTF-8');
    wp_mail($to, $subject, $body, $headers);
}

function askaques_send_test_mail() {
    if(!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'] ?? null)), 'askaques_secure_data')) {
        wp_send_json(['status' => false, 'message' => 'Your session has expired or is invalid. Please refresh the page and try again']);
      }
    global $wpdb;
    $general_config_table = ASKAQUES_GENERAL_CONFIG_TABLE;
    $mail_config_table = ASKAQUES_MAIL_CONFIG_TABLE;

    $mail_data = $wpdb->get_row("select * from $mail_config_table");
  
    $admin_email = $wpdb->get_var("select email from $general_config_table") ?? get_option('admin_email');
    $to = $admin_email;
    $subject = $mail_data->mail_subject;
    $body = $mail_data->mail_content;
    $headers = array('Content-Type: text/html; charset=UTF-8');
    $status = wp_mail($to, $subject, $body, $headers);
    ($status) ? wp_send_json(['status' => true, 'message'=>'Test mail sent']) : wp_send_json(['status' => false, 'message'=>'Test mail failed']);

  }

add_action('wp_ajax_askaques_send_test_mail', 'askaques_send_test_mail');
add_action('askaques_send_email_after_query', 'askaques_send_email_to_admin');
add_action('askaques_send_email_after_query', 'askaques_send_email_to_customer');
add_action('askaques_send_email_after_reply', 'askaques_send_email_after_reply');
?>