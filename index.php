<?php include 'header.php';?>

<div class="main container">
	<div class="content-left" style="padding-top: 70px; ">
		<p class="intro">On the occasion of the 15th anniversary of the Daffodil International University decorate your Facebook profile with colorful frame...</p>
		<p class="intro"><a href="information.php" class="" style="font-size: 20px;padding-top: 15px;font-family: 'Siyam Rupali';color: #fff;text-shadow: 1px 1px 3px #000;text-decoration: none;">Click to learn the rules ...</a></p>
		<?php
			if (isset($_SESSION['facebook_access_token']) != ""){
				//echo '<p class="intro" style="margin: 0;text-align: left; padding-left: 55px;" siyam="" rupali";color:="" #fff;text-shadow:="" 1px="" 3px="" #000;text-decoration:="" none;"="">প্রোফাইল নামঃ<br>আইডিঃ</p>';
			}
			else {
				echo '<p class="intro" style="font-size: 20px;padding-top: 15px;font-family: "Siyam Rupali";color: #fff;text-shadow: 1px 1px 3px #000;text-decoration: none;">You have not log in.</p>';
			}
		?>
		<div class="btn">
			<?php
				if (isset($_SESSION['facebook_access_token']) != ""){ echo '<a href="/genarate.php" class=""><i class="fa fa-facebook" aria-hidden="true"></i> Start Now With FB</a>'; }
				else { 
					//$loginUrl = $helper->getLoginUrl('http://diubuzz.club/', $permissions);
					echo '<a href="/login.php"><i class="fa fa-facebook" aria-hidden="true"></i>Log In With FB</a>';
				}
			?>
		</div>
<div class="btn" style="margin-top: 10px;">
				<?php
				echo '<a href="/support.php" class=""><i class="fa fa-facebook" aria-hidden="true"></i>Support Us</a>';
				?>
			</div>
	</div>
<div class="content-right">
	<div class="pro-demo">
<img src="src/image/b.png">
</div>
	</div>
</div>

<?php include 'footer.php';?>