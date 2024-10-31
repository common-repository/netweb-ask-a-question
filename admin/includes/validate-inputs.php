<?php 

function askaques_validate_form_input($data, $custom_lables = []) {
  $errors = [];

foreach ($data as $field => $value) {
  
  if(trim(wp_strip_all_tags(str_replace("&nbsp;", " ", $value))) == '' || trim($value) == null ) {
    $errors[] = [$field => $custom_lables['error_msg'] ?? 'Required'];
  } elseif(($field =='email' || $field=='customer_email') && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
    $errors[] = [$field => $custom_lables['email_err_msg'] ?? 'Invalid Email Format'];
  }
}

if (!empty($errors)) {
  wp_send_json(['status' => false,  'errors' => $errors]);
} 
}

?>