<div id="app_top_menu" class=""></div>
<div id="app_body" class="">
  <h1 class="text-center">Welcome to Gospel Blocks App</h1>
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
<footer>
  <div class="col-xs-12">
    <form class="form_submit" id="feedback_bar">
      <input type="hidden" name="function" value="feedback">
      <div class="form-group">
        <textarea name="comments" class="form-control" rows="3" cols="80" placeholder="Leave a comment here, and help improve the app."></textarea>
      </div>
      <button type="submit" name="submit" class="btn btn-success">Send Feedback</button>
    </form>
  </div>
</footer>
<script>
  // Global object. Holds controlling data for php scripts and frontend manipulation.
  appGlob = {
    'userId' : "<?=$_SESSION['uid']?>",
    'usersFriends' : [],
    'history' : [],
    'currBlock' : "",
    'viewBlock' : "",
    'blockTitle' : "",
    'blockDesc' : "",
    'sriptureObj': {},
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
                        title:`<i class="fa fa-thumb-tack pin_block" aria-hidden="true"></i> <span style="display:inline-block; width:60px;">&nbsp;</span><i class="fa fa-users share_block" aria-hidden="true"></i>
                              <br/>`,
                        // type: 'info',
                        html: `
                        <div class="form-group">
                          <label class="pull-left" for="update_block_title">Title:</label>
                          <input id="update_block_title" class=" form-control"  style="font-size:30px; width:100%; height:35px; float:left;" value ="`+appGlob.blockTitle+`"><br/>
                        </div>
                        <br/>
                        <div class="form-group">
                          <label class="pull-left" for="update_block_description">Description:</label>
                          <textarea id="update_block_description" class="form-control"  row="5" style="height:100px; width:100%;">`+appGlob.blockDesc+`</textarea>
                        </div>`,
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
    },
    'shareBlock' : function(){
      $.ajax({
          url: 'php_scripts/get_users.php',
          type:'POST',
          data:JSON.stringify({appGlob}),
          dataType: "html"
        }).done(function(data) {
          var json = $.parseJSON(data);
          if(json.response == "success"){
            let userOptions = "";
            let users = $.parseJSON(json.allUser);
            users.forEach(function(user){
              userOptions += `<option value='`+user.id +`' data-subtext="`+user.email+`">`+ user.display_name +`</option>`;
            });
            swal({
              title: '<h2>Select your buds!</h2>',
              html: `<div class="row">
                      <div class="col-xs-12">
                        <select id="user_select" class="selectpicker " multiple="multiple" data-live-search="true">`
                          +userOptions+
                        `</select>
                      </div>
                    </div>`,
              onOpen: function() {
                    $('#user_select').selectpicker('refresh');
                  },
              showCloseButton: true,
              showCancelButton: true,
              confirmButtonText:
                '<i class="fa fa-thumbs-up"></i> Share!',
              cancelButtonText:
                '<i class="fa fa-thumbs-down"></i> Don\'t share? :/'
            }).then(function () {
              appGlob.usersFriends = $('#user_select').val();
              console.log(appGlob);
              $.ajax({
                  url: 'php_scripts/share_block.php',
                  type:'POST',
                  data:JSON.stringify({appGlob}),
                  dataType: "html"
                }).done(function(data) {
                  var json = $.parseJSON(data);
                  console.log(json);
                  if(json.response == "success"){
                    swal(
                      'Wahoo!',
                      'Your shared a block.',
                      'success'
                    )
                  }
                });
            }, function (dismiss) {
              if (dismiss === 'cancel') {  // dismiss can be 'cancel', 'overlay', 'close', and 'timer'
                swal(
                  'Didn\'t Share',
                  'You can always share later. If you want.',
                  'Success'
                )
              }
            });
            // .catch(swal.noop)  use this to dismiss promisses in swal.
          }
        });
    },
    'pinBlock': function(){
      $.ajax({
          url: 'php_scripts/pin_block.php',
          type:'POST',
          data:JSON.stringify({appGlob}),
          dataType: "html"
        }).done(function(data) {
          var json = $.parseJSON(data);
          console.log(json);
          if(json.response == "success"){
            swal(
              'Pinned!',
              'Now your block is viewable on the dashboard :)',
              'success'
            )
          }
        });
    }
  }
  $('#dashboard').load('app/dashboard/dashboard.php', {"user_id": appGlob.userId}).hide().fadeIn('slow');
</script>
