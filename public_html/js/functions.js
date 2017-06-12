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
  if(json.redirect != null){
    window.location.replace(json.redirect);
  }
}

$(".dig").dblclick(function(e) {
  e.preventDefault();
  // e.preventDefault();
  console.log("clicked");
  // $permission = $(this).attr("data-perm");
  $block = $(this).attr("data-block");
  $user = $(this).attr("data-user");
  $('#app_body').load('app/board/board.php', {"user_id": $user, "block_id": $block}).hide().fadeIn('slow');
});
