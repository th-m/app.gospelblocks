<?php

  //$volumes = gb_vols();
  // $books = gb_books();
  // print_r ($volumes);
    // print_r ($_SESSION);
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
          <div class="panel-body" data-toggle="modal" data-target="#build_pinned_block_modal"><h2 class="text-center">Create a Block <i class="fa fa-plus" aria-hidden="true"></i></h2></div>
        </div>
      </div>
  </div>
  <!-- New Block Up Modal -->
  <div class="modal fade" id="build_pinned_block_modal" role="dialog">
    <div class="modal-dialog">
      <!-- New Block Up Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Create A Block</h4>
        </div>
        <div class="modal-body">
          <form id="build_pinned_block" class="form_submit">
            <input type="hidden" name="user_id" value="<?=$_SESSION['uid']?>">
            <input type="hidden" name="function" value="build_block">
            <input type="hidden" name="fromDashboard" value="yup">
            <input type="hidden" name="pinned" value="1">
            <div class="form-group">
              <input type="text" placeholder="Title" name='title' class="form-control">
            </div><br/>
            <div class="form-group">
              <textarea rows="4" cols="50" placeholder="Description" name='description' class="form-control" pattern=".{0}|.{20,}" required></textarea>
            </div><br/>
            <button type="submit" type="submit" class="btn btn-warning">Create block</button>
          </form>
        </div>
      </div>
    </div>
  </div>

</div>

<script>
  $('#dashboard').load('app/dashboard/dashboard.php', {"user_id": <?=$_SESSION['uid']?>}).hide().fadeIn('slow');
</script>
