=== RA Widgets Animate ===
Contributors: frodoBean
Donate link: https://rotsenacob.com/
Tags: aos, animate-on-scroll, animation, widgets, siteorigin-panels
Requires at least: 4.7
Tested up to: 4.9.1
Stable tag: 1.0.7
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Animate widgets using Animate on Scroll library.

== Description ==

RA Widgets Animate is a WordPress plugin that adds additional widget fields into existing widget forms and uses [Animate On Scroll](https://michalsnik.github.io/aos/) to render animation. This plugin also adds 'Animation' tab to Widget Styles when use with SiteOrigin Panels.

<h3>Features</h3>

* Animate almost all of your widgets
* Supports SiteOrigin Panels Widget Styles
* Ability to choose animation type
* Ability to choose anchor placement
* Ability to change anchor element
* Ability to change easing time
* Ability to change animation offset
* Ability to change animation duration
* Ability to change animation delay
* Ability to set animation once

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/ra-widgets-animate` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through 'Plugins' screen in WordPress.

== Frequently Asked Questions ==

= Do I need to install SiteOrigin Panels to be able to use the animation? =

No, the fields will attached itself to existing widgets on 'Widgets' screen in WordPress. If you have SiteOrigin Panels installed, the 'Animation' tab will be added to SiteOrigin Panels 'Widget Styles'.

== Screenshots ==

1. 'Animation' fields inside 'Widgets' screen in WordPress.
2. 'Animation' tab settings in SiteOrigin Panels.
3. 'Animation' tab settings when opened in SiteOrigin Panels.

== Changelog ==
= 1.0.7 =
* Prevent `.rawa-fields` from closing on widgets save, added back deleted files, migrate to Yarn from Bower.

= 1.0.6 =
* Regex fix, removed unneeded files.

= 1.0.5 =
* Added additional fields, fixed bug with widgets with no css selectors, updated npm packages

= 1.0.4 =
* Code cleanup, moved siteorigin related js, css/markup changes, translation related changes

= 1.0.3 =
* Code cleanup, moved animation, placement, easing into their own function

= 1.0.2 =
* Removed unneeded line of codes

= 1.0.1 =
* Fixed float issue with two-column widgets

= 1.0 =
* First release

== Upgrade Notice ==
= 1.0.7 =
Prevent `.rawa-fields` from closing on widgets save, added back deleted files, migrate to Yarn from Bower.

= 1.0.6 =
Regex fix, removed unneeded files.

= 1.0.5 =
Added additional fields, fixed bug with widgets with no css selectors, updated npm packages

= 1.0.4 =
Code cleanup, moved siteorigin related js, css/markup changes, translation related changes

= 1.0.3 =
Code cleanup, moved animation, placement, easing into their own function

= 1.0.2 =
Removed unneeded line of codes

= 1.0.1 =
Fixes an issue with two-column widgets not clearing floats

= 1.0 =
First release