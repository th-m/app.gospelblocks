<?php
  //  print_r($_POST);
  //  print_r($_SESSION);

   include("../../includes/api_functions.php");
   if (!empty($_POST['block_id'])){
     $user_board = gb_userBlockBlocks($_POST['user_id'],$_POST['block_id']);
   }else{
     $user_board = gb_userBoardBlocks($_POST['user_id'],$_POST['board_id']);
   }
   $title = $user_board['board_info']['title'];
   $user_id = $_POST['user_id'];
   $board_id = $_POST['board_id'];
 ?>
<div class="row">

</div>
<div class="row">
  <div class="col-xs-12" style="height:5px;">
    <i id="dash_btn" class="fa-2x fa fa-caret-square-o-left clickable" style="padding:10px 0px 0px 10px;"aria-hidden="true"></i>
  </div>
  <h2 class='text-center'><?php echo $title;?></h2>
  <div class="row" style="padding-top:15px">
      <div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 text-center">
          <div id="line" class="list-group list-group-horizontal">
            <?php
              foreach ($user_board['users_blocks'] as $block) {
                $title = $block['title'];
                $block_id = $block['id'];
                echo "<a href='#' data-user='$user_id' data-block='$block_id' class='list-group-item block dig'>$title</a>";

              }
            ?>
              <a href="#" data-toggle="modal" data-target="#build_block_modal" class="list-group-item active"><i class="fa fa-plus clickable" aria-hidden="true"></i></a>
          </div>
      </div>
	</div>

  <div id="book_controller"  class="col-xs-12 col-sm-6">
    <div class='panel panel-default' >
      <div class='panel-heading'><span class="pull-right hidden-sm visible-xs see_block_controller"><i class="fa fa-cube fa-2x clickable" aria-hidden="true"></i></span><h4 class='text-center'>Scriptures<h4> </div>
      <div id="book_verses" class='panel-body'>verses go here</div>
      <div class="panel-footer">
        <div id="library_search" class="">
        </div>
        <div id="advanced_picker" class="">
        </div>
      </div>
    </div>
  </div>
  <div id="block_controller" class="col-xs-12 hidden-xs col-sm-6">
    <div class='panel panel-default' >
      <div class='panel-heading'><span class="pull-left hidden-sm visible-xs see_book_controller"><i class="fa fa-book fa-2x clickable" aria-hidden="true"></i></span><h4 id="block_title" class='text-center'>Panel title<h4></div>
      <div id="block_verses" class='panel-body'>block verses</div>
      <div class="panel-footer">
        <div id="scripture_adder" class="">
        </div>
        <div id="highliter" class="">
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="build_block_modal" role="dialog">
  <div class="modal-dialog">
    <!-- New block Up Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Create Bit</h4>
      </div>
      <div class="modal-body">
        <form id="build_block_form" action="build_block.php" method="post">
          <input type="hidden" name="permission" value="<?=$_POST['permission']?>">
          <input type="hidden" name="block_id" value="<?=$_POST['block_id']?>">
          <input type="hidden" name="board_id" value="<?=$_POST['board_id']?>">
          <input type="hidden" name="user_id" value="<?=$_POST['user_id']?>">
          <div class="form-group">
            <input type="text" placeholder="Title" name='title' class="form-control">
          </div><br/>
          <div type="submit" id="build_block" type="submit" class="btn btn-warning fire_form" onclick="fire_form()" >Create block</div>
        </form>
      </div>
    </div>
  </div>
</div>

<div id="app_footer" class="">
  <script src="js/functions.js"></script>

  <script>
  $("#library_search").load("app/board/library_select.php");

    $('.block').click(function(){
      $('#block_controller').removeClass('hidden-xs');
      $('#book_controller').addClass('hidden-xs');
      $block_id = $(this).attr("data-block");
      // $('#block_verses').load('app/board/block_verses.php', {"user_id": <?php echo $user_id;?>, "board_id": <?php echo $board_id;?>, "block_id": $block_id}).hide().fadeIn('slow');
      $('#block_verses').load('app/board/block_verses.php', {"user_id": <?php echo $user_id;?>, "block_id": $block_id}).hide().fadeIn('slow');
    });
    $('.see_book_controller').click(function(){
      $('#book_controller').removeClass('hidden-xs');
      $('#block_controller').addClass('hidden-xs');
    });
    $('.see_block_controller').click(function(){
      $('#block_controller').removeClass('hidden-xs');
      $('#book_controller').addClass('hidden-xs');
    });
    $('#dash_btn').click(function(){
       window.location.href = "https://gospelblocks.com/";
    });

  </script>
</div>
