<?php
require_once('authorize.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="X-UA-Compatible" content="IE=edge">
	<meta charset="utf-8">
	<title>Approve Score Page</title>
</head>
<body>
	<h2>Guitar Wars - Approve a High Score</h2>
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
		echo '<p class="error">Sorry, no high score was specified for approval.</p>';
	}

	if(isset($_POST['submit'])){
		if($_POST['confirm'] == 'Yes'){
			//Connect to the database
			$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
			//Delete the source data from the database
			$query = "UPDATE guitarwars SET approved = 1 WHERE id = $id";
			mysqli_query($dbc, $query);
			mysqli_close($dbc);

			//Confirm success with the user
			echo '<p>The high score of ' . $score . ' for ' . $name . ' was successfully approved.</p>';
		} else{
			echo '<p class="error">Sorry, there was a problem approving the high score.</p>';
		}
	}
	else if(isset($id) && isset($name) && isset($date) && isset($score) && isset($screenshot)){

		echo '<p>Are you sure you want to approve the following high score?</p>';
		echo '<p><strong>Name:</strong> ' . $name . '<br><strong>Date:</strong> ' . $date .
			'<hr><strong>Score:</strong> ' . $score . '</p>';
			if(!empty($screenshot)){
				echo '<p><img src="../'. GW_UPLOADPATH . $screenshot . '" alt="Score Image"></p>';
			}
			else {
				echo '<p><img src="../images/unverified.gif" alt="Unverified Score"></p>';
			}
		echo '<form method="post" action="http://localhost/hxhphp/approvescore.php">';
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