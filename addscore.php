<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="X-UA-Compatible" content="IE=edge">
	<meta charset="utf-8">
	<title>Guitar Wars - Add Your High Score</title>
	<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css">
	<link href="guitarwars.css" rel="stylesheet" type="text/css">
	<script src="../jqronie/scripts/jquery-3.2.0.min.js"></script>
	<script src="../bootstrap/js/bootstrap.min.js"></script>
</head>
<body style="background-color: #000">
	<h2 class="text-center" style="color:#fff; font-weight:bolder">Guitar Wars - Add Your High Score</h2>

	<?php
		require_once('appvars.php');
		require_once('connectvars.php');
		session_start();
		if (isset($_POST['submit'])){
			//Grab the score data from the POST
			$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
			$name = mysqli_real_escape_string($dbc, trim($_POST['name']));
			$score = mysqli_real_escape_string($dbc, trim($_POST['score']));
			$screenshot = mysqli_real_escape_string($dbc, trim($_FILES['screenshot']['name']));
			$screenshot_type = $_FILES['screenshot']['type'];
			$screenshot_size = $_FILES['screenshot']['size'];

			$user_pass_phrase = sha1($_POST['verify']);
			if($_SESSION['pass_phrase'] == $user_pass_phrase){



				if(!empty($name) && is_numeric($score) && !empty($screenshot)){
					if(($screenshot_type == 'image/png' || $screenshot_type == 'image/jpeg' || $screenshot_type == 'image/pjpeg'
						|| $screenshot_type == 'image/gif') && ($screenshot_size > 0 && $screenshot_size <= GW_MAXFILESIZE) 
						&& ($_FILES['screenshot']['error'] == 0)){
					//Connect to the database

					$target = GW_UPLOADPATH . $screenshot;
					if(move_uploaded_file($_FILES['screenshot']['tmp_name'], $target)){
					

					//Write the data to the database
					$query = "INSERT INTO guitarwars (date, name, score, screenshot)
					VALUES (NOW(), '$name', '$score', '$screenshot')";
					mysqli_query($dbc, $query);

					//Confirm success with the user
					echo '<p style="color:white">Thanks for adding your new high score!</p>';
					echo '<p style="color:white"><strong>Name:</strong> ' . $name . '<br>';
					echo '<strong>Score:</strong> ' . $score . '</p>';
					echo '<p><a href="guitarwars.php">&lt;&lt; Back to high scores</a></p>';

					//Clear the score data to clear the form
					$name = "";
					$score = "";
					$screenshot ="";
					mysqli_close($dbc);
					} else {
						echo '<p class="error">Sorry, there was a problem uploading your screen shot image.</p>';
					}//Check for upload file moving success
					} else{
						echo '<p class="error">The screen shot must be a GIF, JPEG, or PNG image file'.
						' no greater than '. (GW_MAXFILESIZE/1024) .' kb in size.</p>';
					}//Screen shot type and size
					@unlink($_FILES['screenshot']['tmp_name']);
				}
			    else {
					echo '<p class="error">Please enter all of the information to add '.
					'your high score.</p>';
				}

		
		}else{
				echo '<p class="error">Sorry, please enter the verification exactly as shown.</p>';
		}
	}
	?>
	<div class="container-fluid">
		<div class="row">
		<div class="col-md-4 col-md-offset-4" style="background-color:#cccccc;height:350;margin-top:auto; margin-bottom:auto">
			<hr>
			<form method="post" class="form-horizontal" style="margin:20px" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<div class="form-group">
					<input type="hidden" name="MAX_FILE_SIZE" value="32768">
					<label for="name" class="control-label col-md-2">Name:</label>
					<input type="text" id="name" class="col-md-6" name="name"
					value="<?php if(!empty($name)) echo $name; ?>" > </div>
				<div class="form-group">
					<label for="score" class="control-label col-md-2">Score:</label><input type="text" id="score" class="col-md-6" name="score"
					value="<?php if(!empty($score)) echo $score; ?>" >
				</div>
				<div class="form-group">
					<label for="screenshot" class="control-label col-md-3" style="padding-left:0px">Screen shot:</label>
					<input type="file" id="screenshot" class="col-md-7" name="screenshot">
				</div>
				<div class="form-group">
					<label for ="captcha" class="control-label col-md-3">CAPTCHA:</label>
					<input type="text" id="captcha" class="col-md-6" name="verify" placeholder="Enter the pass-phrase">
					<img src="captcha.php" alt="Verification Pass Phrase">
					<hr>
				</div>
				<div class="form-group col-md-2">
					<input type="submit" class="btn btn-success btn-lg" name="submit" value="Add">
				</div>
			</form>
			</div>
	</div>
	</div>
</body>
</html>