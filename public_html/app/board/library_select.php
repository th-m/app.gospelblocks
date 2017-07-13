<?php
require("../../includes/api_functions.php");

// Regular click views
   if(empty($_POST)){
     $payload = gb_volumes();
     $list_opt = $payload['volumes'];
     $id='id';
     $title='volume_title';
     $selected_title = 'Select a Scripture';
   }
   if(!empty($_POST['volume'])){
          $payload = gb_books($_POST['volume']);
          $list_opt = $payload['books'];
          $id='id';
          $title='book_title';
          $back='Volumes';
          $selected_title = $payload['volume']['title'];
     if(!empty($_POST['book'])){
          $payload = gb_chapters($_POST['volume'],$_POST['book']);
          $list_opt = $payload['chapters'];
          $id='chapter';
          $title='chapter';
          $selected_title = $payload['book']['title'];
          $back = $payload['volume']['title'];
       if(!empty($_POST['chapter'])){
         $payload = gb_verses($_POST['volume'],$_POST['book'],$_POST['chapter']);
         $list_opt = 'verses';
       }
     }
   }
   if(!empty($_POST['search'])){
      $page = 1;
     if(!empty($_POST['page'])){
       $page = $_POST['page'];
     }
     $payload = gb_searchVerses($_POST['search'], $page, $_POST['context']);
     echo "<div><small style='display:inline-block'>Pages</small>";
     echo "<ul style='display:inline-block; padding-left:10px;'>";
     for($x = 1; $x <= $payload["pages_count"]; $x++){
       echo "<small><li class='search_pages clickable' style='display:inline-block' data-result_page='$x'>&nbsp;$x&nbsp;</li></small>";
     }
     echo "</ul>";
     echo "</div><br>";
     foreach ($payload['verses'] as $verse) {
       $scripture=$verse['verse_scripture'];
       $verse_num=$verse['verse'];
       $verse_id=$verse['id'];
       $verse_title=$verse['verse_title'];
       echo "<small>$verse_title</small>";
       echo "<p class='add_to_block script_verse_$verse_id' data-verse_id='$verse_id'><span>$verse_num. </span>$scripture</p>";

     }

    //  echo "<pre>".print_r($payload)."</pre>";
   }




  $data_arr = array('volume' =>  $_POST['volume'], 'book' => $_POST['book'], 'chapter' => $_POST['chapter']);
  $data_str = json_encode($data_arr);
  if($title != 'volume_title'){
    echo '<div id="scripture_bread" class"col-xs-12"><ul>';
            echo "<li class='crumb' data-crumb='volume' data-obj='{}' >Volumes</li>";

            if(!empty($_POST['volume'])){
              echo "<li class='crumb' data-crumb='volume' data-obj=".$data_str." >&nbsp;- ".$payload['volume']['title']."</li>";
            }
            if(!empty($_POST['book'])){
              echo "<li class='crumb' data-crumb='book' data-obj=".$data_str." >&nbsp;- ".$payload['book']['title']."</li>";
            }
            if(!empty($_POST['chapter'])){
              echo "<li class='crumb' data-crumb='chapter' data-obj=".$data_str.">&nbsp;- ".$_POST['chapter']."</li>";
            }
            echo '</ul></div>';
  }
  if($list_opt != 'verses'){
    foreach ($list_opt as $k => $v) {
      if($title == 'chapter'){
        echo "<div class='col-xs-6 library_book' data-obj=".$data_str." data-lid=".$v[$id].">".$title.' '. $v[$title]."</div>";
      }else{
        echo "<div class='col-xs-6 library_book' data-obj=".$data_str." data-lid=".$v[$id].">".$v[$title]."</div>";
      }
   }
 }elseif ($list_opt == 'verses') {
   foreach ($payload['verses'] as $verse) {
     $scripture=$verse['verse_scripture'];
     $verse_num=$verse['verse'];
     $verse_id=$verse['id'];
     echo "<p class='add_to_block script_verse_$verse_id' data-verse_id='$verse_id'><span>$verse_num. </span>$scripture</p>";
   }
 }

?>

<script type="text/javascript">
  var tallest = 0;
  $('.library_book').each(function(){
    console.log(tallest);
    tallest = $( this ).height() > tallest? $( this ).height() : tallest;
  });

  $('.library_book').each(function(){
    $( this ).height(tallest)
    $( this ).prop('line-height', tallest);
  });

</script>
