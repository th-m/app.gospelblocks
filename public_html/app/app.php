<?php

  //$volumes = gb_vols();
  // $books = gb_books();
  // print_r ($volumes);
    // print_r ($_SESSION);
?>
<div id="app_top_menu" class=""></div>
<!-- <div id="app_body" class="container"> -->
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
            <button type="submit" class="btn btn-warning">Create block</button>
          </form>
        </div>
      </div>
    </div>
  </div>

</div>

<script>
  appGlob = {
    'userId' : "<?=$_SESSION['uid']?>",
    'history' : [],
    'currBlock' : "",
    'viewBlock' : "",
    'loadBlockVerses' :  function(){
                          $('#block_verses').load('app/board/block_verses.php', {"user_id": this.userId, "block_id": this.viewBlock}).hide().fadeIn('slow');
                        },

    'loadBoard' : function (){
                    $('#app_body').load('app/board/board.php', {"user_id": this.userId, "block_id": this.currBlock}, function(){
                      appGlob.loadNav();
                    });
                  },
    'loadNav' : function (){
                  $('#line').load('app/board/nav.php ', {'user_id':this.userId, 'block_id': this.currBlock});
                },
    'editBlockInfo' : function(){
                  swal({
                        title:`<br/><textarea id="update_block_title" style="font-size:30px; width:100%; height:35px; float:left;">`+appGlob.blockTitle+`</textarea><br/>`,
                        // type: 'info',
                        html: `<textarea id="update_block_description" style="float:left; height:100px; width:100%;">`+appGlob.blockDesc+`</textarea>`,
                        showCloseButton: true,
                        showCancelButton: true,
                        confirmButtonText:
                          '<i class="fa fa-thumbs-up"></i> Update the Block!',
                        cancelButtonText:
                          '<i class="fa fa-thumbs-down"></i> Delete This Block'
                  }).then(function () {
                    let blockTitle = $("#update_block_title").val();
                    let blockDescription = $("#update_block_description").val();
                    let values = {};
                    values['table'] = 'blocks';
                    values['id'] = appGlob.currBlock;
                    values['fields'] = {"title":blockTitle, "description":blockDescription};
                    $.ajax({
                        url: 'php_scripts/update.php',
                        type:'POST',
                        data:JSON.stringify({values}),
                        dataType: "html"
                      }).done(function(data) {
                        var json = $.parseJSON(data);
                        console.log(json);
                        if(json.response == "success"){
                          $('#line').load('app/board/nav.php', {'user_id':appGlob['userId'], 'block_id': appGlob.history[appGlob.history.length - 1]});
                          swal(
                            'Updated!',
                            'Your block has been updated.',
                            'success'
                          )
                        }
                      });
                  }, function (dismiss) {
                    if (dismiss === 'cancel') {  // dismiss can be 'cancel', 'overlay', 'close', and 'timer'
                      swal(
                        'Deleted',
                        'Your block is in a better place now );',
                        'error'
                      )
                    }
                  });
    }
  }
  $('#dashboard').load('app/dashboard/dashboard.php', {"user_id": appGlob.userId}).hide().fadeIn('slow');
</script>
