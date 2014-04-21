<?php
// ========================================= >>> atw_slider_slider_admin <<< ===============================
function atw_slider_slider_admin() {
    // admin for style options...
?>
   <h2 style="color:blue;">Define Sliders</h2>
   <p>You can define multiple sliders. Each slider can be be a single pane slider, or a carousel. Slider content can be images or posts.
   You must also define a Filter on the Filter tab to select which posts are used for the filter content. Then insert the slider using
   the <strong>[atw_slider name=slider-name]</strong> shortcode.</p>
    <form method="post">
        <input type="hidden" name="atw_slider_save_slider_opts" value="Slider Options Saved" />
        <input style="display:none;" type="submit" name="atw_stop_enter" value="Ignore Enter"/>
<?php
        atw_posts_nonce_field('atw_slider_save_slider_opts');
        atw_posts_nonce_field('atw_slider_save_slider_options');
        // next input stops "Enter" on text fields from doing anything

        atw_slider_select_slider();


        echo '<h3><u>Slider Options</u></h3>';

        atw_slider_required_options();

        atw_posts_save_slider_button();

        atw_slider_pro_options();
?>
    </form>
<?php
}

function atw_posts_save_slider_button() {

?>
<input style="margin-bottom:5px;" class="button-primary" type="submit" name="atw_slider_save_slider_options" value="Save Slider Options"/>
<?php
}

// ========================================= >>> atw_slider_gallery_admin_page <<< ===============================

function atw_slider_gallery_admin_page() {
    // admin for style options...
?>
   <h2 style="color:blue;">[gallery] Replacement</h2>
   <p>
    ATW Show Sliders can serve as a replacement for the standard [gallery] shortcode. If you enable this option,
    then <em>all</em> places you use a [gallery] shortcode in a standard post or page will be displayed as a slider.
   </p>
    <form method="post">
        <input type="hidden" name="atw_slider_save_gallery_opts" value="Slider Options Saved" />
<?php
        atw_posts_nonce_field('atw_slider_save_gallery_opts');
        atw_posts_nonce_field('atw_slider_save_gallery_options');
?>
        <div style="display:inline;padding-left:2.5em;text-indent:-1.7em;"><label><input type="checkbox" name="enable_gallery_slider" id="enable_gallery_slider"
        <?php checked(atw_posts_getopt('enable_gallery_slider') ); ?> >&nbsp;Enable [gallery] replacement - show [gallery] as slider.</label></div>
<?php

        $sliders = atw_posts_getopt('sliders');

        echo '<br /><br /><strong>Select Slider for [gallery]:&nbsp; </strong><select name="gallery_slider" >';
        $cur_gallery_slider = atw_posts_getopt('gallery_slider');
        if ( $cur_gallery_slider == '' )
            $cur_gallery_slider = 'default';

        foreach ($sliders as $slider => $val) {     // display dropdown of available sliders

            if ( $slider == $cur_gallery_slider ) {
                echo '<option value="'. $slider . '" selected="selected">' . $val['name'] . ' (' . $slider . ')</option>';
            } else {
                echo '<option value="'. $slider . '">' . $val['name'] .  ' (' . $slider . ')</option>';
            }
        }
        echo '</select>';

?>
<p>
    When you use the [gallery] replacement, you must specify a Slider definition to determine how to display the gallery slider.
    Set up a Slider on the <em>Sliders</em> tab. Any Slider used for a [gallery] will automatically display Images, and will
    ignore any options related to Posts.
</p>

    <input style="margin-bottom:5px;" class="button-primary" type="submit" name="atw_slider_save_gallery_options" value="Save Gallery Options"/>

    </form>
<?php
}

// ========================================= >>> atw_slider_submits <<< ===============================

