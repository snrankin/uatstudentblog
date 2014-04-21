<?php
/*
Plugin Name: ATW Show Sliders
Plugin URI: http://aspenthemeworks.com/atw-show-sliders/
Description: Aspen Themeworks Show Sliders - Show posts, images, and galleries displayed in a responsive slider with many options.
Author: wpweaver
Author URI: http://weavertheme.com/about/
Version: 1.0.8

License: GPL

Aspen Themeworks Show Sliders
Copyright (C) 2014, Bruce E. Wampler - aspen@aspenthemeworks.com

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

define ( 'ATW_SLIDER_PI_VERSION','1.0.8');
define ( 'ATW_SLIDER_PI_PRO', false);            // change this and the Plugin Name above when building Pro version
define ( 'ATW_SLIDER_PI_MINIFY','.min');		// '' for dev, '.min' for production

if (function_exists('atw_slider_installed')) {
    wp_die('Both ATW Show Sliders and ATW Show Sliders Pro installed. You can only activate one version or the other!','You can have only one activated version of ATW Show Sliders!');
}

// ===============================>>> REGISTER ACTIONS <<<===============================

    add_action( 'plugins_loaded', 'atw_slider_plugins_loaded');
    add_action( 'atw_show_sliders_post_pager','atw_slider_post_pager');

// ===============================>>> DEFINE ACTIONS <<<===============================

function atw_slider_plugins_loaded() {
    // these need to be done like this to avoid installation interaction issues with Show Posts
    // we really don't define any Show Sliders stuff until all the plugins have been installed


if ( function_exists('atw_showposts_installed') ) {

        function atw_slider_installed() {
            return true;
        }

        add_action( 'init', 'atw_slider_register_post_cpt' );
        add_action( 'init', 'atw_slider_setup_shortcodes');
        add_action( 'add_meta_boxes', 'atw_slider_add_meta_box' );
        add_action( 'wp_enqueue_scripts', 'atw_slider_enqueue_scripts' );
        add_action( 'wp_footer','atw_slider_the_footer', 9);	// make it 9 so we can dequeue scripts
        if ( ATW_SLIDER_PI_PRO ) {
            add_action( 'admin_enqueue_scripts','atw_slider_add_admin_scripts');

            function atw_slider_add_admin_scripts() {
                wp_enqueue_script('atw-combined-scripts',
                    atw_slider_plugins_url('/includes/pro/js/jquery.ddslick', ATW_SLIDER_PI_MINIFY . '.js'),array('jquery'),
                    ATW_SLIDER_PI_VERSION, true);
            }
        }


// ========================================= >>> atw_slider_register_post_cpt <<< ===============================
/**
* Registers the atw_slider_post custom post type
*/
function atw_slider_register_post_cpt() {
    $singular_item = __('Slider Post', 'atw-slider');
    $plural_item = __('Slider Posts', 'atw-slider');
    $labels = array(
        'name'               =>  $singular_item,
        'singular_name'      => 'Slider',
        'add_new'            => __('New', 'atw-slider') . ' ' .  $singular_item,
        'add_new_item'       => __('New', 'atw-slider') . ' ' .  $singular_item,
        'edit_item'          => __('Edit', 'atw-slider') . ' ' .  $singular_item,
        'new_item'           => __('New', 'atw-slider') . ' ' .  $singular_item,
        'all_items'          => __('All', 'atw-slider') . ' ' .  $plural_item,
        'view_item'          => __('View', 'atw-slider') . ' ' .  $singular_item,
        'search_items'       => __('Search', 'atw-slider') . ' ' .  $plural_item,
        'not_found'          => sprintf( __( 'No %s found', 'atw-slider' ), $plural_item ),
        'not_found_in_trash' => sprintf( __( 'No %s found in trash', 'atw-slider' ), $plural_item ),
        'parent_item_colon'  => '',
        'menu_name'          => $plural_item,
    );

    $args = array(
        'labels'             => $labels,
        'description'       =>  __('Auxiliary Custom Post Type to use for defining sliders.', 'atw-slider'),
        'exclude_from_search'   => true,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        //'rewrite'            => array( 'slug' => atw_slider_get_default_post_slug() ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'taxonomies'         => array('atw_slider_group','category','post_tag'),
        'menu_position'      => 64,
        'menu_icon' 		 => plugins_url( '', __FILE__ ) .'/images/aspen-leaf.png',  // Icon Path
        'supports'           => array( 'title', 'editor', 'page-attributes','thumbnail','excerpt','custom-fields','comments','revisions','post-formats','author')
    );

  register_post_type( 'atw_slider_post', $args );

    $tlabels = array(
        'name'                       => _x( 'Slider Group', 'Taxonomy General Name', 'atw-slider' ),
        'singular_name'              => _x( 'Slider Group', 'Taxonomy Singular Name', 'atw-slider' ),
        'menu_name'                  => __( 'Slider Groups', 'atw-slider' ),
        'all_items'                  => __( 'All Slider Groups', 'atw-slider' ),
        'parent_item'                => __( 'Parent Slider Group', 'atw-slider' ),
        'parent_item_colon'          => __( 'Parent Slider Group:', 'atw-slider' ),
        'new_item_name'              => __( 'New Slider Group', 'atw-slider' ),
        'add_new_item'               => __( 'Add New Slider Group', 'atw-slider' ),
        'edit_item'                  => __( 'Edit Slider Group', 'atw-slider' ),
        'update_item'                => __( 'Update Slider Group', 'atw-slider' ),
        'separate_items_with_commas' => __( 'Separate Slider Groups with commas', 'atw-slider' ),
        'search_items'               => __( 'Search Slider Groups', 'atw-slider' ),
        'add_or_remove_items'        => __( 'Add or remove Groups', 'atw-slider' ),
        'choose_from_most_used'      => __( 'Choose from the most used groups', 'atw-slider' ),
    );
    $targs = array(
        'labels'                     => $tlabels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'rewrite'            		 => array( 'slug' => atw_slider_get_default_category_slug() ),
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
    );
    register_taxonomy( 'atw_slider_group', 'atw_slider_post', $targs );
}

