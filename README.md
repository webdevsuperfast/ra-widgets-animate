# RA Widgets Animate

Animate widgets using Animate on Scroll library.

## Description

RA Widgets Animate is a WordPress plugin that adds additional widget fields into existing widget forms and uses [Animate On Scroll](https://michalsnik.github.io/aos/) to render animation. This plugin also adds 'Animation' tab to Widget Styles when use with SiteOrigin Panels.

## Features

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
* Set global Animate on Scroll Settings via plugin settings
* Enable/disable plugin scripts and styles via plugin settings

## Installation

1. Upload the plugin files to the `/wp-content/plugins/ra-widgets-animate` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through 'Plugins' screen in WordPress.

## Frequently Asked Questions

Q: Do I need to install SiteOrigin Panels to be able to use the animation?

A: No, the fields will attached itself to existing widgets on 'Widgets' screen in WordPress. If you have SiteOrigin Panels installed, the 'Animation' tab will be added to SiteOrigin Panels 'Widget Styles'.

Q: How can I set Animate on Scroll settings globally without having to edit each widgets?

A: You can set the global settings through `Settings > RA Widgets Animate > Global Settings`.

Q: I have Animate on Scroll already, how can I disable the AOS script on your plugin to prevent conflict?

A: You can disable Animate on Scroll scripts and styles through `Settings > RA Widgets Animate > Script Settings`.


## Screenshots

1. 'Animation' fields inside 'Widgets' screen in WordPress.
2. 'Animation' tab settings in SiteOrigin Panels.
3. 'Animation' tab settings when opened in SiteOrigin Panels.
4. 'RA Widgets Animate' settings page.

## Changelog
1.1.6
* Added custom viewport selection in plugin settings.
* Modified plugin tags.

1.1.5
* Changed style and script filenames and paths.
* Fixed `.rawa-fields` from closing on `widgets update`.
* Added admin script and style to `Customizer` screen.
* Fixed `disable` object name returning array instead of string.  
* Admin style changes.

1.1.4
* Changed donate link, added settings page screenshot.

1.1.3
* Added missing js files, removed unneeded files.

1.1.2
* Renamed app.js to rawa.js, trying to fixed missing js files on SVN commit

1.1.1
* Fixing missing js files

1.1
* Added settings page, added app.js script, modify css build path, grammar fixes, code cleanup, updated translation.

1.0.7
* Prevent `.rawa-fields` from closing on widgets save, added back deleted files, migrate to Yarn from Bower.

1.0.6
* Regex fix, removed unneeded files.

1.0.5
* Added additional fields, fixed bug with widgets with no css selectors, updated npm packages

1.0.4
* Code cleanup, moved siteorigin related js, css/markup changes, translation related changes

1.0.3
* Code cleanup, moved animation, placement, easing into their own function

1.0.2
* Removed unneeded line of codes

1.0.1
* Fixed float issue with two-column widgets

1.0
* First release

## Upgrade Notice
1.1.5
* Filepath, filename changes, bug fixes, customizer implementation.

1.1.4
* Changed donate link, added settings page screenshot.

1.1.3
* Added missing js files, removed unneeded files.

1.1.2
* Renamed app.js to rawa.js, trying to fixed missing js files on SVN commit

1.1.1
* Fixing missing js files

1.1
* Added settings page, added app.js script, modify css build path, grammar fixes, code cleanup, updated translation.

1.0.7
* Prevent `.rawa-fields` from closing on widgets save, added back deleted files, migrate to Yarn from Bower.

1.0.6
* Regex fix, removed unneeded files.

1.0.5
* Added additional fields, fixed bug with widgets with no css selectors, updated npm packages

1.0.4
* Code cleanup, moved siteorigin related js, css/markup changes, translation related changes

1.0.3
* Code cleanup, moved animation, placement, easing into their own function

1.0.2
* Removed unneeded line of codes

1.0.1
* Fixes an issue with two-column widgets not clearing floats

1.0
* First release