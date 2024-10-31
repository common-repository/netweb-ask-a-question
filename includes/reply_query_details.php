  <?php 
 if ( ! defined( 'ABSPATH' ) ) exit;
  foreach($replies as $reply): ?>
  <div class="chat-item border rounded p-2 mb-2">
    <div class="fs-6 fw-bold"><?php echo esc_html(($reply->user_id==get_current_user_id()) ? 'You':$reply->user_nicename) ?></div>
    <p class="mb-0"><?php echo esc_html($reply->reply)?></p>
  </div>

<?php endforeach; ?>