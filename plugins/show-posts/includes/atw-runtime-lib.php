<?php

// # Aspen SW Globals ==============================================================
$atw_posts_opts_cache = false;	// internal cache for all settings

function atw_posts_get_filter_params( $filter = '') {
    if ($filter == '')
        $filter = atw_posts_getopt('current_filter');

    $params = '';

    $full_opts = array ( 'post_type','category_name','tag','author','taxonomy','date','atw_slider_group', 'wp_query_args',
                        );
    foreach ($full_opts as $opt) {
        if ( ($par = atw_posts_get_filter_opt($opt,$filter)) != '')
            $params .= ' ' . esc_textarea($par);
    }


    $val_opts = array ('cols', 'excerpt_length', 'more_msg', 'offset', 'order', 'orderby', 'post_ids', 'posts_per_page',
                       'post_slug', 'show', 'show_sticky_posts',
                );

    foreach ($val_opts as $opt) {
        if ( ($par = atw_posts_get_filter_opt( $opt, $filter )) != '') {

            if (      ($opt == 'orderby' && $par == 'date')    // ignore defaults
                  ||  ($opt == 'order' && $par == 'DESC')
               ) {
                continue;
            }
            if ( $opt == 'show_sticky_posts') {
                if ( $par ) {
                    $params .= ' ' . 'ignore_sticky_posts=0';
                }
            } else if ( $opt == 'more_msg' ) {
                $params .= ' ' . $opt . '="' . esc_textarea(addslashes($par)) . '"';
            } else {
                $params .= ' ' . $opt . '=' . esc_textarea($par);
            }
        }
    }

    $check_opts = array ('hide_bottom_info','hide_featured_image','hide_title', 'hide_top_info', 'show_avatar', 'use_paging',
                );

    foreach ($check_opts as $opt) {
        if ( ($par = atw_posts_get_filter_opt($opt,$filter)))
            $params .= ' ' . $opt . '=true';
    }


    return $params;
}

// ====================================== >>> atw_posts_get_qargs <<< ======================================

function atw_posts_get_qargs( $args, $opts ) {

    // Build the qargs array for the WP_Query for the show post from the args supplied to the shortcode
    // 1. convert any 'friendly' args to WP_Query args
    // 2. strip out non-WP_Query args
    // 3. Fix up any others (e.g., post_type) that might need array() or - (not) handling
    // needs to be here for integration with Aspen/Weaver

    if (is_array($args)) {
        $qargs = $args;
    } else {
        return array();     // no args supplied - everything is default
    }

    foreach ($opts as $opt => $val) {
        unset( $qargs[$opt]) ;  // clear out our options
    }


    // ---------------------- fixup values that we want to enhance -----------------------------

    if ( isset( $qargs['post_type'] ) ) {       // allow array()
       $qargs['post_type'] = explode(',',$qargs['post_type']);  // make array form
    }

    if (isset($qargs['category_name'])) {       // move these to cat to support '-' not operator
        $cat = atw_posts_cat_slugs_to_ids($qargs['category_name']);
        unset( $qargs['category_name']);
        if ( isset( $qargs['cat'] ) )
            $qargs['cat'] .= $cat;
        else
            $qargs['cat'] = $cat;
    }

    if ( isset($args['use_paging']) && $args['use_paging']) {         // convert "friendly" use_paging

        if ( get_query_var( 'paged' ) )
            $qargs['paged'] = get_query_var('paged');
        else if ( get_query_var( 'page' ) )
            $qargs['paged'] = get_query_var( 'page' );
        else
            $qargs['paged'] = 1;
    }

    if ( isset($qargs['date'] )) {              // convert "friendly" date values
        switch ($qargs['date']) {
            case 'today':
                $today = getdate();
                $qargs['year'] = $today['year'] . '&monthnum=' . $today['mon'] . '&day=' . $today['mday'];
                break;
            case 'past-24h':
                $qargs['date_query'] = array ( array ('column' => 'post_date_gmt','after'=>'1 day ago'));
                break;
            case 'this-week':
                $qargs['year'] = date('Y') . '&w=' . date('W');
                break;
            case 'past-week':
                $qargs['date_query'] = array ( array ('column' => 'post_date_gmt','after'=>'1 week ago'));
                break;
            case 'this-month':
                break;
            case 'past-30d':
                $qargs['date_query'] = array ( array ('column' => 'post_date_gmt','after'=>'1 month ago'));
                break;
            case 'this-year':
                $qargs['year'] = date('Y');
                break;
            case 'past-365d':
                $qargs['date_query'] = array ( array ('column' => 'post_date_gmt','after'=>'1 month ago'));
                break;
            default:
                break;
        }
        unset( $qargs['date'] );
    }

    if ( isset( $qargs['post_ids'] ) ) {    // change list to array

        $ids = str_replace( ' ', '', $qargs['post_ids'] );  // clean up
        $id_list = explode( ',', $ids );                    // put into an array
        $qargs['post__in'] = $id_list;
        $qargs['orderby'] = 'post__in';
        unset ( $qargs['post_ids'] );
    }

    if ( isset( $qargs['post_slug'] ) ) {
        $qargs['name'] = $qargs['post_slug'];
        unset( $qargs['post_slug'] );
    }

    if ( !isset( $qargs['ignore_sticky_posts']) )   // igonre sticky posts by default
        $qargs['ignore_sticky_posts'] = 1;

    return $qargs;
}


