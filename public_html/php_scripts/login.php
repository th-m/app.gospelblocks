<?php

	include("../includes/include.php");
	// $redirect = "http://gospelblocks.local/"
	$json = file_get_contents('php://input');
	$json = json_decode($json, true);
	// print_r($json);
	$email = mysqli_real_escape_string($link, $json['values']['email']);
	$email = trim($email);
	$email = strtolower($email);
	$password = mysqli_real_escape_string($link, $json['values']['password']);
	$password = trim($password);
	$password = strtolower($password);


	// $password_new = password_hash($password, PASSWORD_DEFAULT);
	$users = mysqli_fetch_assoc(mysqli_query($link, "SELECT id, password FROM users WHERE email = '$email';"));
	if(password_verify($password, $users['password'])) {
		// print_r($users);
		// Create the a 'remember me' token
	  $rem = generateRandomToken();
	  $cookie_expire = time()+86400*240; // expires 30 days
		$sql_date = date('Y-m-d 00:00:00', $cookie_expire);
		$user_id = $users['id'];

		$remember_me_sql = 	"INSERT INTO auth_tokens
								(id,user_id,token,expires)
								VALUES
								(null,$user_id,'$rem','$sql_date')";
		mysqli_query($link,$remember_me_sql);
	  setcookie('token', $rem, $cookie_expire, '/', $_SERVER[HTTP_HOST]);
		$email = 'hit the right area';
		session_start();
		$_SESSION['uid'] = $user_id;
	}

	$json_reponse = [
		"response" => "success",
		"redirect" => "http://$_SERVER[HTTP_HOST]",
		'email' => $email
	];
	 echo json_encode($json_reponse);
?>
