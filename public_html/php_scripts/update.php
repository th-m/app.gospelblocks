<?php
require("../includes/include.php");

$json = file_get_contents('php://input');
$json = json_decode($json, true);
$id = $json['values']['id'];
$table = $json['values']['table'];
$fields = $json['values']['fields'];
$title = $fields['title'];
$description = $fields['description'];

$sql = "UPDATE blocks SET title = '$title', description = '$description' WHERE id = $id";
mysqli_query($link,$sql);
// $alert = 'Wow, You just organized a block of verses';

$json_reponse = [
  "response" => "success",
];

echo json_encode($json_reponse);

?>
