<?php

// ========================================= >>> atw_slider_shortcode <<< ===============================

function atw_slider_shortcode( $args = '' ) {
    $opts = array(
        'use_gallery' => false,
        'gallery_ids' => '',        // internal value for [gallery] replacement
        'name' => ''               // name is only "public" allowed argument
    );

    if ( !isset( $GLOBALS['atw_slider_recursion'] ) )
        $GLOBALS['atw_slider_recursion'] = true;
    else if ( $GLOBALS['atw_slider_recursion'] )
        return '<strong>Nesting error.</strong> This post has an instance of [show_posts] or [gallery] that is nested inside another instance of the shortcode. Nesting is not supported, only the outer instance will be displayed. ';



    extract(shortcode_atts($opts, $args));  // setup local vars


    if ( !function_exists( 'atw_showposts_installed')) {
        unset($GLOBALS['atw_slider_recursion']);
        return '<strong>ERROR with [atw_slider name="' . $name . '"]: Aspen Themeworks Show Posts Plugin not installed.</strong>';
    }

    if ( $name != 'default' && ($name == '' || atw_posts_get_slider_opt( 'name', $name ) == '') ) {
        unset($GLOBALS['atw_slider_recursion']);
        return '<strong>ERROR with [atw_slider name="' . $name . '"]: You must specify a valid slider name.</strong>';
    }

    $filter = atw_posts_get_slider_opt( 'selected_slider_filter', $name);
    if ($filter == '')
        $filter = 'default';

    $fname = atw_posts_get_filter_opt( 'slug', $filter);
    if ($fname == '')
        $fname = 'default';
    $content = '';
    $lead = '';
    $prestyle = '';

    if ( $fname != $filter && $filter != 'default') {
        unset($GLOBALS['atw_slider_recursion']);
        return '<strong>ERROR with [atw_slider name="' . $name . '"]: Slider does not have a valid filter (' . $filter . '/'. $fname . ') set in options.</strong>';
    }

    // -- ok - we will be generating a slider

    if ( !isset($GLOBALS['atw_sliders_count']) ) {
        $GLOBALS['atw_sliders_count'] = 1;
        $GLOBALS['atw_slider_names'] = array();
        $GLOBALS['atw_slider_names'][1] = $name;
    }
    else {
        $GLOBALS['atw_sliders_count']++;
        $GLOBALS['atw_slider_names'][$GLOBALS['atw_sliders_count']] = $name;
    }

    if ( !isset($GLOBALS['atw_slider_names' . $name]) ) {
        $GLOBALS['atw_slider_names' . $name] = 1;       // first time for this slider
        $prestyle .= atw_slider_emit_css( $name );          // emit inline CSS for this slider
    } else {
        $GLOBALS['atw_slider_names' . $name]++;         // bump slider
    }

    $slide_num = $GLOBALS['atw_sliders_count'];
    $class_name = 'atwkslider-' . $name ;
    $id = $class_name . '-' . $slide_num;

    $type = atw_posts_get_slider_opt('slider_type', $name);
    $carousel = '';

    if ($type == 'slide') {   // add carousel class if a carousel
        $carousel = ' carousel';
    }

    $content_type = ' slider-content-' .  atw_posts_get_slider_opt( 'content_type', $name );


    $lead .= '<div id="' . $id . '" class="atwkslider ' . $class_name . $content_type . $carousel . '"><div class="slides">' . "\n";
    $tail = "</div></div><!-- atwslider -->\n";

    $slider_post_slug = atw_posts_get_slider_opt( 'slider_post_slug', $name);

    if ( $use_gallery ) {
        $content .= atw_slider_show_slider_gallery( $name, $gallery_ids );      // for [gallery] replacement
    } elseif ($slider_post_slug != '') {
        $content .= atw_slider_show_slider_post( $name, $slider_post_slug);     // if has slider_post specified explicitly
    }
    else {              // posts slider
        $content .= atw_show_posts_sc(array( 'slider' => $name, 'filter' => $filter));  // use filter
    }

    // add slider thmumnail - above or below

    $sliding = '';
    if (atw_posts_get_slider_opt('pager', $name) == 'sliding' && !empty($GLOBALS['atw_slider_thumbs'])) {
        $above = '';
        if ( atw_posts_get_slider_opt('slidingAbove') )
            $above = '-above';
        $slide_num = $GLOBALS['atw_sliders_count'];
        $class = 'atwkslider-' . $name;
        $id = $class . '-' . $slide_num;
        $sliding = "<div id='{$id}-thumbs' class='atwkslider {$class}-thumbs atwk-content-thumbs{$above}'><div class='slides'>\n";

        foreach ($GLOBALS['atw_slider_thumbs'] as $thumb ) {
            $sliding .= '<div class="atwk-slide"><img src="' .  $thumb . '" /></div>' . "\n";
        }
        $sliding .= "</div></div><!-- $id -->\n";
    }


    unset($GLOBALS['atw_slider_recursion']);

    if ( atw_posts_get_slider_opt('slidingAbove') )
        return $prestyle . $sliding . $lead .  $content . $tail;
    else
        return $prestyle . $lead .  $content . $tail . $sliding;
}

