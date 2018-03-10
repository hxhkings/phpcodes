<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>My Channel</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js" type="text/javascript"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" type="text/javascript"></script>
</head>
<body>
<h2 class="text-center" style="font-family:Times serif; font-weight:bolder">hXhRonie's YOUTUBE VIDEOS</h2><hr>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
<?php
	$API_KEY = 'AIzaSyD0O6YlRuoQjn8YZTVC5LT_p7wNMYeeuFQ';
	$channelId = 'UCEYVAD-20EU6HaijJbnxvsQ';
	$maxresults = 20;
	$videolist = json_decode(file_get_contents('https://www.googleapis.com/youtube/v3/search?order=date&part=snippet&channelId=' . $channelId . '&maxResults=' . $maxresults . '&key=' .$API_KEY . ''));
	$playlist = json_decode(file_get_contents('https://www.googleapis.com/youtube/v3/search?order=viewCount&part=snippet&q=hyoyeon%7Cmystery&maxResults=20&key=' .$API_KEY . ''));
	
	foreach($videolist -> items as $item){
		if (isset($item -> id -> videoId))
		echo '<iframe width="280" height="180" src="https://www.youtube.com/embed/' . $item -> id -> videoId. '" allowfullscreen></iframe>';

		
	}
	echo '<hr>';
	foreach($playlist -> items as $item){
		if(isset($item -> id -> videoId))
	echo '<iframe width="280" height="180" src="https://www.youtube.com/embed/' . $item-> id -> videoId. '" allowfullscreen></iframe>';
}

?>
		</div>
	</div>
</div>
</body>
</html>