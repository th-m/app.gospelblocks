<?php

include("../includes/include.php");

$json = file_get_contents('php://input');
$json = json_decode($json, true);
// print_r($json);
// $permission_id = $json['values']['permission'];
$user_id = $json['values']['user_id'];
$board_id = $json['values']['board_id'];
if(!empty($json['values']['block_id'])){
  $sub_block = true;
  $block_id = $json['values']['block_id'];
  // print_r($json);
}


$title = mysqli_real_escape_string($link, $json['values']['title']);
$title = trim($title);
if(empty($json['values']['title'])){
    $alert='Sorry you got to got to pick a display name';
}
if($sub_block){
  $last_board =  mysqli_fetch_assoc(mysqli_query($link, "SELECT sequence FROM blocks WHERE parent_id = $block_id ORDER BY sequence DESC LIMIT 1;"));
}else{
  $last_board =  mysqli_fetch_assoc(mysqli_query($link, "SELECT sequence FROM blocks WHERE board_id = $board_id ORDER BY sequence DESC LIMIT 1;"));
}

$sequence = $last_board['sequence']+1;

if(empty($alert)){
  if($sub_block){
    $add_subblock_sql = "INSERT INTO blocks
                (id,title,parent_id,sequence)
                VALUES
                (null,'$title',$block_id,$sequence)";
    mysqli_query($link,$add_subblock_sql);
    $alert = 'Congratulations, You created a SubBlock';
  }else{
    // $qry =  "INSERT INTO blocks
    //             (id,title,board_id,sequence)
    //             VALUES
    //             (null,$title,$board_id,$sequence)";

  $add_block_sql = "INSERT INTO blocks
              (id,title,board_id,sequence)
              VALUES
              (null,'$title',$board_id,$sequence)";
  mysqli_query($link,$add_block_sql);
  $alert = 'Congratulations, You created a Block';
  }//$alert = $qry;
}
if($sub_block){
  $refresh_list = "block_id";
  $refresh_id = $block_id;
}else{
  $refresh_list = "board_id";
  $refresh_id = $board_id;
}
$json_reponse = [
  "response" => "success",
  'alert' => $alert,
  'modal' => 'close',
  'refresh_list' => $refresh_list,
  'refresh_id' => $refresh_id,
  'user' => $user_id,
];

echo json_encode($json_reponse);