// ========================================= >>> atw_slider_show_slider_post <<< ===============================

function atw_slider_show_slider_post( $slider, $slider_post_slug ) {
    // bypass all the show_posts code, and disply a single post directly

    if ( $slider && atw_posts_get_slider_opt( 'content_type', $slider ) == 'images' ) {
        $slider_post = new WP_Query(array( 'post_type' => 'atw_slider_post', 'name' => $slider_post_slug ));
        if ( !empty( $slider_post ) ) {
            ob_start();
            atw_slider_do_gallery( $slider_post, $slider );
            // reset stuff
            wp_reset_query();
            wp_reset_postdata();
            atw_trans_clear_all();
            $content = ob_get_clean();	// get the output
            return $content;
        }
    }
    return '<strong>[show_slider slider=' . $slider . ' slider_post_slug=' . $slider_post_slug . '] improperly set up.</strong>';

}


// ========================================= >>> atw_slider_show_slider_gallery <<< ===============================

function atw_slider_show_slider_gallery ( $slider, $ids ) {
    // bypass all the show_posts code, and disply a gallery list

    if ( $slider  && atw_posts_get_slider_opt( 'content_type', $slider ) == 'images' ) {
        ob_start();
        atw_slider_do_gallery( null, $slider, $ids );

        atw_trans_clear_all();
        $content = ob_get_clean();	// get the output
        return $content;

    }
    return '<strong>ATW [gallery] improperly set up. Must specify Slider with content type Images.</strong>';
}

// ========================================= >>> atw_slider_emit_css <<< ===============================

