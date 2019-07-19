<?php
	include 'config.php';
	try {
		if (isset($_SESSION['facebook_access_token'])) {
			$accessToken = $_SESSION['facebook_access_token'];
		} else {
	  		$accessToken = $helper->getAccessToken();
		}
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
		// When Graph returns an error
		echo 'Graph returned an error: ' . $e->getMessage();
		exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
		 // When validation fails or other local issues
		echo 'Facebook SDK returned an error: ' . $e->getMessage();
		exit;
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

		// redirect the user back to the same page if it has "code" GET variable
		if (isset($_GET['code'])) {
			header('Location: ./');
		} else {
			header('Location: ./login.php');
		}
	  	// Now you can redirect to another page and use the access token from $_SESSION['facebook_access_token']
	}
	else {
		// replace your website URL same as added in the developers.facebook.com/apps e.g. if you used http instead of https and you used non-www version or www version of your website then you must add the same here
		$loginUrl = $helper->getLoginUrl('http://diubuzz.club/', $permissions);
		echo '';
	}
?>
<?php include 'header.php';?>
<div class="main container">
	<div class="content-left">
			<div class="pro-demo">
			<?php
					echo $pic;
			?>
			</div>


<div class="btn" style="margin-top: 10px;"><div class="fb-follow" data-href="https://www.facebook.com/alamin.diubd" data-layout="button" data-size="large" data-show-faces="false"></div></div>


			<div class="btn" style="margin-top: 10px;">
				<?php
					if (isset($_SESSION['facebook_access_token']) != ""){
						echo '<a href="/genarate.php" class=""><i class="fa fa-facebook" aria-hidden="true"></i> Start Now With FB</a>';
					}
					else { 
						$loginUrl = $helper->getLoginUrl('http://diubuzz.club/', $permissions);
						echo '<a href="' . $loginUrl . '"><i class="fa fa-facebook" aria-hidden="true"></i>Log In With FB</a>';
					}
				?>
			</div>
		</div>
	<div class="content-right" style="margin-top: 10%;">
<div class="fb-page" data-href="https://www.facebook.com/diubuzz/" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/diubuzz/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/diubuzz/">DIU Buzz</a></blockquote></div></div>
	<!--<?php include 'right-part.php';?>-->
</div>

<?php include 'footer.php';?>