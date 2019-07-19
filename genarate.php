<?php
	include 'header.php';
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
			$request = $fb->get('/me');
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
		// getting profile picture of the user
		try {
			$requestPicture = $fb->get('/me/picture?redirect=false&height=960&width=960'); //getting user picture
			$requestProfile = $fb->get('/me?fields=name,id,email,gender,age_range'); // getting basic info
			$picture = $requestPicture->getGraphUser();
			$profile = $requestProfile->getGraphUser();
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
			// When Graph returns an error
			echo 'Graph returned an error: ' . $e->getMessage();
			exit;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
			// When validation fails or other local issues
			echo 'Facebook SDK returned an error: ' . $e->getMessage();
			exit;
		}

		// Function with Image
		if(isset($_GET['pic'])){
			$pic_id = $_GET['pic'];
			if($pic_id == 'a') {
				$img1=imagecreatefrompng(__DIR__.'/app/img/a.png');
			}
			else if($pic_id == 'b') {
				$img1=imagecreatefrompng(__DIR__.'/app/img/b.png');
			}
			else if($pic_id == 'c') {
				$img1=imagecreatefrompng(__DIR__.'/app/img/c.png');
			}
			else if($pic_id == 'd') {
				$img1=imagecreatefrompng(__DIR__.'/app/img/d.png');
			}
			else if($pic_id == 'e') {
				$img1=imagecreatefrompng(__DIR__.'/app/img/e.png');
			}
			else if($pic_id == 'f') {
				$img1=imagecreatefrompng(__DIR__.'/app/img/f.png');
			}
			else if($pic_id == '') {
				$img1=imagecreatefrompng(__DIR__.'/app/img/b.png');
			}
		}
		else {
			$img1=imagecreatefrompng(__DIR__.'/app/img/b.png');
		}

		$src = imagecreatefromjpeg($picture['url']);        
		list($width, $height) = getimagesize($picture['url']); 

		$tmp = imagecreatetruecolor(960, 960); 

		//$filename = 'a.jpg';

		imagecopyresampled($tmp, $src, 0, 0, 0, 0, 960, 960, $width, $height); 
		//imagejpeg($tmp, $filename, 100);




		//$img2=imagecreatefromjpeg($picture['url']);
		imagecopy($tmp, $img1, 0, 0, 0, 0, 960, 960);
		imagejpeg($tmp, __DIR__.'/app/users-image/'.$profile['id'].'-'.$pic_id.'.jpg');
		$pic = '<img src="/app/users-image/'.$profile['id'].'-'.$pic_id.'.jpg">';

	} else {
		$helper = $fb->getRedirectLoginHelper();
		$loginUrl = $helper->getLoginUrl('http://diubuzz.club/');
		echo "<script>window.top.location.href='".$loginUrl."'</script>";
	}

	//include 'footer.php';
?>
<div class="main container">
	<div class="content-left">
			<div class="pro-demo">
			<?php if ($pic) {
					echo $pic;
				}
				else {
					$imgurl = "";
					echo "You Don't Have Generate any Picture !";
				}
			?>
			</div>
			<?php
				//echo $profile['name'];
				//echo $profile['id'];
				//echo $profile['email'];
				//echo $profile['gender'];
				//echo $profile['age_range'];


				$file = 'people.txt';
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
			?>
			<div class="btn" style="margin-top: 10px;">
				<?php
					if (isset($_SESSION['facebook_access_token']) != ""){
						echo '<a href="publish.php?pic='.$pic_id.'"><i class="fa fa-facebook" aria-hidden="true"></i>Post on Facebook</a>';
					}
					else { 
						echo "<script>window.top.location.href='".$loginUrl."'</script>";
				exit;
					}
				?>
			</div>
		</div>
<div class="content-right" style="margin-top: 10%;">
<div class="fb-page" data-href="https://www.facebook.com/diubuzz/" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/diubuzz/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/diubuzz/">DIU Buzz</a></blockquote></div></div>
	<!--<?php include 'right-part.php';?>-->
</div>

<?php include 'footer.php';?>