// ========================================= >>> atw_slider_get_default_post_slug <<< ===============================
/**
* Get the default post slug
*/
function atw_slider_get_default_post_slug(){
    $gallery_options_array = get_option( 'atw_slider_manager_options' );
    $default_slug = 'atw-slider';
    if( $gallery_options_array ){
        if( is_array($gallery_options_array) && array_key_exists( 'post_slug', $gallery_options_array ) ){
            $user_defined_slug = $gallery_options_array['post_slug'];
            if($user_defined_slug!=''){
                $default_slug = $user_defined_slug;
            }
        }
    }
    return $default_slug;
}

// ========================================= >>> atw_slider_get_default_category_slug <<< ===============================
/**
* Get the default category slug
*/
function atw_slider_get_default_category_slug() {
    $gallery_options_array = get_option( 'atw_slider_manager_options' );
    $default_slug = 'atw-slider';
    if( $gallery_options_array ){
        if( is_array($gallery_options_array) && array_key_exists( 'category_slug', $gallery_options_array ) ){
            $user_defined_slug = $gallery_options_array['category_slug'];
            if($user_defined_slug!=''){
                $default_slug = $user_defined_slug;
            }
        }
    }
    return $default_slug;
}


// ========================================= >>> atw_slider_add_meta_box <<< ===============================
/**
* Adds the intro meta box container
*/
function atw_slider_add_meta_box() {

   add_meta_box(
       'atw_slider_intro',
       __( 'ATW Slider Post Introduction', 'atw-slider' ),
       'atw_slider_render_meta_box_intro',
       'atw_slider_post',
       'normal',
       'high'
       );
}

// ========================================= >>> atw_slider_render_meta_box_intro <<< ===============================
/**
* Render Shortcode Info Meta Box content.
*
* @param WP_Post $post The post object.
*/
function atw_slider_render_meta_box_intro( $post ) {
?>
<p>
    The <em>ATW Slider Post</em> is a custom post type that is intended to help define ATW Slider/Slideshows. Posts of this type
    are effectively "hidden". However, you can include <em>ATW Slider Posts</em> by adding the post type to the <em>Post Type</em>
    option on the <em>Filters</em> tab of the <em>ATW Posts/Slider</em> admin page. You can group sliders, or create different slide shows
    by specifying a <em>Slider Group</em>.
    This post type has all the features of a standard post, but because it is a custom post type, post created using it will <strong>not</strong>
    appear on any of your normal blogs, category lists, tag lists, searches, or other archive-like pages.
</p>
<?php
}



// ========================================= >>> atw_slider_plugins_url <<< ===============================

