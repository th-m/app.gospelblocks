<?php
require("../includes/include.php");

$json = file_get_contents('php://input');
$json = json_decode($json, true);
$block = $json['appGlob']['currBlock'];
$id = $json['appGlob']['userId'];


$pin_block_sql = "INSERT INTO users_pinned_blocks
            (id,user_id,block_id)
            VALUES
            (null,'$id',$block)";
mysqli_query($link,$pin_block_sql);


$json_reponse = [
  "response" => "success",
  'user' => $json['values']['userId'],
  'refresh_verses' => "yes",
];

echo json_encode($json_reponse);

?>
