<?php
/*
Plugin Name: Custom Post Type RSS feeds
Plugin URI: http://jonathandavidharris.co.uk
Description: A very simply plugin that add rss feeds for custom post types that have the archives set to true
Version: 1.0
Revision Date: MAR 13, 2012
Requires at least: WP 3.2.1
Tested up to: WP 3.2.1
Author: Jonathan Harris
Author URI: http://jonthandavidharris.co.uk
License: GNU General Public License 2.0 (GPL)
Site Wide Only: true

*/

/*  Copyright 2011  JONATHAN HARRIS  (email : JON@SPACEDMONKEY.CO.UK)

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


define ( 'CPTRF_IS_INSTALLED', 1 );

define ( 'CPTRF_VERSION', '1' );

define ( 'CPTRF_DB_VERSION', '1' );


function cptrf_activate() {
	global $wp_rewrite;
	$wp_rewrite->flush_rules();
}
register_activation_hook( __FILE__, 'cptrf_activate' );

function cptrf_init(){
	$args=array(
  		'public'   => true,
  		'has_archive' => true,
  		'_builtin' => false
	); 

	foreach(get_post_types($args) as $id => $vale){
		$feed = get_post_type_archive_feed_link( $vale );
		$obj = get_post_type_object($vale);
		$name = $obj->labels->name;
		$feedname = __('Feed');
		echo '<link rel="alternate" type="application/rss+xml" title="'.get_bloginfo("name").' &raquo; '.$name.' '.$feedname .'" 	href="'.$feed.'" />';
	}
			
}

add_action('wp_head', 'cptrf_init');



?>