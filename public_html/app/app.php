<?php

  //$volumes = gb_vols();
  // $books = gb_books();
  // print_r ($volumes);
?>
<div id="app_top_menu" class=""></div>
<div id="app_body" class="">

  <h1 class="text-center">Welcome to Gospel Blocks App</h1>
  <!-- <div class="panel panel-default">
    <div class="panel-heading">Panel Heading</div>
    <div class="panel-body">Panel Content</div>
  </div> -->
  <div id="dashboard" class="">

  </div>
  <div class="row">
      <div class="col-md-10 col-md-offset-1 col-sm-12">
        <div class="panel panel-default">
          <div class="panel-body" data-toggle="modal" data-target="#build_board_modal"><h2 class="text-center">Create a Board <i class="fa fa-plus" aria-hidden="true"></i></h2></div>
        </div>
      </div>
  </div>
  <!-- New Block Up Modal -->
  <div class="modal fade" id="build_board_modal" role="dialog">
    <div class="modal-dialog">
      <!-- New Block Up Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Create A Board</h4>
        </div>
        <div class="modal-body">
          <form id="build_board_form" action="build_board.php" method="post">
            <input type="hidden" name="user" value="<?=$_SESSION['uid']?>">
            <div class="form-group">
              <input type="text" placeholder="Title" name='title' class="form-control">
            </div><br/>
            <div class="form-group">
              <textarea rows="4" cols="50" placeholder="Description" name='description' class="form-control" pattern=".{0}|.{20,}" required></textarea>
            </div><br/>
            <div type="submit" id="build_board" type="submit" class="btn btn-warning fire_form"  onclick="fire_form()">Create Board</div>
          </form>
        </div>
      </div>
    </div>
  </div>

</div>

<script>
  $('#dashboard').load('app/dashboard/dashboard.php', {"user_id": <?=$_SESSION['uid']?>}).hide().fadeIn('slow');
</script>
