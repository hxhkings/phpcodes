<?php
require_once('authorize.php');
?>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="X-UA-Compatible" content="IE=edge">
	<meta charset="utf-8">
	<title>Admin Page</title>
</head>
<body>
<h2>Guitar Wars - High Scores Administration</h2>
<p>Below is a list of all Guitar Wars high scores. Use this page to remove scores as needed.</p>
<hr>
<?php
	require_once('appvars.php');
	require_once('connectvars.php');

	//Connect to the database
	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	$query = "SELECT * FROM guitarwars ORDER BY score ASC, date DESC";
	$data = mysqli_query($dbc, $query);

	echo '<table>';
	while($row = mysqli_fetch_array($data)){
		echo '<tr class="scorerow"><td><strong>' . $row['name'] . '</strong></td>';
		echo '<td>' . $row['date'] . '</td>';
		echo '<td>' . $row['score'] . '</td>';
		echo '<td><a href="removescore.php/?id=' . $row['id'] . '&amp;date=' . $row['date'] .
		'&amp;name=' . $row['name'] . '&amp;score=' . $row['score'] . '&amp;screenshot=' .
		$row['screenshot'] . '">Remove</a>';
		if($row['approved'] == '0'){
			echo ' <a href="approvescore.php/?id=' . $row['id'] . '&amp;date=' . $row['date'] .
			'&amp;name=' . $row['name'] . '&amp;score=' . $row['score'] . '&amp;screenshot=' . 
			$row['screenshot'] . '">Approve</a>';
		}
		echo '</td></tr>';
	}
	echo '</table>';
	mysqli_close($dbc);
?>
</body>
</html>