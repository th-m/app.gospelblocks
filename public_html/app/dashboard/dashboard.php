<?php
  include("../../includes/api_functions.php");
  $users_boards = gb_usersBoards($_POST['user_id']);
  $user_id = $_POST['user_id'];

  echo $user_id;
  echo 'test';
  // print_r ($users_boards);
  foreach ($users_boards['users_boards'] as $k => $v) {
    $title = $v['board_info']['title'];
    $description = $v['board_info']['description'];
    $permission = $v['permission'];
    $board_id = $v['board_id'];
    echo "
    <div class='row'>
        <div class='col-md-10 col-md-offset-1 col-sm-12'>
          <div class='panel panel-default user_board'  data-perm='$permission' data-board='$board_id'>
            <div class='panel-heading'><h2 class='text-center'>$title<h2></div>
            <div class='panel-body'><h4>$description</h4></div>
          </div>
        </div>
    </div>";
   }
?>

<script type="text/javascript">
  $('.user_board').click(function(){
    $permission = $(this).attr("data-perm");
    $board = $(this).attr("data-board");
    $('#app_body').load('app/board/board.php', {"permission": $permission, "user_id": <?php echo $user_id;?>, "board_id": $board}).hide().fadeIn('slow');
  });
</script>
