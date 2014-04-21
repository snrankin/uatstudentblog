<?php
/* Copyright 2014 - Aspen Themworks, Bruce E. Wampler */
// ========================================= >>> atw_slider_pro_options <<< ===============================

function atw_slider_pro_options() {
    $thumb = atw_slider_plugins_url( '/images/slider-pro.jpg', '' );
?>
<!-- ** Pro Options ** -->
<h3><u>Options Included with ATW Show Sliders Pro</u></h3>
<p></p><span style="margin-left:30px;font-size:180%;"><a style="text-decoration:none;" href="http://aspenthemeworks.com/atw-show-sliders-pro-plugin/" target="_blank">
    <img src="<?php echo $thumb; ?>" />&nbsp;&nbsp;&nbsp;Click to Upgrade to ATW Sliders Pro!</a></span><span style="margin-left:15px;">See a live demo!</span></p>

<?php
    atw_slider_start_section();
    atw_slider_general_slider_layout();
    atw_slider_post_video_layout();

    atw_slider_image_slider_layout();
    atw_slider_post_slider_layout();
    atw_slider_carousel_options();

    atw_slider_show_misc_opts();

    atw_slider_end_section();

}

function atw_slider_list( $item ) {
    echo '<span style="padding-left:3em;">&bull; ' . $item . '</span><br />';
}

// ========================================= >>> atw_slider_general_slider_layout <<< ===============================

function atw_slider_general_slider_layout() {

?>
<div class="filter-title">&bull; General Slider Layout</em>
    <span class="filter-title-description">Options affecting general layout of sliders</span></div>
<?php
    atw_slider_subheader('Slider Width','Width and position of slider container');

    atw_slider_list('Slider Width - Percent of enclosing container slider will use. (Defalut:100%)');
    atw_slider_list('&nbsp;Position of slider if width specified');


    atw_slider_subheader('Slider Height');

    atw_slider_list('Allow height of the slider shrink and grow to match slide height.');


    atw_slider_subheader('Thumbnail Pagers','Attributes of thumbnail pager. (Do <em>not</em> apply to Carousels.)');

    atw_slider_list('Sliding Thumbnail Area Width - Percent of main slider width Thumbnail Slider uses.');
    atw_slider_list('Move Sliding Thumbnail pager above main slider');
    atw_slider_list('Number of pager thumbnails (Default: Thumbnails - 5 per row; Sliding Thumbnails - 6)');
    atw_slider_list('Maximum Height for thumbnail images - can make better looking thumbnails with mixed height images');
    atw_slider_list('Border around Thumbnail and Sliding Thumbnails pager images. (Transparent, so it will match slider bg color. Default:none)');
    atw_slider_list("Don't dim thumbnails for non-current image.");
    atw_slider_list('Use Featured Image only for thumbnails (when FI is defined). Featured Image will <em>not</em> be used for slider main image.');

    echo '<br />';

}

// ========================================= >>> atw_slider_image_slider_layout <<< ===============================

function atw_slider_image_slider_layout() {

?>
<div class="filter-title">&bull; Image Slider Layout</em>
    <span class="filter-title-description">Options affecting layout of image sliders</span></div>
  <p>
<?php
    atw_slider_subheader('Image Height and Width','Make images fill the slider, control height');

    atw_slider_list('Force images to use full width of slider. (Make small images fit the slider.)');
    atw_slider_list('Maximum Height of Image. Useful to control height when full width set, but will lead to clipping of taller images.');

    atw_slider_subheader('Visual Styling');
    atw_slider_list('Add "photo" border around images.');

    atw_slider_subheader('Title and Caption Overlay', 'Change the visual impact');
    atw_slider_list('Overlay title over top of image (when Show Title also checked).');
    atw_slider_list('Overlay caption over bottom of image (when Show Caption also checked).');

    atw_slider_subheader('Prev/Next Navigation', 'Change style and behavior of navigation arrows');
    atw_slider_list( 'Show Prev/Next Navigation Arrows at top right corner of slider.');
    atw_slider_list( 'Disable arrow "slide-in" effect.');
    atw_slider_list( 'Always display navigation arrows.');
    atw_slider_list( 'Select Navigation Arrow Graphic');
?>
  </p>

<?php
}

