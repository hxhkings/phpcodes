<?php
	header('Content-Type: text/xml');
?>
<?php
	echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<rss version="2.0">
	<channel>
		<title>Aliens Abducted Me - Newsfeed</title>
		<link>http://localhost/hxhphp/index.php</link>
		<description>Alien abduction reports from around the world courtesy of Owen and his abducted dog Moussey.</description>
		<language>en-us</language>

		<?php
			require_once('rssconnectvars.php');
			$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

			$query = "SELECT abduction_id, first_name, last_name, ".
			"DATE_FORMAT(when_it_happened, '%a, %d %b %Y %f') AS when_it_happened_rfc, ".
			"alien_description, what_they_did FROM alien_abduction ORDER BY when_it_happened DESC";

			$data = mysqli_query($dbc, $query);

			while($row = mysqli_fetch_array($data)){
				echo '<item>';
				echo '<title>' . $row['first_name'] . ' ' . $row['description'] .'</title>';
				echo '<link>http://localhost/hxhphp/index.php?abduction_id='.$row['abduction_id'].'</link>';
				echo '<pubDate>' . $row['when_it_happened_rfc'] . date('T') . '</pubDate>';
				echo '<description>' . $row['what_they_did'] . '</description>';
				echo '</item>';
			}
		?>
	</channel>
</rss>