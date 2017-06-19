<?php
require("../includes/include.php");

$json = file_get_contents('php://input');
$json = json_decode($json, true);
$block = $json['appGlob']['currBlock'];
$id = $json['appGlob']['userId'];
$friends = $json['appGlob']['usersFriends'];

foreach ($friends as $friend_id) {
  $pin_block_sql = "INSERT INTO users_pinned_blocks SET user_id = '$friend_id', block_id = '$block', permission = '0'";

  $qry = mysqli_query($link,$pin_block_sql);
}


$json_reponse = [
  "response" => "success",
  // 'allUser' => $allUsers,
  // 'refresh_verses' => "yes",
];

echo json_encode($json_reponse);

?>
