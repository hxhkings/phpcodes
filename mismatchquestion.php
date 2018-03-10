<?php
	require_once('startsession.php');

	$page_header = 'Questionnaire';
	require_once('header.php');

	require_once('mismatchappvars.php');
	require_once('mismatchconnect.php');

	if(!isset($_SESSION['user_id'])){
		echo '<p class="login">Please <a href="mismatchlogin.php">Log in</a> to access this page.</p>';
		exit();
	}

	require_once('navmenu.php');

	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("Unable to Connect");
	
	// If this user has never answered the questionnaire, insert empty responses into the database
	  $query = "SELECT * FROM mismatch_response WHERE user_id = '" . $_SESSION['user_id'] . "'";
	  $data = mysqli_query($dbc, $query);
	  if (mysqli_num_rows($data) == 0) {
	    // First grab the list of topic IDs from the topic table
	    $query = "SELECT topic_id FROM mismatch_topic ORDER BY category_id, topic_id";
	    $data = mysqli_query($dbc, $query);
	    $topicIDs = array();
	    while ($row = mysqli_fetch_array($data)) {
	      array_push($topicIDs, $row['topic_id']);
	    }

	    // Insert empty response rows into the response table, one per topic
	    foreach ($topicIDs as $topic_id) {

	      $query = "INSERT INTO mismatch_response (user_id, topic_id) VALUES ('" . $_SESSION['user_id']. "', '$topic_id')";
	      mysqli_query($dbc, $query);
	    }
	  }

	//If the questionnaire form has been submitted, write the form responses to the database
	if(isset($_POST['submit'])){
		//Write the questionnaire response rows to the response table
		foreach($_POST as $response_id => $response){
			$query = "UPDATE mismatch_response SET response = '$response' WHERE response_id = '$response_id' ";
			mysqli_query($dbc, $query);
		}
		echo '<p class="login">Your responses have been saved.</p>';
	}

	//Grab the response data from the database to generate the form
	  $query = "SELECT mr.response_id, mr.topic_id, mr.response, mt.name AS topic_name, mc.name AS category_name " .
	    "FROM mismatch_response AS mr " .
	    "INNER JOIN mismatch_topic AS mt USING (topic_id) " .
	    "INNER JOIN mismatch_category AS mc USING (category_id) " .
	    "WHERE mr.user_id = '" . $_SESSION['user_id'] . "'";
	  $data = mysqli_query($dbc, $query) or die("Error in querying!");
	  $responses = array();
	  while ($row = mysqli_fetch_array($data)) {
	  	
	    array_push($responses, $row);
	  }

	mysqli_close($dbc);

	//Generate the questionnaire form by looping through the response array
	echo '<div class="col-md-5">';
	 echo '<form method="post" class = "form-horizontal" action="' . $_SERVER['PHP_SELF'] . '">';
	  echo '<p class="login">How do you feel about each topic?</p>';
	  $category = $responses[0]['category_name'];
	  echo '<fieldset><legend>' . $responses[0]['category_name'] . '</legend>';
	  foreach ($responses as $response) {
	    // Only start a new fieldset if the category has changed
	    if ($category != $response['category_name']) {
	      $category = $response['category_name'];
	      echo '</fieldset><fieldset><legend>' . $response['category_name'] . '</legend>';
	    }

	    // Display the topic form field
	    echo '<div class="form-group">';
	    echo '<div class="col-xs-6">';
	    echo '<label ' . ($response['response'] == NULL ? 'class="error"' : '') . ' for="' . $response['response_id'] . '">' . $response['topic_name'] . ':</label></div>';
	    echo '<div class="col-xs-6">';
	    echo '<input type="radio" id="' . $response['response_id'] . '" name="' . $response['response_id'] . '" value="1" ' . ($response['response'] == 1 ? 'checked="checked"' : '') . ' />Love ';
	    echo '<input type="radio" id="' . $response['response_id'] . '" name="' . $response['response_id'] . '" value="2" ' . ($response['response'] == 2 ? 'checked="checked"' : '') . ' />Hate<br />';
	    echo '</div></div>';
	  }
	  echo '</fieldset>';
	  echo '<div class="form-group"><button type="submit" class="btn btn-danger btn-lg" name="submit">Save Questionnaire '.
	        '<span class="glyphicon glyphicon-save"></span></button></div>';
	  echo '</form></div>';

	
?>

</body>
</html>