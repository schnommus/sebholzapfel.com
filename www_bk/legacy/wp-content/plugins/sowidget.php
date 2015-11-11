<?php
/*
Plugin Name: Stack Overflow Widget
Plugin URI: http://www.grumpydev.com/2009/01/09/stack-overflow-wordpress-widget/
Description: Display Stack Overflow Reputation 
Author: Steve Robbins
Version: 2.0.0
Author URI: http://www.grumpydev.com/
*/

// Constants for cache timeout
define("MINUTES", 60);
define("HOURS", MINUTES*60);
define("DAYS", HOURS*24);

function widget_sowidget_init() {

	// Check to see required Widget API functions are defined...
	if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') )
		return; // ...and if not, exit gracefully from the script.

	// This function prints the sidebar widget--the cool stuff!
	function widget_sowidget($args) {

		// $args is an array of strings which help your widget
		// conform to the active theme: before_widget, before_title,
		// after_widget, and after_title are the array keys.
		extract($args);

		// Collect our widget's options, or define their defaults.
		$options = get_option('widget_sowidget');
		$username = empty($options['username']) ? 'username' : $options['username'];
		$email = empty($options['email']) ? 'email!' : $options['email'];
		$cache_time = empty($options['cache_time']) ? 30 : $options['cache_time'];
		if ($cache_time == '')
			$cache_time = 30; 
		$cache_time = $cache_time * MINUTES;
		$title = "Stack Overflow";
		$hash = md5($email);

 		// It's important to use the $before_widget, $before_title,
 		// $after_title and $after_widget variables in your output.
		echo $before_widget;
		echo $before_title . $title . $after_title;
		echo widget_sowidget_getsocontent($username, $hash, $cache_time);
		echo $after_widget;
	}
	
	// Returns the filename for the cache
	//
	// Gets the system temp directory and uses the current script dir/name
	// plus an optional cache name to generate the filename.
	//
	// Should always return the same file when given the same cache name
	// if the script stays in the same directory :-)
	function get_cache_filename($cacheName)
	{
	        $dir = sys_get_temp_dir();
	        $file = trim(__FILE__, '/\\');
	        $file = str_replace(';', '.', $file);
	        $file = str_replace(':', '.', $file);
        	$file = str_replace('/', '.', $file);
        	$file = str_replace('\\', ',', $file);
        	if (strlen($cacheName) > 0)
                $file = $file.'.'.$cacheName;
        	$file = $file.'.cache';

        	return $dir.'/'.$file;
	}

	function widget_sowidget_getsocontent($userid, $hash, $cache_time) {
		$url = "http://stackoverflow.com/users/flair/".$userid.".json";
		$gravatar = '<img border="0" alt="Gravatar" src="http://www.gravatar.com/avatar/'.$hash.'?s=48&d=identicon&r=PG" height=48 width=48 />';
		
		$cache_file = get_cache_filename('stackoverflow'.$userid);
		$timedif = @(time() - filemtime($cache_file));
		if (file_exists($cache_file) && $timedif < $cache_time) {
		    $raw = file_get_contents($cache_file);
		} else {
		    $raw = file_get_contents($url);
		    if ($f = @fopen($cache_file, 'w')) {
		        fwrite ($f, $raw, strlen($raw));
		        fclose($f);
		    }
		}

    // Decode JSON
    $json_decoded = json_decode($raw, true);
    $username = $json_decoded['displayName'];
    $url = $json_decoded['profileUrl'];
    $badges = $json_decoded['badgeHtml'];
    $rep = $json_decoded['reputation'];
    
    $content='<style>.badge1 { color: #FFCC00; } .badge2 { color: #C0C0C0; } .badge3 { color: #CC9966; } </style>';
		$content.='<div style="background-color: #dddddd; border: 1px solid #888888; display: block; float: left; padding: 2px; margin: 2px;width: auto; line-height: 1.3em !important;"';
                $content.='<div style="float: left; width: 48px; display: block; vertical-align: middle;">';
                $content.='<a href="'.$url.'" target="_blank">';
		$content.=$gravatar;
                $content.='</a>';
                $content.='</div>';
                $content.='<div style="float: right; width: 100px; text-align: right; display: block;">';
                $content.='<a href="'.$url.'" target="_blank">'.htmlentities($username).'</a><br />';
                $content.='<span style="font-size: 12px;">'.$rep.'</span><span style="color: #A00004;">r</span>';
		$content.='<br/>';
		$content.=$badges;
		
		$content.='</div>'; 
            	$content.='</div>';
              $content.='<div style="clear: both;"></div>';

		return $content;
	}

	function widget_sowidget_control() {
		$options = get_option('widget_sowidget');
		if ( $_POST['sowidget-submit'] ) {
			$options['username'] = strip_tags(stripslashes($_POST['sowidget-username']));
			$options['email'] = strip_tags(stripslashes($_POST['sowidget-email']));
			$options['cache_time'] = strip_tags(stripslashes($_POST['sowidget-cache_time']));
			update_option('widget_sowidget', $options);
		}

		$username = $options['username'];
		$email = $options['email'];
		$cache_time = $options['cache_time'];
                if ($cache_time == '')
                        $cache_time = 30;
?>
		<div>
		<label for="sowidget-username" style="line-height:35px;display:block;">Stack Overflow User Number:<br/><input type="text" id="sowidget-username" name="sowidget-username" value="<?php echo $username; ?>" /></label>
		<label for="sowidget-email" style="line-height:35px;display:block;">Email:<br/><input type="text" id="sowidget-email" name="sowidget-email" value="<?php echo $email; ?>" /></label>
		 <label for="sowidget-cache_time" style="line-height:35px;display:block;">Cache Timeout (mins):<br/><input type="text" id="sowidget-cache_time" name="sowidget-cache_time" value="<?php echo $cache_time; ?>" /></label>
		<input type="hidden" name="sowidget-submit" id="sowidget-submit" value="1" />
		</div>
	<?php
	// end of widget_sowidget_control()
	}

	// This registers the widget. About time.
	register_sidebar_widget('Stack Overflow Widget', 'widget_sowidget');

	// This registers the (optional!) widget control form.
	register_widget_control('Stack Overflow Widget', 'widget_sowidget_control');
}

// Delays plugin execution until Dynamic Sidebar has loaded first.
add_action('plugins_loaded', 'widget_sowidget_init');
?>
