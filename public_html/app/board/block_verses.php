<?php
  include("../../includes/api_functions.php");

  // $verses = gb_userBlockVerses($_POST['user_id'],$_POST['board_id'],$_POST['block_id']);
  $verses = gb_userBlockVerses($_POST['user_id'],$_POST['block_id']);
  // print_r($_POST);
  foreach ($verses['block_verses'] as $verse) {
    $scripture=$verse['verse_scripture'];
    $verse_id=$verse['id'];
    $short_title=$verse['verse_title_short'];
    echo "<p class='script_verse' data-verse_id='$verse_id'><span>$short_title </span><span class='delete_verse' style='float:right;'><i class='fa fa-times' aria-hidden='true'></i></span><br/>$scripture</p>";
  }

 ?>
