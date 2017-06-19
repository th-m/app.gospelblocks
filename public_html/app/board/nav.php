<?php
include("../../includes/api_functions.php");
$payload = gb_userBlocks($_POST['user_id'],$_POST['block_id']);
$user_id = $_POST['user_id'];
// print_r($payload);
  foreach ($payload['blocks'] as $block) {
    $title = $block['title'];
    $block_id = $block['id'];
    $description = $block['description'];
    echo "<a href='#' data-user='$user_id' data-block='$block_id' data-description='$description' class='list-group-item block dig'> <h4>$title</h4></a>";
  }
  echo "<a href='#' data-toggle='modal' data-target='#build_block_modal' class='list-group-item active'><i class='fa fa-2x fa-plus clickable' aria-hidden='true'></i></a>";
?>