function atw_slider_plugins_url($file,$ext='') {
    return plugins_url($file,__FILE__) . $ext;
}

// ========================================= >>> atw_slider_enqueue_scripts <<< ===============================

function atw_slider_enqueue_scripts() {	// enqueue runtime scripts

    $at_end = true;

    /* use combined js file */

    /*
     wp_enqueue_script('atw-flex-easing',
        atw_slider_plugins_url('/flex/js/jquery.easing', ATW_SLIDER_PI_MINIFY . '.js'),array('jquery'),
        ATW_SLIDER_PI_VERSION, $at_end);
    wp_enqueue_script('atw-flex-mousewheel',
        atw_slider_plugins_url('/flex/js/jquery.mousewheel', ATW_SLIDER_PI_MINIFY . '.js'),array('jquery'),
        ATW_SLIDER_PI_VERSION, $at_end);
    wp_enqueue_script('atw-fitvids',
        atw_slider_plugins_url('/flex/js/jquery.fitvids', ATW_SLIDER_PI_MINIFY . '.js'),array('jquery'),
        ATW_SLIDER_PI_VERSION, $at_end);
    */

    wp_enqueue_script('atw-combined-scripts',
        atw_slider_plugins_url('/flex/js/jquery.combined', ATW_SLIDER_PI_MINIFY . '.js'),array('jquery'),
        ATW_SLIDER_PI_VERSION, $at_end);



    wp_enqueue_script('atw-flex',
        atw_slider_plugins_url('/flex/js/jquery.flexslider', ATW_SLIDER_PI_MINIFY . '.js'),array('jquery'),
        ATW_SLIDER_PI_VERSION, $at_end);


    // add plugin CSS here, too.

    wp_register_style('atw-flex-style-sheet', atw_slider_plugins_url('/flex/css/atwflexslider', ATW_SLIDER_PI_MINIFY.'.css'),null,ATW_SLIDER_PI_VERSION,'screen');
    wp_enqueue_style('atw-flex-style-sheet');

}

// ========================================= >>> atw_slider_the_footer <<< ===============================

function atw_slider_the_footer() {
    if ( !isset($GLOBALS['atw_sliders_count']) ) {  // dequeue scripts if not used
        echo "<!-- No ATW Sliders used on this page -->\n";
        /*
        wp_dequeue_script( 'atw-flex-easing' );
        wp_dequeue_script( 'atw-flex-mousewheel' );
        wp_dequeue_script( 'atw-fitvids');
        */
        wp_dequeue_script( 'atw-combined-scripts' );
        wp_dequeue_script( 'atw-flex' );
        if ( atw_posts_getopt('showLoading') ) {
            echo '<script type="text/javascript">jQuery(window).ready(function(slider){jQuery(\'body\').removeClass(\'atwkloading\');});</script>' ,"\n";
        }
        return;
    }

    require_once(dirname( __FILE__ ) . '/includes/atw-slider-shortcode.php');

    atw_slider_do_footer();
}

// ========================================= >>> atw_slider_setup_shortcodes <<< ===============================

function atw_slider_setup_shortcodes() {
    if ( function_exists('atw_posts_getopt') && atw_posts_getopt('enable_gallery_slider')) {
        add_filter( 'post_gallery', 'atw_gallery_sc_filter', 10, 2);
    }

    remove_shortcode('show_slider');
    add_shortcode('show_slider', 'atw_slider_sc');
}

// ========================================= >>> atw_slider_sc <<< ===============================


function atw_slider_sc( $args = '' ) {
    require_once(dirname( __FILE__ ) . '/includes/atw-slider-shortcode.php');
    return atw_slider_shortcode( $args );
}

// ========================================= >>> atw_gallery_sc_filter <<< ===============================

function atw_gallery_sc_filter( $content, $args = '' ) {
    require_once(dirname( __FILE__ ) . '/includes/atw-slider-shortcode.php');
    return atw_gallery_shortcode_filter( $args );
}

// ========================================= >>> atw_slider_load_admin <<< ===============================

function atw_slider_load_admin() {
    require_once(dirname( __FILE__ ) . '/includes/atw-slider-slider-admin.php'); // NOW - load the admin stuff
    if ( atw_slider_pro() )
        require_once(dirname( __FILE__ ) . '/includes/pro/atw-slider-pro-admin-pro.php'); // NOW - load the admin stuff
    else
        require_once(dirname( __FILE__ ) . '/includes/atw-slider-pro-admin.php'); // NOW - load the admin stuff
    require_once(dirname( __FILE__ ) . '/includes/atw-slider-help-admin.php'); // NOW - load the admin stuff
}

