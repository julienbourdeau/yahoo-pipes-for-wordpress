<?php
/*
Plugin Name: Yahoo Pipes for Wordpress
Plugin URI: 
Description: Get a list of all your posts using Yahoo Pipes. This plugin provides a widget and a function
Version: 0.1
Author: Julien Bourdeau 
Author URI: http://sigerr.org
*/


require_once 'config.php';

// $pattern = 's|(http://)?(www\.)?([^.]*)\.(.*\.?)*|\3|p';

function ypfwp_curl_get_file($path) {
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_POST, 0);
	curl_setopt($ch,CURLOPT_URL, $path);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	 
	$res = curl_exec($ch);
	
	curl_close($ch);
	
	return $res;
}


function ypfwp_get_last_posts() {
	
	$cache = dirname(__FILE__) . "/pipe.cache";
	
	if( filemtime($cache) < (time() - CACHE_TTL) ) {  
		
		$json = ypfwp_curl_get_file( PIPE_URL );
		$data = json_decode($json);
		
		if(isset($data->value->items)){
						
			$cachefile = fopen($cache, 'w');  
			fwrite($cachefile, $json);  
			fclose($cachefile);  
			
		} else {
			$data = json_decode(file_get_contents($cache));
		}
	} else {  
	
		$data = json_decode(file_get_contents($cache));
	
	}

	return $data;	
}


function ypfwp_display_yahoo_pipe() {
	$data = ypfwp_get_last_posts();
	
	echo '<ul class="postlinkslist">';
	
	foreach( $data->value->items as $item ):
		
		$src = parse_url($item->{'y:id'}->value, PHP_URL_HOST);
		$src = str_ireplace('www.', '', $src);
		$src_class_name = str_ireplace('.', '-', $src);
		
		$desc = strip_tags($item->description);
	?>
	
    	<li class="web-src-icon <?php echo $src_class_name; ?>">
        	
			<a href="<?php echo $item->link; ?>">
            	<div class="web-src-icon"></div>
                <?php echo $item->title; ?>
                <span class=""> - <small><?php echo calc_time_diff(strtotime($item->pubDate)); ?></small></span>
            </a>
        </li>
    
	<?php	
	endforeach; 
	 
	echo "</ul>";
	
}


function calc_time_diff($timestamp, $unit = NULL, $show_unit = TRUE) {
    $seconds = round((time() - $timestamp)); // How many seconds have elapsed
    $minutes = round((time() - $timestamp) / 60); // How many minutes have elapsed
    $hours = round((time() - $timestamp) / 60 / 60); // How many hours have elapsed
    $days = round((time() - $timestamp) / 60 / 60 / 24); // How many hours have elapsed
    $seconds_string = $seconds;
    $minutes_string = $minutes;
    $hours_string = $hours;
    $days_string = $days;
    switch($unit) {
        case "seconds": return $seconds;
            break;
        case "minutes": return $minutes;
            break;
        case "hours": return $hours;
            break;
        case "days": return $days;
            break;
        default: // No time unit specified, return the most relevant
            if($seconds < 60) { // Less than a minute has passed
                if($seconds != 1) {
                    $seconds_string .= " seconds ago";
                }
                else {
                    $seconds_string .= " second ago";
                }
                return ($show_unit) ? $seconds_string : $seconds;
            }
            elseif($minutes < 60) { // Less than an hour has passed
                if($minutes != 1) {
                    $minutes_string .= " minutes ago";
                }
                else {
                    $minutes_string .= " minute ago";
                }
                return ($show_unit) ? $minutes_string : $minutes;
                ;
            }
            elseif($hours < 24) { // Less than a day has passed
                if($hours != 1) {
                    $hours_string .= " hours ago";
                }
                else {
                    $hours_string .= " hour ago";
                }
                return ($show_unit) ? $hours_string : $hours;
            }
            else { // More than a day has passed
                if($days != 1) {
                    $days_string .= " days ago";
                }
                else {
                    $days_string .= " day ago";
                }
                return ($show_unit) ? $days_string : $days;
            }
            break;
    }
}

ypfwp_display_yahoo_pipe();