// ========================================= >>> atw_slider_post_slider_layout <<< ===============================

function atw_slider_post_slider_layout() {

?>
<div class="filter-title">&bull; Post Slider Layout</em>
    <span class="filter-title-description">Options affecting layout of post sliders</span></div>

<?php
    atw_slider_list('Maximum Hieght for Post Slides. Will automatically add scroll bar for taller posts.');
    echo '<br />';
}

// ========================================= >>> atw_slider_post_video_layout <<< ===============================

function atw_slider_post_video_layout() {

?>
<div class="filter-title">&bull; Video</em>
    <span class="filter-title-description">Options sliders with video</span></div>

<?php
    atw_slider_list('Slider contains Video - adds additional support for Video slides, including responsive sizing.');
    echo '<br />';
}


// ========================================= >>> atw_slider_show_misc_opts <<< ===============================

function atw_slider_show_misc_opts() {

?>

<div class="filter-title">&bull; Timing and Order:
    <span class="filter-title-description">Options for animation timing</span></div>
<?php
    atw_slider_list('Randomize slide order');
    atw_slider_list('The slide that the slider should start on.' );

    atw_slider_list('Set the speed of the slideshow cycling, in milliseconds (Default: 5000ms = 5 seconds)' );
    atw_slider_list('Set the speed of animations, in milliseconds (Default: 600ms)' );
    atw_slider_list('Set an initialization delay, in milliseconds (Default: 0)' );

?>

<br />
<div class="filter-title">&bull; Other Options:
    <span class="filter-title-description">Other Options less commonly used.</span></div>
<?php

    atw_slider_subheader('Navigation', 'Options to enhance navigation');
    atw_slider_list('For Image Slide from a post, use link as specified in "Add Media" link for image rather than link to post.');
    atw_slider_list('Don\'t pause slide show when user hovers over slider.');
    atw_slider_list('Don\'t pause slide show when user clicks a Slider control. Not recommended.');
    atw_slider_list('Allow slider navigating via mousewheel. Is a non-conventional navigation method.','<br /><br />');

    atw_slider_subheader('Visual Effects');
    atw_slider_list('Easing Methods for Fader');


    atw_slider_list('Use Vertical sliding for single-image Slider Type (not Fader or Carousel). Only looks good with borderless, equal height slides.');
    atw_slider_list('Show "Loading" spinner - useful if you have slide shows that take extra time to load. Applies to <em>all</em> sliders.');

    atw_slider_list('No [gallery]', 'Can avoid [gallery] within [gallery] issues.');

    atw_slider_subheader('Per-Slider Custom CSS', 'Advanced option. Add per-slider custom CSS. See Help file for more information.');

}

// ========================================= >>> atw_slider_carousel_options <<< ===============================

function atw_slider_carousel_options() {

?>
<div class="filter-title">&bull; Carousel Options:
    <span class="filter-title-description">Options to configure carousel slider</span></div>

<?php
    atw_slider_list('Reverse the animation direction' );

?>
<p style="margin-left:5.5em;text-indent:-3em;"><strong><em>Note:&nbsp;</em></strong>
    The following 4 options interact, and are used to control number of items in a Carousel Slider.
</p>
<?php
    atw_slider_list('Minimum number of visible carousel items. (Default: 4)' );
    atw_slider_list('Maxmimum number of visible carousel items. (Default: 4)' );
    atw_slider_list('Width of individual carousel items. Interacts with Min/Max items and actual width of slider in browser.');
    atw_slider_list('Number of carousel items that should move on animation. By default, slider will move all visible items.' );
    echo '<br />';
}
?>
