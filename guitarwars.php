<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="X-UA-Compatible" content="IE=edge">
	<meta charset="utf-8">
	<title>Guitar Wars</title>
	<link href="guitarwars.css" rel="stylesheet" type="text/css">
</head>
<body>
		<h2>Guitar Wars - High Scores</h2>
		<p>Welcome, Guitar Warrior, do you have what it takes to crack the 
		high score list? If so, just <a href="addscore.php">add your own score</a>.</p>
		<hr>

<?php
		require_once('appvars.php');
		require_once('connectvars.php');
		//Connect to the database
		$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

		//Retrieve the score data from MySQL
		$query = "SELECT * FROM guitarwars WHERE approved = 1 ORDER BY score DESC, date ASC";
		$result = mysqli_query($dbc, $query);

		//Loop through the array of score data, formatting it as html
		echo '<table>';
		$i = 0;
		while($row = mysqli_fetch_array($result)){
			//Display the score data
			if($i == 0){
				echo '<tr><th colspan="2" class="topscoreheader">';
				echo 'Top Score: ' .$row['score'].'</th></tr>';
			}
			echo '<tr><td class="scoreinfo">';
			echo '<span class="score">' . $row['score'] . '</span><br>';
			echo '<strong>Name: </strong>' . $row['name'] . '<br>';
			echo '<strong>Date: </strong>' . $row['date'] . '</td>';
			if(is_file(GW_UPLOADPATH.$row['screenshot']) && filesize(GW_UPLOADPATH.$row['screenshot'])>0){
				echo '<td><img src="'.GW_UPLOADPATH.$row['screenshot'].'" alt="Score image"></td></tr>';
			} 
			else {
				echo '<td><img src="images/unverified.gif" alt="Unverified score"></td></tr>';
			}
			$i = $i + 1;
		}
		echo '</table>';
		mysqli_close($dbc);

?>
</body>
</html>