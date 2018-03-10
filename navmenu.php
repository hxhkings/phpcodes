<?php
	echo '<hr>';
if(isset($_SESSION['username'])){
		if(isset($_SESSION['prof_pic'])){
			echo '<a href="mismatchviewprof.php"><img src="image/' . $_SESSION['prof_pic'] . '" alt="Profile Pic">';
			echo '<span class="login">     (' . $_SESSION['username'] . ')            </span></a>';
		}

		echo '<a href="mismatchhome.php">Home </a>';
		echo '&#10084; <a href="mismatchviewprof.php">View Profile </a>';
		echo '&#10084; <a href="mismatcheditprof.php">Edit Profile </a>';
		echo '&#10084; <a href="mismatchquestion.php">Questionnaire </a>';
		echo '&#10084; <a href="mymismatch.php">My Mismatch </a>';
		echo '&#10084; <a href="mismatchlogout.php">Log Out</a>';
	
	}
	else{
		echo '&#10084; <a href="mismatchlogin.php">Log In </a>';
		echo '&#10084; <a href="mismatchsignup.php">Sign Up</a>';
	}
	echo '<hr>';
?>