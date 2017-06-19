$(function(){
  console.log('Welcome to Gospel Blocks');
  window.oncontextmenu = function(event) {
     event.preventDefault();
     event.stopPropagation();
     return false;
   };
});

$('body').on('submit', '.form_submit' ,function(e){
    e.preventDefault();
    let values = {'div_id':this.id};
    $("#"+values.div_id+" input").each(function(){
      values[this.name] = $(this).val();
    });
    values['checkboxes'] = [];
    var checks = $('#'+this.id+' input:checkbox:checked').map(function () {
      values['checkboxes'].push($(this).attr('value'));
    }).get();
    values[$('#'+this.id+' textarea').attr('name')] = $('#'+this.id+' textarea').val();
    values['appGlobuserId'] = appGlob.userId;
    console.log(values);
    $.ajax({
        url: 'php_scripts/'+values.function+'.php',
        type:'POST',
        data:JSON.stringify({values}),
        dataType: "html"
      }).done(function(data) {
        // Get the JSON response.
        var json = $.parseJSON(data);
        console.log(json);
        if(json.response == "success"){
          frontEndAction(json);
        }
      });
});

function frontEndAction(json){
  if(json.modal == "close"){
      $('#'+json.div_id+'_modal').modal('toggle');
    }
  if(json.alert != null){
      swal(json.alert)
  }
  if(json.load != ""){
      $('#'+json.load).load('app/'+json.load+'.php').hide().fadeIn('slow');
  }
  if(json.refresh_dash != null){
    $('#dashboard').load('app/dashboard/dashboard.php', {"user_id": json.user}).hide().fadeIn('slow');
  }
  if(json.refresh_list != null){
    if(json.refresh_list == "block_id"){
      $('#app_body').load('app/board/board.php', {"user_id": json.user, "block_id": json.refresh_id}).hide().fadeIn('slow');
    }else{
      url = window.location.href;
      window.location.href = url;
    }
  }
  if(json.refresh_verses != null){
    appGlob.loadBlockVerses();
  }
  if(json.redirect != null){
    window.location.replace(json.redirect);
  }
}

$('#app_body').on('click' ,'.user_board' ,function(){
  $permission = $(this).parent().data("perm");
  appGlob.currBlock = $(this).parent().data("block");
  appGlob.history.push(appGlob.currBlock);
  appGlob.loadBoard();
});

$('#app_body').on('dblclick' ,'.dig' ,function(e){
  e.preventDefault();
  $block = $(this).data("block");
  appGlob.currBlock = $(this).data("block");
  appGlob.history.push($block);
  appGlob.loadBoard()
});

$('#app_body').on('click' ,'#dash_btn' ,function(){
  appGlob.history.splice(-1,1);
  appGlob.currBlock = appGlob.history[appGlob.history.length - 1];
  if(appGlob.history.length < 1){
    window.location.reload()
  }else{
    appGlob.loadBoard()
  }
});

$('#app_body').on('click', '.see_book_controller' ,function(){
  $('#book_controller').removeClass('hidden-xs');
  $('#block_controller').addClass('hidden-xs');
});

$('#app_body').on('click', '.see_block_controller' ,function(){
  $('#block_controller').removeClass('hidden-xs');
  $('#book_controller').addClass('hidden-xs');
});

$('#app_body').on('click', '.script_verse' ,function(){
  $block_id = $(this).attr("data-block");
});

$('#app_body').on('click', '#line a' ,function(){
  appGlob.viewBlock = $(this).data('block');
});

$('#app_body').on('click', '.add_to_block' ,function(){
    var new_str = '';
       $(".block").each(function(){
         $a_block_id = $(this).attr("data-block");
         $a_text = $(this).text();
         $a_text = $.trim($a_text)
         new_str = new_str + '<input data-labelauty="'+$a_text+'|Added to '+$a_text+'" type="checkbox" value="'+$a_block_id+'"/>';
     });

     verse_id = $(this).attr("data-verse_id");
     if ($('#add_verse_'+verse_id).length){
      //  console.log(new_str);
       $('#add_verse_'+verse_id).modal('toggle');
     }else{
      //  console.log("string:made");
       var string = `<div id="add_verse_`+verse_id+`" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-body">
                              <p>Some text in the modal.</p>
                              <form id="add_verse_`+verse_id+`_form" class="form_submit" >
                                <input type="hidden" name="function" value="add_verse">
                                <input type="hidden" name="verse_id" value="`+verse_id+`">
                                `+new_str+`
                                <button type="submit" class="btn btn-warning">Add Verse</button>
                              </form>
                            </div>
                          </div>
                        </div>
                     </div>`;
       $('body').append(string);
       $('#add_verse_'+verse_id).modal('toggle');
       $(":checkbox").labelauty();
      //  $.getScript( "js/functions.js" )
     }
});

$('#app_body').on('click', '.delete_verse' ,function(){
  values = appGlob;
  values['block_verse_id'] = $(this).parent().data('verse_id');
  $.ajax({
      url: 'php_scripts/delete_verse.php',
      type:'POST',
      data:JSON.stringify({values}),
      dataType: "html"
    }).done(function(data) {
      // Get the JSON response.
      var json = $.parseJSON(data);
      if(json.response == "success"){
        frontEndAction(json);
      }
    });
});


// TODO this function needs a hairy eyeball.

var sw = 'false';
$('#app_body').on('mousedown', '.block' ,function(){
    appGlob.viewBlock = $(this).data('block');
    appGlob.currBlock = $(this).data('block');
    appGlob.blockTitle = $(this).text();
    appGlob.blockDesc = $(this).data('description')
    clearTimeout(this.downTimer);
    this.downTimer = setTimeout(function() {
    		sw = 'true';
        appGlob.editBlockInfo();
    }, 500);
});

$('#app_body').on('mouseup', '.block' ,function(){
		if(sw == 'false'){
      $('#block_controller').removeClass('hidden-xs');
      $('#book_controller').addClass('hidden-xs');
      appGlob.loadBlockVerses();
    }
    clearTimeout(this.downTimer);
    sw = 'false';
});

var blockLongTouch;
var blockTimer;
var touchduration = 500;

$('#app_body').on('touchstart','.block', function(){
    blockTimer = setTimeout(blockLongTouch, touchduration);
    appGlob.blockTitle = $(this).text();
    appGlob.blockDesc = $(this).data('description')
    appGlob.currBlock = $(this).data('block');
    appGlob.viewBlock = $(this).data('block');
});

$('#app_body').on('touchend','.block', function(){
  if (blockTimer){
  }
  clearTimeout(blockTimer);
});

function blockLongTouch() {
  appGlob.editBlockInfo();
};

$('body').on('click', '.pin_block' ,function(e){
    appGlob.pinBlock();
});
$('body').on('click', '.share_block' ,function(e){
    appGlob.shareBlock();
});

$('#dashboard').on('click','.share_block', function(){
  appGlob.currBlock = $(this).parent().parent().data("block");
});

// TODO: IMPLEMENT CONTROLS ON PERMISSIONS
// TODO: create feedback button at bottom.
// TODO: Look at tooltip plugins.
// TODO: Look at firebase.
// TODO: Look at react.
