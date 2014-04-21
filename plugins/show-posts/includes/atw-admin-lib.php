<?php

function atw_posts_help_link($ref, $label) {

    $t_dir = atw_posts_plugins_url('/help/' . $ref, '');
    $icon = atw_posts_plugins_url('/help/help.png','');
    $pp_help =  '<a href="' . $t_dir . '" target="_blank" title="' . $label . '">'
		. '<img class="entry-cat-img" src="' . $icon . '" style="position:relative; top:4px; padding-left:4px;" title="Click for help" alt="Click for help" /></a>';
    echo $pp_help ;
}


function atw_posts_save_msg($msg) {
    echo '<div id="message" class="updated fade" style="width:70%;"><p><strong>' . $msg .
	    '</strong></p></div>';
}

function atw_posts_error_msg($msg) {
    echo '<div id="message" class="updated fade" style="background:#F88;" style="width:70%;"><p><strong>' . $msg .
	    '</strong></p></div>';
}

function atw_media_lib_button($fillin = '') {
?>
&nbsp;&larr;&nbsp;<a style='text-decoration:none;' href="javascript:atw_media_lib('<?php echo $fillin;?>');" ><img src="<?php echo atw_posts_plugins_url('/images/media-button.png'); ?>" title="Select image from Media Library. Click 'Insert into Post' to paste url here." alt="media" /></a>
<?php
}


/*
    ================= nonce helpers =====================
*/
function atw_posts_submitted($submit_name) {
    // do a nonce check for each form submit button
    // pairs 1:1 with aspen_nonce_field
    $nonce_act = $submit_name.'_act';
    $nonce_name = $submit_name.'_nonce';

    if (isset($_POST[$submit_name])) {
	if (isset($_POST[$nonce_name]) && wp_verify_nonce($_POST[$nonce_name],$nonce_act)) {
	    return true;
	} else {
	    die("WARNING: invalid form submit detected ($submit_name). Probably caused by session time-out, or, rarely, a failed security check. Please contact AspenThemeWorks.com if you continue to receive this message.");
	}
    } else {
	return false;
    }
}

function atw_posts_nonce_field($submit_name,$echo = true) {
    // pairs 1:1 with sumbitted
    // will be one for each form submit button

    return wp_nonce_field($submit_name.'_act',$submit_name.'_nonce',$echo);
}

/*
    ================= form helpers =====================
*/

function atw_posts_get_POST( $id ) {
    return isset( $_POST[$id]) ? stripslashes( $_POST[$id] ) : '';
}

// general values - atw_posts_getopt

function atw_posts_form_checkbox($id, $desc, $br = '<br />') {
?>
    <div style = "display:inline;padding-left:2.5em;text-indent:-1.7em;"><label><input type="checkbox" name="<?php echo $id ?>" id="<?php echo $id; ?>"
        <?php checked(atw_posts_getopt($id) ); ?> >&nbsp;
<?php   echo $desc . '</label></div>' . $br . "\n";
}

// filter values - atw_posts_get_filter_opts

function atw_posts_filter_checkbox($id, $desc, $br = '<br />') {
?>
    <div style = "display:inline;padding-left:2.5em;text-indent:-1.7em;"><label><input type="checkbox" name="<?php echo $id; ?>" id="<?php echo $id; ?>"
        <?php checked(atw_posts_get_filter_opt($id) ); ?> >&nbsp;
<?php   echo $desc . '</label></div>' . $br . "\n";
}

function atw_posts_filter_textarea($id, $desc, $br = '<br />') {
?>
    <div style="margin-top:5px;display:inline-block;padding-left:4em;text-indent:-1.7em;"><label>
    <textarea style="margin-bottom:-8px;" cols=32 rows=1 maxlength=64 name="<?php echo $id; ?>"><?php echo sanitize_text_field( atw_posts_get_filter_opt($id) ); ?></textarea>
    &nbsp;
<?php   echo $desc . '</label></div>' . $br . "\n";
}

function atw_posts_filter_val($id, $desc, $br = '<br />') {
?>
    <div style = "margin-top:5px;display:inline-block;padding-left:2.5em;text-indent:-1.7em;"><label>
    <input class="regular-text" type="text" style="width:50px;height:22px;" name="<?php echo $id; ?>" value="<?php echo sanitize_text_field( atw_posts_get_filter_opt($id) ); ?>" />
    &nbsp;
<?php   echo $desc . '</label></div>' . $br . "\n";
}

?>
