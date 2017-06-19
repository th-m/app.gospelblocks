<?php
  include("../../includes/api_functions.php");
  $payload = gb_usersPinnedBlocks($_POST['user_id']);
  $user_id = $_POST['user_id'];
  // print_r($_SESSION);

  // echo $user_id;
  // echo 'test';
  // print_r ($payload);
  foreach ($payload['pinned_blocks'] as $k => $v) {
    $title = $v['block_info']['title'];
    $description = $v['block_info']['description'];
    $permission = $v['permission'];
    $block_id = $v['block_id'];
    echo "
    <div class='row'>
        <div class='col-md-10 col-md-offset-1 col-sm-12 no_pad'>
          <div class='panel panel-default user_board'  data-perm='$permission' data-block='$block_id' data-user='$user_id'>
            <div class='panel-heading'><h2 class='text-center'>$title<h2></div>
            <div class='panel-body'><h4>$description</h4></div>
          </div>
        </div>
    </div>";
   }
?>
