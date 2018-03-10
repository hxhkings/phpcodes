<html>
	<head>
		<title>Make Me Elvis</title>
	</head>
	<body>
		<?php 
			$first_name = $_POST['firstname'];
			$last_name = $_POST['lastname'];
			$email = $_POST['email'];
			$dbc = mysqli_connect('localhost', 'hxhking', 'hunter1hunter', 'elvis_store')
				or die("Error in connecting to MySQL server.");
			
			$query = "INSERT INTO email_list (first_name, last_name, email)" . 
				"VALUES ('$first_name', '$last_name', '$email')";
			mysqli_query($dbc, $query)
				or die("Error in querying to MySQL database.");
		echo 'You are part of the email list.';
		mysqli_close($dbc);
		?>
	</body>
</html>