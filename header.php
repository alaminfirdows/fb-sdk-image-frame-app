<?php
	include 'app/config.php';
	include 'function.php';
?>
	<!DOCTYPE html>
<html style="width: 100%; height: 100%; text-rendering: optimizeLegibility !important; -webkit-font-smoothing: antialiased !important;">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="On the occasion of the 15th anniversary of the Daffodil International University decorate your Facebook profile with 6 colorful frame..." />
	<meta name="description" content="On the occasion of the 15th anniversary of the Daffodil International University decorate your Facebook profile with 6 colorful frame..." />
	<meta property="og:url" content="http://diubuzz.club" />
	<meta property="og:type" content="article" />
	<meta property="og:title" content="DIU Buzz" />
	<meta property="og:site_name" content="DIU Buzz"/>
	<meta property="og:description" content="On the occasion of the 15th anniversary of the Daffodil International University decorate your Facebook profile with colorful frame..." />
	<meta property="og:image" content="http://diubuzz.club/src/image/b.png" />
	<title>DIU Buzz</title>
	<link rel="stylesheet" type="text/css" href="src/css/style.css">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>
<body class="body">
	<div class="header">
		<div class="container">
			<div class="h1st left"><a href="index.php" class="logo-brand">DIUBuzz</a></div>
			<div class="h2nd left">
				<ul>
					<li><a href="/about.php" class="">About Us</a></li>
					<li><a href="/privacy.php" class="">Privacy</a></li>
					<li><a href="/terms.php" class="">Terms</a></li>
					<li style="padding-top: 0px;padding-bottom: 5px;margin-top: 1px;"><div class="fb-follow" data-href="https://www.facebook.com/alamin.diubd" data-layout="button" data-size="large" data-show-faces="false"></div></li>
					<!--<li style="border-right: none;"><a href="https://daffodilvarsity.edu.bd/" class="">DIU</a></li>-->
				</ul>
			</div>
			<div class="h3rd right">
				<?php
					if (isset($_SESSION['facebook_access_token'])) {
						$accessToken = $_SESSION['facebook_access_token'];
					} else {
				  		$accessToken = $helper->getAccessToken();
					}
					if (isset($accessToken)) {
						if (isset($_SESSION['facebook_access_token'])) {
							$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
						} else {
							// getting short-lived access token
							$_SESSION['facebook_access_token'] = (string) $accessToken;

						  	// OAuth 2.0 client handler
							$oAuth2Client = $fb->getOAuth2Client();

							// Exchanges a short-lived access token for a long-lived one
							$longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);

							$_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;

							// setting default access token to be used in script
							$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
						}
						$profile_request = $fb->get('/me?fields=name');
						$profile = $profile_request->getGraphNode();
					}
					if (isset($_SESSION['facebook_access_token']) != "") {
						echo $profile['name'].' '.'<a href="/logout.php">(Log Out)</a>';
					}
					else {
						$loginUrl = $helper->getLoginUrl('http://diubuzz.club/', $permissions);
						echo 'Hello, User ! '.'<a href="'. $loginUrl .'">(Log In)</a>';
					}
				?>
			</div>
		</div>
	</div>