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
		$response = gbCall("/volumes");
		return $response;
	}

	// Volumes Books
  Function gb_books($vol) {
    $response = gbCall("/volume/$vol");
    return $response;
  }

 	// Books Chapters
  Function gb_chapters($vol,$book) {
    $response = gbCall("/volume/$vol/book/$book");
    return $response;
  }

  // Chapters Verses
  Function gb_verses($vol,$book,$chap) {
    $response = gbCall("/volume/$vol/book/$book/chapter/$chap");
    return $response;
  }

	// CALLS SPECIFIC TO THE BLOCKS PANEL IN APP
	// Get Blocks Pinnd To Dashboard
	Function gb_usersPinnedBlocks($user) {
		$response = gbCall("/users/$user/pinned");
		return $response;
	}

	// Get Block as Board Info
	Function gb_userBlocks($user,$block_id) {
		$response = gbCall("/users/$user/block/$block_id");
		return $response;
	}

	// Get Verses associated with Block
	Function gb_userBlockVerses($user,$block_id) {
		$response = gbCall("/users/$user/block/$block_id/verses");
		return $response;
	}
	// // Users Boards
	// Function gb_usersBoards($user) {
	// // 	$response = gbCall("/users/$user/boards");
	//
	// 	return $response;
	// }


	// Board Info/ Blocks
	// Function gb_userBoardBlocks($user,$board_id) {
	// // 	$response = gbCall("/users/$user/board/$board_id");
	//
	// 	return $response;
	// }

	// // Get Block as Board Info
	// Function gb_userBlocks($user,$block_id) {
	// // 	$response = gbCall("/users/$user/block/$block_id");
	//
	// 	return $response;
	// }
	// Users Boards

	// // Get Block as Board Info
	// Function gb_userBlockBlocks($user,$block_id) {
	// // 	$response = gbCall("/users/$user/block/$block_id");
	//
	// 	return $response;
	// }

?>