function atw_slider_emit_css( $name ) {
    // emit in-body CSS for this slider
    $css = '';
    $lead = "\n<style type='text/css'><!-- $name -->\n";
    $my_class = '.atwkslider-' . $name;

    $img_class = '.slide-image';
    if (atw_posts_get_slider_opt( 'addImageBorder', $name ))
        $img_class = '.slide-image-border';

    $margin = atw_posts_get_slider_opt( 'slideMargin', $name );   // margin around

    if ( $margin != '' ) {
        $css .= $my_class . ' .slides .atwk-slide ' . $img_class . ' .atwk-title-overlay{left:' . $margin
             . 'px!important;top:' . $margin . "px!important;}\n";
        $css .= $my_class . ' .atwk-caption-overlay{right:' . $margin . 'px!important;bottom:' . $margin . "px!important;}\n";
        $css .= $my_class . ' .slide-content{margin:' . $margin . "px!important;}\n";
        if ( !atw_posts_get_slider_opt( 'topNavArrows', $name ) ) {     // topNavArrows code will adjust left/right if it is used
            $next = $margin;
            $prev = $next;

            $css .= $my_class . ':hover .atwk-prev {left:' . $prev . 'px;}';
            $css .= $my_class . ':hover .atwk-next {right: ' . $next . 'px;}';
        }
    }

    if ( atw_posts_get_slider_opt('showDescription',$name) ) {  // we might show description
        if ( $margin != '') {
            $css .= $my_class . ' .atwk-caption-description{right:' . $margin . '!important;top:' . $margin . "!important;max-width:58%!important;background:none!important;}\n";
        }
    } else {
        $css .= $my_class . ' .slides .atwk-slide ' . $img_class . ' .atwk-title-overlay{max-width:75%}' . "\n";
    }

    if ( atw_posts_get_slider_opt(  'fullWidthImages' , $name)) {
        $css .= $my_class . ' .slides .atwk-slide ' . $img_class . " img {width:100%;}\n";
    }

    if ( atw_posts_get_slider_opt( 'maxImageHeight', $name) ) {
        $height = atw_posts_get_slider_opt( 'maxImageHeight', $name);
        if ( atw_posts_get_slider_opt(  'fullWidthImages' , $name) ) {
            $css .= $my_class .  ' .slides .atwk-slide {max-height:' . $height . "px;overflow:hidden;}\n";  // clip vertical images
        } else {
            $css .= $my_class .  ' .slides .atwk-slide img{max-height:' . $height . "px;}\n";
        }
    }


    if ( atw_posts_get_slider_opt( 'hideBorder', $name) ) {
        $css .= $my_class . "{-webkit-box-shadow:none;-moz-box-shadow:none;-o-box-shadow:none;box-shadow:none;}\n";
        $style = '';
    }

    if ( ($bg = atw_posts_get_slider_opt( 'sliderColor', $name)) != '' ) {
        $css .= $my_class . '{background-color:' . $bg . ";}\n";
    }

    if ( atw_posts_get_slider_opt( 'sliderWidth', $name)) {    // make it not take full width
        $width = atw_posts_get_slider_opt ( 'sliderWidth', $name);
        $css .= $my_class . ',' . $my_class . '-thumbs{width:' . $width . '%;';
        $position = atw_posts_get_slider_opt( 'sliderPosition', $name);
        switch ( $position ) {
            case 'right':
                $css .= 'margin-left:auto;';
                break;
            case 'center':
                $css .= 'margin-left:auto;margin-right:auto;';
                break;
            case 'floatLeft':
                $css .= 'float:left;';
                break;
            case 'floatRight':
                $css .= 'float:right;';
                break;
            default;
                break;
        }
        $css .= "}\n";
    }

    if ( atw_posts_get_slider_opt( 'widthThumbs', $name) != '' ) {

        $widthThumbs = (float) atw_posts_get_slider_opt( 'widthThumbs', $name);
        $widthSlider = atw_posts_get_slider_opt ( 'sliderWidth', $name);
        if ( $widthSlider ) {
            $widthThumbs = (float) ($widthSlider * ($widthThumbs / 100.0 ));
        }
        $rule = sprintf("{max-width:%.3f%%;margin-left:auto;margin-right:auto;}\n", $widthThumbs );
        $css .= $my_class . '-thumbs' . $rule;
    }

    if ( atw_posts_get_slider_opt( 'numberThumbs', $name) ) {
        $num_thumbs = atw_posts_get_slider_opt( 'numberThumbs', $name);
        $percent =  100.0 / (float) $num_thumbs;
        $css .= $my_class . sprintf(" .atwk-control-thumbs li {width: %.3f%%;}\n", $percent);
    }

    if ( atw_posts_get_slider_opt( 'maxHeightThumbs', $name) ) {
        $max_h = atw_posts_get_slider_opt( 'maxHeightThumbs', $name);
        $css .= $my_class . ' .atwk-control-thumbs li{max-height:' . $max_h . "px;overflow:hidden;}\n";
        $css .= $my_class . '-thumbs .atwk-slide{max-height:' . $max_h . "px;overflow:hidden;}\n";
    }



    if ( atw_posts_get_slider_opt( 'borderThumbs', $name ) ) {
        $bwidth = atw_posts_get_slider_opt( 'borderThumbs', $name );
        $css .= $my_class . ' .atwk-control-thumbs img,' . $my_class . '-thumbs .slides .atwk-slide img{border:' . $bwidth . "px solid transparent;}\n";
    }

    if ( atw_posts_get_slider_opt( 'noDimThumbs', $name) ) {   // don't dim, so instead dim hover
        $css .= $my_class . '-thumbs.atwk-content-thumbs img,' . $my_class . " .atwk-control-thumbs img{opacity:1;}\n";
        $css .= $my_class . '-thumbs.atwk-content-thumbs img:hover,' . $my_class . " .atwk-control-thumbs img:hover{opacity:.7;}\n";
    }

    if ( atw_posts_get_slider_opt( 'postHeight', $name) ) {
        $height = atw_posts_get_slider_opt( 'postHeight', $name);
        $css .= $my_class . ' .slides .atwk-slide .slide-post{max-height:' . $height . "px;overflow:auto;}\n";
    }

    if (atw_posts_get_slider_opt( 'pager', $name ) == 'none') {
        $css .= $my_class . '.atwkslider{margin-bottom:0;}';
    }

    if (atw_posts_get_slider_opt( 'disableArrowSlide', $name) ) {   // before alwaysShowArrows & topNavArrows
        if ($margin == '')
            $margin = 5;
        $next = $margin - 5;
        $prev = $next;
        $css .= $my_class . ' .atwk-direction-nav .atwk-next{background-position: 100% 0;right:' . $next . 'px;}';
        $css .= $my_class . ' .atwk-direction-nav .atwk-prev{left:' . $prev . 'px;}';

        $css .= $my_class . '-thumbs .atwk-direction-nav .atwk-prev{left:0px;}';
        $css .= $my_class . '-thumbs .atwk-direction-nav .atwk-next{right:0px;}';
    }

    if ( atw_posts_get_slider_opt( 'alwaysShowArrows', $name) ) {
        if ($margin == '')
            $margin = 5;
        $next = $margin - 5;
        $prev = $next;
        $css .= $my_class . ' .atwk-direction-nav .atwk-next{opacity:1;right:' . $next . 'px;}';
        $css .= $my_class . ' .atwk-direction-nav .atwk-prev{opacity:1;left:' . $prev . 'px;}';
        $css .= $my_class . ':hover .atwk-prev{opacity:.8;left:' . $prev . 'px;}';
        $css .= $my_class . ':hover .atwk-next{opacity:.8;right: ' . $next . 'px;}';

        $css .= $my_class . '-thumbs .atwk-direction-nav .atwk-prev{opacity:1;left:0px;}';
        $css .= $my_class . '-thumbs .atwk-direction-nav .atwk-next{opacity:1;right:0px;}';
        $css .= $my_class . '-thumbs:hover .atwk-prev{opacity:.8;left:0px;}';
        $css .= $my_class . '-thumbs:hover .atwk-next{opacity:.8;right:0px;}';
    }



    if ( atw_posts_get_slider_opt( 'topNavArrows', $name ) ) {    // top right nav
        if ($margin == '')
            $margin = 5;

        $next = $margin - 5;
        $prev = $next + 55;

        if ( atw_posts_get_slider_opt( 'showTitle', $name) && !atw_posts_get_slider_opt('titleOverlay', $name ) ) {
            $top = 13;
        } else {
            $top = 16 + $margin;
        }
        $css .= $my_class . ' .atwk-direction-nav a {top:' . $top . 'px;}';
        $css .= $my_class . ' .atwk-direction-nav .atwk-next {opacity:1;right:' . $next . 'px;}';
        $css .= $my_class . ' .atwk-direction-nav .atwk-prev {opacity:1;right:' . $prev . 'px;left:auto;}';
        $css .= $my_class . ':hover .atwk-prev {opacity:.8;right:' . $prev . 'px;left:auto;}';
        $css .= $my_class . ':hover .atwk-next {opacity:.8;right: ' . $next . 'px;}';
    }

    if ( atw_posts_get_slider_opt( 'navArrows', $name ) != '' ) {
        $arrow = atw_posts_get_slider_opt( 'navArrows', $name );
        $src = atw_slider_plugins_url('/flex/images/nav-') . $arrow . '.png';

        $css .= $my_class . ' .atwk-direction-nav a,' . $my_class
             . '-thumbs .atwk-direction-nav a {background:url(' . $src . ') no-repeat 0 0;}';
        $css .= $my_class . ' .atwk-direction-nav .atwk-next,' . $my_class
             . '-thumbs .atwk-direction-nav .atwk-next  {background-position: 100% 0;}';
    }

    // finally, the per slider custom CSS
    $custom_css = atw_posts_get_slider_opt('sliderCustomCSS',$name);
    if ($custom_css != '') {
        $css .= "\n" . str_replace('.this-slider', $my_class, $custom_css);
    }


    if ( $css )
        return $lead . $css . "\n</style>\n";
    else
        return '';
}

