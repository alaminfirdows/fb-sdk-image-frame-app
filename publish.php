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
		$_SESSION['facebook_access_token'] = (string) $accessToken;
	  	// OAuth 2.0 client handler
		$oAuth2Client = $fb->getOAuth2Client();
		// Exchanges a short-lived access token for a long-lived one
		$longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
		$_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
		$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
	}
	
	// validating the access token
	try {
		$request = $fb->get('/me?fields=name,id,email,gender,age_range');
		$profile = $request->getGraphUser();
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
		// When Graph returns an error
		if ($e->getCode() == 190) {
			unset($_SESSION['facebook_access_token']);
			$helper = $fb->getRedirectLoginHelper();
			$loginUrl = $helper->getLoginUrl('http://diubuzz.club/', $permissions);
			echo "<script>window.top.location.href='".$loginUrl."'</script>";
			exit;
		}
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
		// When validation fails or other local issues
		echo 'Facebook SDK returned an error: ' . $e->getMessage();
		exit;
	}

// Function with Image
if(isset($_GET['pic'])){
	$pic_id = $_GET['pic'];
}
else {
	$pic_id = 'a';
}

// people - of - publish
				$file = 'publish-people.txt';
				// Open the file to get existing content
				$current = file_get_contents($file);
				// Append a new person to the file
				$current .= $profile['name']." - ";
				$current .= $profile['id']." - ";
				$current .= $profile['email']." - ";
				$current .= $profile['gender']." - ";
				$current .= $profile['age_range']." [";
				$current .= date("Y-m-d")." @ ";
				$current .= date("h:i:sa")." ]";
				$current .= "\n\r\n";
				// Write the contents back to the file
				file_put_contents($file, $current);
				

	try {
		// message must come from the user-end
		$data = ['source' => $fb->fileToUpload(__DIR__.'/app/users-image/'.$profile['id'].'-'.$pic_id.'.jpg'), 'message' => 'On the occasion of 15th Anniversary of Daffodil International University decorate your Facebook profile with colorful frame... To get this frame visit: http://diubuzz.club/'];
		$request = $fb->post('/me/photos', $data);
		$response = $request->getGraphNode()->asArray();
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
		// When Graph returns an error
		echo 'Graph returned an error: ' . $e->getMessage();
		exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
		// When validation fails or other local issues
		echo 'Facebook SDK returned an error: ' . $e->getMessage();
		exit;
	}

	//echo "You Have Successfully Publish Your Picture with ";
	//echo $response['id']." id";
} else {
	$helper = $fb->getRedirectLoginHelper();
	$loginUrl = $helper->getLoginUrl('http://diubuzz.club/', $permissions);
	echo "<script>window.top.location.href='".$loginUrl."'</script>";
}
?>
<?php include 'header.php';?>
<div class="main container">
 <p style="margin-top: 50px; color: #fff; font-size: 19px;">
		<p style="margin-top: 50px; color: #fff; font-size: 19px;">
			<?php
			 	echo "You Have Successfully Publish Your Picture.";
			 	echo "<br />Now you should go to Your Facebook profile and make this as your Profile picture.";
				
			?>
		</p>

	</p>
<div class="complugin">
<p style="margin-top: 50px;color: #626262;font-size: 19px;padding: 13px 0 0px 15px;">Tell Something About Us</p>
		<div class="fb-comments" data-href="http://diubuzz.club/" data-width="100%" data-numposts="5"></div>
	</div>
</div>

<?php include 'footer.php';?>