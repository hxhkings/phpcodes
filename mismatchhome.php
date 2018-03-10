<?php

    require_once('startsession.php');
    $page_header = 'Where opposites attract';
    require_once('header.php');

	require_once('navmenu.php');

	require_once('mismatchconnect.php');
	require_once('mismatchappvars.php');

	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	$query = "SELECT * FROM mismatch_user";
	$data = mysqli_query($dbc, $query);

	//Loop through the array of user data, formatting it as HTML
	echo '<div class="col-md-3"><h4>Latest Members:</h4>';
	echo '<table>';
	while($row = mysqli_fetch_array($data)){
		if (is_file(MM_UPLOADPATH . $row['picture']) && filesize(MM_UPLOADPATH . $row['picture']) > 0) {

	      echo '<tr><td><img width="100%" height="100%" src="' . MM_UPLOADPATH . $row['picture'] . '" alt="' . $row['first_name'] . '" /></td>';
	    }
	    else {
	      echo '<tr><td><img width="100%" height="100%"  src="' . MM_UPLOADPATH . 'nopic.jpg' . '" alt="' . $row['first_name'] . '" /></td>';
	    }
	    if (isset($_SESSION['user_id'])) {
	    	
	      echo '<td><a style="margin:4px" href="mismatchviewprof.php?user_id=' . $row['user_id'] . '">' . $row['first_name'] . '</a></td></tr>';
	  		
	    }
	    else {
	      echo '<td>' . $row['first_name'] . '</td></tr>';
	    }
	  }
	echo '</table> </div>';

?>
</body>
</html>


