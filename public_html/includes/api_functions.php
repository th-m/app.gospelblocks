<?php
//
// Gospel Blocks PHP Helper Library
// Created by Thom Valadez
//

// Gospel Blocks API URL
$ApiUrl = "http://api.gospelblocks.com/v1/"; // The Gospel Blocks API URL

// Main Gospel Blocks API Call Function
Function gbCall($gbRoute) {
	// JSON Headers
	$chHeaders[] = "Content-Type: application/json;charset=utf-8";

	// Call the API
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $GLOBALS['ApiUrl'] . $gbRoute);
	curl_setopt($ch, CURLOPT_HTTPGET, TRUE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $chHeaders);

	// Get the response
	$response = curl_exec($ch);

	// Close cURL connection
	curl_close($ch);

	// Decode the response (Transform it to an Array)
	$response = json_decode($response, true);

	// Return response
	return $response;
}

//
// Gospel Blocks Helper Functions
//

	// All Volumes
	Function gb_volumes() {
		// Make the Call
		$response = gbCall("/volumes");

		// Return Response
		return $response;
	}

	// Volumes Books
  Function gb_books($vol) {
    // Make the Call
    $response = gbCall("/volume/$vol");

    // Return Response
    return $response;
  }

	 // Books Chapters
	  Function gb_chapters($vol,$book) {
	    // Make the Call
	    $response = gbCall("/volume/$vol/book/$book");

	    // Return Response
	    return $response;
	  }

  // Chapters Verses
  Function gb_verses($vol,$book,$chap) {
    // Make the Call
    $response = gbCall("/volume/$vol/book/$book/chapter/$chap");

    // Return Response
    return $response;
  }

	// Users Boards
	Function gb_usersBoards($user) {
		// Make the Call
		$response = gbCall("/users/$user/boards");

		// Return Response
		return $response;
	}

	// Board Info/ Blocks
	Function gb_userBoardBlocks($user,$board_id) {
		// Make the Call
		$response = gbCall("/users/$user/board/$board_id");

		// Return Response
		return $response;
	}

	// Bit Info
	Function gb_userBlockVerses($user,$board_id,$block_id) {
		// Make the Call
		$response = gbCall("/users/$user/board/$board_id/block/$block_id");

		// Return Response
		return $response;
	}
?>
