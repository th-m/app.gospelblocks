<?php
  include("../../includes/api_functions.php");

  $verses = gb_verses($_POST['volume'],$_POST['book'],$_POST['chapter']);


  foreach ($verses['verses'] as $verse) {
    $scripture=$verse['verse_scripture'];
    $verse_num=$verse['verse'];
    $verse_id=$verse['id'];
    echo "<p class='add_to_block script_verse_$verse_id' data-verse_id='$verse_id'><span>$verse_num. </span>$scripture</p>";
  }

 ?>
 <script type="text/javascript">
 $('.add_to_block').click(function(){
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


 </script>
