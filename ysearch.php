<?php
$videolist = json_decode(file_get_contents('https://www.googleapis.com/youtube/v3/search?order=relevance&part=snippet&controls=2&q='. $query .'&maxResults=50&key=' . API_KEY . ''));
							
							$pagearr = array();
							foreach($videolist -> items as $item){
								if(isset($item -> id -> videoId) && isset($item -> snippet -> title)){
									$title = $item -> snippet -> title;
									$video = $item -> id -> videoId;
									array_push($pagearr, array("title" => $title, "video" => $video));
								

								}
							}
?>