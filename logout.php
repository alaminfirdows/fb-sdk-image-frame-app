<?php
	//start session
	session_start();
	if (isset($_SESSION['facebook_access_token'])) {
		$_SESSION = array();    //clear session array
		session_destroy();      //destroy session
		//exit();
	}
	else {
		header('Location: ./');
	}
	header('Location: ./');
?>