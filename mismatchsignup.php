<?php
$page_header = 'Sign Up';
require_once('header.php');
require_once('mismatchappvars.php');
require_once('mismatchconnect.php');

//Connect to the database
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if(isset($_POST['submit'])){
	$username = mysqli_real_escape_string($dbc, trim($_POST['username']));
	$password1 = mysqli_real_escape_string($dbc, trim($_POST['password1']));
	$password2 = mysqli_real_escape_string($dbc, trim($_POST['password2']));

	if(!empty($username) && !empty($password1) && !empty($password2) &&
		($password1 == $password2)){
		//Make sure someone isn't already registered using this username

		$query = "SELECT * FROM mismatch_user WHERE username = '$username' AND password = '$password1'";

		$data = mysqli_query($dbc, $query);
		if(mysqli_num_rows($data) == 0){
			//The username is unique, so insert the data into the database
			$query = "INSERT INTO mismatch_user (username, password, join_date)" .
					"VALUES ('$username', SHA('$password1'), NOW())";
			mysqli_query($dbc, $query);
			//Confirm success with the user
			echo '<p class="success">Your new account has been successfully created. You\'re now ready to log in and ' . 
			'<a href="mismatchlogin.php">edit your profile</a></p>';

			mysqli_close($dbc);
			exit();
		}
		else{
			//An account already exists for this username, so display an error message
			echo '<p class="error">An account already exists for this username. Please use a different'.
			'address.</p>';
			$username = "";
		}
	}
	else{
		echo '<p class="error">You must enter all of the sign-up data, including the desired password' .
			' twice.</p>';
	}
}
mysqli_close($dbc);
?>

<p class="signup">Please enter your username and desired password to sign up to Mismatch.</p><hr>
<div class="col-md-3">
<form method="post" class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<fieldset>
		<legend>Registration Info</legend>
	<div class="form-group">
		<label for="username">Username:</label>
		<input type="text" id="username" class="form-control" name="username" 
		value="<?php if(!empty($username)) echo $username; ?>" placeholder="Username..."><br>
	</div>
	<div class="form-group">
		<label for="password1">Password:</label>
		<input type="password" id="password1" class="form-control" name="password1" 
		value="<?php if(!empty($password1)) echo $password1; ?>" placeholder="Password..."><br>
	</div>
	<div class="form-group">
		<label for="password2">Password (retype):</label>
		<input type="password" id="password2" class="form-control" name="password2" 
		value="<?php if(!empty($password2)) echo $password2; ?>" placeholder="Password..."><br> 
	</div>
	</fieldset>
	<div class="form-group">
	<button type="submit" name="submit" class="btn btn-danger btn-md form-control">Sign Up <span class="glyphicon glyphicon-heart"></span></button>
	</div>
</form>
</div>
<?php
	require_once('footer.php');
?>