<?php
	session_start();
	require_once __DIR__ . '/src/Facebook/autoload.php';
	$fb = new Facebook\Facebook([
		'app_id' => '1109381402416523',
		'app_secret' => 'abd470b6336d2144c788897f53c18a0d',
		'default_graph_version' => 'v2.4',
	]);
	$helper = $fb->getRedirectLoginHelper();
	$permissions = ['email', 'publish_actions']; // optional
?>