function atw_slider_submits() {

    $actions = array( 'atw_slider_delete_slider', 'atw_slider_new_slider',
                     'atw_slider_save_slider_options', 'atw_slider_header_slider', 'atw_slider_save_gallery_options'
        );

    // need to respond to onchange="this.form.submit()" for 'selected_slider'
    if (atw_posts_get_POST( 'selected_slider')) {
        $new_slider =  atw_posts_get_POST( 'selected_slider');
        $cur_slider =  atw_posts_getopt('current_slider');
        if ($cur_slider != $new_slider) {
            atw_slider_set_to_slider(  );
            return;
        }
    }

    foreach ( $actions as $functionName ) {
        if ( isset( $_POST[$functionName] ) ) {
            if ( atw_posts_submitted( $functionName ) && function_exists( $functionName ) ) {
                if ($functionName())
                    break;
            }
        }
    }

    do_action('atw_slider_process_license_options');    // process license options
}

function atw_slider_set_to_slider() {
    $selected = sanitize_title_with_dashes( atw_posts_get_POST( 'selected_slider' ) );

    // Validate
    $sliders = atw_posts_getopt('sliders');
    $found = false;
    foreach ($sliders as $slider => $val) {     // display dropdown of available sliders
        if ($slider == $selected) {
            $found = true;
            break;
        }
    }
    if ( !$found ) {
        atw_posts_error_msg("Slider not found. Try again.");
        return true;
    }

    atw_posts_setopt('current_slider',$selected);
    // $name = atw_posts_get_slider_opt('name');

    //atw_posts_save_msg('Slider selected: ' . $name);
    return true;
}

function atw_slider_delete_slider() {

    $selected = sanitize_title_with_dashes( atw_posts_get_POST( 'selected_slider' ) );

    // Validate
    $sliders = atw_posts_getopt('sliders');
    $found = false;
    foreach ($sliders as $slider => $val) {
        if ($slider == $selected) {
            $found = true;
            break;
        }
    }
    if ( !$found ) {
        atw_posts_error_msg("Slider not found. Try again.");
        return true;
    }

    atw_posts_delete_slider_opts($selected);

    return true;
}



function atw_slider_new_slider() {
    $name = sanitize_text_field( atw_posts_get_POST ( 'slider_name' ) );
    $slug = sanitize_title_with_dashes($name);
    if ( $name == '' ) {
        atw_posts_error_msg('Please provide a name for the new slider.');
        return true;
    }
    atw_posts_setopt('current_slider', $slug);
    atw_posts_set_slider_opt( 'name', $name);
    atw_posts_set_slider_opt( 'slug', $slug);
    atw_posts_save_msg('New Slider Created: "' . $name . '" (Slug: <em>' . $slug . '</em>)');
    return true;
}

function atw_slider_header_slider() {

    $slider = atw_posts_getopt('current_slider');   // save name
    $name = atw_posts_get_slider_opt( 'name');
    $slug = atw_posts_get_slider_opt( 'slug');
    $current_filter = atw_posts_get_slider_opt('selected_slider_filter');
    $slider_post_slug = atw_posts_get_slider_opt('slider_post_slug');
    if ($current_filter == '') {
        $current_filter = 'default';
    }

    atw_posts_delete_slider_opts($slider);        // delete

    atw_posts_setopt('current_slider', $slider);    // reset
    atw_posts_set_slider_opt( 'name', $name);
    atw_posts_set_slider_opt( 'slug', $slug);

    atw_posts_set_slider_opt('selected_slider_filter', $current_filter);
    atw_posts_set_slider_opt('slider_post_slug', $slider_post_slug );

    atw_posts_set_slider_opt( 'pager', 'none' );          // and set for a banner
    atw_posts_set_slider_opt ( 'content_type', 'images' );
    atw_posts_set_slider_opt ( 'slider_type', 'fader' );
    atw_posts_set_slider_opt ( 'slideMargin', '0' );
    atw_posts_set_slider_opt ( 'showCaptions', false );
    atw_posts_set_slider_opt ( 'hideBorder', true );
    atw_posts_set_slider_opt ( 'showDescription', false );
    atw_posts_set_slider_opt ( 'showLinks', false );
    atw_posts_set_slider_opt ( 'no_directionNav', true );

    atw_posts_save_msg('Slider "' . $name . '" settings set to display banner slider. Be sure to set a Filter to use with this slider.');
    return true;
}

// ========================================= >>> atw_slider_save_slider_options <<< ===============================

