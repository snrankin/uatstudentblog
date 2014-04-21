<?php
/*
Plugin Name: ATW Show Posts
Plugin URI: http://AspenThemeworks.com/atw-show-posts
Description: Aspen Themeworks Show Posts - Show  posts or custom posts within your Theme's pages or posts using a shortcode and a form-based interface.
Author: wpweaver
Author URI: http://weavertheme.com/about/
Version: 1.0.4

License: GPL

Aspen Themeworks Show Posts
Copyright (C) 2013, Bruce E. Wampler - aspen@aspenthemeworks.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/


/* CORE FUNCTIONS
*/

define ( 'ATW_SHOWPOSTS_VERSION','1.0.4');
define ( 'ATW_SHOWPOSTS_MINIFY','.min');		// '' for dev, '.min' for production

// ===============================>>> REGISTER ACTIONS <<<===============================

add_action( 'plugins_loaded', 'atw_posts_plugins_loaded');

    function atw_posts_plugins_loaded() {

        function atw_showposts_installed() {
        return true;
    }

    add_action( 'media_buttons', 'atw_posts_add_form_buttons', 20 );
    add_action('admin_menu', 'atw_posts_admin_menu');
    add_action('wp_enqueue_scripts', 'atw_posts_enqueue_scripts' );
    add_action('template_redirect', 'atw_posts_emit_css' );
    add_action('init', 'atw_posts_setup_shortcodes');  // allow shortcodes to load after theme has loaded so we know which version to use
}

// ===============================>>> DEFINE ACTIONS <<<===============================


/** --------------------------------------------------------------------------------------------
* Add the ATW Slider button to the post editor
*/

function atw_posts_add_form_buttons(){
    $page = is_admin() ? get_current_screen() : null;

    if(  isset($page) && $page-> id!= 'atw_slider_post'  ) {
        echo '<a href="#TB_inline?width=400&height=300&inlineId=select-show-posts-dialog" class="thickbox button" id="add_atw_posts_posts" title="' . __("Add [show_posts]", 'atw-showposts') . '"><span class="atw-slider-media-icon "></span> ' . __("Add [show_posts]", "atw-slider") . '</a>';
        add_action( 'admin_footer', 'atw_posts_select_posts_form' );
    }

    if ( function_exists( 'atw_slider_installed') && isset($page) && $page->id != 'atw_slider_post' ) {
        echo '<a href="#TB_inline?width=400&height=300&inlineId=select-show-sliders-dialog" class="thickbox button" id="add_atw_slider_slidrs" title="' . __("Add [show_slider]", 'atw-slider') . '"><span class="atw-slider-media-icon "></span> ' . __("Add [show_slider]", "atw-slider") . '</a>';
        add_action( 'admin_footer', 'atw_posts_select_slider_form' );
    }
}

/**
* Displays the Insert a [show_posts] Selector
*/
function atw_posts_select_posts_form() {
    atw_posts_select_scripts_and_styles();
?>
    <div id="select-show-posts-dialog" style="display:none">
        <h3><?php _e('Insert [show_posts]', 'atw-showposts'); ?></h3>
        <p><?php _e('Add a [show_posts filter=specify-filter-name] into this page/post', 'atw-showposts'); ?></p>
<?php
    $filters = atw_posts_getopt('filters');

    echo '<label for="atw-slider-post-select">Select a filter: </label><select id="atw-slider-post-select" >';
    foreach ($filters as $filter => $val) {     // display dropdown of available filters
            echo '<option value="'. $filter . '">' . $val['name'] .  ' (' . $filter . ')</option>';
    }
    echo '</select>';
?>
    <br/><br/>

        <a href="#" id="select-atw-show-posts" class="button button-primary button-large" onClick="atwSelectShowPosts(); return false;">Add</a>
        <a href="#" id="cancel-insert-show-posts" class="button  button-large" onClick="atwCancelSelectShowPosts(); return false;">Cancel</a>

    </div>
<?php
}

/**
* Displays the Insert [show_slider] Selector
*/
function atw_posts_select_slider_form() {
    atw_posts_select_scripts_and_styles();
?>
    <div id="select-show-sliders-dialog" style="display:none">
        <h3><?php _e('Insert [show_slider]', 'atw-showposts'); ?></h3>
        <p><?php _e('Add a [show_slider name=specify-slider-name] into this page/post', 'atw-showposts'); ?></p>
<?php
    $sliders = atw_posts_getopt('sliders');

    echo '<label for="atw-slider-slider-select">Select a Slider: </label><select id="atw-slider-slider-select" >';
    foreach ($sliders as $slider => $val) {     // display dropdown of available sliders
        echo '<option value="'. $slider . '">' . $val['name'] .  ' (' . $slider . ')</option>';
    }
    echo '</select>';
?>
    <br/><br/>

        <a href="#" id="select-atw-show-posts" class="button button-primary button-large" onClick="atwSelectSliders(); return false;">Add</a>
        <a href="#" id="cancel-insert-show-posts" class="button  button-large" onClick="atwCancelSelectSliders(); return false;">Cancel</a>

    </div>
<?php
}


