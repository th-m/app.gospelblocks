<?php
require("../includes/include.php");

$json = file_get_contents('php://input');
$json = json_decode($json, true);
$block = $json['appGlob']['currBlock'];
$id = $json['appGlob']['userId'];


$pin_block_sql = "SELECT id, email, display_name FROM users";

$qry = mysqli_query($link,$pin_block_sql);
$allUsers = json_encode(mysqli_fetch_all($qry,MYSQLI_ASSOC));

$json_reponse = [
  "response" => "success",
  'allUser' => $allUsers,
  'refresh_verses' => "yes",
];

echo json_encode($json_reponse);

?>
