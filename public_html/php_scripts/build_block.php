<?php

include("../includes/include.php");

$json = file_get_contents('php://input');
$json = json_decode($json, true);
// print_r($json);
$permission_id = $json['values']['permission'];
$board_id = $json['values']['board_id'];


$title = mysqli_real_escape_string($link, $json['values']['title']);
$title = trim($title);
if(empty($title)){
    $alert='Sorry you got to pick a display name';

}
$last_board =  mysqli_fetch_assoc(mysqli_query($link, "SELECT sequence FROM blocks WHERE board_id = $board_id ORDER BY sequence DESC LIMIT 1;"));
$sequence = $last_board['sequence']+1;

if(empty($alert)){
  $qry =  "INSERT INTO blocks
              (id,title,board_id,sequence)
              VALUES
              (null,$title,$board_id,$sequence)";
$add_permission_sql = "INSERT INTO blocks
            (id,title,board_id,sequence)
            VALUES
            (null,'$title',$board_id,$sequence)";
mysqli_query($link,$add_permission_sql);
$alert = 'Congratulations, You created a Block';
//$alert = $qry;
}
$json_reponse = [
  "response" => "success",
  'alert' => $alert,
  'modal' => 'close',
];

echo json_encode($json_reponse);
