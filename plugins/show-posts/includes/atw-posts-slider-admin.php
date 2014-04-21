<?php
// ========================================= >>> atw_posts_select_filter <<< ===============================
function atw_posts_slider_admin() {
    // admin for style options...

    if (function_exists('atw_slider_installed')) {
        atw_slider_do_slider_admin();
        return;
    }
?>
   <h2 style="color:blue;">Aspen Theme Works Show Sliders Plugin</h2>

<p>
    The Aspen Themworks <em>Show Sliders</em> plugin is an optional companion to <em>ATW Show Posts</em> that
    can display Posts and Images in a great looking responsive sliders that automatically resize to fit
    the screen of any browser, tablet, or phone.
    Unlike many other sliders, <em>ATW Show Sliders</em> will display either Posts or Images. It uses the Filters tab to
    select which posts or images will be included in the slider. You can easily specify the images included in the slider
    using the standard WordPress Media Library Gallery tool, or use standard posts that contain images.
    <em>ATW Show Sliders</em> also includes a [gallery] shortcode replacement that will display galleries as a slide show.
</p>
<p>
    <em>ATW Show Sliders</em> has a free version available from the WordPress plugins collection that will meet the needs
    of many users. There also is a Pro version with many more options to customize your sliders to get the exact look
    and content you want to display, including Videos in a slider.
</p>
<?php
}
?>
