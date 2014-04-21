<?php
// ========================================= >>> atw_posts_select_filter <<< ===============================
function atw_posts_help_admin() {
    // admin for help
    $t_dir = atw_posts_plugins_url('/help/help.html', '');

    $title = "View Aspen Themeworks Show Posts ";

?>
    <h2 style="color:blue;font-weight:bold;">Quick Start Help</h2>

<h2 style="color:blue;text-decoration:underline;">Show Posts Quick Start</h2>
<p style="color:green;font-weight:bold;font-size:140%;">
    <?php echo $title; ?> <a href="<?php echo $t_dir; ?>" target="_blank" title="ATW Plugins Help File">Help Document</a>
    <span style="font-size:80%;margin-left:20px;">Visit the official
    <a href="http://forum.weavertheme.com/categories/atw-show-posts-and-atw-show-sliders" target="_blank">help forum.</a></span>
</p>
<p>
    The Aspen Themeworks <code>[show_posts]</code> shortcode allows you to display posts on your pages or in a text widget
    in the sidebar. You can specify a large number of filtering options to select a specific set of posts to show.
</p>

<p>
    The recommended way to display posts is to specify all the filter selection options on the <em>Filter</em> tab, and use the
    <strong>[show_posts filter=filter-name]</strong> form of the shortcode. You can also specify the options manually.
</p>
<ol>
  <li>Open the Filters tab.</li>
  <li>Use a meaningful name and <em>Create New Filter</em> to define a filter. You can define as many filters as you need.</li>
  <li>Set Post Display Options to define how post will be displayed.</li>
  <li>Set options to select which posts will be displayed</li>
  <li>Save Options</li>
  <li>Display posts using <strong>[show_posts filter=filter-name]</strong>. There is an "Add [show_posts]" button on the Page/Post editor.</li>
</ol>

<?php

    if (function_exists('atw_slider_help_admin')) {
        atw_slider_help_admin();
    }

}


/*
Free vs. Premium ideas...

Pro - add support for more qargs - just have the basic ones in the free version
reduce the options for different slide shows in the free.
*** */
?>
