<?php

  include("../includes/include.php");

	// Get JSON Call
	$json = file_get_contents('php://input');
	$json = json_decode($json, true);

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

  $slack_message = "*User:* $user_email \n joined your mailing list";
  slack_message($slack_message, "#new-users", "Welcome Email Sent", ":speech_balloon:");

?>
