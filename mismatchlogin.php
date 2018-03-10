<?php
	require_once('mismatchconnect.php');
	require_once('startsession.php');
	//Clear the error message
	$error_msg = "";
	// If the user isn't logged in, try to log them in
	if(!isset($_SESSION['user_id'])){
		if(isset($_POST['submit'])){
		

	//Connect to the database
	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	//Grab the user-entered log-in data
	$user_username = mysqli_real_escape_string($dbc, trim($_POST['username']));
	$user_password = mysqli_real_escape_string($dbc, trim($_POST['password']));

			if(!empty($user_username) && !empty($user_password)){
			//Look up the username and password in the database

			$query = "SELECT user_id, username FROM mismatch_user WHERE username = '$user_username' AND password = SHA('$user_password')";
			$data = mysqli_query($dbc, $query) or die("Error in querying");

				if(mysqli_num_rows($data) == 1){
					//The log-in is OK so set the user ID and username variables
					$row = mysqli_fetch_array($data);
					$_SESSION['user_id'] = $row['user_id'];
					$_SESSION['username'] = $row['username'];

					 setcookie('user_id', $row['user_id'], time() + (60 * 60 * 24 * 30));    // expires in 30 days
         			 setcookie('username', $row['username'], time() + (60 * 60 * 24 * 30));
         			 $query2 = "SELECT picture FROM mismatch_user WHERE username = '$user_username' AND password = SHA('$user_password')";
         			 $data2 = mysqli_query($dbc, $query2) or die("Error in querying");
         			 	if(mysqli_num_rows($data2) == 1){
         			 		$row2 = mysqli_fetch_array($data2);
         			 		$_SESSION['prof_pic'] = $row2['picture'];
         			 		setcookie('prof_pic', $row2['picture'], time() + (60 * 60 * 24 * 30));
         			 	}
					$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/mismatchhome.php';
					header('Location: ' . $home_url);
				}
				else{
					//The username and password are incorrect so set an error message
					$error_msg = 'Sorry, you must enter a valid username and password to log in.';
				}


			}
			else{
				//The username/password weren't entered so set an error message
				$error_msg = 'Sorry, you must enter your username and password to log in.';
			}
		}
	}
?>


	<?php
		$page_header = 'Log In';
		require_once('header.php');
		//If the cookie is empty, show any error message and the log-in form; otherwise confirm the log-in
		if (empty($_SESSION['user_id'])){
			echo '<p class="error">' . $error_msg . '</p>';
	?>
	<div class="col-md-3 col-sm-3">
	<form method="post" class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<fieldset>
			<legend>Log In</legend>
			<div class="form-group has-feedback">
				<label for="username" class="control-label">Username:</label>
				<input type="text" id="username" class="form-control" name="username" value="<?php if(!empty($user_username)) echo $user_username; ?>" placeholder="Enter Username...">
				<span class="glyphicon glyphicon-user form-control-feedback"></span>
			</div>
			<div class="form-group has-feedback">
				<label for="password" class="control-label">Password:</label>
				<input type="password" id="password" class="form-control" name="password" placeholder="Enter Password...">
				<span class="glyphicon glyphicon-lock form-control-feedback"></span>
			</div>
		</fieldset>
		<div class="form-group">
				<button type="submit" class="btn btn-primary form-control" name="submit">Log In 
				<span class="glyphicon glyphicon-heart"></span></button>	
			
		</div>
	</form>
	</div>
	<?php
		}
		else{
			//Confirm the successful log in
			echo ('<p class="login">You are logged in as <a class="login" href="mismatchhome.php"><span class="login">' . $_SESSION['username'] . '</span></a>.</p>');
		}

		require_once('footer.php');
	?>