// ========================================= >>> atw_slider_do_slider_admin <<< ===============================

function atw_slider_do_slider_admin() {
    atw_slider_load_admin();
    atw_slider_slider_admin();
}

// ========================================= >>> atw_slider_gallery_admin <<< ===============================

function atw_slider_gallery_admin() {
    atw_slider_load_admin();
    atw_slider_gallery_admin_page();
}

function atw_slider_pro() {
    // Note that just changing this to true will not give you Pro capabilities.
    // Those are supplied by content that is included only with the Pro version, and
    // are enforced by having a registered license. This simple file just makes things easier
    // to maintain...
    return ATW_SLIDER_PI_PRO;
}

// ====================================== >>> atw_slider_do_gallery <<< ======================================

function atw_slider_do_gallery( $qargs, $slider, $ids = null) {

    $content = "\n<!-- **** Slider Images: " . $slider . " **** -->\n";
    $style = '';


    if ( isset($GLOBALS['atw_slider_thumbs']))
        unset($GLOBALS['atw_slider_thumbs']);
    $GLOBALS['atw_slider_thumbs'] = array();        // save our thumbs...

    /* $margin = atw_posts_get_slider_opt( 'slideMargin', $slider );

    if ( $margin  != '') { // change default image margin?
        $style = ' style="margin:' . $margin . 'em;"';
    } */

    $img_class = 'slide-image';
    if (atw_posts_get_slider_opt( 'addImageBorder', $slider ))
        $img_class = 'slide-image-border';

    $lead_class = 'class="atwk-slide"';
    $lead_div = '<div class="slide-content ' . $img_class . '"' . $style . '>';

    if ( !$qargs || !empty( $ids ) ) {

        $content .= atw_slider_get_gallery( '' , $slider, $ids, $lead_class, $lead_div);

    } else {

        // get posts
        if ( !$qargs->have_posts()) {
            $content .= '<em>' . __('No posts found.','atw-slider') . ' ' . __('Slider Post slug: `', 'atw-slider') . $qargs->query['name'] .
                __('` - Slider: `', 'atw-slider') . $slider . '`.</em>';

        }
        while ( $qargs->have_posts() ) {
            $qargs->the_post();
            $post_content =  get_the_content();
            $gallery = atw_slider_get_gallery( $post_content , $slider, null, $lead_class, $lead_div);

            if ($gallery != '' ) {
                $content .= $gallery;
            }  else {
                $img = atw_slider_get_first_post_image( $post_content, $slider, $lead_class, $lead_div );

                if ( $img != '' ) {

                    $content .= $img ;
                }
            }
        }
    }

    echo $content;
}

// ====================================== >>> atw_slider_get_gallery <<< ======================================

function atw_slider_get_gallery( $content, $slider, $ids = array(), $lead_class='class="atwk-slide"', $lead_div='<div class="slide-content slide-image">' ) {
    // we will pass in either content, or a list of ids grabbed from the [gallery] shortcode replacement

     $gallery = '';

    // @@@@@@@@@@ need to use get_shortcode_regex

    if ( $content != ''
        && !atw_posts_get_slider_opt('noGallery', $slider)       // skip looking for [gallery]
        && preg_match( '/\[gallery(.*?)\]/i', $content, $sc)) {  // find the first [gallery]  ************************
        // sc[0] = full match
        // sc[1] = content of [gallery];
        $attr = shortcode_parse_atts( $sc[1] );
        if ( empty( $attr['ids'] ) )                            // will only work with [gallery ids="1,2,3"] form of shortcode
            return '';
        $gal_link = '';                                         // default is attachment
        if ( !empty( $attr['link']) )
            $gal_link = $attr['link'];

        $orderby = 'post__in';

        if ( !empty( $attr['orderby']) && $attr['orderby'] == 'rand' ) {
            $orderby = 'rand';
        }

        $img_list = explode( ',', $attr['ids']);        // build our list of attachment ids

        $attachments = get_posts( array('include' => $img_list, 'orderby' => $orderby,  'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image') );

        foreach ($attachments as $attachment => $attachment_obj) {
            $gallery .= atw_slider_get_slide_image( $attachment_obj, $slider, $lead_class, $lead_div, $gal_link);   // adeach image
        }

    } else if ($content == '' && !empty($ids) ) {        // we got passed a list of attachment images  *********************
        $gal_link = '';

        $attachments = get_posts( array('include' => $ids, 'orderby' => 'post__in',  'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image') );

        foreach ($attachments as $attachment => $attachment_obj) {
            $gallery .= atw_slider_get_slide_image( $attachment_obj, $slider, $lead_class, $lead_div, $gal_link);   // adeach image
        }



    } else if ($content == '') {                        // look for first image **********************

        $post = get_post();
        $id = $post ? $post->ID : 0;
        $gal_link = '';

        $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment',
                                           'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID') );

        foreach ($attachments as $attachment => $attachment_obj) {
            $gallery .= atw_slider_get_slide_image( $attachment_obj, $slider, $lead_class, $lead_div, $gal_link);   // add each image
        }

    }
    return $gallery;
}

