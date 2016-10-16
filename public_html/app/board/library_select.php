<?php
require("../../includes/api_functions.php");
   if(empty($_POST)){
     $volumes = gb_volumes();
     $list_opt = $volumes['volumes'];
     $id='id';
     $title='volume_title';
     $selected_title = 'Select a Scripture';

   }
   if(!empty($_POST['volume'])){
          $books = gb_books($_POST['volume']);
          $list_opt = $books['books'];
          $id='id';
          $title='book_title';
          $back='Volumes';
          $selected_title = $books['volume']['title'];
     if(!empty($_POST['book'])){
          $chapters = gb_chapters($_POST['volume'],$_POST['book']);
          $list_opt = $chapters['chapters'];
          $id='chapter';
          $title='chapter';
          $selected_title = $chapters['book']['title'];
          $back = $chapters['volume']['title'];
       if(!empty($_POST['chapter'])){
          //  $verses = gb_verses($vol,$book,$chap)
          //  Do Something Different Here
       }
     }
   }
  echo '<select id="library_select" class="selectpicker" data-live-search="true" >';

  if($title != 'volume_title'){

    echo "<option value='0'>Back To $back</option>";
  }
    echo "<option value='-1' selected>$selected_title</option>";
  foreach ($list_opt as $k => $v) {

    if($title == 'chapter'){
      echo "<option value=".$v[$id].">".$title.' '. $v[$title]."</option>";
    }else{
      echo "<option value=".$v[$id].">".$v[$title]."</option>";
    }
   }

   echo '</select>';
?>

<script type="text/javascript">
  $('#library_select').selectpicker('refresh');
  $( "#library_select" ).change(function() {
    $selector = $( "#library_select" ).val();

    $volume = "<?php echo $_POST['volume'];?>";
    $book = "<?php echo $_POST['book'];?>";
    $chapter= "<?php echo $_POST['chapter'];?>";
    console.log($selector);
    if($selector != 0){
      console.log('changed');


      if($volume != ""){
        if($book != ""){
          if($chapter != ""){

          }else{
            $selector = $( "#library_select" ).val();
            $("#book_verses").load("app/board/script_verses.php", {"volume": $volume, "book": $book, "chapter": $selector});
          }
        }else{
          $("#library_search").load("app/board/library_select.php", {"volume": $volume, "book": $selector});
        }
      }else{
        $("#library_search").load("app/board/library_select.php", {"volume": $selector});
      }
      // $("#library_search").load("app/board/library_select.php", {"volume": $volume, "book": $book, "chapter": $chapter});
    }else{
      if($book != ""){
        $("#library_search").load("app/board/library_select.php", {"volume": $volume});
      }else{
        $("#library_search").load("app/board/library_select.php");
      }
    }
  });
</script>
