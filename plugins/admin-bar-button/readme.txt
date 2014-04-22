=== Admin Bar Button ===
Contributors: duck__boy
Tags: admin bar
Requires at least: 3.8
Tested up to: 3.9
Stable tag: 1.2.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Replace the default WordPress admin bar on the front end with a simple button.

== Description ==

Replace the default WordPress admin bar on the front end with a simple button.

When using this plugin, the full page height is used by your site so fixed headers work correctly.

No user interaction is required, simply install and activate to use this plugin.

== Installation ==

= If you install the plugin via your WordPress blog =
1. Click 'Install Now' underneith the plugin name
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Job done!

= If you download from http://wordpress.org/plugins/ =

1. Upload the folder `admin-bar-button` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. That's it!

== Frequently Asked Questions ==

= Can I change how the Admin Bar Button looks and works? =

Yes, there are several settings that you can alter if you so wish. Copy the code below in to a
suitable JS file in your theme and change the values as required.  Note that the values below
are defaults and can be removed if you do not wish to change them.

`$(document).ready(function(){
	$('#wpadminbar').adminBar({
		text:				'Admin bar',
		text_direction:		'ltr',
		button_position:	'left',
		button_direction:	'left',
		button_duration:	500,
		bar_direction:		'right',
		bar_duration:		500,
		show_time:			5000
	);
});`

= What do all of the options mean? =

* **text**				> The text to display in the button
* **text_direction**	> The direction of the text ('ltr' or 'rtl')
* **button_position**	> Where to place the button ('left' or 'right')
* **button_direction**	> The direction that the 'Show admin bar' button sldes on/off the screen ('up', 'down', 'left' or 'right')
* **button_duration**	> The lenght of time (in miliseconds) to take to show/hide the 'Show admin menu' button
* **bar_direction**		> The direction that the WordPress admin bar sldes on/off the screen ('up', 'down', 'left' or 'right')
* **bar_duration**		> The length of time (in miliseconds) to take to show/hide the admin menu
* **show_time**			> The length of time (in miliseconds) to show the admin bar for

== Screenshots ==

1. The minimised Admin Bar Button, shown when the Admin Bar is not active.
2. The regular Admin Bar, as shown here, is still available when the Admin Bar Button is hovered over.

== Changelog ==

= 1.2.5 =
* Minor bug fix to the adminBar jQuery UI widget

= 1.2.4 =
* Addition of screen shots
* Updats to the FAQ's
* Important update to the installation instrustions

= 1.2.3 =
* Minor changes to the adminBar jQuery UI widget

= 1.2.2 =
* Minor changes to function names to avoid possible clashes

= 1.2.1 =
* First release on the WordPress repository

== Upgrade Notice ==

Any previous version that is installed will be a beta, so you should upgrade immediatly to a stable version.