// ========================================= >>> atw_slider_do_footer <<< ===============================

function atw_slider_do_footer() {
    echo "<!-- ATW Slider -->\n";

    if ( !isset($GLOBALS['atw_sliders_count']) ) {   // did we have sliders?
        return;
    }

    echo '<script type="text/javascript">jQuery(window).ready(function() {' . "\n";

    $sliders_count = $GLOBALS['atw_sliders_count'];

    for ($i = 1 ; $i <= $sliders_count ; $i++) {
        $name = $GLOBALS['atw_slider_names'][$i];

        $slider_type = atw_posts_get_slider_opt( 'slider_type', $name );
        $content_type = atw_posts_get_slider_opt( 'content_type', $name);
        $pager = atw_posts_get_slider_opt( 'pager', $name );

        $id = 'atwkslider-' . $name . '-' . $i;

        if ($pager == 'sliding' ) {     // emit the slider pager js first - required to make slider-pager sync correctly
            $slides = 6;
            if ( atw_posts_get_slider_opt( 'numberThumbs', $name) ) {
                $slides = atw_posts_get_slider_opt( 'numberThumbs', $name);
            }
            echo 'jQuery("#' . $id . '-thumbs").flexslider({namespace: "atwk-",selector:".slides > .atwk-slide", animation:"slide",controlNav:false,';

            //atw_slider_echo_opt_tf( 'no_animationLoop', $name, false );
            echo 'slideshow:false,animationLoop:true,itemWidth:150,minItems:' . $slides . ',maxItems:' . $slides .',itemMargin:0,asNavFor:"#' . $id . '" });' . "\n";
        }


        $fitvids = atw_posts_get_slider_opt( 'video' , $name) ? '.fitVids()' : '';
        echo 'jQuery("#' . $id . '")'. $fitvids . '.flexslider({namespace: "atwk-", selector:".slides > .atwk-slide",';     // flexslider args go here..
        if ( $slider_type == 'fader')
            echo 'animation:"fade",';
        else
            echo 'animation:"slide",';

        if ( $slider_type == 'carousel') {
            atw_slider_echo_opt_val( 'minItems', $name, '4' );
            atw_slider_echo_opt_val( 'maxItems', $name, '4' );
            atw_slider_echo_opt_val( 'itemWidth', $name, '250' );
            atw_slider_echo_opt_val( 'move', $name, '0');
        }

        //@@@@@echo 'video:true,useCSS:false,';            // for whatever reason, always want video true


        if ( $pager == 'none')                           // dotted pager is default
            echo 'controlNav:false,';                    // turn off for none
        else if ($pager == 'sliding') {
            echo 'controlNav:false,';    // sliding carousel
            echo 'sync:"#' . $id .'-thumbs",';
        }
        else if ($pager == 'thumbnails' && $slider_type != 'carousel' && $content_type != 'posts') { // no thumbnails for carousel or posts - don't really look right
            echo 'controlNav:"thumbnails",';                        // if thumbnails
        }

        if ($pager != 'thumbnails' && $slider_type != 'carousel') {
            atw_slider_echo_opt_tf( 'smoothHeight', $name, false );
        }

        atw_slider_echo_opt_tf( 'pausePlay', $name, false );

        atw_slider_echo_opt_tf( 'no_slideshow', $name, false );
        atw_slider_echo_opt_tf( 'no_animationLoop', $name, false );


        if ( $slider_type == 'slider' && atw_posts_get_slider_opt ( 'directionVertical', $name) != '' )
            echo 'direction:"vertical",';

        atw_slider_echo_opt_tf( 'no_directionNav', $name, false );
        atw_slider_echo_opt_text( 'easing', $name );
        atw_slider_echo_opt_tf( 'reverse', $name, false );


        atw_slider_echo_opt_tf( 'randomize', $name, false );
        atw_slider_echo_opt_tf( 'mousewheel', $name, false );
        atw_slider_echo_opt_tf( 'no_pauseOnHover', $name, false);

        atw_slider_echo_opt_tf( 'no_pauseOnAction', $name, false); // doesn't seem to work or do anything useful
        // atw_slider_echo_opt_tf( 'no_allowOneSlide', $name );


        atw_slider_echo_opt_val( 'startAt', $name );
        atw_slider_echo_opt_val( 'slideshowSpeed', $name, 5000 );  /* change default to 5 seconds - 7 is too long */
        atw_slider_echo_opt_val( 'animationSpeed', $name );
        atw_slider_echo_opt_val( 'initDelay', $name );

        if ( atw_posts_getopt('showLoading') ) {
            echo "start: function(slider){jQuery('body').removeClass('atwkloading');}});\n";
        } else {
            echo "start: function(){}});\n";
        }

    }

    echo '});</script>'. "\n";

}

