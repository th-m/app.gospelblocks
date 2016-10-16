$(function(){
  console.log('Welcome to Gospel Blocks');
});
$('.fire_form').on('click',function(event){
// $('.fire_form').click(function(event){
// function fire_form(event){
    event.preventDefault();
    $form = event.target.id
    console.log($form);
    // switch($form) { //Switch case for value of action
    //   case "sign_up": test_function(); break;
    // }
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
     console.log(values);
    //  console.log(checkboxes);
    $.ajax({
        url: 'php_scripts/'+$clean_form+'.php',
        type:'POST',
        data:JSON.stringify({values}),
        dataType: "html"
      }).done(function(data) {
        // Get the JSON response.
        var json = $.parseJSON(data);

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
          if(json.redirect != null){
            window.location.replace(json.redirect);
          }
        }
      });
// }
});
 function fire_form(event){
 }
function myfunction(){
  console.log('hello');
}

$(".note_edit").dblclick(function(event) {
  event.preventDefault();
  // event.preventDefault();
  console.log("clicked");

  // Get the params.
  // console.log("clicked")
  var note_id = $(this).attr("note_id");
    console.log(note_id);
  // var message_id = $(this).attr("message_id");
  var original_message = $("#note_id_"+note_id).text();
  console.log(original_message);

  // Message to editable
  $("#note_id_"+note_id).html("<textarea class=\'textarea\' input_note_id=\'+note_id+\'>" + original_message + "</textarea>");
  $("#note_id_"+note_id).children().first().focus();

  $("textarea[input_note_id=\'+note_id+\']").blur(function() {
    // Get the new message
    var new_note = $("textarea[input_note_id=\'+note_id+\']").val();

    // POST to update the message.
    $.ajax({
      type: "POST",
      url: "router/scripts/notes_update.php",
      data: JSON.stringify({note_id: note_id, new_note: new_note}),
      dataType: "html"
    }).done(function(data) {
      console.log(data);
      // Get the JSON response.
      var json = $.parseJSON(data);

      if(json.response == "updated"){
        // Display the new message;
        $("#note_id_"+note_id).text(json.new_note);
        // $('#note_id_'+note_id).html("<textarea class='textarea' input_note_id='"+note_id+"'>" + original_message + "</textarea>");

      }
    });
  });
});
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
