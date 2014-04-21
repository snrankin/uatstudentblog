=== ATW Show Posts ===
Contributors: wpweaver
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tags: weaver theme, settings, save, subthemes
Requires at least: 3.6
Tested up to: 3.9
Stable tag: 1.0.4

== Description ==

This plugin provides a very flexible way to show posts anywhere on a site using a shortcode. It works with any theme. Aspen Themeworks Show Posts is by far the most flexible with an easy to use interface to select which posts to show.

= Easy to select which posts to show =

There are several WordPress plugins that allow you to display selected posts via shortcode on your pages, other posts, or in widgets.

This plugin provides a powerful interactive admin page that allows you to specify exactly which posts you want displayed. The specifications are called a "filter", and you can define as many filters as you need to display different posts via the shortcode. Includes support for custom post types and taxonomies.


= Style of Displayed Posts =

ATW Show Posts will normally display posts using its own basic display functions. These can be easily styled to match the rest
of your site by defining Custom CSS rules in the Custom CSS option.

But ATW Show Posts can go way beyond that. For many Themes, you can elect to use the native Theme Post formatting function.
The posts displayed by Show Posts will match other posts displayed by your theme. If you are using the Aspen or Weaver II
themes, there is even more integrated display of posts.

= Show Posts in a Text Widget =

You can add [show_posts] to the standard Text Widget. If your theme or other plugin doesn't add this capability, ATW Show Posts
includes an option to allow the Text Widget to support shortcodes.

= The Shortcode =

The form of the shortcode is:

[show_posts filter=filter-name]



== Installation ==

Please use the WordPress Plugins:Install page to install this plugin.


== Frequently Asked Questions ==

= How do I specify which posts to display =

1. Define a filter that selects which posts you want. This can be by category, tag, date, and many other options.
2. Add the shortcode [show_posts] wherever you want the posts to display.


== Changelog ==
= 1.0.4 =
* Added support for sliding pagers for [ show_sliders ] Posts sliders

= 1.0.3 =
* Fixed show='' (blank) to work with Weaver/Aspen correctly
* Fixed wording on the "By Post Slug" option
* Fixed "Enter/Submit" on "text" input

= 1.0.2 =
* Revised plugin description
* Fixed bug with blank show slider filter specification
* Added "No posts found." message if no posts are found.
* Fixed bug with shortcode support for text widgets


= 1.0 & 1.0.1 =
* The need for 1.0.1 was because the 1.0 upload to wordpress.org failed.

= 0.9 =
* First release.