/*
* Enqueue scripts styles for select box in editor - can't be done when plugin is
* loaded - needs to be done by the add-button code
*/
function atw_posts_select_scripts_and_styles() {
    wp_enqueue_script( 'atw-posts-editor-buttons', plugins_url( 'js/atw-posts-editor-buttons.js', __FILE__ ), array( 'jquery' ), 1.0, true );
     echo '<style>.atw-slider-media-icon{
            background:url(' . plugins_url( 'images/aspen-leaf.png', __FILE__ )  . ') no-repeat top left;
            display: inline-block;
            height: 16px;
            margin: 0 2px 0 0;
            vertical-align: text-top;
            width: 16px;
            }
         </style>';

    //wp_enqueue_style( 'atw-slider-selector-style', plugins_url( 'css/atw-slider-selector-style.css', __FILE__ ));



}
// ---------------------------------------------------------------------

function atw_posts_admin() {
    require_once(dirname( __FILE__ ) . '/includes/atw-posts-admin-top.php'); // NOW - load the admin stuff
    atw_posts_admin_page();
}

function atw_posts_admin_menu() {

    //$page = add_submenu_page('edit.php?post_type=atw_posts_post',

        $menu = function_exists( 'atw_slider_installed' ) ? 'ATW Posts/Slider' : 'ATW Show Posts';
        $full = function_exists( 'atw_slider_installed' ) ? 'Aspen Show Posts and Show Sliders by Aspen ThemeWorks' : 'Aspen Show Posts by Aspen ThemeWorks';

        $page = add_menu_page(
	  'Aspen Show Posts by Aspen ThemeWorks', $menu, 'install_plugins',
      'atw_showposts_page', 'atw_posts_admin',plugins_url( '', __FILE__ ) .'/images/aspen-leaf.png',63);

	/* using registered $page handle to hook stylesheet loading for this admin page */

    add_action('admin_print_styles-'.$page, 'atw_posts_admin_scripts');
}


function atw_posts_admin_scripts() {
    /* called only on the admin page, enqueue our special style sheet here (for tabbed pages) */
    wp_enqueue_style('atw_sw_Stylesheet', atw_posts_plugins_url('/atw-admin-style', ATW_SHOWPOSTS_MINIFY . '.css'), array(), ATW_SHOWPOSTS_VERSION);

    wp_enqueue_script('atw_Yetii', atw_posts_plugins_url('/js/yetii/yetii',ATW_SHOWPOSTS_MINIFY.'.js'), array(),ATW_SHOWPOSTS_VERSION);
    wp_enqueue_script('atw_Admin', atw_posts_plugins_url('/js/atw-posts-admin',ATW_SHOWPOSTS_MINIFY.'.js'), array(), ATW_SHOWPOSTS_VERSION);


}

function atw_posts_plugins_url($file,$ext='') {
    return plugins_url($file,__FILE__) . $ext;
}

// ############


function atw_posts_enqueue_scripts() {	// enqueue runtime scripts

    if (function_exists('atw_posts_header')) atw_posts_header();

    // add plugin CSS here, too.

    wp_register_style('atw-posts-style-sheet',atw_posts_plugins_url('atw-posts-style', ATW_SHOWPOSTS_MINIFY.'.css'),null,ATW_SHOWPOSTS_VERSION,'all');
    wp_enqueue_style('atw-posts-style-sheet');

    if ( atw_posts_getopt( 'custom_css' ) != '' ) {
        wp_register_style( 'atw-posts-custom', '/?atwpostscss=1' );   // @@@@@@@ add some versioning
        wp_enqueue_style( 'atw-posts-custom' );
    }
}

// ############ stuff for custom CSS

/**
 * Add Query Var Stylesheet trigger
 *
 * Adds a query var to our stylesheet, so it can trigger our psuedo-stylesheet
 */
function atw_posts_add_trigger( $vars ) {
	$vars[] = 'atwpostscss';
	return $vars;
}

add_filter( 'query_vars','atw_posts_add_trigger' );

/**
 * If trigger (query var) is tripped, load our pseudo-stylesheet
 */
function atw_posts_emit_css() {
	if ( intval( get_query_var( 'atwpostscss' ) ) == 1 ) {
			header( 'Content-type: text/css' );
            $css = '/* ATW Show Posts Custom CSS */';
			$css .= atw_posts_getopt( 'custom_css' );
			$esc_css = esc_html( $css );
			$content = str_replace( '&gt;', '>', $esc_css ); // put these back
            $content = str_replace( '&lt;', '<', $esc_css ); // put these back
			echo $content;
			exit;
	}
}


// ############


function atw_posts_setup_shortcodes() {
    remove_shortcode('show_posts');                         // alias
    add_shortcode('show_posts','atw_show_posts_sc');

    if ( function_exists('atw_posts_getopt') && atw_posts_getopt( 'textWidgetShortcodes' ) ) {
        add_filter('widget_text', 'atw_post_text_widget_shortcode' );
    }
}

function atw_post_text_widget_shortcode( $text ) {
    return do_shortcode( $text );
}

function atw_show_posts_sc($args = '') {
    require_once(dirname( __FILE__ ) . '/includes/atw-showposts-sc.php');
    return atw_show_posts_shortcode($args);
}


// ############

require_once(dirname( __FILE__ ) . '/includes/atw-runtime-lib.php'); // NOW - load the basic library
?>
