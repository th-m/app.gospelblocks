<?php

  include("../../includes/api_functions.php");
  $payload = gb_userBlocks($_POST['user_id'],$_POST['block_id']);
   $title = $payload['info']['title'];
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
      <div class="col-xs-12 col-md-8 col-md-offset-2 text-center">
          <div id="line" class="list-group list-group-horizontal">
          </div>
      </div>
	</div>

  <div id="book_controller"  class="col-xs-12 col-sm-6 no_pad">
    <div class='panel panel-default' >
      <div class='panel-heading'><span class="pull-right hidden-sm visible-xs see_block_controller"><i class="fa fa-cube fa-2x clickable" aria-hidden="true"></i></span><h4 class='text-center'>Scriptures<h4> </div>
      <div id="book_verses" class='panel-body'>verses go here</div>
      <div class="panel-footer">
        <div id="library_search" class="row">
          <form id="library_search_form">
            <span class="form-group col-xs-10">
              <input id="search_string" type="text" placeholder="Use `&&` and `||` for advanced searches" name='title' class="form-control">
            </span>
            <button type="submit" class="btn btn-danger col-xs-2">search</button>
            <button type="button" class="btn btn-warning col-xs-2">clear search</button>
          </form>
        </div>
        <div id="advanced_picker" class="">
        </div>
      </div>
    </div>
  </div>

  <div id="block_controller" class="col-xs-12 hidden-xs col-sm-6 no_pad">
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
        <form id="build_block" class="form_submit" data-user="<?=$_POST['user_id']?>">
          <input type="hidden" name="function" value="build_block">
          <input type="hidden" name="permission" value="<?=$_POST['permission']?>">
          <input type="hidden" name="block_id" value="<?=$_POST['block_id']?>">
          <input type="hidden" name="user_id" value="<?=$_POST['user_id']?>">
          <div class="form-group">
            <input type="text" placeholder="Title" name='title' class="form-control">
          </div><br/>
          <button type="submit" type="submit" class="btn btn-warning">Create block</button>
        </form>
      </div>
    </div>
  </div>
</div>


  <script>
    $("#book_verses").load("app/board/library_select.php");
  </script>
