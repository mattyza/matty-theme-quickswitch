=== Plugin Name ===
Contributors: mattyza
Donate link: http://matty.co.za/
Tags: themes, theme-development, development, theme switching, admin-bar, wordpress toolbar, theme search, utilities
Requires at least: 3.2.1
Tested up to: 3.9.1
Stable tag: 1.3.0

Quickly switch between themes via a menu in the WordPress Toolbar.

== Description ==

Matty Theme QuickSwitch makes it easy to activate a theme without needing to visit the "Appearance -> Themes" screen in the WordPress admin.

A new menu in the WordPress Toolbar lists all themes currently available on your website, with quick links to activate each individually.

Theme QuickSwitch is particularly useful when developing or debugging WordPress themes, as it saves time in getting you to the place you need to be.

== Installation ==

= Manual Installation =

1. Upload the `matty-theme-quickswitch` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

= Automatic Installation =

1. Visit the "Plugins -> Add New" menu in your WordPress admin.
1. Search for `Matty Theme QuickSwitch`.
1. Once the search results have loaded, click the "Install" link next to the "Matty Theme QuickSwitch" search result.
1. At the confirmation screen, click "Yes".
1. The plugin should now install itself onto your website.

== Frequently Asked Questions ==

= Is there any way to display the theme switcher menu elsewhere, other than the WordPress Toolbar? =

Currently, the WordPress Toolbar is required in order to use Matty Theme QuickSwitch.

== Screenshots ==

1. The Theme QuickSwitch Menu as of WordPress V3.3, including the search field.

== Changelog ==

= 1.3.0 =
* Adds a "current" CSS class to the current theme's list item.
* Updates the styling to be WordPress 3.9.1 compatible.

= 1.2.3 =
* Cater for WordPress 3.4's preference of the wp_get_theme() and wp_get_themes() functions.
* Move menu item to the "top-secondary" section and remove unnecessary floating CSS style.

= 1.2.2 =
* Make sure the full theme name is displayed in menu title when two themes share the same name (theme name and folder name).
* Make the current active theme bold and a darker styling in the theme list.

= 1.2.1 =
* Adjust the position of the "reset" button when the search field has text (fixes overlapping reset button bug).
* Make sure the search field focuses on hover of the menu.
* Update screenshot.

= 1.2.0 =
* Adjusted styling of the search field and added magnifying glass icon.
* Split themes into "Child Themes" and "Parent Themes" categories. Child themes are listed first, then parent themes.
* Fix bug where not all child themes were displaying correctly in the list, due to an ID conflict.

= 1.1.0 =
* Added search form and search logic to the theme switcher menu on the WordPress toolbar.
* Moved CSS to a separate file and added JavaScript file.

= 1.0.0 =
* First Release!

== Upgrade Notice ==

= 1.3.0 =
Adds a "current" CSS class to the current theme's list item and updates the styling to be WordPress 3.9.1 compatible.

= 1.2.3 =
Improve WordPress 3.4+ compatibility. Minor refinements and code optimisations.

= 1.2.2 =
Improved accuracy of theme name in the menu item, as well as bolded the current active theme in the theme list and made the styling of that text darker.

= 1.2.0 =
Fixed bug where some child themes didn't display due to an ID conflict. Adjust styling of the search field and split themes in the "Child Themes" and "Parent Themes" categories.

= 1.1.0 =
Added search functionality to the theme switcher menu.

= 1.0.0 =
First Release!