// ====================================== >>> atw_posts_cat_slugs_to_ids <<< ======================================

function atw_posts_cat_slugs_to_ids($cats) {
	if (empty($cats)) return '';
	// now convert slugs to numbers
	$cats = str_replace(' ','',$cats);
	$clist = explode(',',$cats);        // break into a list
	$cat_list = '';
	foreach ($clist as $slug) {
		$neg = 1;       // not negative
		if ($slug[0] == '-') {
			$slug = substr($slug,1);    // zap the -
			$neg = -1;
		}
		if (strlen($slug) > 0 && is_numeric($slug)) { // allow both slug and id
			$cat_id = $neg * (int)$slug;
			if ($cat_list == '') $cat_list = strval($cat_id);
			else $cat_list .= ','.strval($cat_id);
		} else {
			$cur_cat = get_category_by_slug($slug);
			if ($cur_cat) {
				$cat_id = $neg * (int)$cur_cat->cat_ID;
				if ($cat_list == '') $cat_list = strval($cat_id);
				else $cat_list .= ','.strval($cat_id);
			}
		}
	}
	if (empty($cat_list)) $cat_list='99999999';
	return $cat_list;
}


// ===============================  options =============================

function atw_posts_getopt($opt) {
    global $atw_posts_opts_cache;
    if (!$atw_posts_opts_cache) {
        $atw_posts_opts_cache = get_option('atw_posts_settings' ,array());
    }

    if (!isset($atw_posts_opts_cache['current_filter'])) {
        $atw_posts_opts_cache['current_filter'] = 'default';
        $atw_posts_opts_cache['filters']['default'] = array();
        $atw_posts_opts_cache['filters']['default']['name'] = 'Default Filter';
        $atw_posts_opts_cache['filters']['default']['slug'] = 'default';
        atw_posts_wpupdate_option('atw_posts_settings',$atw_posts_opts_cache);
    }
    if (!isset($atw_posts_opts_cache['current_slider'])) {
        $atw_posts_opts_cache['current_slider'] = 'default';
        $atw_posts_opts_cache['sliders']['default'] = array();
        $atw_posts_opts_cache['sliders']['default']['name'] = 'Default Slider';
        $atw_posts_opts_cache['sliders']['default']['slug'] = 'default';
        atw_posts_wpupdate_option('atw_posts_settings',$atw_posts_opts_cache);
    }

    if (!isset($atw_posts_opts_cache[$opt]))	// handles changes to data structure
      {
        return false;
      }
    return $atw_posts_opts_cache[$opt];
}

