<?php
function send_message($message, $title, $playerids, $url = null){
	$message = $message;
	$user_id = "4444";
	$content = array(
		"en" => "$message",
	);

	$heading = array(
		"en" => "$title",
	);

	$fields = array(
		'app_id' => "ee539463-8ad7-4e8a-90b9-ebe033c8a4e8",
        'include_player_ids' => $playerids,
		'contents' => $content,
		'headings' => $heading
	);

	if (!empty($url)) {
		// $fields['url'] = $url;
	}
	$fields = json_encode($fields);
    // echo $fields;die;
	// print("\nJSON sent:\n");
	// print($fields);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8', 'Authorization: Basic Yzg3MTYyMWYtMjI2Ny00NzYxLTg4ODgtZGY4OWIzMjM1ZjM3'));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

	$response = curl_exec($ch);
	curl_close($ch);
	return $response;
}