// ====================================== >>> atw_slider_get_title_class <<< ======================================

function atw_slider_get_title_class($slider) {

    return atw_posts_get_slider_opt( 'titleOverlay', $slider) ? 'atwk-title-overlay' : 'atwk-title';

}

// ====================================== >>> atw_slider_get_slide_image <<< ======================================

function atw_slider_get_slide_image( $attachment_obj, $slider, $lead_class, $lead_div, $gal_link = '', $use_post_info = false) {

    // Get an image for the slide, and its pager index image

    $image_code = '';
    $attachment_id = $attachment_obj->ID;
    $src = $attachment_obj->guid;                  // link to full size image

    $caption = $attachment_obj->post_excerpt;      // Media Library Caption field
    $description = $attachment_obj->post_content;  // Media Library description field

    if ( $use_post_info ) {
        $title = the_title('','',false);    // get the post title
    } else {
        $title = $attachment_obj->post_title;       // title field of image
    }

    $title_div = '';
    if ($title && atw_posts_get_slider_opt('showTitle',$slider) ) {
        $title_div = '<div class="' . atw_slider_get_title_class($slider) . '">' . $title . '</div>';
    }

    $link_begin = '';
    $link_end = '';                     // No links by default

    if ( $gal_link != 'none' && atw_posts_get_slider_opt( 'showLinks', $slider) ) {
        if ( $use_post_info ) {
            if ($gal_link != '' && atw_posts_get_slider_opt('inlineLink', $slider)) {
                $attachment_link = $gal_link;
            } else {
                $attachment_link = get_permalink( get_the_ID() );       // link is to post
            }
        } else {
            $attachment_link = home_url( '/?attachment_id=' . $attachment_id );
            if ( $attachment_link == '' || $gal_link == 'file' )
                $attachment_link = $src;    // just use raw link if not available
        }

        $link_begin = '<a href="' . $attachment_link . '" alt="' . $title . '">';
        $link_end = '</a>';
    }

    $lead = atw_slider_set_pager_img( $attachment_id, $src, $lead_class, $lead_div . $title_div, $slider );


    $image_code .= $lead . $link_begin .
    '<img class="atw-gallery-img" src="' . $src . '" alt="' . $title . '" />' . $link_end . "\n";


    if ( $caption && atw_posts_get_slider_opt('showCaptions',$slider) ) {
        if ( $description
            && atw_posts_get_slider_opt('showDescription',$slider)
            && atw_posts_get_slider_opt( 'captionOverlay', $slider ) ) {        // move it to the top if description, too
            $image_code .= '<div class="atwk-caption-description">' . $caption . '</div>';
        } else {
            if ( atw_posts_get_slider_opt( 'captionOverlay', $slider ) )
                $image_code .= '<div class="atwk-caption-overlay">' . $caption . '</div>';
            else
                $image_code .= '<div class="atwk-caption">' . $caption . '</div>';
        }
    }

    if ( $description && atw_posts_get_slider_opt('showDescription',$slider) ) {
        $image_code .= '<div class="atwk-description">' . $description . '</div>';
    }
    $image_code .= "</div></div>\n";
    return $image_code;
}

// ====================================== >>> atw_slider_get_first_post_image <<< ======================================

