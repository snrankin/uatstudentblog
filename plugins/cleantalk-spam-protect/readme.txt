=== Anti-spam by CleanTalk ===
Contributors: znaeff, shagimuratov
Tags: antispam, anti-spam, anti spam, spam, spammers, captcha, comment, comments, wpmu, multisite, forms, registration, login, contact form, buddypress, bbpress, users, post, posts, javascript, plugin, blacklists, cloud, math, signup, akismet, JetPack, WooCommerce, iphone, android, security, formidable, contact form 7, bot, spam bots, спам
Requires at least: 3.0
Tested up to: 3.9
Stable tag: 2.38
License: GPLv2 
License URI: http://www.gnu.org/licenses/gpl-2.0.html

No spam comments, no spam registrations, no spam contact emails. All in one anti-spam with Android, iPhone apps to control anti-spam.

== Description ==
No CAPTCHA, no questions, no counting animals, no puzzles, no math and no spam bots.

= Anti-spam features =
1. Stops spam bots comments.
1. Stops spam bots signups.
1. Stops spam bots contacts emails.
1. Stops spam pingbacks, trackbacks.

= Anti-spam protection =
* WordPress, JetPack comments.
* WordPress, BuddyPress, bbPress signups.
* Formiadble forms.
* Contact form 7.
* JetPack Contact form.
* WooCommerce review form.
* WordPress Landing Pages.

= Anti spam plugin info = 
The plugin is client application for cloud anti-spam service CleanTalk.org, which **daily protects 5k web-sites from spam bots**. Also you can use CleanTalk app for iPhone, Android to control anti-spam service on web-site or control comments, signups, contacts and orders.

We have developed an anti-spam service CleanTalk that would provide **maximum protection from spam** and you can provide for your visitors **a simple and convenient form of comments/registrations without annoying CAPTCHAs and puzzles**. Used to detect spam multistage test that allows us to block up to 100% of spam bots.

= Spam protection methods =
Plugin uses several simple tests to stop spammers.

* Spam bots signatures.
* JavaScript anti spam test.
* Checks by Email, IP, domains at <a href="http://cleantalk.org/blacklists" target="_blank">spam activities list</a>.
* Comment submit time. Spam bots usually send post immediately after page load.
* Relevance test for the comments. Spam bots send offtop posts, so the plugin can filter spam bots by oftop.

= Protection from manual spam = 
For manual spam filtering plugin evaluates the relevance of the comments text according to the subject and the content of the blog. Relevance is determined by keyword and topic of each keyword separately. Comments which have been tested for manual spam are automatically published in the blog.

= We recommend =
* Audience engagement plugin <a href="http://wordpress.org/plugins/feedweb/">Feedweb</a>
* The Best Content Editor plugin <a href="http://wordpress.org/plugins/zedity/">Zedity</a>

== Installation ==
1. Download, install and activate the plugin. 
1. Get Access key <a href="http://cleantalk.org/register?platform=wordpress" target="_blank">http://cleantalk.org/register</a>
1. Enter Access key at the plugin settings. 
1. Make dummy spam comment with email **stop_email@example.com**. You should see notice,

*** Forbidden. Sender blacklisted. Request number 8aa9209204b2f521b3da16f92d9440a5. Antispam service cleantalk.org. ***

The setup is done! You can control anti-spam plugin by <a href="http://cleantalk.org/my" target="_blank">Control panel</a> at the cleantalk.org or use <a href="https://play.google.com/store/apps/details?id=org.cleantalk.app">Adnroid</a>, <a href="https://itunes.apple.com/us/app/cleantalk/id825479913?mt=8">iPhone</a> anti-spam app. 

== Frequently Asked Questions ==

= How plugin stops spam? =
Plugin uses several simple tests to stop spammers.

* Spam bots signatures.
* JavaScript antispam test.
* Checks by Email, IP, web-sites domain at <a href="http://cleantalk.org/blacklists" target="_blank">spam activities list</a>.
* Comment submit time. Spam bots usually send post immediately after page load.
* Relevance test for the comment. Spam bots send offtop posts, so the plugin can filter spam bots by oftop.