function atw_slider_save_gallery_options() {

    if (atw_posts_get_POST('enable_gallery_slider') != '')      // [gallery] settings need own processing...
        atw_posts_setopt( 'enable_gallery_slider', true );
    else
        atw_posts_setopt( 'enable_gallery_slider', false );

    if ( atw_posts_get_POST('gallery_slider') != '' ) {
        $val = sanitize_text_field( atw_posts_get_POST( 'gallery_slider' ) );
        atw_posts_setopt( 'gallery_slider', $val );
    } else {
        atw_posts_setopt( 'gallery_slider', '' );
    }


    atw_posts_save_all_options();    // and save them to db
    atw_posts_save_msg( '[gallery] Replacement Options saved' );

}

// ========================================= >>> atw_slider_save_slider_options <<< ===============================
// *********

function atw_slider_save_slider_options() {

    // **** text values
    $text_opts = array (
        'selected_slider_filter', 'content_type', 'slider_type', 'easing',
        'itemWidth', 'minItems', 'maxItems', 'move', 'startAt', 'slideshowSpeed', 'animationSpeed', 'initDelay',
        'sliderColor',  'slideMargin', 'slider_post_slug', 'sliderPosition', 'sliderWidth', 'numberThumbs', 'maxHeightThumbs',
        'borderThumbs',  'widthThumbs', 'maxImageHeight', 'postHeight', 'navArrows', 'sliderCustomCSS',
    );

    foreach ($text_opts as $opt) {
        $val = sanitize_text_field( atw_posts_get_POST( $opt ) );
        atw_posts_set_slider_opt( $opt, $val );
    }


    // **** check boxes
    $check_opts = array (
        'no_animationLoop', 'reverse', 'smoothHeight', 'no_slideshow', 'randomize', 'mousewheel',  'noGallery',
        'thumbCaptions', 'no_directionNav', 'video', 'pausePlay', 'no_allowOneSlide',  'showTitle', 'captionOverlay',
        'hideBorder', 'pausePlay', 'no_slideshow', 'showCaptions', 'showDescription', 'showLinks', 'fiOnlyforThumbs',
        'fullWidthImages', 'addImageBorder', 'no_pauseOnAction', 'no_pauseOnHover',  'directionVertical', 'titleOverlay',
         'slidingAbove', 'noDimThumbs', 'inlineLink', 'topNavArrows', 'alwaysShowArrows', 'disableArrowSlide',
    );

    foreach ($check_opts as $opt) {
        if ( atw_posts_get_POST( $opt ) != '' ) {
            atw_posts_set_slider_opt($opt, true );
        } else {
            atw_posts_set_slider_opt($opt, false );
        }
    }

    // special case - loading
    if ( atw_posts_get_POST( 'showLoading' ) != '' ) {
            atw_posts_setopt('showLoading', true );
        } else {
            atw_posts_setopt('showLoading', false );
        }

    atw_posts_save_all_options();    // and save them to db

    // special handling for 'slider_post_slug'

    if (atw_posts_get_slider_opt( 'slider_post_slug' ) != '') {  // force default and images
        atw_posts_set_slider_opt( 'selected_slider_filter', 'default' );
        atw_posts_set_slider_opt( 'content_type', 'images' );
        atw_posts_save_all_options();    // and save them to db
    }

    // others set, now special handling for 'pager'
    $pager = atw_posts_get_POST( 'pager' );

    $content_type = atw_posts_get_slider_opt('content_type');
    $slider_type = atw_posts_get_slider_opt('slider_type');

    if ($pager == 'none')
        atw_posts_set_slider_opt('pager',$pager);
    else if ( $slider_type == 'fader' || $slider_type == 'slider' )
                atw_posts_set_slider_opt('pager',$pager);
    else
        atw_posts_set_slider_opt('pager','dots');



    atw_posts_save_all_options();    // and save them to db
    atw_posts_save_msg( 'Slider Options saved' );
}


// ========================================= >>> atw_slider_select_slider <<< ===============================

