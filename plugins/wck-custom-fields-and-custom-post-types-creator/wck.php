<?php
/*
Plugin Name: WCK - Custom Fields and Custom Post Types Creator
Description: WordPress Creation Kit consists of three tools that can help you create and maintain custom post types, custom taxonomies and most importantly, custom fields and metaboxes for your posts, pages or CPT's.
Author: Reflection Media, Madalin Ungureanu, sareiodata
Version: 1.0.9
Author URI: http://www.reflectionmedia.ro

License: GPL2

== Copyright ==
Copyright 2011 Reflection Media (wwww.reflectionmedia.ro)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
*/

define( 'WCK_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . dirname( plugin_basename( __FILE__ ) ) );

/* ready for localization */
load_plugin_textdomain( 'wck', false, basename( dirname( __FILE__ ) ) . '/languages' );


/* include Custom Fields Creator API */
require_once('wordpress-creation-kit-api/wordpress-creation-kit.php');

/* Create the WCK Page only for admins ( 'capability' => 'edit_theme_options' ) */
$args = array(							
			'page_title' => __( 'Wordpress Creation Kit', 'wck' ),
			'menu_title' => 'WCK',
			'capability' => 'edit_theme_options',
			'menu_slug' => 'wck-page',									
			'page_type' => 'menu_page',
			'position' => '30,27',
			'priority' => 7,
			'icon_url' => plugins_url('/images/wck-icon.png', __FILE__)
		);
new WCK_Page_Creator( $args );

/* Remove the automatically created submenu page */
add_action('admin_menu', 'wck_remove_wck_submenu_page', 11);
function wck_remove_wck_submenu_page(){
	remove_submenu_page( 'wck-page', 'wck-page' );
}

/* include template API */
if( file_exists( dirname(__FILE__).'/wck-template-api/wck-template-api.php' ) )
	require_once('wck-template-api/wck-template-api.php');

/* include Start and Settings Page */
require_once('wck-sas.php');

$wck_tools = get_option( 'wck_tools' );
if( $wck_tools ){
	if( !empty( $wck_tools[0]['custom-fields-creator'] ) ){
		$wck_cfc = $wck_tools[0]['custom-fields-creator'];		
	}
	if( !empty( $wck_tools[0]['custom-post-type-creator'] ) ){
		$wck_cptc = $wck_tools[0]['custom-post-type-creator'];		
	}
	if( !empty( $wck_tools[0]['custom-taxonomy-creator'] ) ){
		$wck_ctc = $wck_tools[0]['custom-taxonomy-creator'];		
	}
	if( !empty( $wck_tools[0]['frontend-posting'] ) ){
		$wck_fep = $wck_tools[0]['frontend-posting'];		
	}
	if( !empty( $wck_tools[0]['option-pages-creator'] ) ){
		$wck_opc = $wck_tools[0]['option-pages-creator'];		
	}
	if( !empty( $wck_tools[0]['swift-templates'] ) ){
		$wck_stp = $wck_tools[0]['swift-templates'];		
	}
}
/* include Custom Post Type Creator */
if( !isset( $wck_cptc ) || $wck_cptc == 'enabled' )
	require_once('wck-cptc.php');
/* include Custom Taxonomy Creator */
if( !isset( $wck_ctc ) || $wck_ctc == 'enabled' )
	require_once('wck-ctc.php');
/* include Custom Fields Creator */
if( !isset( $wck_cfc ) || $wck_cfc == 'enabled' )
	require_once('wck-cfc.php');



/* include FrontEnd Posting */
if( file_exists( dirname(__FILE__).'/wck-fep.php' ) && ( !isset( $wck_fep ) || $wck_fep == 'enabled' ) )
	require_once('wck-fep.php');
/* include Option Page Creator */
if( file_exists( dirname(__FILE__).'/wck-opc.php' ) && ( !isset( $wck_opc ) || $wck_opc == 'enabled' ) )
	require_once('wck-opc.php');

/* include Swift Templates */
if( file_exists( dirname(__FILE__).'/wck-stp.php' ) && ( !isset( $wck_stp ) || $wck_stp == 'enabled' ) )
	require_once('wck-stp.php');	
	
/* deactivation hook */
register_deactivation_hook( __FILE__, 'wck_deactivate_function' );
function wck_deactivate_function() {	
	
	/* remove capabilities from subscriber that were added by FEP */
	$role = get_role( 'subscriber' ); 	
	$role->remove_cap( 'upload_files' );	
	$role->remove_cap( 'edit_posts' );
}

/* check for updates */
$wck_premium_update = WCK_PLUGIN_DIR.'/update/';
if (file_exists ($wck_premium_update . 'update-checker.php')){
	require_once ($wck_premium_update . 'update-checker.php');
	(array)$wck_serial = get_option('wck_serial');
	if( !empty( $wck_serial[0] ) )
		$wck_serial = urlencode( $wck_serial[0]['serial-number'] );
	if(empty($wck_serial) || $wck_serial == '') $wck_serial = '';
	
	if (file_exists ( WCK_PLUGIN_DIR . '/wordpress-creation-kit-api/wck-fep/wck-fep.php' )){
		$wck_update = new wck_PluginUpdateChecker('http://updatemetadata.cozmoslabs.com/?localSerialNumber='.$wck_serial.'&uniqueproduct=WCKP', __FILE__, 'wck-pro');
	} else {
		$wck_update = new wck_PluginUpdateChecker('http://updatemetadata.cozmoslabs.com/?localSerialNumber='.$wck_serial.'&uniqueproduct=WCKH', __FILE__, 'wck-hobby');
	}
}

/* include nested repeaters */
/* if( file_exists( dirname(__FILE__).'/wordpress-creation-kit-api/wck-nested-repeaters/wck-nested-repeaters.php' ) )
	require_once('wordpress-creation-kit-api/wck-nested-repeaters/wck-nested-repeaters.php'); */

?>