= How plugin works with spam comments? =
Spam comments moves to SPAM folder. First comment from a new author plugin compares with post and previous comments. If the relevance of the comment is good enough it gets approval at the blog without manual approval.

= Will anti spam protects my theme? =
Plugin works with all WordPress themes, for example - Responsive, Twenty Eleven, Twenty Twelve, Twenty Ten, Twenty Thirteen, Sixteen, Radiate, Alexandria, Swift Basic, Ridizain, Customizr, Catch Box, Twenty Fourteen, Virtue, Tempera, Pinboard, hemingway, Vantage, Weaver II, Buzz, Omega, iFeature, Simple Catch and etc. With some themes may not works JavaScript anti-spam method, but it's not crucial to protect your blog from spam bots.

= How can I test anti-spam protection? =
Please use email **stop_email@example.com** for comments, contacts or signups. Also you can see comments processed by plugin for last 7 days at <a href="http://cleantalk.org/my/show_requests">Control panel</a> or look at folder "Spam" for banned comments.

= How the plugin is effective against spam bots? =
Plugin Anti-spam by CleanTalk stops up to 100% of spam comments, spam signups (registrations) and spam contact emails. More over, by determining the relevance of the comment text, the plugin stops about 96% spam comments submitted manually via browser. 

= What about pingback, trackback spam? = 
Plugin by default pass not spam pingbacks/trackbacks (sender host clear at <a href="http://cleantalk.org/blacklists">blacklists IP</a> database) from third-party sites to the blog. If the pingback has more then 3 records in the blacklists and not relevant to the blog the pingback will be stopped by CleanTalk.

= Should I use another antispam plugins? =
Use other antispam plugins not necessarily, because CleanTalk stops up to 100% of spam bots. In some cases several anti-spam plugins can conflict, so it will be better use just one plugin.  

= The plugin WordPress MultiUser (WPMU or WordPress network) compatible? =
The plugin is WordPress MultiUser (WPMU or WordPress network) compatible. Each blog in multisite environment has individual anit spam options for spam bots protection.

== Other notes ==

= Troubleshooting Guide =
<a href="http://wordpress.org/support/plugin/cleantalk-spam-protect">Anti-spam by CleanTalk support forum</a> | <a href="http://wordpress.org/plugins/cleantalk-spam-protect/faq/">Plugin FAQ</a>

If you're having trouble getting things to work after installing the plugin, here are a few things to check:

1. If you haven't yet, please upgrade plugin to the latest version.
1. If you have error '*** Forbidden. Enable JavaScript. Anti-spam service cleantalk.org. ***' please check JavaScript support in your browser and do JavaScript test at this page <a href="http://cleantalk.org/checkout-javascript-support">Check out JavaScript support</a>.
1. If you have spam comments, signups or contacts please check the Access key at plugin settings. The key should be same as you can find in service <a href="https://cleantalk.org/my/">Control panel</a>.
1. If you have spam contact emails after plugin installation, please check your plugin with list of supported contact forms (see section **Anti-spam protection**). 

= Requirements =
WordPress 3.0 at least. PHP 4, 5 with CURL or file_get_contents() function and enabled 'allow_url_fopen' setting. <a href="http://cleantalk.org/register?platform=wordpress">Sign up</a> to get an Access key.

= Translations =
* Russian (ru_RU)
* Spain (es_ES) - thanks to Andrew Kurtis and <a href="http://www.webhostinghub.com/index-c.html">WebHostingHub</a>


== Changelog ==

= 2.38 2014-03-27 =
  * Fixed: Registraion form submit time spam test. 

= 2.36 2014-03-12 =
  * Reversed to patches from old revisions. 

= 2.35 2014-03-12 =
  * New: Notifications about disabled account 
  * New: Improved JavaScript spam test.
  * Fixed: Code optimization 
  * Fixed: JavaScript test for signups.

= 2.33 2014-02-12 =
  * Fixed: CURLOPT_FOLLOWLOCATION bug at admin notice 

= 2.32 2014-02-04 =
  * New: Added notice about automatically approved comment. The notice shows only for first approved comment and only for new commentators (without approved comments) of the blog.  
  * New: At WordPress console added banner for notices. 
  * Changed: Screenshots updated. 

