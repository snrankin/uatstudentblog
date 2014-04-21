<?php
// ========================================= >>> atw_posts_select_filter <<< ===============================
function atw_posts_showposts_admin() {
    // admin for style options...
?>
   <h2 style="color:blue;">ATW Show Posts</h2>
    <form method="post">
        <input type="hidden" name="atw_posts_save_showposts_opts" value="Show Posts Options Saved" />
<?php
        atw_posts_nonce_field('atw_posts_save_showposts_opts');

?>
<label><span style="color:blue;font-weight:bold; font-size: larger;"><b>Show Posts - [show_posts filter=filter-name]</b></span></label>
<br />
<p>
    The Aspen Themeworks <code>[show_posts]</code> shortcode allows you to display posts on your pages or in a text widget
    in the sidebar. You can specify a large number of filtering options to select a specific set of posts to show.
</p>

<p>
    The recommended way to display posts is to specify all the filter selection options on the <em>Filter</em> tab, and use the
    <strong>[show_posts filter=filter-name]</strong> form of the shortcode. You can also specify the options manually.
</p>
<p><span style="font-size:120%;font-weight:bold;">Shortcodes, using current <em>Filter</em> settings:</span> - You can Copy/Paste these.
<table>
    <tr><td>Shortcode using filter name:&nbsp;&nbsp;</td><td><strong>[show_posts filter=<?php echo atw_posts_getopt('current_filter'); ?>]</strong>
    &nbsp;&nbsp;- You can also use the "Add [show_posts]" button on the Page/Post Editor.</td></tr>
    <tr><td>Shortcode using parameters:&nbsp;&nbsp; </td><td><strong>[show_posts
<?php
    $params = atw_posts_get_filter_params();       // define in atw-runtime-lib.php
    echo $params;
?>
]</strong></td></tr></table>
</p>

<p>
<h3>Summary of all parameters for [show_posts] shortcode, shown with default values:</h3>
<table style="padding-left:25px;">
    <tr><td>cols=1</td><td>display posts in 1 to 3 columns</td></tr>
    <tr><td>filter=''</td><td>use named filter - all other parameters ignored when filter specified </td></tr>
    <tr><td>hide_bottom_info=false</td><td>hide bottom info line </td></tr>
    <tr><td>hide_featured_image=false</td><td>hide featured image - FI is displayed by default </td></tr>
    <tr><td>hide_title=false</td><td>hide the title </td></tr>
    <tr><td>hide_top_info=false</td><td>hide the top info line </td></tr>
    <tr><td>show=full</td><td>show: title | excerpt | full | titlelist | title_featured </td></tr>
    <tr><td>show_avatar=false</td><td>show the author avatar </td></tr>
    <tr><td>more_msg="New More Message"&nbsp;&nbsp;</td><td>replacement for Continue Reading excerpt message </td></tr>
    <tr><td>use_paging=false</td><td>Use paging when displaying multiple posts </td></tr>
    <tr><td>category_name=list</td><td>list of categories by slug</td></tr>
    <tr><td>post_ids</td><td>list of posts by IDs</td></tr>
    <tr><td>post_slug</td><td>single post by specified post slug name</td></tr>
    <tr><td>WP_Query args</td><td>Any standard <a href="http://codex.wordpress.org/Class_Reference/WP_Query" alt="WP_Query Codex Entry" target="_blank">WP_Query</a> argument (not including those needing array()).
    <br />
    Using these options directly requires fairly advanced technical understanding, and is intended for advanced users.
    </td></tr>
</table>
<br />

You don't need to supply every option when you add the <code>[show_posts]</code> to your own content.
You can wrap the parameter values with double or single quotation marks if you want, but they aren't needed
unless the value has a space (e.g., the more_msg example).</p>

<hr />
<p style = "display:inline;padding-left:2.5em;text-indent:-1.7em;"><label><input type="checkbox" name='textWidgetShortcodes' id='textWidgetShortcodes'
        <?php checked(atw_posts_getopt('textWidgetShortcodes') ); ?> >&nbsp;
        Enable [shortcode] support for the Text Widget. Some themes and plugins already support this, but this allows you
        to add [show_posts] or [show_slider] directly into the standard Text Widget.</label></p>
<br />
<br />

<?php

        atw_posts_save_showposts_button();
?>
    </form>
<?php
}

function atw_posts_save_showposts_button() {
?>
<input style="margin-bottom:5px;" class="button-primary" type="submit" name="atw_posts_save_showposts_options" value="Save Show Posts Options"/>
<?php
}

/*
Free vs. Premium ideas...

Pro - add support for more qargs - just have the basic ones in the free version
reduce the options for different slide shows in the free.
*** */
?>
