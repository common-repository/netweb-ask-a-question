<?php
 if ( ! defined( 'ABSPATH' ) ) exit;
function askaques_enqueue_bootstrap()
{
  wp_enqueue_style('bootstrap-custom', ASKAQUES_PLUGIN_PATH_URL . 'assets/bootstrap_v5/css/bootstrap-v5-min.css', null, '1.0.0');
  wp_enqueue_script('bootstrap-js-custom', ASKAQUES_PLUGIN_PATH_URL . 'assets/bootstrap_v5/js/bootstrap-v5-min.js', null, '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'askaques_enqueue_bootstrap');

global $wpdb;
$label_form_table = ASKAQUES_LABEL_CONFIG_TABLE;
$labels = $wpdb->get_row("select * from $label_form_table");
?>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  <?php echo  esc_html($labels->ask_btn_content) ?>
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?php echo  esc_html($labels->ask_btn_content) ?></h5><br>
      </div>
      <div class="modal-body">
        <p class="modal-title mb-2" id="exampleModalLabel2"><?php echo  esc_html($labels->sub_heading)  ?></p>
        <form class="form-submit" data-form-type='modal'>
          <input type="hidden" name='product_id' value='<?php echo esc_attr(the_ID()); ?>'>
          <input type="hidden" name='user_id' value='<?php echo  esc_attr(get_current_user_id()) ?>'>
          <input type="hidden" name="action" value="askaques_handle_query">
          <div class="form-group">
            <label for="name"><b><?php echo  esc_html($labels->name_label) ?></b></label>
            <input type="text" class="form-control" aria-describedby="nameHelp" placeholder="Enter Your Name" name='customer_name'>
          </div>
          <div class="form-group">
            <label for="name"><b><?php echo  esc_html($labels->email_label)?></b> (You will receive email on this address)</label>
            <input type="text" class="form-control" aria-describedby="emailHelp" placeholder="Enter Your Email" name='customer_email'>
          </div>
          <div class="form-group">
            <label for="name"><b><?php echo  esc_html($labels->title_label)?></b></label>
            <input type="text" class="form-control" aria-describedby="titleHelp" placeholder="Enter Your Title" name='title'>
          </div>
          <div class="form-group mb-3">
            <label for="exampleFormControlTextarea1"><b><?php echo  esc_html($labels->description_label) ?></b></label>
            <textarea class="form-control" rows="3" name='description'></textarea>
          </div>
          <div class="form-group">
            <input type="submit" class="btn btn-primary" value="<?php echo  esc_html($labels->submit_btn_content) ?>">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo  esc_html($labels->cancel_btn_content) ?></button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>