function atw_slider_get_first_post_image( $content='', $slider,  $lead_class='class="atwk-slide"', $lead_div='<div class="slide-content slide-image">' ) {

    // We're getting this image from a post, so we will use the Post's Title and link to the post instead of the image.

    $use_post_info = true;

	// Priority 1: Featured Image

    if ( !atw_posts_get_slider_opt('fiOnlyforThumbs', $slider) && has_post_thumbnail() && !atw_posts_get_slider_opt( 'video', $slider) ) {
        $attachment_obj = get_post( get_post_thumbnail_id( ) );
        if (!empty( $attachment_obj ))
            return atw_slider_get_slide_image( $attachment_obj, $slider, $lead_class, $lead_div, '', $use_post_info);
	}

	if ($content == '')
		$content = get_the_content('');

    $content = do_shortcode(apply_filters( 'the_content', $content ));    // get images - even those generated by a shortcode

    // Priority 2: First image with an attachment class - e.g., wp-image-2793

    if ( preg_match('/wp-image-([\d]+)/', $content, $img_id) ) {        // look for the first image with an attachment
        $attachment_obj = get_post( $img_id[1] );
        if (!empty( $attachment_obj )) {
            $link = '';
            if ( atw_posts_get_slider_opt('inlineLink', $slider) && preg_match('/<a[^>]*href="([^"]*)"[^>]*>.*<\/a>/', $content, $img_link) )
                $link = $img_link[1];

            return atw_slider_get_slide_image( $attachment_obj, $slider, $lead_class, $lead_div, $link, $use_post_info);
        }
    }

    // Priority 3: any other image there

	if (preg_match('/<img[^>]+>/i',$content, $images)) {        // grab <img>s

		$src = '';
		if (preg_match('/src="([^"]*)"/', $images[0], $srcs)) {
			$src = $srcs[1];
		} else if (preg_match("/src='([^']*)'/", $images[0], $srcs)) {
			$src = $srcs[1];
		}

        $title_div = '';
        if ( atw_posts_get_slider_opt('showTitle',$slider) ) {
            $title_div = '<div class="' . atw_slider_get_title_class($slider) . '">' . the_title('','',false) . '</div>';
        }

        $lead = atw_slider_set_pager_img( null, $src, $lead_class, $lead_div . $title_div, $slider );

        if ( atw_posts_get_slider_opt( 'showLinks', $slider)) {
            return $lead . '<a href="' . get_permalink( get_the_ID() ) .
                    '"><img class="atw-gallery-img" src="' . $src . '" alt="post image" /></a></div></div>';
        }
        else {
            return $lead . '<img class="atw-gallery-img" src="' . $src . '" alt="post image" /></div></div>';
        }

	} else  { // assume post has a video or something else to show
        $title_div = '';
        if ( atw_posts_get_slider_opt('showTitle',$slider) ) {
            $title_div = '<div class="' . atw_slider_get_title_class($slider) . '">' . the_title('','',false) . '</div>';
        }

        $lead = atw_slider_set_pager_img( get_the_ID(), null, $lead_class, $lead_div . $title_div, $slider );

        return $lead . $content . '</div></div>';
    }
    return '';
}

// ====================================== >>> atw_slider_get_pager_img <<< ======================================

function atw_slider_set_pager_img( $id, $src, $lead_class, $lead_div, $slider ) {

    // find and set the slider image
    //echo '<!-- @@@@@@@@@@@@@ SET PAGER: ' . $id . '/' . $lead_class . '/' . $lead_div . '/' . $slider . '/' . $who . ' -->' . "\n";
    $lead = "\n<div ". $lead_class . '>'. $lead_div;

    $pager = atw_posts_get_slider_opt( 'pager', $slider );

    if ( $pager == 'thumbnails' || $pager == 'sliding' ) {          // set the pager image
        if ( $id == null )
            $id = get_the_ID();

        $thumbnail = image_downsize($id, 'thumbnail');

        //echo '<pre>'; print_r($thumbnail); echo '</pre>';
        $img = $thumbnail[0];
        if ( $img == '' ) {     // not at the first level
            if (has_post_thumbnail()) {
                $attachment_obj = get_post( get_post_thumbnail_id( ) );
                if (!empty( $attachment_obj )) {
                    $attachment_id = $attachment_obj->ID;
                    $thumbnail = image_downsize($attachment_id, 'thumbnail');
                    $img = $thumbnail[0];
                }
            }
        }

        if ($img == '')
            $img = $src;            // final fall back

        if ( $img == '' )
            $img = plugins_url('images/image-pager.png', __FILE__);


        if ( $pager == 'thumbnails' )
            $lead = "\n<div " . $lead_class . ' ' . 'data-thumb="' . $img . '">' . $lead_div;
        else
            $GLOBALS['atw_slider_thumbs'][] = $img;
    }
    return $lead;               //  return the $lead

}

