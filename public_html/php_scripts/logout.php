<?php

	include("../includes/include.php");
	// $redirect = "http://gospelblocks.local/"
	$json = file_get_contents('php://input');
	$json = json_decode($json, true);

	unset($_SESSION["uid"]);
	setcookie("token", "", time() - 3600);

	$json_reponse = [
		"response" => "success",
		"redirect" => "http://$_SERVER[HTTP_HOST]",
		'email' => $email
	];
	 echo json_encode($json_reponse);
?>
