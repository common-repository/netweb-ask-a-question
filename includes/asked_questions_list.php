<?php
 if ( ! defined( 'ABSPATH' ) ) exit;
$output = '';
if($ques_type == 'new_ques') {
  $output = '<h6>New Asked Queries</h6>';
} else {
  $output = '<h6>All Asked Queries</h6>';
}
$output .= '<table class="table table-bordered">
<thead>
    <tr>
        <th scope="col">ID</th>
        <th scope="col">Product ID</th>
        <th scope="col">Product Name</th>
        <th scope="col">Query Title</th>
        <th scope="col">Description</th>
        <th scope="col">Date And Time</th>
        <th scope="col">Status</th>
        <th scope="col">Action</th>
    </tr>
</thead>
<tbody>';

if (!empty($queries)) :
    foreach ($queries as $query) : 
    $output .= '<tr>
    <th scope="row">' . esc_html($query->id) . '</th>
    <td>' . esc_html($query->product_id) . '</td>
    <td>' . esc_html($query->post_title) . '</td>
    <td>' . esc_html($query->title) . '</td>
    <td>' . esc_html((strlen($query->description)) > 10 ? esc_html(substr($query->description, 0, 10)) . "..." : esc_html($query->description)) . '</td>
    <td>' . $query->created_at . '</td>
    <td><span class="' . ($query->status == "success" ? "bg-success" : "bg-warning") . ' text-light py-1 px-2">' . esc_html($query->status) . '</span></td>
    <td><button class="btn btn-sm btn-primary askaques_queries" data-query-id="' . esc_html($query->id) . '" onclick="query_view(this)">' . (esc_html($label_config->view_query_btn) ?? "view") . '</button></td>
</tr>';
    ?>
     
  <?php endforeach; ?>

<?php else : 
  $output .= ' <tr>
    <td colspan="8">
      <div class="border shadow-sm my-3 p-4 text-danger text-center">Sorry ! No Data Found</div>
    </td>
  </tr>
'
  ?>
 
<?php endif;
$output .= '</tbody>
</table>';

$output .= '<nav><ul class="pagination pagination-sm">';

$outOfRange = false;
for ($i = 1; $i <= $total_pages; $i++) {
    if ($i <= 2 || $i >= $total_pages - 2 || abs($i - $page_number) <= 2) {
        $outOfRange = false;
        $output .= '<li class="page-item paginate ' . ($i == $page_number ? "active" : "") . '" data-page-no="' . $i . '" data-ques-type="' . $ques_type . '">';
        $output .= '<a class="page-link" href="#">' . $i . '</a>';
        $output .= '</li>';
    } else {
        if (!$outOfRange) {
            $output .= '...';
        }
        $outOfRange = true;
    }
}

$output .= '</ul>
</nav>';
echo wp_kses_post ($output);
?>