// ====================================== >>> atw_slider_post_pager <<< ======================================
function atw_slider_post_pager($slider) {

    if ( atw_posts_get_slider_opt( 'pager', $slider ) != 'sliding')
        return;

    $id = get_the_ID();
    $thumbnail = image_downsize($id, 'thumbnail');

    $img = $thumbnail[0];
    if ( $img == '' ) {     // not at the first level
        if (has_post_thumbnail()) {
            $attachment_obj = get_post( get_post_thumbnail_id( ) );
            if (!empty( $attachment_obj )) {
                $attachment_id = $attachment_obj->ID;
                $thumbnail = image_downsize($attachment_id, 'thumbnail');
                $img = $thumbnail[0];
            }
        }
    }
    if ( $img == '' )
        $img = plugins_url('images/post-pager.png', __FILE__);
    $GLOBALS['atw_slider_thumbs'][] = $img;
}

// ====================================== >>> atw_slider_body_classes <<< ======================================

function atw_slider_body_classes( $classes ) {
	$classes[] = 'atwkloading';
	return $classes;
}

if ( function_exists('atw_posts_getopt') && atw_posts_getopt('showLoading')) {
        add_filter( 'body_class', 'atw_slider_body_classes' );
    }



// =============================>>> DEFINE UPDATES - Pro Only, but code must be here <<<============================
if ( ATW_SLIDER_PI_PRO ) {
		// load our custom updater
		require_once ( dirname( __FILE__ ) . '/includes/pro/atw-slider-pro-license.php' );

}
// ====================================== >>> atw_slider_kill_header_image <<< ======================================

/* function atw_slider_kill_header_image($args = '') {
    if ( !isset($GLOBALS['atw_slider_header'])) {
        $GLOBALS['atw_slider_header'] = true;   // only emit the code once.

        echo atw_slider_sc(array('name' => 'header'));
    }
    return 'remove-header';
}

add_filter( 'theme_mod_header_image' , 'atw_slider_kill_header_image');
*/

} else {    // !!!! Show Posts NOT installed !!!!!

    add_action('admin_menu', 'atw_slider_admin_menu');  // let them know they need show_posts

// ========================================= >>> atw_slider_admin_menu <<< ===============================

function atw_slider_admin_menu() {
       $page = add_menu_page(
	  'Aspen Slider by Aspen ThemeWorks','ATW Slider','install_plugins',
      'atw_slider_page', 'atw_slider_admin',plugins_url( '', __FILE__ ) .'/images/aspen-leaf.png',62);

	/* using registered $page handle to hook stylesheet loading for this admin page */

    add_action('admin_print_styles-'.$page, 'atw_slider_admin_scripts');
}

// ========================================= >>> atw_slider_admin <<< ===============================

function atw_slider_admin() {
    if ( !function_exists('atw_showposts_installed')) {
        echo '<h2>You must first install and activate the Aspen Themeworks Show Posts plugin!</h2>';
        if ( is_multisite() ) {
            echo '<h2 style="color:red;">IMPORTANT! This is a WP MultiSite Installation. You MUST follow these special instructions:</h2>';
            echo '<p>For MultiSite sites, you MUST disable ATW Show Sliders first. Then install and activate ATW Show Posts. After that, you
            can activate ATW Show Sliders. Both plugins must be activated the same way - either both network activated, or both per site activation.
            After in initial installation, sites with Per Site Activation can activate in any order.</p>';
        }

    }
}

// ========================================= >>> atw_slider_admin_scripts <<< ===============================

function atw_slider_admin_scripts() {
    /* called only on the admin page, enqueue our special style sheet here (for tabbed pages) */
    //wp_enqueue_style('atw_sw_Stylesheet', atw_slider_plugins_url('/atw-admin-style', ATW_SLIDER_PI_MINIFY . '.css'), array(), ATW_SLIDER_PI_VERSION);

}

if (current_user_can('activate_plugins')) {
    require_once((dirname( __FILE__ ) . '/includes/atw-activate-show-posts.php'));
}

}   // end Show Posts not installed
}   // end of plugins_loaded action
?>
