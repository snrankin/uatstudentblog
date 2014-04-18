<?php
/*
Plugin Name: jQuery Migrate
Plugin URI: http://www.chromeorange.co.uk
Description: Test your site for potential problems with jQuery 1.9.1 as ships with WordPress 3.6 before 3.6 is relaeased. This plugin will add jquery-migrate.js to your site to prevent plugins and scripts that are using deprecated functions from breaking when you use jQuery 1.9.1. Additionally, for admin users only, a list of errors will be output to the console so you can see which areas need to be fixed. WordPress 3.6 includes jquery-migrate.js for the admin but not the frontend. You can use this plugin in your currect version of WordPress, so you can find out if anything in your jQuery files will break before upgrading to WordPress 3.6
Version: 0.1.0
Author: Andrew Benbow
Author URI: http://www.chromeorange.co.uk
*/

/*  Copyright 2011  Andrew Benbow  (email : andrew@chromeorange.co.uk)

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
        class CO_jquerymigrate {

            public function __construct() {
				
				/**
				 * Include jQuery Migrate
				 *
				 * Achieves 2 things, 
				 * 1 - replaces the removed functions
				 * 2 - lets you see that they needed replacing by logging in the console
				 * 
				 * WordPress 3.6 ships with jQuery Migrate for use in the admin so we can use that, 
				 * If the $wp_version is less than 3.6 then we'll load a version from the plugin 
				 */
				include_once(ABSPATH . 'wp-includes/pluggable.php');
                add_action( 'admin_enqueue_scripts', array( $this,'admin_jquery_migrate' ) );
				
				if ( current_user_can( 'level_10' ) ) :
					add_action( 'wp_enqueue_scripts', array( $this,'logging_jquery_migrate' ) );
				else :
					add_action( 'wp_enqueue_scripts', array( $this,'nologging_jquery_migrate' ) );			
				 endif;

            }

            /**
             * Include jQuery Migrate in the Admin
             */
            function admin_jquery_migrate() {
				wp_enqueue_script( 'jquery-migrate', plugins_url( '/jquerymigrate/js/jquery-migrate.js' ), array( 'jquery' ), '1.1.1', TRUE );
            }

            /**
             * Include jQuery Migrate in the frontend
			 * this version has logging enabled
             */
            function logging_jquery_migrate() {
				wp_enqueue_script( 'jquery-migrate', plugins_url( '/jquerymigrate/js/jquery-migrate.js' ), array( 'jquery' ), '1.1.1', TRUE );
            }

            /**
             * Include jQuery Migrate in the frontend
			 * this version has logging disabled
             */
            function nologging_jquery_migrate() {
				wp_enqueue_script( 'jquery-migrate', plugins_url( '/jquerymigrate/js/jquery-migrate-mute.js' ), array( 'jquery' ), '1.1.1', TRUE );
            }
        }

	$GLOBALS['CO_jquerymigrate'] = new CO_jquerymigrate();
