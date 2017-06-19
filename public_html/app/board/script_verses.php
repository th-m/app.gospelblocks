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
 
