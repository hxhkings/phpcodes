<?php

						echo '<div class="col-md-10 col-md-offset-1">';
						echo '<h3>Search Results for <em>' . str_replace('%20', ' ', $query) . '</em>:</h3><hr>';
						echo '<div id="videos">';
						$range = $number == $pages ? count($pagearr) - (9*($pages-1)) : 9;
						for($i=($number-1)* 9; $i < ($number-1)* 9 + $range; $i++){
							echo '<div id="block">';
									echo '<iframe src="https://www.youtube.com/embed/' . $pagearr[$i]['video'] .'" width="300px" allowfullscreen></iframe>';
									echo '<a class="download" href="https://www.ssyoutube.com/watch?v='.$pagearr[$i]['video'].'" target="_blank"><p id="title" class="text-center">' . $pagearr[$i]['title'] .'</p></a></div>';
						}
						echo $pages > 1 ? page_numbers($number, $query, $pages) : '';
						echo '</div></div>';

?>