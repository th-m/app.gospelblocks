<?php
require("../includes/include.php");

$json = file_get_contents('php://input');
$json = json_decode($json, true);
$block_verse_id = $json['values']['block_verse_id'];

$sql = "DELETE FROM block_verses WHERE id = $block_verse_id";
mysqli_query($link,$sql);
$alert = 'Wow, You just organized a block of verses';

$json_reponse = [
  "response" => "success",
  'refresh_verses' => "yes",
];

echo json_encode($json_reponse);

?>
