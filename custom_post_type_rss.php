<?php
/*
Plugin Name: Custom Post Type RSS feeds
Plugin URI: http://www.jonathandavidharris.co.uk/scripts/custom-post-type-rss-feeds/
Description: A very simply plugin that add rss feeds for custom post types that have the archives set to true
Version: 1.1
Revision Date: JUL 19, 2012
Requires at least: WP 3.2.1
Tested up to: WP 3.4.1
Author: Jonathan Harris
Author URI: http://www.jonthandavidharris.co.uk/
License: GNU General Public License 2.0 (GPL)
Network: true

*/

/*  Copyright 2012  JONATHAN HARRIS  (email : JON@SPACEDMONKEY.CO.UK)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/





define ( 'CPTRF_IS_INSTALLED', '1.1' );

define ( 'CPTRF_VERSION', '1.1' );

define ( 'CPTRF_DB_VERSION', '1.1' );


function cptrf_activate() {
	global $wp_rewrite;
	$wp_rewrite->flush_rules();
}
register_activation_hook( __FILE__, 'cptrf_activate' );

function cptrf_init(){
	$siteName = get_bloginfo("name");
	
	$args=array(
  		'public'   => true,
  		'has_archive' => true,
  		'_builtin' => false
	); 

	$list_post_types = get_post_types($args);
	$list_post_types = apply_filters('cptrf_list',$list_post_types);
	
	foreach($list_post_types as $id => $vale){
		$feed = get_post_type_archive_feed_link( $vale );
		$obj = get_post_type_object($vale);
		$name = $obj->labels->name;
		$feedtitle = __('Feed');
		$feedname = $siteName." &raquo; ".$name. " ". $feedtitle; 
		echo '<link rel="alternate" type="application/rss+xml" title="'.$feedname.'" href="'.$feed.'" />
		';
	}
			
}

add_action('wp_head', 'cptrf_init');



?>