// ========================================= >>> atw_gallery_shortcode_filter <<< ===============================
function atw_gallery_shortcode_filter( $args = '' ) {
    $opts = array(
        'ids' => '',
        'orderby' => ''
    );

    extract(shortcode_atts($opts, $args));  // setup local vars

    // find out if we have a slider definition set for galleries

    $slider = atw_posts_getopt('gallery_slider');

    if ( $slider == '')
        $slider = 'default';

    if ( $orderby == 'rand' ) {
        // set 'randomize' @@@@@@@@@@@@@@
    }

    // @@@@@ set auto-vertical size to true...

    if ($ids != '' )
        $imgs = explode( ',', $ids);
    else
        $imgs = null;

    return atw_slider_shortcode( array ('name' => $slider, 'use_gallery' => true, 'gallery_ids' => $imgs) );

}

// ========================================= >>> echo helpers <<< ===============================

function atw_slider_echo_opt_val( $opt, $name, $def = '') {
    $val = atw_posts_get_slider_opt( $opt, $name );
    if ( $val != '' ) {
        echo $opt . ':' . $val . ',';
    } elseif ( $def != '' ) {
        echo $opt . ':' . $def . ',';
    }
}

function atw_slider_echo_opt_text( $opt, $name, $def = '') {
    $val = atw_posts_get_slider_opt( $opt, $name );
    if ( $val != '' ) {
        echo $opt . ':"' . $val . '",';
    } elseif ( $def != '' ) {
        echo $opt . ':"' . $def . '",';
    }
}

function atw_slider_echo_opt_tf( $opt, $name, $def = false) {

    $val = atw_posts_get_slider_opt( $opt, $name );
    if ( strpos($opt, 'no_') !== false) {
        $opt_out = substr($opt, 3);
        if ( $val != '' ) {
            echo $opt_out . ':false,';
        } elseif ( $def ) {
            echo $opt_out . ':false,';
        } else {
            echo $opt_out . ':true,';
        }
    } else {
        if ( $val != '' ) {
            echo $opt . ':true,';
        } elseif ( $def ) {
            echo $opt . ':true,';
        } else {
            echo $opt . ':false,';
        }
    }
}
?>
