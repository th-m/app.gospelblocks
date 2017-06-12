$(function(){
  console.log('Welcome to Gospel Blocks');
});

$('.form_submit').on('submit',function(e){
    e.preventDefault();
    let values = {'div_id':this.id};
    $("#"+values.div_id+" input").each(function(){
      values[this.name] = $(this).val();
    });
    // console.log(values);
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

$('.fire_form').on('click',function(e){
    e.preventDefault();
    $form = e.target.id
    // console.log($form);
    var $inputs = $('#'+$form+'_form :input');
    var values = {};
    $inputs.each(function() {
        values[this.name] = $(this).val();
    });
    console.log(values);
    var checkboxes = [];
    var checks = $('#'+$form+'_form input:checkbox:checked').map(function () {
      checkboxes.push($(this).attr('value'));
    }).get();
    values['checkboxes']=checkboxes;
    $clean_form = $form.replace(/\d+/g, '');
    var url = 'php_scripts/'+$clean_form+'.php';

    $.ajax({
        url: 'php_scripts/'+$clean_form+'.php',
        type:'POST',
        data:JSON.stringify({values}),
        dataType: "html"
      }).done(function(data) {
        // Get the JSON response.
        var json = $.parseJSON(data);
        console.log(json);
        if(json.response == "success"){
          if(json.modal == "close"){
              $('#'+$form+'_modal').modal('toggle');
            }
          if(json.alert != null){
              swal(json.alert)
          }
          if(json.load != ""){
              $('#'+json.load).load('app/'+json.load+'.php').hide().fadeIn('slow');
          }//console.log(json.alert);
          if(json.refresh_dash != null){
            $('#dashboard').load('app/dashboard/dashboard.php', {"user_id": json.user}).hide().fadeIn('slow');
          }
          if(json.refresh_list != null){
            if(json.refresh_list == "block_id"){
              $('#app_body').load('app/board/board.php', {"user_id": json.user, "block_id": json.refresh_id}).hide().fadeIn('slow');
            }else{
              $('#app_body').load('app/board/board.php', {"user_id": json.user, "board_id": json.refresh_id}).hide().fadeIn('slow');
            }
          }
          if(json.redirect != null){
            window.location.replace(json.redirect);
          }
          if(json.addHistory != null){
            appGlob.userId = json.user;
            appGlob.history.push(json.block_id);
          }
        }
      });
// }
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
  }//console.log(json.alert);
  if(json.refresh_dash != null){
    $('#dashboard').load('app/dashboard/dashboard.php', {"user_id": json.user}).hide().fadeIn('slow');
  }
  if(json.refresh_list != null){
    if(json.refresh_list == "block_id"){
      $('#app_body').load('app/board/board.php', {"user_id": json.user, "block_id": json.refresh_id}).hide().fadeIn('slow');
    }else{
      url = window.location.href;
      console.log(url);
      window.location.href = url;
    }
  }
  if(json.refresh_verses != null){
    loadBlockVerses(json.user, json.block);
  }
  if(json.redirect != null){
    window.location.replace(json.redirect);
  }
}

$('#app_body').on('click' ,'.user_board' ,function(){
  $permission = $(this).data("perm");
  $block = $(this).data("block");
  $user = $(this).data("user");
  appGlob.userId = $user;
  appGlob.history.push($block);
  console.log(appGlob);
  $('#app_body').load('app/board/board.php', {"permission": $permission, "user_id": appGlob.userId, "block_id": $block}).hide().fadeIn('slow');
});

$('#app_body').on('dblclick' ,'.dig' ,function(e){
// $(".dig").dblclick(function(e) {
  e.preventDefault();
  // $permission = $(this).attr("data-perm");
  console.log(appGlob);
  $block = $(this).data("block");
  $user = $(this).data("user");

  appGlob.userId = $user;
  appGlob.history.push($block);
  $('#app_body').load('app/board/board.php', {"user_id": $user, "block_id": $block}).hide().fadeIn('slow');
});

$('#app_body').on('click' ,'#dash_btn' ,function(){
  appGlob.history.splice(-1,1);
  if(appGlob.history.length < 1){
    window.location.reload()
  }else{
    $('#app_body').load('app/board/board.php', {"user_id": appGlob.userId, "block_id": appGlob.history[appGlob.history.length - 1]}).hide().fadeIn('slow');
  }
});

$('#app_body').on('click', '.block' ,function(){
  $('#block_controller').removeClass('hidden-xs');
  $('#book_controller').addClass('hidden-xs');
  loadBlockVerses($(this).data("user"), $(this).data("block"));
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
  appGlob.currentBlock = $(this).data('block');
  // console.log($(this).data('block'));
});

$('#app_body').on('click', '.add_to_block' ,function(){
// $('.add_to_block').click(function(){
    var $new_str = '';
       $(".block").each(function(){
         $a_block_id = $(this).attr("data-block");
         $a_text = $(this).text();
         $a_text = $.trim($a_text)
         $new_str = $new_str + '<input name="blocks_list[]" data-labelauty="'+$a_text+'|Added to '+$a_text+'" type="checkbox" value="'+$a_block_id+'"/>';
     });

     $verse_id = $(this).attr("data-verse_id");
     if ($('#add_verse_'+$verse_id).length){
       $('#add_verse_'+$verse_id).modal('toggle');
     }else{
      //  console.log('#add_verse_'+$verse_id); e_'+$verse_id+'
       var string = '<div id="add_verse_'+$verse_id+'" class="modal fade" role="dialog">  <div class="modal-dialog"><div class="modal-content">  <div class="modal-body"><p>Some text in the modal.</p><form id="add_verse'+$verse_id+'_form" action="build_block.php" method="post">  <input type="hidden" name="verse_id" value="'+$verse_id+'">'+$new_str+'  <div type="submit" id="add_verse'+$verse_id+'" type="submit" class="btn btn-warning fire_form">Add Verse</div></form></div></div>  </div> </div>';
       $('body').append(string);
       $('#add_verse_'+$verse_id).modal('toggle');
       $(":checkbox").labelauty();
       $.getScript( "js/functions.js" )

     }
});

$('#app_body').on('click', '.delete_verse' ,function(){
  // console.log($(this).parent().data('verse_id'));
  values = appGlob;
  values['block_verse_id'] = $(this).parent().data('verse_id');
  console.log(values);
  $.ajax({
      url: 'php_scripts/delete_verse.php',
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

function loadBlockVerses(user,block_id){
  $('#block_verses').load('app/board/block_verses.php', {"user_id": user, "block_id": block_id}).hide().fadeIn('slow');
};

function loadBoard(user, block){
  $('#app_body').load('app/board/board.php', {"user_id": json.user, "block_id": json.refresh_id}).hide().fadeIn('slow').then($("#library_search").load("app/board/library_select.php"));

}


// TODO: Consolidate this javascript. Simplify into a few simple functions.
// TODO: Create edit modal for block.
// TODO: Look at tooltip plugins.
// TODO: Look at firebase.
// TODO: Look at react.