function atw_slider_select_slider() {

    $current_slider = atw_posts_getopt('current_slider');
?>

<h3><u>Select Slider</u></h3>

<?php atw_slider_start_section(); ?>


<!-- ** Current slider ** -->


    <div class="filter-title">&bull; Current Slider: <em style="font-size:150%;color:#CC2323;"><?php echo atw_posts_get_slider_opt('name'); ?></em>
    <span class="filter-title-description">Select a slider to define or edit </span>
    <span style="color:black;font-size:90%;margin-left:5em;font-weight:bold;">Shortcode: [show_slider name=<?php echo $current_slider?>]</span></div>
<?php

    $sliders = atw_posts_getopt('sliders');

    echo '<table><tr><td><strong>Select Slider:&nbsp; </strong></td><td><select onchange="this.form.submit()" name="selected_slider" >';
    foreach ($sliders as $slider => $val) {     // display dropdown of available sliders
        if ($slider == $current_slider) {
            echo '<option value="'. $slider . '" selected="selected">' . $val['name'] . ' (' . $slider . ')</option>';
        } else {
            echo '<option value="'. $slider . '">' . $val['name'] .  ' (' . $slider . ')</option>';
        }
    }
    echo '</select>';
?>

    &nbsp;&nbsp;&larr; <input class="button" type="submit"
                      onclick="return confirm('This will clear all current slider settings. The slider will also be deleted unless it is the Default slider. Are you sure?')"
                      name="atw_slider_delete_slider" value="Clear/Delete Current Slider"/></td></tr>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<textarea cols=24 rows=1 placeholder="Enter name for new slider" maxlength=64 name="slider_name"></textarea>
    &larr; <input class="button" type="submit" name="atw_slider_new_slider" value="Create New Slider"/>
    </td>
    </tr></table>
    <span style="margin-left:2em;"><strong>HINT:</strong> You can create Sliders and Filters with the same name and use them together.</span>

    <div style="clear:both;"></div>
<?php
atw_posts_nonce_field('atw_slider_set_to_slider');
atw_posts_nonce_field('atw_slider_delete_slider');
atw_posts_nonce_field('atw_slider_new_slider');

atw_slider_end_section();

}

// ========================================= >>> atw_slider_required_options <<< ===============================

