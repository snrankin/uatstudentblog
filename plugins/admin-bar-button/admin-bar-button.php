<?php
/**
 * Plugin Name: Admin Bar Button
 * Description: Hide the front end admin bar and replace it with an 'Admin bar' button. When you hover over the button, the bar appears and stays for as long as your mouse hovers over it (it'll disappear 5 seconds after you move the mouse away).
 * Author: David Gard
 * Version: 1.2.4
 *
 * Copyright 2014 David Gard.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as 
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

/**
 * Avoid direct calls to this file where WP core files are not present
 */
if(!function_exists('add_action')) :
	header('Status: 403 Forbidden');
	header('HTTP/1.1 403 Forbidden');
	exit();
endif;

/**
 * Enqueue any necessary admin scripts/styeles
 */
add_action('wp_enqueue_scripts', '_abb_enqueue_scripts');
function _abb_enqueue_scripts(){
	
	global $wp_styles;
	
	/** Enqueue the JS required scripts */
	wp_enqueue_script('jquery-ui-widget');
	wp_enqueue_script('jquery-effects-slide');
	wp_enqueue_script('djg-admin-bar', plugins_url('adminBar.js?scope=admin-bar-button', __FILE__ ), array('jquery-ui-widget', 'jquery-effects-slide'));
	
	/** Enqueue the required CSS */
	wp_enqueue_style('djg-admin-bar', plugins_url('adminBar.css?scope=admin-bar-button', __FILE__ ));
	
}

/**
 * Make sure that the admin bar does not add any margin to the top of the <body>
 */
add_theme_support('admin-bar', array('callback' => 'abb_display'));
function abb_display(){
?>
	<style>
	body{
		margin-top: 0;
	}
	#wpadminbar{
		display: none;
	}
	</style>
<?php
}