<?php

include("../includes/include.php");

$json = file_get_contents('php://input');
$json = json_decode($json, true);
// print_r($json);
// $permission_id = $json['values']['permission'];
$user_id = $json['values']['user_id'];
// $board_id = $json['values']['board_id'];
if(!empty($json['values']['block_id'])){
  $sub_block = true;
  $block_id = $json['values']['block_id'];
  // print_r($json);
}


$title = mysqli_real_escape_string($link, $json['values']['title']);
$title = trim($title);


if(empty($json['values']['title']) && !empty($json['values']['fromDashboard'])){
  $alert='Sorry you got to got to pick a display name';

  $json_response = [
    "response" => "success",
    'alert' => $alert,
    'modal' => 'close',
    'user' => $user_id,
    'div_id' => $json['values']['div_id'],
  ];

  echo json_encode($json_response);
  return false;
}
if(empty($json['values']['title'])){
  $alert='Sorry you got to got to pick a display name';
}
if($sub_block){
  $last_board =  mysqli_fetch_assoc(mysqli_query($link, "SELECT sequence FROM blocks WHERE parent_id = $block_id ORDER BY sequence DESC LIMIT 1;"));
}else{
  $block_id = "";
  $last_board['sequence'] = 0;
}

$sequence = $last_board['sequence']+1;

if(empty($alert)){
  if($sub_block){
    $add_subblock_sql = "INSERT INTO blocks
                (id,title,parent_id,sequence,created ,updated)
                VALUES
                (null,'$title',$block_id,$sequence, NOW(), NOW())";
    mysqli_query($link,$add_subblock_sql);
  }else{
  $add_block_sql = "INSERT INTO blocks
              (id,title,sequence,created,updated)
              VALUES
              (null,'$title',$sequence, NOW(), NOW())";
  mysqli_query($link,$add_block_sql);

  $last_id = mysqli_fetch_assoc(mysqli_query($link,"SELECT id FROM blocks ORDER BY id DESC LIMIT 1;"));
  $last_id = $last_id['id'];
  $pin_block_sql = "INSERT INTO users_pinned_blocks
              (id,user_id,block_id)
              VALUES
              (null,'$user_id',$last_id)";
  mysqli_query($link,$pin_block_sql);
  }//$alert = $qry;
  // $alert = 'Congratulations, You created a Block';
}
if($sub_block){
    $json_response['refresh_list'] = "block_id";
    $json_response['refresh_id'] = $block_id;
}else{
    $json_response['refresh_list'] =  "dashboard";
}

if(isset($json['values']['div_id'])){
  $json_response['div_id'] = $json['values']['div_id'];
}

$json_response["response"] = "success";
$json_response["addHistory"] = "yes";
$json_response["block_id"] = $last_id;
$json_response['modal'] = 'close';
$json_response['user'] = $user_id;
$json_response['json'] = $json;


echo json_encode($json_response);
