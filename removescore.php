<?php
require_once('authorize.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="X-UA-Compatible" content="IE=edge">
	<meta charset="utf-8">
	<title>Removal Page</title>
	<link href="guitarwars.css" rel="stylesheet" type="text/css">
</head>
<body>
	<h2>Guitar Wars - Remove a High Score</h2>
	<?php
	require_once('appvars.php');
	require_once('connectvars.php');
	if(isset($_GET['id']) && isset($_GET['date']) && isset($_GET['name'])
		&& isset($_GET['score']) && isset($_GET['screenshot'])){
		//Grab the score data from the GET
		$id = $_GET['id'];
		$date = $_GET['date'];
		$name = $_GET['name'];
		$score = $_GET['score'];
		$screenshot = $_GET['screenshot'];
	}
	else if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['score'])){

		$id = $_POST['id'];
		$name = $_POST['name'];
		$score = $_POST['score'];
	}
	else{
		echo '<p class="error">Sorry, no high score was specified for removal.</p>';
	}

	if(isset($_POST['submit'])){
		if($_POST['confirm'] == 'Yes'){
			//Delete the screen shot image file from the server
			@unlink(GW_UPLOADPATH.$screenshot);

			//Connect to the database
			$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
			//Delete the source data from the database
			$query = "DELETE FROM guitarwars WHERE id = $id LIMIT 1";
			mysqli_query($dbc, $query);
			mysqli_close($dbc);

			//Confirm success with the user
			echo '<p>The high score of ' . $score . ' for ' . $name . ' was successfully removed.</p>';
		} else{
			echo '<p class="error">The high score was not removed.</p>';
		}
	}
	else if(isset($id) && isset($name) && isset($date) && isset($score) && isset($screenshot)){

		echo '<p>Are you sure you want to delete the following high score?</p>';
		echo '<p><strong>Name:</strong> ' . $name . '<br><strong>Date:</strong> ' . $date .
			'<hr><strong>Score:</strong> ' . $score . '</p>';
		echo '<form method="post" action="http://localhost/hxhphp/removescore.php">';
		echo '<input type="radio" name="confirm" value="Yes">Yes';
		echo '<input type="radio" name="confirm" value="No" checked="checked">No <br>';
		echo '<input type="submit" value="Submit" name="submit">';
		echo '<input type="hidden" name="id" value="' . $id . '">';
		echo '<input type="hidden" name="name" value="' . $name . '">';
		echo '<input type="hidden" name="score" value="' . $score . '">';
		echo '</form>';
	}
	echo '<p><a href="http://localhost/hxhphp/admin.php">&lt;&lt; Back to admin page</a></p>';
	?>
</body>
</html>