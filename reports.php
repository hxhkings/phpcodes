<html>
<head>
	<title>Aliens Abducted Me - Report an Abduction</title>
	<link rel="stylesheet" type="text/css" href="style.css" >
</head>
<body>
	<h2>Aliens Abducted Me - Report an Abduction</h2>
	<?php
		if(isset($_POST['submit'])){
			if(!empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['email']) && !empty($_POST['moussey_spotted']) && 
				!empty($_POST['aliendescription']) && !empty($_POST['whenithappened']) && !empty($_POST['howlong']) && !empty($_POST['howmany']) && !empty($_POST['whattheydid']) && !empty($_POST['other'])){
		$when_it_happened = $_POST['whenithappened'];
		$how_long = $_POST['howlong'];
		$alien_description = $_POST['aliendescription'];
		$moussey_spotted = $_POST['mousseyspotted'];
		$email = $_POST['email'];
		$fname = $_POST['firstname'];
		$lname = $_POST['lastname'];
		$name = $_POST['firstname'] . ' ' . $_POST['lastname'];
		$how_many = $_POST['howmany'];
		$what_they_did = $_POST['whattheydid'];
		$other = $_POST['other'];
		
		$msg = "$name was abducted $when_it_happened and was gone for $how_long.\n" .  
			"Number of aliens: $how_many\n" .
			"Alien description: $alien_description\n" . 
			"What they did: $what_they_did\n" . 
			"Moussey spotted: $moussey_spotted\n" . 
			"Other comments: $other";
		$to = 'rvhorca@up.edu.ph';
		$subject = 'Aliens Abducted Me - Abduction Report';
		mail($to, $subject, $msg, 'From:' . $email);

		$dbc = mysqli_connect('localhost', 'hxhking', 'hunter1hunter', 'hfjq_race_info')
			or die('Error in connecting to the database.');

		$query = "INSERT INTO alien_abduction(first_name, last_name, when_it_happened, how_long," . 
				"how_many, alien_description, what_they_did, moussey_spotted, other, email)" . 
				"VALUES ('$fname', '$lname', '$when_it_happened', '$how_long', '$how_many', '$alien_description'," .
				"'$what_they_did', '$moussey_spotted', '$other', '$email')";
		$result = mysqli_query($dbc, $query)
				or die('Error in querying.');

		mysqli_close($dbc);
		echo 'Thanks for submitting the form. <hr>';
		echo 'You were abducted ' . $when_it_happened;
		echo ' and were gone for ' . $how_long. '<br>';
		echo 'Number of aliens: ' . $how_many. '<br>';
		echo 'Describe them: ' , $alien_description . '<br>';
		echo 'The aliens did this: ' . $what_they_did. '<br>';
		echo 'Was Moussey there? ' . $moussey_spotted . '<br>';
		echo 'Other comments: ' . $other. '<br>';
		echo 'Your email address is ' . $email;
		exit();
	} else{
		echo '<p class="error">Please complete the form! Click <a href="abductform.html">here</a> to return.</p>';
	}
	
	}
	?>
</body>
</html>