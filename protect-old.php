<?php
/*
Plugin Name: Protect old posts
Version: 0.1
Plugin URI: http://dev.wp-plugins.org/wiki/ProtectOld
Description: This plugin puts a password specified in the protect-old.php file on every post but the latest published one that doesn't already have a password.
Author: Matt Mullenweg
Author URI: http://photomatt.net/
*/

$default_password = 'changeme';

function mm_something_changed($something) { // This is extremely crude
	global $wpdb, $tableposts, $default_password;
	$count = $wpdb->get_var("SELECT COUNT(*) FROM $tableposts WHERE post_status = 'publish'");
	$one = $count - 1;
	$wpdb->query("UPDATE $tableposts SET post_password = '$default_password' WHERE post_status = 'publish' AND post_password = '' ORDER BY post_date_gmt ASC LIMIT $one");
	return $something;
}

add_action('publish_post', 'mm_something_changed');
add_action('edit_post', 'mm_something_changed');
add_action('delete_post', 'mm_something_changed');
add_action('comment_post', 'mm_something_changed');
add_action('trackback_post', 'mm_something_changed');
add_action('pingback_post', 'mm_something_changed');
add_action('edit_comment', 'mm_something_changed');
?>