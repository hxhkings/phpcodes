<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>My Channel</title>
	<link rel="icon" type="image/png" href="youtube.png">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js" type="text/javascript"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" type="text/javascript"></script>
	<style>
		@font-face{
			font-family:Story;
			src:url('cheer_leader.ttf');
		}
		#videos{
			display:flex;	
			width:1000px;
			flex-wrap:wrap;
			margin: 0 80px 0 90px;
		}
		h1{
			font-family:Story, Times, serif;
			font-weight:bold;
			font-size:40px;
			margin-top:50px;
		}
		h3{
			font-family: Times, serif;
			font-weight:bold;
		}
		body{
			width:100%;
			height:100%;
			min-width: 100%;
			max-width:100%;
			background-color:rgba(200, 100, 249, 0.3);
		}
		button{
			margin-top:10px;

		}
		div#block{
			width:300px;
			font-family:Times serif;
			font-weight:bold;
			border:2px solid #000;
		}
		#page{
			font-size:30px;
			position:absolute;
			top: 800px;
			left:40%;
		}
		a.download{
			color:#000;
		}
		a.download:hover{
			color:rgb(90,0,255);
			text-decoration:none;
		}
	</style>
</head>
<body>
	<div class="container-fluid">
		<div class="row">
				<h1 class="text-center">hxhRonie's Youtube Search</h1><hr>
				<div class="col-md-4 col-sm-4 col-md-offset-4 col-sm-offset-4">
				<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?> ">
					<div class="input-group">
					<input type="text" name="search" class="form-control" id="search" placeholder="Search Youtube">
					<span class="input-group-addon"><span class="glyphicon glyphicon-blackboard"></span></span>
					</div>
					<button type="submit" name="submit" class="btn btn-secondary">Search <span class="glyphicon glyphicon-search"></span></button>
				</form>
				</div>
				<?php
					define('API_KEY', 'AIzaSyD0O6YlRuoQjn8YZTVC5LT_p7wNMYeeuFQ');
					

					function page_numbers($number, $query, $pages){

						$page_links = '<p id="page">';

						if ($number > 1){
							$page_links .= '<a href="' . $_SERVER['PHP_SELF'] . '?number=' . ($number-1) . '&query='.$query.'&pages='.$pages.'"><span class="glyphicon glyphicon-backward"></span></a> ';
						} else {
							$page_links .= '<span class="glyphicon glyphicon-backward"></span> ';
						}
						
						for($i=1; $i <= $pages; $i++){
							if($i == $number){
								$page_links .= ' ' . $i;
							} else{
							$page_links .= ' <a href="' . $_SERVER['PHP_SELF'] . '?number=' . $i . '&query='.$query.'&pages='.$pages.'">' . $i .'</a>';
						}
						}

						if ($number < $pages){
							$page_links .= ' <a href="' . $_SERVER['PHP_SELF'] . '?number=' . ($number+1) . '&query='.$query.'&pages='.$pages.'"><span class="glyphicon glyphicon-forward"></span></a>';
						} else {
							$page_links .= ' <span class="glyphicon glyphicon-forward"></span></p>';
						}
						return $page_links;

					}

					if(isset($_GET) && !empty($_GET)){
						$number = $_GET['number'];
						$query = $_GET['query'];
						$pages = $_GET['pages'];
						$query = str_replace(' ', '%20', $query);
						require('ysearch.php');
						require('yloop.php');
					}

					if(isset($_POST['submit'])){
						if(!empty($_POST['search'])){
							$number = 1;
							$searchphrase = preg_replace('/\W/', ' ', trim($_POST['search']));
							$searcharr = explode(' ', $searchphrase);
							$finalarr = array();
							for($i = 0; $i < count($searcharr); $i++){
								if($searcharr[$i] != ""){
									array_push($finalarr, $searcharr[$i]);
								}
							}
							$query = implode('%20', $finalarr);	
							require('ysearch.php');
							$pages = ceil(count($pagearr)/9);
							require('yloop.php');
							
				}}
				 ?>
		</div>
	</div>
</body>
</html>