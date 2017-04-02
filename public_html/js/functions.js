$(function(){
  console.log('Welcome to Gospel Blocks');
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
    var checkboxes = [];
    var checks = $('#'+$form+'_form input:checkbox:checked').map(function () {
      checkboxes.push($(this).attr('value'));
    }).get();
    values['checkboxes']=checkboxes;
    $clean_form = $form.replace(/\d+/g, '');
    //  console.log($clean_form);
    //  console.log(values);
    //  console.log(checkboxes);
    var url = 'php_scripts/'+$clean_form+'.php';
    // console.log(url);
    // $.ajax({
    //     url: 'php_scripts/'+$clean_form+'.php',
    //     type:'POST',
    //     data:JSON.stringify({values}),
    //     dataType: "json"
    //   }).done(function(data){
    //     var json = $.parseJSON(data);
    //     // if(json.redirect != null){
    //     //     window.location.replace(json.redirect);
    //     // }
    //     // var json = JSON.stringify(eval("(" + data + ")"));
    //     console.log(typeof(json));
    //     console.log('hello');
    //   });
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

// var touchtime = 0;
// $('.dig').on('click', function() {
//     if(touchtime == 0) {
//         //set first click
//         touchtime = new Date().getTime();
//     } else {
//         //compare first click to this click and see if they occurred within double click threshold
//         if(((new Date().getTime())-touchtime) < 800) {
//             //double click occurred
//             alert("double clicked");
//             touchtime = 0;
//         } else {
//             //not a double click so set as a new first click
//             touchtime = new Date().getTime();
//         }
//     }
// });
$(".dig").dblclick(function(event) {
  e.preventDefault();
  // e.preventDefault();
  console.log("clicked");
  // $permission = $(this).attr("data-perm");
  $block = $(this).attr("data-block");
  $user = $(this).attr("data-user");
  $('#app_body').load('app/board/board.php', {"user_id": $user, "block_id": $block}).hide().fadeIn('slow');
});

// $(".dig").dblclick(function(event) {
//   e.preventDefault();
//   // e.preventDefault();
//   console.log("clicked");
//
//   // $permission = $(this).attr("data-perm");
//   $block = $(this).attr("data-block");
//   $user = $(this).attr("data-user");
//   $('#app_body').load('app/board/board.php', {"user_id": $user, "block_id": $block}).hide().fadeIn('slow');

  // Get the params.
  // console.log("clicked")
  // var note_id = $(this).attr("note_id");
  //   console.log(note_id);
  // // var message_id = $(this).attr("message_id");
  // var original_message = $("#note_id_"+note_id).text();
  // console.log(original_message);

  // Message to editable
  // $("#note_id_"+note_id).html("<textarea class=\'textarea\' input_note_id=\'+note_id+\'>" + original_message + "</textarea>");
  // $("#note_id_"+note_id).children().first().focus();

  // $("textarea[input_note_id=\'+note_id+\']").blur(function() {
  //   // Get the new message
  //   var new_note = $("textarea[input_note_id=\'+note_id+\']").val();
  //
  //   // POST to update the message.
  //   $.ajax({
  //     type: "POST",
  //     url: "router/scripts/notes_update.php",
  //     data: JSON.stringify({note_id: note_id, new_note: new_note}),
  //     dataType: "html"
  //   }).done(function(data) {
  //     console.log(data);
  //     // Get the JSON response.
  //     var json = $.parseJSON(data);
  //
  //     if(json.response == "updated"){
  //       // Display the new message;
  //       $("#note_id_"+note_id).text(json.new_note);
  //       // $('#note_id_'+note_id).html("<textarea class='textarea' input_note_id='"+note_id+"'>" + original_message + "</textarea>");
  //
  //     }
  //   });
  // });
// });
// $('.add_to_block').click(function(){
//      $verse_id = $(this).attr("data-verse_id");
//
//       $(".block").each(function(){
//        $a_block_id = $(this).attr("data-block");
//        $a_text = $(this).text();
//       console.log($a_text);
//       console.log($a_block_id);
//     });
//
//     $.contextMenu({
//         selector: '.context-menu-'+$verse_id,
//         trigger: 'left',
//         callback: function(key, options) {
//             var m = "clicked: " + key;
//             window.console && console.log(m) || alert(m);
//         },
//         items: {
//             "edit": {name: "Edit", icon: "edit"},
//             "cut": {name: "Cut", icon: "cut"},
//             "copy": {name: "Copy", icon: "copy"},
//             "paste": {name: "Paste", icon: "paste"},
//             "delete": {name: "Delete", icon: "delete"},
//             "sep1": "---------",
//             "quit": {name: "Quit", icon: function($element, key, item){ return 'context-menu-icon context-menu-icon-quit'; }}
//         }
//     });
//   console.log(<?php echo $_SESSION["bit_id"];?>);
//   console.log(<?php echo $user_id;?>);
//   console.log($verse_id);
//  //  $('#bit_verses').load('php_scripts/add_verse.php', {"bit_id": <?php echo $_SESSION['bit_id'];?>, "user_id": <?php echo $user_id;?>, "verse_id": $verse_id}).hide().fadeIn('slow');
// });