function atw_posts_setopt($opt, $val, $save = true) {
    global $atw_posts_opts_cache;
    if (!$atw_posts_opts_cache)
        $atw_posts_opts_cache = get_option('atw_posts_settings' ,array());

    if (!isset($atw_posts_opts_cache['current_filter'])) {
        $atw_posts_opts_cache['current_filter'] = 'default';
        $atw_posts_opts_cache['filters']['default'] = array();
        $atw_posts_opts_cache['filters']['default']['name'] = 'Default Filter';
        $atw_posts_opts_cache['filters']['default']['slug'] = 'default';
        atw_posts_wpupdate_option('atw_posts_settings',$atw_posts_opts_cache);
    }
    if (!isset($atw_posts_opts_cache['current_slider'])) {
        $atw_posts_opts_cache['current_slider'] = 'default';
        $atw_posts_opts_cache['sliders']['default'] = array();
        $atw_posts_opts_cache['sliders']['default']['name'] = 'Default Slider';
        $atw_posts_opts_cache['sliders']['default']['slug'] = 'default';
        $atw_posts_opts_cache['sliders']['default']['selected_slider_filter'] = 'default';
        atw_posts_wpupdate_option('atw_posts_settings',$atw_posts_opts_cache);
    }

    $atw_posts_opts_cache[$opt] = $val;
    if ($save)
        atw_posts_wpupdate_option('atw_posts_settings',$atw_posts_opts_cache);
}

function atw_posts_delete_filter_opts($filter) {
    global $atw_posts_opts_cache;
    if (!$atw_posts_opts_cache)
        $atw_posts_opts_cache = get_option('atw_posts_settings' ,array());

    unset( $atw_posts_opts_cache['filters'][$filter]);
    $atw_posts_opts_cache['current_filter'] = 'default';   // switch to default
    if ( $filter == 'default' ) {                            // clear default settings...
        $atw_posts_opts_cache['filters']['default'] = array();
        $atw_posts_opts_cache['filters']['default']['name'] = 'Default Filter';
        $atw_posts_opts_cache['filters']['default']['slug'] = 'default';
    }

    atw_posts_wpupdate_option('atw_posts_settings',$atw_posts_opts_cache);
}

function atw_posts_get_filter_opt($opt, $current_filter = '') {    // get a filter value
    global $atw_posts_opts_cache;

    if ($current_filter == '')
        $current_filter = atw_posts_getopt('current_filter');

    // echo '<pre>Get filter opt: ' . $opt . '  '; print_r($atw_posts_opts_cache); echo '</pre>';

    if (!isset($atw_posts_opts_cache['filters'][$current_filter][$opt]))	// handles changes to data structure
      {
        return false;
      }
    return $atw_posts_opts_cache['filters'][$current_filter][$opt];
}

function atw_posts_set_filter_opt($opt, $val, $current_filter = '', $save = true) {    // set a filter value
    global $atw_posts_opts_cache;

    if ($current_filter == '')
        $current_filter = atw_posts_getopt('current_filter');

    $atw_posts_opts_cache['filters'][$current_filter][$opt] = $val;
    if ($save)
        atw_posts_wpupdate_option('atw_posts_settings',$atw_posts_opts_cache);
}


//----
function atw_posts_delete_slider_opts($slider) {
    global $atw_posts_opts_cache;
    if (!$atw_posts_opts_cache)
        $atw_posts_opts_cache = get_option('atw_posts_settings' ,array());

    unset( $atw_posts_opts_cache['sliders'][$slider]);
    $atw_posts_opts_cache['current_slider'] = 'default';   // switch to default
    if ( $slider == 'default' ) {                            // clear default settings...
        $atw_posts_opts_cache['sliders']['default'] = array();
        $atw_posts_opts_cache['sliders']['default']['name'] = 'Default slider';
        $atw_posts_opts_cache['sliders']['default']['slug'] = 'default';
        $atw_posts_opts_cache['sliders']['default']['selected_slider_filter'] = 'default';
    }

    atw_posts_wpupdate_option('atw_posts_settings',$atw_posts_opts_cache);
}

