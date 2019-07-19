<?php include 'header.php';?>
<?php
	if(isset($_GET['pic'])){
		$pic_id = $_GET['pic'];
		if($pic_id == 'a') {
			$pic = '<img src="src/image/a.png">';
		}
		else if($pic_id == 'b') {
			$pic = '<img src="src/image/b.png">';
		}
		else if($pic_id == 'c') {
			$pic = '<img src="src/image/c.png">';
		}
		else if($pic_id == 'd') {
			$pic = '<img src="src/image/d.png">';
		}
		else if($pic_id == 'e') {
			$pic = '<img src="src/image/e.png">';
		}
		else if($pic_id == 'f') {
			$pic = '<img src="src/image/f.png">';
		}
		else if($pic_id == '') {
			$pic = '<img src="src/image/a.png">';
		}
	}
	else {
		$pic = '<img src="src/image/a.png">';
	}
?>
<div class="main container">
	<div class="content-left">
			<div class="pro-demo">
			<?php
					echo $pic;
			?>
			</div>
			<div class="btn" style="margin-top: 10px;">
				<?php
					if (isset($_SESSION['facebook_access_token']) != ""){
						echo '<a href="/genarate.php?pic='.$pic_id.'" class=""><i class="fa fa-facebook" aria-hidden="true"></i> Start Now With FB</a>';
					}
					else { 
						$loginUrl = $helper->getLoginUrl('http://diubuzz.club/', $permissions);
						echo '<a href="' . $loginUrl . '"><i class="fa fa-facebook" aria-hidden="true"></i>Log In With FB</a>';
					}
				?>
			</div>
		</div>
	<?php include 'right-part.php';?>
</div>

<?php include 'footer.php';?>