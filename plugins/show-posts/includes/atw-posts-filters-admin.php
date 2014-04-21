<?php
// ======================================================== filters admin ===============================
function atw_posts_filters_admin() {
?>
    <h2 style="color:blue;">Create and Define Filters</h2>
    <form method="post">
        <input type="hidden" name="atw_posts_save_filter_opts" value="Filter Options Saved" />
        <input style="display:none;" type="submit" name="atw_stop_enter" value="Ignore Enter"/>

<?php
    //settings_fields( 'atw_posts_opt_group' );
    //atw_posts_delete_all_options();     // @@@@@@ for debugging

    atw_posts_select_filter();             // select filter box
    atw_posts_save_filter_button();

    atw_posts_define_display();            // define content display options
    atw_posts_save_filter_button();
?>
<h3><u>Define Content Selection Filter Options</u></h3>

<style>
.filter-section {padding:10px;border:2px solid #aaa;margin-bottom:5px;}
.filter-title {font-size:110%;font-weight:bold;color:blue;margin-bottom:5px;}
.filter-title-description {padding-left:40px;font-size:90%;font-weight:normal;font-style:italic;color:#444;}
.filter-opts {margin:0 0 5px 15px;}
.filter-description {padding-left:1%;font-size:90%;}
.filter-select {}
.filter-text {margin-left:20px;}
.filter-button{}
</style>

<?php
    atw_posts_filter_basic();              // basic filter options box

    atw_posts_set_post_type();             // set post type

    atw_posts_set_slider_group();          // the slider group

    atw_posts_save_filter_button();

    atw_posts_set_post_cats();             // set post categories

    atw_posts_set_post_tags();             // tag filters

    atw_posts_set_by_posts();              // set by post id

    atw_posts_set_post_slug();             // by post slug

    atw_posts_save_filter_button();

    atw_posts_set_author();                // select the author

    atw_posts_set_date();                  // select by date

    atw_posts_set_taxonomy();              // select by custom taxonomy

    atw_posts_set_custom_wpq();            // set custom WP_Query args

    atw_posts_save_filter_button();

    atw_posts_nonce_field('atw_posts_save_filter_opts');

?>

    </form>
    <hr />
<?php
}

function atw_posts_save_filter_button() {
?>
<input style="margin-bottom:5px;" class="button-primary" type="submit" name="atw_posts_save_options" value="Save Filter Options"/>
<?php
}

// ========================================= >>> atw_posts_select_filter <<< ===============================

function atw_posts_select_filter() {

    $current_filter = atw_posts_getopt('current_filter');
?>

<h3><u>Select Filter</u></h3>


<!-- ** Current Filter ** -->

<div class="filter-section">
    <div class="filter-title">&bull; Current Filter: <em style="font-size:150%;color:#CC2323;"><?php echo atw_posts_get_filter_opt('name'); ?></em>
    <span class="filter-title-description">Select a filter to define or edit </span></div>
<?php

    $filters = atw_posts_getopt('filters');

    echo '<table><tr><td><strong>Select Filter: </strong></td><td><select name="selected_filter" onchange="this.form.submit()">';
    foreach ($filters as $filter => $val) {     // display dropdown of available filters
        if ($filter == $current_filter) {
            echo '<option value="'. $filter . '" selected="selected">' . $val['name'] . ' (' . $filter . ')</option>';
        } else {
            echo '<option value="'. $filter . '">' . $val['name'] .  ' (' . $filter . ')</option>';
        }
    }
    echo '</select>';
?>

    &nbsp;&nbsp;&larr; <input class="button" type="submit" onclick="return confirm('This will clear all current filter settings. The filter will also be deleted unless it is the Default filter. Are you sure?')"
                           name="atw_posts_delete_filter" value="Clear/Delete Current Filter"/></td></tr>
    <tr><td>&nbsp;</td><td><span style="padding-left:20px;"></span></span><textarea cols=32 rows=1 placeholder="Enter name for new filter" maxlength=64 name="filter_name"></textarea>
    &nbsp;&nbsp;<input class="button" type="submit" name="atw_posts_new_filter" value="Create New Filter"/></td></tr></table>


    <div style="clear:both;"></div>
    <div class="filter-title">&bull; Native Theme Support <span class="filter-title-description">Interaction with native theme. Options apply to all filters, but not to image sliders.</span></div>
    <div class="filter-opts">

<?php
        $native = false;
        if ( !atw_posts_is_generic() ) {
            atw_posts_form_checkbox('ignore_aspen_weaver','Disable automatic post display integration with Weaver II/Aspen Themes.');
            $native = true;
        }
        $has_templates = atw_posts_theme_has_templates();
        if ( $has_templates ) {
            atw_posts_form_checkbox('use_native_theme_templates',
            "<strong>Use Current Theme's Native Post Display</strong> - Native post display capability detected.
            You will need to try this option to see if it works or properly or not.<br />");
            $native = true;
        }
        if ( !$native ) {
?>
           <span style="display:inline;padding-left:2.5em;text-indent:-1.7em;"></span>
        <em>Sorry, your theme does not seem to have native support for displaying posts from this plugin.</em> You
        can add custom CSS rules on the "Style" tab to make posts better match your current theme.<br /><br />
<?php
        }
?>
    </div>


    <div class="filter-title">&bull; [show_posts] Shortcode
    <span class="filter-title-description">Copy/Paste either of these shortcodes to display posts in your content</span></div>

<table>
    <tr><td>Shortcode using filter name:&nbsp;&nbsp;</td><td><strong>[show_posts filter=<?php echo $current_filter; ?>]</strong>
    &nbsp;&nbsp;- You can also use the "Add [show_posts]" button on the Page/Post Editor.</td></tr>
    <tr><td>Shortcode using parameters:&nbsp;&nbsp; </td><td><strong>[show_posts
<?php
    $params = atw_posts_get_filter_params();       // define in atw-runtime-lib.php
    echo $params;
?>
]</strong></td></tr></table>
</div>

<?php
atw_posts_nonce_field('atw_posts_set_to_filter');
atw_posts_nonce_field('atw_posts_delete_filter');
atw_posts_nonce_field('atw_posts_new_filter');

}

// ========================================= >>> atw_posts_define_display <<< ===============================

function atw_posts_define_display() {
    // define display filter options
?>

    <h3><u>Define Post Display Filter Options</u></h3>
    <div class="filter-section">
    <div class="filter-title">&bull; Post Display <span class="filter-title-description">When displaying posts, use these display options. Don't apply to image sliders.</span></div>

    <div class="filter-opts">
<?php
    $has_templates = atw_posts_theme_has_templates();
    if ($has_templates && atw_posts_is_generic() && atw_posts_getopt('use_native_theme_templates') ) {
?>
        <span style="display:inline;padding-left:2.5em;text-indent:-1.7em;"></span>
        <em>Post Display Options not available when using your theme's content display as checked in the option above.</em><br /><br />
<?php
    } else {
        atw_posts_filter_checkbox('hide_title','Hide Post Title','');
        atw_posts_filter_checkbox('show_avatar','Show Author Avatar');

        atw_posts_filter_checkbox('hide_top_info','Hide Top Post Meta Info (date, author)','');
        atw_posts_filter_checkbox('hide_bottom_info','Hide Bottom Post Meta Info (category, tag, comment link)');

        atw_posts_filter_checkbox('hide_featured_image','Hide Featurd Image in post (default: show; or theme defaults)', '');

        echo '<br />';
        atw_posts_filter_textarea('more_msg','"Continue Reading..." message for excerpts.');

        $cur_show = atw_posts_get_filter_opt('show');
?>


    <div style="padding:1em 0 .5em 4em;text-indent:-1.7em;">Display posts as: &nbsp;&nbsp;
	<select name="show" >
	<option value="" <?php selected( $cur_show == '' );?>></option>
	<option value="full" <?php selected( $cur_show == 'full');?>>Full post</option>
	<option value="excerpt" <?php selected( $cur_show == 'excerpt');?>>Excerpt</option>
	<option value="title" <?php selected( $cur_show == 'title');?>>Title + Top Meta Line</option>
    <option value="titlelist" <?php selected( $cur_show == 'titlelist');?>>Title only as list</option>
    <option value="title_featured" <?php selected( $cur_show == 'title_featured');?>>Title + Featured Image</option>
	</select> &nbsp;How to display posts - (Default: full post; Weaver/Aspen: theme settings)
    </div>


<?php
    }   // else not getting from gallery
?>
    </div>

    <div style="clear:both;"></div>

        <div class="filter-description">
    <p>
        Use this section to define how each post is to be displayed - title, excerpted, etc. These options apply to how each post is displayed when
        using the plugin's built-in post layout, or when used with native Weaver II or Aspen Theme layout. Use the Content Selection Filter to define which posts
        will be displayed. The Slider Image Show options can be used to define how images are used in a image only slide show. (Note: when using the
        ATW Slider plugin to display an image slider, these Post Display options do not apply.)
    </p>
    </div>
</div>
<?php
}

// ========================================= >>> atw_posts_filter_basic <<< ===============================

function atw_posts_filter_basic() {
    // **** basic options ****
?>

<div class="filter-section">
<div class="filter-title">&bull; Basic Options <span class="filter-title-description">Some basic options for selecting posts </span></div>
    <div class="filter-opts">

        <?php

        atw_posts_filter_checkbox('show_sticky_posts','Show Sticky Posts at beginning of displayed posts','');

        atw_posts_filter_checkbox('use_paging','Use Paging (posts will be paged using Number of Posts per page)');

        atw_posts_filter_val('posts_per_page', 'Number of Posts to Show (Use -1 for all. Default: Settings-&gt;Reading value)');

        atw_posts_filter_val('offset', 'Number of posts to skip over');


        atw_posts_filter_val('excerpt_length','Excerpt length (words)', '<span style="padding-left:70px"></span>');

        atw_posts_filter_val('cols','Display posts in columns (1-3)')
?>
        <?php $cur_order = atw_posts_get_filter_opt('orderby'); ?>
        <br />
        <strong>Display posts ordered by:</strong>
        <select name='orderby'>
            <option value="date" <?php selected( $cur_order == 'date');?>>Date</option>
            <option value="title" <?php selected( $cur_order == 'title');?>>Post Title</option>
            <option value="modified" <?php selected( $cur_order == 'modified');?>>Last Modified Date</option>
            <option value="rand" <?php selected( $cur_order == 'rand');?>>Random order</option>
            <option value="comment_count" <?php selected( $cur_order == 'comment_count');?>>Number of comments</option>
            <option value="author" <?php selected( $cur_order == 'author');?>>Author</option>
            <option value="ID" <?php selected( $cur_order == 'ID');?>>Post ID</option>
            <option value="none" <?php selected( $cur_order == 'none');?>>No order</option>
        </select>

        <?php $cur_order = atw_posts_get_filter_opt('order'); ?>
        <strong style="padding-left:25px">Sort order:</strong>
        <select name='order'>
            <option value="DESC" <?php selected( $cur_order == 'DESC');?>>Descending (3,2,1) (default)</option>
            <option value="ASC" <?php selected( $cur_order == 'ASC');?>>Ascending (1,2,3)</option>
        </select>
    </div>

<div style="clear:both;"></div>

</div><!-- end filter-section -->
<?php
}

// ========================================= >>> atw_posts_set_post_type <<< ===============================

function atw_posts_set_post_type() {
    //  **** post_type ****
?>
<div class="filter-section">
<div class="filter-title">&bull; Post Type <span class="filter-title-description">Include posts with this post type. (WP_Query: post_type - Default: post) </span></div>
    <div class="filter-opts">
    <table><tr>
    <td><select class="filter-select" name="post_type_selection" >
<?php
    $post_types = get_post_types(array() , 'names');
    foreach ($post_types as $post_type) {
        if ($post_type != 'page'
            && $post_type != 'nav_menu_item'
            && $post_type != 'revision'
            && $post_type != 'attachment')
            echo '<option value="'. $post_type . '">' . $post_type . '</option>';
    }
?>
    </select></td>
    <td><input class="button filter-button" type="submit" name="atw_posts_add_post_type" value="Add Post Type" /></td>
    <td><textarea class="filter-text" cols=40 rows=1 placeholder="post_type=list" maxlength=128 name="post_type"><?php echo sanitize_text_field(atw_posts_get_filter_opt('post_type')); ?></textarea></td>
    </tr></table>

<?php
atw_posts_nonce_field('atw_posts_add_post_type');
?>
    </div>
<div class="filter-description">
    Specify the <em>post_type</em> used to select posts. If you just want standard posts, you don't need to define this setting.
    Include a post type by selecting the type from the drop-down list,
    and clicking the "Add Post Type" button. This list includes any <em>Custom Post Types</em> that may be defined by
    plugins you have installed. These custom post types may or may not display useful content depending how they are
    used by the plugin. You may add more than one post type. You can edit the query
    string displayed in the text area directly, and then save by clicking "Save Filter Options".
</div>
<div style="clear:both;"></div>

</div><!-- end filter-section -->
<?php
}


// ========================================= >>> atw_posts_set_post_cats <<< ===============================

function atw_posts_set_post_cats() {
    //<!-- **** Post Categories **** -->
?>
<div class="filter-section">
<div class="filter-title">&bull; Categories <span class="filter-title-description">Include posts with these categories. (WP_Query: category_name - Default: all) </span></div>
    <div class="filter-opts">
    <table><tr>
    <td><select class="filter-select" name="category_name_selection" >
<?php
    $cats = get_categories( );

    foreach ($cats as $cat => $val) {
        echo '<option value="'. $val->slug . '">' . $val->name . ' (' . $val->slug . ')</option>';
    }
?>
    </select></td>
    <td><input class="button" type="submit" name="atw_posts_add_category_name" value="Add Category" /></td>
    <td><input class="button" type="submit" name="atw_posts_hide_category_name" value="Hide Category" /></td>
    <td><textarea class="filter-text" cols=40 rows=1 placeholder="category_name=list" maxlength=128 name="category_name"><?php echo sanitize_text_field(atw_posts_get_filter_opt('category_name')); ?></textarea></td>
    </tr></table>

<?php
atw_posts_nonce_field('atw_posts_add_category_name');
atw_posts_nonce_field('atw_posts_hide_category_name');

?>
    </div>
<div class="filter-description">
    Specify the <em>category_name</em> slug to display posts from that category. Include a category by selecting the category from the drop-down list,
    and clicking the "Add Category" button. This list includes all categories for standard posts that have been defined.
    You may add more than one category. If you prefix a category slug with a minus sign (e.e., -cat-slug) or use the "Hide Category" button,
    that category will NOT be displayed. You can edit the query
    string displayed in the text area directly, and then save by clicking "Save Filter Options".
</div>
<div style="clear:both;"></div>

</div><!-- end filter-section -->
<?php
}

// ========================================= >>> atw_posts_set_post_tags <<< ===============================

function atw_posts_set_post_tags() {
    //<!-- *** Tags *** -->
?>

<div class="filter-section">
<div class="filter-title">&bull; Tags <span class="filter-title-description">Include posts with these tags. (WP_Query: tag - Default: all) </span></div>

    <div class="filter-opts">
    <table><tr>
    <td><select class="filter-select" name="tag_selection" >
<?php
    $tags = get_tags( );

    foreach ($tags as $tag => $val) {
        echo '<option value="'. $val->slug . '">' . $val->name . ' (' . $val->slug . ')</option>';
    }
?>
    </select></td>
    <td><input class="filter-button button" type="submit" name="atw_posts_add_tag" value="Add Tag" /></td>
    <td><textarea class="filter-text" cols=40 rows=1 placeholder="tag=list" maxlength=128 name="tag"><?php echo sanitize_text_field(atw_posts_get_filter_opt('tag')); ?></textarea></td>
    </tr></table>
<?php
atw_posts_nonce_field('atw_posts_add_tag');
?>
    </div>
<div class="filter-description">
    Specify the <em>tag</em> slug to display posts from that tag. Include a tag by selecting the tag from the drop-down list,
    and clicking the "Add Tag" button. This list includes all tags for standard posts that have been defined.
    You may add more than one tag. You can edit the query
    string displayed in the text area directly, and then save by clicking "Save Filter Options".
</div>
<div style="clear:both;"></div>

</div><!-- end filter-section -->
<?php
}

// ========================================= >>> atw_posts_set_slider_group <<< ===============================

function atw_posts_set_slider_group() {
    //<!-- *** Slider Group *** -->
    if ( !function_exists('atw_slider_installed') )     // don't show this if we don't have the slider installed
        return;
?>

<div class="filter-section">
<div class="filter-title">&bull; Slider Group <span class="filter-title-description">Include posts from these Slider Groups (most useful with ATW Slider plugin)</span></div>

    <div class="filter-opts">
    <table><tr>
    <td><select class="filter-select" name="group_selection" >
<?php

    $terms = get_terms( 'atw_slider_group' );
    foreach ( $terms as $term ) {
        echo '<option value="'. $term->slug . '">' . $term->name . ' (' . $term->slug . ')</option>';
    }
?>
    </select></td>
    <td><input class="filter-button button" type="submit" name="atw_posts_add_group" value="Add Slider Group" /></td>
    <td><textarea class="filter-text" cols=40 rows=1 placeholder="atw_slider_group=list" maxlength=128 name="atw_slider_group"><?php echo sanitize_text_field(atw_posts_get_filter_opt('atw_slider_group')); ?></textarea></td>
    </tr></table>
<?php
atw_posts_nonce_field('atw_posts_add_group');
?>
    </div>
<div class="filter-description">
    Specify the <em>Slider Group</em> slug to display posts from that slider group. Include a group by selecting the group from the drop-down list,
    and clicking the "Add Slider Group" button. This list includes only groups for the atw_sliders_post that have been defined.
    You may add more than one group. You can edit the query
    string displayed in the text area directly, and then save by clicking "Save Filter Options".
    <em style="font-weight:bold;color:red;">Important:</em> Post Type option must include "atw_slider_post" to display slider groups.
</div>
<div style="clear:both;"></div>

</div><!-- end filter-section -->
<?php
}

// ========================================= >>> atw_posts_set_author <<< ===============================

function atw_posts_set_author() {
    //<!-- *** Author *** -->
?>

<div class="filter-section">
<div class="filter-title">&bull; Author <span class="filter-title-description">Include posts with these authors. (WP_Query: author - Default: all) </span></div>

    <div class="filter-opts">
<?php
    $user_args = array(
		'fields' => array( 'ID', 'user_nicename', 'display_name' ),
		'who' => 'authors',
        'orderby' => 'display_name'
		);
    $wp_user_search = new WP_User_Query( $user_args );
    $authors = $wp_user_search->get_results();
?>
    <table><tr>
    <td><select class="filter-select" name="author_selection" >
<?php
    foreach ($authors as $author => $val) {
        echo '<option value="' . $val->ID . '">' . $val->display_name . ' (' . $val->ID . ')</option>';
    }
 ?>
    </select></td>
    <td><input class="filter-button button" type="submit" name="atw_posts_add_author" value="Add Author" /></td>
    <td><textarea class="filter-text" cols=40 rows=1 placeholder="author=list" maxlength=128 name="author"><?php echo sanitize_text_field(atw_posts_get_filter_opt('author')); ?></textarea></td>
    </tr></table>
<?php
atw_posts_nonce_field('atw_posts_add_author');
?>
    </div>
<div class="filter-description">
    Specify the <em>author</em> ID to display posts from that author. Include an author by selecting the author's display name from the drop-down list,
    and clicking the "Add Author" button. This list includes all registered users with a role of Contributor or higher.
    You may add more than one author. If you prefix a category slug with a minus sign (e.e., -3), the author with that ID will NOT be displayed. You can edit the query
    string displayed in the text area directly - use the author ID shown in the drop-down list, and then save by clicking "Save Filter Options".
</div>
<div style="clear:both;"></div>

</div><!-- end filter-section -->
<?php
}

// ========================================= >>> atw_posts_set_by_posts <<< ===============================

function atw_posts_set_by_posts() {
    //<!-- *** by Pates *** -->
?>

<div class="filter-section">
<div class="filter-title">&bull; By Post IDs <span class="filter-title-description">Include posts with these post IDs</span></div>

    <div class="filter-opts">
<textarea class="filter-text" cols=60 rows=1 placeholder="Post ID list" maxlength=512 name="post_ids"><?php echo sanitize_text_field(atw_posts_get_filter_opt('post_ids')); ?></textarea>

    </div>
<div class="filter-description">
    Specify a comma separated list of <em>Post IDs</em> to display posts in that list, in the order specified. This option will override
    other selection options (e.g., Tags, Date, etc.). You can find a post's ID in your browser's URL address field when editing the
    post with the Post editor. It is the number right after the <em>?post=</em>. Sorry this can't be easier, but the only way
    WordPress supports showing a specific set of posts is by ID.
</div>
<div style="clear:both;"></div>
</div>
<?php
}

// ========================================= >>> atw_posts_set_post_slug <<< ===============================

function atw_posts_set_post_slug() {
    //<!-- *** by Post Slug *** -->
?>

<div class="filter-section">

<div class="filter-title">&bull; By Post Slug <span class="filter-title-description">Include only post with this title slug</span></div>

    <div class="filter-opts">
<textarea class="filter-text" cols=40 rows=1 placeholder="page-title-slug" maxlength=512 name="post_slug"><?php echo sanitize_text_field(atw_posts_get_filter_opt('post_slug')); ?></textarea>

    </div>
<div class="filter-description">
    This option will display a single post with the specified slug - usually automatically generated from the posts's title.
    If this is a post from a custom post type, you need to specify that in the "Post Type" setting. Other selection options are ignored.
    This is the WP_Query 'name' argument.
</div>

<div style="clear:both;"></div>

</div><!-- end filter-section -->
<?php
}



// ========================================= >>> atw_posts_set_date <<< ===============================

function atw_posts_set_date() {
    // <!-- *** Date *** -->
?>
<div class="filter-section">
<div class="filter-title">&bull; Date <span class="filter-title-description">Include posts in a date range. (Default: all)</span></div>

    <div class="filter-opts">
<?php
    $dates = array('Today' => 'today', 'Past 24 Hours' => 'past-24h', 'This Week' => 'this-week', 'Past 7 Days' => 'past-week',
                   'This Month' => 'this-month', 'Past 30 Days' => 'past-30d', 'This Year' => 'this-year', 'Past 365 Days' => 'past-365d'
            );
?>
    <table><tr>
    <td><select class="filter-select" name="date_selection">
<?php
    foreach ($dates as $date => $val) {
        echo '<option value="' . $val . '">' . $date . '</option>';
    }
 ?>
    </select></td>
    <td><input class="filter-button button" type="submit" name="atw_posts_add_date" value="Select Date" /></td>
    <td><textarea class="filter-text" cols=40 rows=1 placeholder="date=date-slug" maxlength=128 name="date"><?php echo sanitize_text_field(atw_posts_get_filter_opt('date')); ?></textarea></td>
    </tr></table>
<?php
atw_posts_nonce_field('atw_posts_add_date');
?>
    </div>
<div class="filter-description">
    You can specify a pre-defined date range of posts to display. If you need to specify other date options, see the WordPress WP_Query help page, and
    add specific date values using the "Custom WP_Query Args" section below.
</div>
<div style="clear:both;"></div>

</div><!-- end filter-section -->


<div style="clear:both;"></div>
<?php
}

// ========================================= >>> atw_posts_set_taxonomy <<< ===============================

function atw_posts_set_taxonomy() {
    //<!-- *** Custom Taxonomies *** -->
?>
<div class="filter-section">
<div class="filter-title">&bull; Custom Taxonomies <span class="filter-title-description">Manual specification of Custom Taxonomies</span></div>

    <div class="filter-opts">
<?php
    $taxonomies = get_taxonomies(array( 'public' => true, '_builtin' => false), 'objects');
    $li_out = false;
    if (empty($taxonomies)) {
        echo '<strong>No Custom Taxonomies Found</strong><br /><br />';
    } else {
        echo '<ul>';
        $li_out = false;
        foreach ($taxonomies as $taxonomy => $val ) {
            if ($val->name == 'atw_slider_group')
                continue;
            $li_out = true;
            echo '<li><strong>Taxonomy name: </strong> &nbsp;<em>' . $val->label . '</em>&nbsp;&nbsp; (slug: ' . $val->name . ')';
            $tax = $val->name;
            $terms = get_terms( $tax );

            $lead = '<br /><span style="margin-left:20px;">Values (slugs): </span>&nbsp;&nbsp;';

            if ( is_wp_error( $terms ) ) {
                continue;
            } else {
                if (empty($terms)) {
                    echo '<br /><span style="margin-left:20px;">Values: </span>&nbsp;&nbsp;None defined.<br />';
                    continue;
                }
                foreach ( $terms as $term ) {
                    echo $lead;
                    $lead = ', ';
                    echo esc_attr( $term->slug );
                }
                echo "<br />";
            }
            echo '</li>';
        }
        if ( !$li_out ) {
            echo '<li>No custom taxonomies defined for this site.</li>';
        }
        echo '</ul>';
    }

    if ( $li_out ) {
?>
    <table><tr><td>Specify custom taxonomy parameters:</td><td><textarea class="filter-text" cols=60 rows=1 placeholder="custom_taxonomy_name=custom_values_by_slug_list" maxlength=512 name="taxonomy"><?php echo sanitize_text_field(atw_posts_get_filter_opt('taxonomy')); ?></textarea></td></tr></table>
<?php
    }
?>
    </div>
<div class="filter-description">
    Various plugins can create Custom Taxonomies for use with custom post types. You can use these custom taxonomy names and
    values to specify additional filter terms to this filter definition. Add as many values as you wish for a custom taxonomy
    in the text box, then click "Save Filter Options" to set the value. For example, you could add a value something like
    <code>custom_category=cat1</code> to include custom posts with the 'custom_category' taxonomy with a value 'cat1'. Separate
    different taxonomy lists with a space.
    <em style="font-weight:bold;color:red;">Important:</em> Be sure to include the corresponding custom post type in the "Post Type" section that matches the
    custom taxonomy.
</div>
</div>
<?php
}

// ========================================= >>> atw_posts_set_custom_wpq <<< ===============================

function atw_posts_set_custom_wpq() {
    //<!-- *** Custom Taxonomies *** -->
?>
<!-- *** Other WP_Query args *** -->

<div class="filter-section">
<div class="filter-title">&bull; Custom WP_Query Args (Advanced Option) <span class="filter-title-description">Manual specification of WP_Query arguments</span></div>

    <div class="filter-opts">

    <table><tr><td>Specify custom WP_Query arguments:</td><td><textarea class="filter-text" cols=60 rows=1 placeholder="arg1=val1 arg2=val2 ..." maxlength=512 name="wp_query_args"><?php echo esc_textarea(atw_posts_get_filter_opt('wp_query_args')); ?></textarea></td></tr></table>
    </div>
<div class="filter-description">
    <em>This option is intended for advanced users.</em> The Selection Filter Options specified on this admin page
    are mapped to the corresponding WordPress <code>WP_Query</code> function arguments, but there are many additional WP_Query options
    not included in these options; most users will never need them.
    However, you can specify your own custom arguments to WP_Query here. Provide as many arguments
    as you need in the text box, each separated by a space. These arguments will be added to any other options specified above, and be
    added directly to the '$args' parameter to WP_Query. For a full, very technical explanation of all the options available for WP_Query, please consult the
    <a href="http://codex.wordpress.org/Class_Reference/WP_Query" alt="WP_Query Codex Entry" target="_blank">WordPress Codex for WP_Query</a>.
    <em style="font-weight:bold;color:red;">Important:</em> WP_Query arguments requiring values with 'array()' are <em><strong>not</strong></em> supported
    by this plugin.
</div>
</div>
<?php
}

?>