function atw_posts_get_slider_opt($opt, $current_slider = '') {    // get a slider value
    global $atw_posts_opts_cache;

    if ($current_slider == '')
        $current_slider = atw_posts_getopt('current_slider');

    // echo '<pre>Get slider opt: ' . $opt . '  '; print_r($atw_posts_opts_cache); echo '</pre>';

    if (!isset($atw_posts_opts_cache['sliders'][$current_slider][$opt]))	// handles changes to data structure
      {
        return false;
      }
    return $atw_posts_opts_cache['sliders'][$current_slider][$opt];
}

function atw_posts_set_slider_opt($opt, $val, $current_slider = '', $save = true) {    // set a slider value
    global $atw_posts_opts_cache;

    if ($current_slider == '')
        $current_slider = atw_posts_getopt('current_slider');

    $atw_posts_opts_cache['sliders'][$current_slider][$opt] = $val;
    if ($save)
        atw_posts_wpupdate_option('atw_posts_settings',$atw_posts_opts_cache);
}


//----

function atw_posts_save_all_options() {
    global $atw_posts_opts_cache;
    if ($atw_posts_opts_cache) // don't save anyting if we have nothing to save yet.
        atw_posts_wpupdate_option('atw_posts_settings',$atw_posts_opts_cache);
}

function atw_posts_delete_all_options() {
    global $atw_posts_opts_cache;
    $atw_posts_opts_cache = false;
    if (current_user_can( 'manage_options' ))
        delete_option( 'atw_posts_settings' );
}

function atw_posts_wpupdate_option($name, $opts) {
    if (current_user_can( 'manage_options' )) {
        update_option($name, $opts);
    }
}

// ====================================== >>> atw_posts_is... <<< ======================================
function atw_posts_is_aspen() {
    return function_exists( 'aspen_setup' );
}

function atw_posts_is_wii() {
    return function_exists( 'weaverii_setup' );
}

function atw_posts_is_generic() {
    // version for a generic theme
    return !function_exists( 'aspen_setup' ) && !function_exists( 'weaverii_setup' );
}

function atw_posts_theme_has_templates() {
    // see if the current theme has a content.php template
    $templates = array();
    $templates[] = 'content.php';           // see if the theme has a content.php file, assume it works as expected...
    return locate_template($templates) != '';
}

// ====================================== >>> transient options <<< ======================================

if (!function_exists('atw_tran_globals')) {
function atw_tran_globals($glb = 'aspen_temp_opts') {
    return isset($GLOBALS[$glb]) ? $GLOBALS[$glb] : '';
}
}

if (!function_exists('atw_trans_set')) {
function atw_trans_set($opt, $val) {
    $GLOBALS['aspen_temp_opts'][$opt] = $val;
    if ( function_exists( 'weaverii_sc_setopt' ))
        weaverii_sc_setopt( $opt, $val);
}
}

if (!function_exists('atw_trans_get')) {
function atw_trans_get($opt) {
    if ( function_exists( 'weaverii_sc_getopt' ))
        weaverii_sc_getopt( $opt);
    return isset($GLOBALS['aspen_temp_opts'][$opt]) ? $GLOBALS['aspen_temp_opts'][$opt] : '';
}
}

if (!function_exists('atw_trans_clear_all')) {
function atw_trans_clear_all() {
    unset($GLOBALS['aspen_temp_opts']);
    if ( function_exists( 'weaverii_sc_reset_opts' ) )
        weaverii_sc_reset_opts();
}
}

?>
