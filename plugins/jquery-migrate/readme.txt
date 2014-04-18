=== jQuery Migrate ===
Contributors: Chrome Orange (Andrew Benbow)
Donate link: http://example.com/
Tags: jQuery
Tested up to: 3.5.1
Stable tag: 0.1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Test your site for potential problems with jQuery 1.9.1 as ships with WordPress 3.6 before 3.6 is released.

== Description ==

Test your site for potential problems with jQuery 1.9.1 as ships with WordPress 3.6 before 3.6 is released. 

This plugin will add jquery-migrate.js to your site to prevent plugins and scripts that are using deprecated functions from breaking when you use jQuery 1.9.1. 

Additionally, for admin users only, a list of errors will be output to the console so you can see which areas need to be fixed. WordPress 3.6 includes jquery-migrate.js for the admin but not the frontend. 

You can use this plugin in your currect version of WordPress, so you can find out if anything in your jQuery files will break before upgrading to WordPress 3.6

== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload `plugin-name.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress


== Frequently Asked Questions ==

= How do I view potential problems? =

If you are logged in as the site admin then open the console and any problems will be included, if you see "JQMIGRATE: Logging is active" in the console then the plugin is working

= Erm, console? =

How to use the Google Chrome console : 
https://developers.google.com/chrome-developer-tools/docs/console

How to use FireBug for FireFox : 
https://addons.mozilla.org/en-us/firefox/addon/firebug/
https://getfirebug.com/faq/

== Screenshots ==

1. Screenshot of an example output

== Changelog ==

= 0.1.0 =
* First release