= 2.31 2014-01-24 =
  * New: Added spam protection for JetPack comments
  * Fixed: cURL connection issue "Expect: 100-continue" 

= 2.30 2014-01-13 =
  * Changed: Improved servers connection logic.
  * Fixed: Antispam test for Fomidable forms. 

= 2.28 2013-12-19 =
  * New: Added protection against spam bots for WooCommerce review form. 
  * Fixed: JavaScript antispam logic for WooCommerce review form.

= 2.27 2013-12-06 =
  * New: Added protection against spam bots for JetPack Contact form. 
  * Fixed: JavaScript antispam logic for registrations and Contact form 7.

= 2.25 2013-11-27 =
  * New: Added protection against spam bots for BuddyPress registrations. 
  * New: Added protection against spam bots for Contact form 7. 
  * New: Added Spanish (es_ES) translation. 

= 2.23 2013-11-20 =
  * New: Added automatic training blacklists on spam bot account deletion. 
  * New: Added URL to project homepage at plugin options. 
  * Changed: Improved antispam logic. 

= 2.21 2013-11-13 =
  * Changed: WordPress blacklists settings get priority over plugin's antispam settings 
  * Changed: Disabled management approval comments for regular commentators of the blog. Automatically approved for publication only the comments of the new blog authors. 
  * Changed: Removed form submit time test. Imporved JavaScript spam test. 
  * Changed: PHP code optimizations 

= 2.19 2013-11-08 =
  * New: Antispam protection from spam bots at the registration form
  * Changed: Russian localization for admin panel 
  * Changed: PHP code optimizations 

= 2.5.18 2013-11-01 =
  * Fixed: Bug with selection of the last comments for post
  * New: Antispam protection for Formiadble feedback forms
  * New: Automatic deletion of outdated spam comments 
  * New: On/Off option for comments spam filtration 
  * Tested with WordPress 3.7.1

= 2.4.15 2013-09-26 =
  * Fixed: Bug with mass comments deletion 
  * Changed: Russian localization for admin panel 
  * Tested with mulitsite setup (WordPress network or WPMU) 

= 2.4.14 2013-08-29 =
  * Changed: Removed feedback requests to the servers for banned (spam) comments. 

= 2.4.13 2013-08-19 =
  * Changed: Switched HTTP requests from file_get_contents() to CURL. Added file_get_contens() as backup connection to the servers. 
  * Changed: Removed feedback requests for comments moved to trash. 
  * Fixed: "Fail connect to servers..." error on hostings with disabled 'allow_url_fopen' PHP option.

= 2.4.12 2013-08-12 =
  * Removed RPC::XML library from plugin. 
  * Switched plugin to HTTP+JSON connection with servers.
  * Fixed bug with comments antispam tests with non UTF8 codepage.

= 2.4.11 2013-08-02 =
  * Removed spam tests for self-made pingbacks 
  * Tested up to WP 3.6

= 2.4.10 2013-07-24 =
  * Fixed warning in PHP 5.4
  * Fixed bug with disabling comments test for Administrators, Authors and Editors 
  * "Stop words" settings moved to <a href="http://cleantalk.org/my">Control panel</a> of the service
  * "Response language" settings moved <a href="http://cleantalk.org/my">Control panel</a> of the service

= 2.4.9 =
  * Fixed extra debugging in base class 

= 2.4.8 =
  * Enabled convertion to UTF8 for comment and example text 
  * Optimized PHP code 

= 2.3.8 =
  * Enabled selection the fastest server in the pool 
  * Fixed work server in plugin's config

= 2.2.3 =
  * Secured md5 string for JavaScript test
  * Added requests's timestamp to calculate request work time
  * Update base CleanTalk's PHP class

= 2.1.2 =
  * Improved perfomance for processing large comments (over 32kb size)
  * Improved perfomance for bulk operations with comments in Comments panel 
  * Added feedback request with URL to approved comment 

= 2.0.2 =
  * Fixed bug with JavaScript test and WordPress cache plugins 

= 2.0.1 =
  * Added option "Publicate relevant comments" to plugin's options. 
  * Added descriptions to plugin options

= 1.5.4 =
  * Fixed HTTP_REFERER transmission to the servers 
  * Improved JavaScript spam test
  * Optimized PHP code