function atw_slider_required_options() {

    atw_slider_start_section();
?>
<!-- ** Required Options ** -->

    <div class="filter-title">&bull; Required Options:
    <span class="filter-title-description">Options required for each slider</span></div>

<?php
    $cur_slider_type = atw_posts_get_slider_opt('slider_type');
    if ($cur_slider_type == '')
        $cur_slider_type = 'fader';
?>
    <p>
    <span style="margin-left:1.5em;margin-right:2.5em;font-weight:bold;">Slider Type:</span>
	<select name="slider_type" >
        <option value="fader" <?php selected( $cur_slider_type == 'fader' );?>>Fader - one item, fade to next</option>
        <option value="slider" <?php selected( $cur_slider_type == 'slider' );?>>Slider - one item, slide to next</option>
        <option value="carousel" <?php selected( $cur_slider_type == 'carousel');?>>Carousel - multiple sliding items</option>
    </select>

    <span style="margin-left:8%"></span><strong style="color:green;">Quick Option: </strong><input class="button" type="submit" name="atw_slider_header_slider"
          onclick="return confirm('This will automatically create the required settings for a slider suitable to use as a banner. Be sure to select a Filter to use with this Slider. Continue?')"
          value="Auto Set Values for Banner Slider"/></span>


<?php
    atw_posts_nonce_field('atw_slider_header_slider');
    $cur_pager = atw_posts_get_slider_opt('pager');
    if ($cur_pager == '' )
        $cur_pager = 'dots';
?>

    <br><span style="margin-left:1.5em;margin-right:1.5em;font-weight:bold;">Slider Paging:</span>
        <label for="pager">&nbsp;&nbsp;&nbsp;<input type="radio" name="pager" <?php checked($cur_pager, 'none'); ?> value="none">No Paging</label>
        <label for="pager">&nbsp;&nbsp;&nbsp;<input type="radio" name="pager" <?php checked($cur_pager, 'dots'); ?> value="dots">Paging dots</label>
        <br />
        <strong style="padding-left:12em;">For Fader/Slider (one item) Image Sliders only:</strong>
        <label for="pager">&nbsp;&nbsp;&nbsp;<input type="radio" name="pager" <?php checked($cur_pager, 'thumbnails'); ?> value="thumbnails">Thumbnails </label>
        <label for="pager">&nbsp;&nbsp;&nbsp;<input type="radio" name="pager" <?php checked($cur_pager, 'sliding'); ?> value="sliding">Sliding Thumbnails</label>
        <br />
        <small style="padding-left:16em;">For "Show Slider as Posts": "Sliding Thumbnails" <em>require</em> Featured Image to be defined for each post. "Thumbnails" not supported.</small>

    </p>
<?php


    $cur_content_type = atw_posts_get_slider_opt('content_type');
    if ($cur_content_type == '')
        $cur_content_type = 'images';
?>
    <p><span style="margin-left:1.5em;margin-right:1.5em;font-weight:bold;">Slider Content:</span>
	<select name="content_type" >
        <option value="images" <?php selected( $cur_content_type == 'images');?>>Show Slider as Images</option>
        <option value="posts" <?php selected( $cur_content_type == 'posts' );?>>Show Slider as Posts</option>

	</select>
    <span style="margin-left:1.5em;">Show Posts or Images - content selected using specified Slider Filter
    </span></p>


<?php
    $filters = atw_posts_getopt('filters');
    $current_filter = atw_posts_get_slider_opt('selected_slider_filter');
    if ($current_filter == '') {
        $current_filter = 'default';
    }

    echo '<p><span style="margin-left:1.5em;margin-right:3em;font-weight:bold;">Slider Filter:</span><select id="selected_slider_filter" name="selected_slider_filter" >';
    foreach ($filters as $filter => $val) {     // display dropdown of available filters
        if ($filter == $current_filter) {
            echo '<option value="'. $filter . '" selected="selected">' . $val['name'] . '</option>';
        } else {
            echo '<option value="'. $filter . '">' . $val['name'] . '</option>';
        }
    }

    echo '</select><span style="margin-left:1.5em;font-weight:bold;">You must select a filter</span> (defined on <em>Filter</em> tab) to define content displayed by this slider - or use <span style="color:green;">Quick Option</span> below.';

    $sp_posts = get_posts( array( 'posts_per_page' => -1, 'order'=>'ASC', 'orderby'=>'title', 'post_type'=>'atw_slider_post' ));

    $slugs = array();
    $slugs[] = '';      // first one is blank
    $slugs_count = 0;
    foreach ($sp_posts as $sp_post) {
        $slugs[] = $sp_post->post_name;
        $slugs_count++;
    }

    echo '<br /><strong style="color:green;margin-left:2.5em;margin-right:2em;">Quick Option:</strong> Slider Post Slug';
    if ( $slugs_count < 100) {
        $cur_slug = atw_posts_get_slider_opt('slider_post_slug');
        echo '&nbsp;&nbsp;&nbsp;<select style="min-width:30px;" id="slider_post_slug" name="slider_post_slug" >';
        foreach ($slugs as $slug) {
            if ($slug == $cur_slug) {
                echo '<option value="'. $slug . '" selected="selected">' . $slug . '</option>';
            } else {
                echo '<option value="'. $slug . '">' . $slug . '</option>';
            }
        }
        echo '</select> &nbsp;&nbsp; Use selected "Slider Post" for slider images <strong>instead</strong> of <em>Slider Filter</em>.<br />';

    } else {
        atw_posts_slider_textarea( 'slider_post_slug',
            ' Enter Slider Posts "slug" to use for slider images <strong>instead</strong> of <em>Slider Filter</em>. (Too many "Slider Posts" to display in list.)', '', 16 );
    }
    echo '</p>';
?>

    <!-- ** Basic Options ** -->


    <div class="filter-title">&bull; Basic Options:
    <span class="filter-title-description">Options to configure slider</span></div>

<?php
    atw_slider_subheader( 'Navigation', 'Navigation, autostart, linking');

    atw_posts_slider_checkbox( 'no_directionNav', 'No previous/next navigation buttons');
    atw_posts_slider_checkbox( 'no_slideshow', 'Don\'t autostart animation (ignored for Carousel)');
    atw_posts_slider_checkbox( 'pausePlay', '+Show pause/play button.');
    atw_posts_slider_checkbox( 'showLinks', 'Add links to images in Image Slider (Depends on source: link to post if from post, link to Attachment if from [gallery]',
                              '<br /><br />');


    atw_slider_subheader('Title, Caption, Description', 'Caption and Description from media library values; Title from Post; or Media Library if using [gallery]');

    atw_posts_slider_checkbox( 'showTitle', 'Show image Title','');
    atw_posts_slider_checkbox( 'showCaptions', 'Show image Caption','');
    atw_posts_slider_checkbox( 'showDescription', 'Show image Description','<br /><br />');


    atw_slider_subheader('Background, Borders', '');
    atw_posts_slider_val( 'sliderColor', 'Color for Slider BG (Default: transparent)', 'Hex value (#000), rgba(), or standard HTML color name - ', '12em' );

    atw_posts_slider_val( 'slideMargin', 'Border width around Slider; space between Carousel slides (Defaults: Posts=15px, Images=5px)', 'px' );
    atw_posts_slider_checkbox( 'hideBorder', 'Hide the border shadow around Slider (This is independent of the Border Width.)','');

    atw_slider_end_section();
}


