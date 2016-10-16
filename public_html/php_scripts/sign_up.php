<?php

include("../includes/include.php");

	// Get JSON Call
	$json = file_get_contents('php://input');
	$json = json_decode($json, true);

	if(!empty($json['values']['email'])){
	$email = mysqli_real_escape_string($link, $json['values']['email']);
	$email = trim($email);
	$email = strtolower($email);
	$users = mysqli_fetch_assoc(mysqli_query($link, "SELECT id, password FROM users WHERE email = '$email';"));
}

// print_r ($json);
if(!empty($email)){
		$alert ='Cmon kid, You need an Email.';
}
	$alert ="";
	if(!empty($users)){
		$alert ='Oops that email already exists! Maybe just try logging in?';
	}
	$password = mysqli_real_escape_string($link, $json['values']['password']);
	$password = trim($password);
	$password = strtolower($password);

	$password_chk = mysqli_real_escape_string($link, $json['values']['password_chk']);
	$password_chk = trim($password_chk);
	if(($password != $password_chk) || empty($password)){
		$alert = 'Hey bud, check your password.';
	}

	$display_name = mysqli_real_escape_string($link, $json['values']['display_name']);
	$display_name = trim($display_name);

	if(empty($display_name)){
			$alert='Sorry you got to pick a display name';
	}
	if(empty($alert)){
 	$password_hash = password_hash($password, PASSWORD_DEFAULT);
	$users = mysqli_fetch_assoc(mysqli_query($link, "SELECT id, password FROM users WHERE email = '$email';"));

  $rem = generateRandomToken();
  $cookie_expire = time()+86400*240; // expires 30 days
	$sql_date = date('Y-m-d 00:00:00', $cookie_expire);
	$user_id = $users['id'];
	$add_user_sql = "INSERT INTO users
							(id,email,display_name,password)
							VALUES
							(null,'$email','$display_name','$password_hash')";
	mysqli_query($link,$add_user_sql);
	$alert = 'hey you just became a Gospel Blocker';
	}

	$json_reponse = [
	  "response" => "success",
		'modal' => "close",
		'alert' => $alert
	];

	echo json_encode($json_reponse);
?>