= 1.4.4 =
  * Pingback, trackback comments has moved to manual moderataion
  * Added transmission to the serves comment type and URL
  * Post title, body and comments separated into individual data elements
  * Added priority for matched words in the comment with post title
  * Enabled stop words filtration as default option 

= 1.3.4 =
  * Removed PHP debugging.

= 1.3.3 =
  * Added notice at admin panel about empty Access key in plugin settings
  * Removed HTTP link to the site project from post page
  * Removed unused options from settings page
  * Tested up to WordPress 3.5

= 1.2.3 =
 * Fixed bug with session_start.

= 1.2.2 =
  * Plugin rename to CleanTalk. Spam prevent plugin
  * Integration Base Class version 0.7
  * Added fast submit check
  * Added check website in form
  * Added feedbacks for change comment status (Not spam, unapprove)
  * Added function move comment in spam folder if CleanTalk say is spam
  * Disable checking for user groups Administrator, Author, Editor
  * Marked red color bad words

= 1.1.2 =
  * Addition: Title of the post attached to the example text in auto publication tool.
  * Tested with WordPress 3.4.1.

= 1.1.1 =
  * HTTP_REFERER bug fixed

= 1.1.1 =
  * Added user locale support, tested up to WP 3.4

= 1.1.0 =
  * First version

== Upgrade Notice ==
= 2.38 2014-03-27 =
  * Fixed: Registraion form submit time spam test. 

= 2.36 2014-03-12 =
  * Reversed to patches from old revisions. 

= 2.35 2014-03-12 =
  * New: Notifications about disabled account 
  * New: Improved JavaScript spam test.
  * Fixed: Code optimization 
  * Fixed: JavaScript test for signups.

= 2.33 2014-02-12 =
  * Fixed: CURLOPT_FOLLOWLOCATION bug at admin notice 

= 2.32 2014-02-04 =
  * New: Added notice about automatically approved comment. The notice shows only for first approved comment and only for new commentators (without approved comments) of the blog.  
  * New: At WordPress console added banner for notices. 
  * Changed: Screenshots updated. 

= 2.31 2014-01-24 =
  * New: Added spam protection for JetPack comments
  * Fixed: CURL connection issue "Expect: 100-continue" 

= 2.30 2014-01-13 =
  * Changed: Improved servers connection logic.
  * Fixed: Antispam test for Fomidable forms. 

= 2.27 2013-12-06 =
  * New: Added protection against spam bots for JetPack Contact form. 
  * Fixed: JavaScript antispam logic for registrations and Contact form 7.

= 2.25 2013-11-27 =
  * New: Added protection against spam bots for BuddyPress registrations. 
  * New: Added protection against spam bots for Contact form 7. 
  * New: Added Spanish (es_ES) translation. 

= 2.23 2013-11-20 =
  * New: Added automatic training blacklists on spam bot account deletion. 
  * New: Added URL to project homepage at plugin options. 
  * Changed: Improved antispam logic. 

= 2.21 2013-11-13 =
  * Changed: WordPress blacklists settings get priority over plugin's antispam settings 
  * Changed: Disabled management approval comments for regular commentators of the blog. Automatically approved for publication only the comments of the new blog authors. 
  * Changed: PHP code optimizations

= 2.19 2013-11-08 =
  * New: Antispam protection from spam bots at the registration form
  * Changed: Russian localization for admin panel 
  * Changed: PHP code optimizations 

= 2.5.18 2013-11-01 =
  * Fixed: Bug with selection of the last comments for post
  * New: Antispam protection for Formiadble feedback forms
  * New: Automatic deletion of outdated spam comments 
  * New: On/Off option for comments spam filtration 
  * Tested with WordPress 3.7.1

= 2.4.15 2013-09-26 =
  * Fixed: Bug with mass comments deletion 
  * Changed: Russian localization for admin panel 
  * Tested with mulitsite setup (WordPress network or WPMU) 

= 2.4.14 2013-08-29 =
  * Changed: Removed feedback requests to the servers for banned (spam) comments.

= 2.4.13 2013-08-19 =
  * Fixed: "Fail connect to servers..." error on hostings with disabled 'allow_url_fopen' PHP option.
