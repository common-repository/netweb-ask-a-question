<?php
/*
Template Name: Enquiry
*/
if ( ! defined( 'ABSPATH' ) ) exit;

if (!wp_is_block_theme()) {
  get_header();
} elseif (is_page('netweb-ask-question-enquiry')) {
  block_header_area();
  wp_head();
}
global $wpdb;
$label_config_table = ASKAQUES_LABEL_CONFIG_TABLE;
$label_reply_btn = $wpdb->get_var("select reply_btn_content from $label_config_table");

?>
<div class="container-fluid">
  <div class="custom-loader" style="display: none;">
    <div class="askques_loader"></div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <h5 class="text-center">Your Queries</h5>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="asked-ques">
        <?php include_once ASKAQUES_PLUGIN_ABS_PATH . 'paginate.php';
        askaques_custom_paginate(); ?>
      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="queryViewModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="queryViewModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="queryViewModalLabel">Query Details</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="queryWrapper mb-3">
          <div class="fs-5 mb-3">Basic Details</div>
          <div class="table-responsive">
            <table class="table table-bordered">
              <tr>
                <th>Query ID -</th>
                <td id="query_id"></td>
              </tr>
              <tr>
                <th>Customer Name -</th>
                <td id="customer"></td>
              </tr>
              <tr>
                <th>Query Title</th>
                <td id="title"></td>
              </tr>
            </table>
          </div>
        </div>
        <div class="queryWrapper">
          <div class="fs-5 mb-3">Whole Conversation</div>
          <div class="query-description border rounded p-2 mt-1 mb-2"></div>
          <div class="wholeChat">

          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-start">
        <form class="form-submit" data-form-type="modal">
          <input type="hidden" name='query_id'>
          <input type="hidden" name='action' value="askaques_handle_query_reply">
          <textarea placeholder="Write Some Text...." class="form-control mb-2" cols='80' name='reply'></textarea>
          <input type="submit" class="btn btn-primary" value="<?php echo esc_attr($label_reply_btn ?? 'Reply') ?>">
        </form>
      </div>
    </div>
  </div>
</div>

<?php if (!wp_is_block_theme()) {
  get_footer();
} elseif (is_page('netweb-ask-question-enquiry')) {
  block_footer_area();
  wp_footer();
}
?>