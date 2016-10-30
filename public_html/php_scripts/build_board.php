<?php

include("../includes/include.php");

$json = file_get_contents('php://input');
$json = json_decode($json, true);
// print_r($json);
$user_id = $json['values']['user'];
$time = date('Y-m-d h:i:s');
$title = mysqli_real_escape_string($link, $json['values']['title']);
$title = trim($title);

if(empty($title)){
    $alert='Sorry you got to pick a display name';
}

$description = mysqli_real_escape_string($link, $json['values']['description']);
$description = trim($description);

if(empty($alert)){
  $add_board_sql = "INSERT INTO boards
              (id,title,description,created)
              VALUES
              (null,'$title','$description','$time')";
  mysqli_query($link,$add_board_sql);
  // $qry="SELECT id FROM board WHERE created = '$time';";
  // echo $qry;
  $board = mysqli_fetch_assoc(mysqli_query($link, "SELECT id FROM boards WHERE created = '$time';"));

  $board_id = $board['id'];

  $add_permission_sql = "INSERT INTO users_boards
              (id,user_id,board_id,permission)
              VALUES
              (null,$user_id,$board_id,1)";
  mysqli_query($link,$add_permission_sql);

  $alert = 'Congratulations, You created a board';
}
$json_reponse = [
  "response" => "success",
  'alert' => 'Congratulations. You created a Block',
  'modal' => 'close',
  'load' => 'boards_dsh',
  'refresh_dash' => "refresh",
  'user' => $user_id,
];

echo json_encode($json_reponse);
?>