// ========================================= >>> atw_posts_slider_checkbox + others <<< ===============================

function atw_slider_print_r($var, $return=false) {

    if ( $return ) {
        return '<pre>' . print_r( $var, $return ) . '</pre>';
    }
    echo '<pre>' . print_r( $var, true ) . '</pre>';
}

function atw_slider_start_section() {
    echo "\n<div class='filter-section'>\n";
}

function atw_slider_end_section() {

    echo "\n</div>\n";
}

function atw_posts_slider_checkbox($id, $desc, $br = '<br />') {

    $is_pro = false;

    if ($desc[0] == '+') {
        $desc = str_replace( '+', '', $desc );
        $is_pro = true;
    }
?>
    <div style="display:inline;padding-left:2.5em;text-indent:-1.7em;"><label><input type="checkbox" name="<?php echo $id ?>" id="<?php echo $id; ?>"
        <?php checked(atw_posts_get_slider_opt($id) ); ?> >&nbsp;
<?php


echo $desc . '</label></div>' . $br . "\n";
}

function atw_slider_subheader($header, $desc = '' ) {
    echo '<div style="padding-bottom:.3em;"><span style="color:#00a;font-weight:bold;font-style:italic;padding-left:1.5em;padding-right:1.5em;">' . $header . '</span>' . $desc . '</div>';
}

function atw_posts_slider_textarea($id, $desc, $br = '<br />', $cols = 32, $rows=1, $maxlength = 64) {

    $is_pro = false;

    if ($desc[0] == '+') {
        $desc = str_replace( '+', '', $desc );
        $is_pro = true;
    }
?>
    <span style="margin-top:5px;display:inline;padding-left:2.5em;"><label>
    <textarea style="margin-bottom:-8px;" cols=<?php echo $cols; ?> rows=<?php echo $rows;?> maxlength=<?php echo $maxlength; ?> name="<?php echo $id; ?>"><?php echo sanitize_text_field( atw_posts_get_slider_opt($id) ); ?></textarea>
    &nbsp;
<?php   echo $desc . '</label></span>' . $br . "\n";
}

function atw_posts_slider_val($id, $desc, $units = '', $width = '60px',  $br = '<br />') {

    $is_pro = false;

    if ($desc[0] == '+') {
        $desc = str_replace( '+', '', $desc );
        $is_pro = true;
    }
    if ( $units )
        $units = '<strong>' . $units . '</strong>';
?>
    <div style = "margin-top:0px;display:inline-block;padding-left:4em;text-indent:-1.7em;"><label>
    <input class="regular-text" type="text" style="width:<?php echo $width;?>;height:22px;" name="<?php echo $id; ?>" value="<?php echo sanitize_text_field( atw_posts_get_slider_opt($id) ); ?>" />
<?php   echo $units . '&nbsp;&nbsp;&nbsp;' . $desc . '</label></div>' . $br . "\n";
}
?>
