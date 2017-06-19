<?php

  include("../includes/include.php");

	// Get JSON Call
	$json = file_get_contents('php://input');
	$json = json_decode($json, true);
  $message = $json['values']['comments'];
  $id = $json['values']['appGlobuserId'];
  // print_r($json);
  $user_info_sql = "SELECT id, email, display_name FROM users WHERE id = $id";

  $qry = mysqli_query($link,$user_info_sql);
  $user = (mysqli_fetch_all($qry,MYSQLI_ASSOC));
  function slack_message($message, $channel, $username, $emoji) {
  	// Build Message.
  	$data = "payload=" . json_encode(array(
  					"channel"       =>  $channel,
  					"text"          =>  $message,
  					"username"      => 	$username,
  					"icon_emoji"    =>  $emoji
  			));

  	// Sen message CURL.
  	$ch = curl_init("https://hooks.slack.com/services/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");
  	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  	$result = curl_exec($ch);
  	curl_close($ch);
  }

  $sender = $user[0]['email']." (".$user[0]['display_name'].") said,";
  slack_message($message, "#gospel_blocks_ideas", $sender, ":speech_balloon:");


  $json_reponse = [
    "response" => "success",
  ];

  echo json_encode($json_reponse);

?>
