<?php
require("../includes/include.php");

$json = file_get_contents('php://input');
$json = json_decode($json, true);
$verse_id = $json['values']['verse_id'];

foreach ($json['values']['checkboxes'] as $block_id) {

  $last_block =  mysqli_fetch_assoc(mysqli_query($link, "SELECT sequence FROM block_verses WHERE block_id = $block_id ORDER BY sequence DESC LIMIT 1;"));
  $sequence = $last_block['sequence']+1;
  // $qry =  "INSERT INTO block_verses
  //             (id,title,board_id,sequence)
  //             VALUES
  //             (null,$title,$board_id,$sequence)";
  $add_block_verse_sql = "INSERT INTO block_verses
              (id,verse_id,block_id,sequence)
              VALUES
              (null,$verse_id,$block_id,$sequence);";
  mysqli_query($link, $add_block_verse_sql);
}
$alert = 'Wow, You just organized a block of verses';

$json_reponse = [
  "response" => "success",
  'alert' => $alert,
  'modal' => 'close',
];

echo json_encode($json_reponse);

?>
