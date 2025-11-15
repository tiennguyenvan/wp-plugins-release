=== DragBlock - WordPress Site & Page Builder with Advanced Blocks ===
Contributors: dragblock, sneeit, Tien Nguyen
Donate link: https://www.paypal.me/sneeit
Tags: gutenberg, gutenberg blocks, site builder, drag-and-drop, visual editor
Requires at least: 5.9
Requires PHP: 7.4
Stable tag: 25.11.15
Tested up to: 6.6.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

The "DragBlock" plugin enhances the WordPress Full Site Gutenberg Editor to support designing pixel perfect websites
easily.

== Description ==

The "DragBlock" plugin enhances the WordPress Full Site Gutenberg Editor to support designing pixel perfect websites
easily.

https://www.youtube.com/watch?v=c0kgB-mBDTo&list=PLM7acJv8ZNtio0sPznKOGtxodBUOZWDYR

<h3>YOU CAN:</h3>
<strong><a href="https://www.youtube.com/watch?v=c0kgB-mBDTo" title="Introduce Appearance Panel">Add Appearance Styles</a>:</strong> to design perfect websites. You can also select devices for the styles to create responsive designs.

<strong><a href="https://www.youtube.com/watch?v=KpjyBqkY-MY" title="Introduce Attributes Panel">Add Tag Attributes</a>: </strong> like title, alt, placeholder... to improve both search engine optimization (SEO) and Core Web Vital Score.

<strong><a href="https://www.youtube.com/watch?v=q90uCWkNRKA" title="Introduce Form Blocks">Build Forms</a>: </strong> such as contact forms or any kind of forms. ContactForm7 and all other heavy form plugins are no longer needed

<strong><a href="https://www.youtube.com/watch?v=zqqhUubFawY" title="Introduce Database Panel">Query Database</a>: </strong> to load posts and other dynamic contents to your design.

<strong><a href="https://www.youtube.com/watch?v=UTTi8Smuz3g" title="Introduce Interactions Panel">Define Interactions</a>:</strong> like onClick, onMouseEnter onMouseLeave between blocks.

<strong><a href="https://www.youtube.com/watch?v=KRILy2KsT60" title="Introduce Wrapper Toolbar">Quick Styling</a>: </strong> via the block toolbars.

<strong><a href="https://www.youtube.com/watch?v=bbnUsu-fXU4" title="Introduce Font Library">Pick Google Fonts</a>: </strong> through the font library. You can also upload your custom font to the library.

<strong>Define multilingual texts:</strong> to support many languages without creating separate pages and designs

<h3>CREDITS AND CONTRIBUTION</h3>
The icon feature is an improvision of <a href="https://wordpress.org/plugins/icon-block/" title="Icon Block Plugin"><strong>The Icon Block</strong></a> of <strong>Nick Diego</strong>. Thank you very much, Nick!

If you want to contribute to my plugin, check it at <a href="https://github.com/tiennguyenvan/wp.org.dragblock/" title="DragBlock GitHub OpenSource">DragBlock GitHub</a>

<h3>DESIGN PHILOSOPHY</h3>
Our philosophy is "block oriented designing" (BOD) which means attaching everything related to a block to itself. By doing that, we can manage things related to an individual block easily and when removing a block, everything that is plugged into it, including server side scripts, client scripts, css and text definitions, will be completely removed as well. This will give a huge impact on improving the performance of websites and also saving the time for developers to not find and clean codes manually like before.

Moreover, we also want to get rid of the era when we treat users like babies by providing them inputs for everything. In the DragBlock, we provide users with dictionaries so they can grasp their layout properties completely without being smashed by a flood of many different kinds of inputs.

In summary, DragBlock empowers users to create professional-looking websites like an expert designer effortlessly with a fresh feeling of managing blocks with simplicity. Everything can be done within the Gutenberg editor, ushering in a new era of Full Site Editing with the DragBlock plugin.

== Screenshots ==
1. **Powerful Block Toolbars** Easily pick design layout for wrapper, font-size, rotation and other attributes for
blocks
2. **Devices and States for Styles** Visually select devices and states for individual styles via the DragBlock
appearance panel
3. **Interaction** Define action and behavior for blocks via the interaction panel
4. **Database Queries** Get posts from the database and place them to custom places via the Database panel
5. **Multilingual Text** Input texts and attributes for different languages easily without need WPML, Polylang or other
language plugin. Saving time by not creating many different pages.
6. **Custom** Create custom forms with beautiful layout and assign form action to process submitted data automatically.
No need Contact-Form 7 or any other form plugins.

== Changelog ==
= 25.11.15 =
* Toolbar popover does not not hide when switching blocks

= 24.08.01 =
* Remove unused toolbar buttons

= 24.07.31 =
* Support query posts by post views

= 24.07.28 =
* Add new Appearance Presets

= 24.06.02 =
* Replace CSS Variable names to suppot non-unicode databases

= 24.05.27 =
* DragBlock default form action does not work
* Support more options for Ignore Loaded Posts filter

= 24.05.12 =
* Support background image gradient picker
* Support fallback color when removing global colors
* Support URL_QUERY renderability/visibility conditions
* Support LANGUAGE renderability/visibility conditions

= 24.04.30 =
* Fixed: cannot modify the grid builder
* Support managing pattern sets
* Fixed: cannot select default layout values
* Fixed: cannot change border for A tag from the toolbar
* Fixed: cannot change box-shadow fields

= 24.04.25 =
* Support new essential appearance styles (text-underline-offset, box-sizing, resize, pointer-event)
* Support stripping title appearance preset
* Fixed: share links does not work

= 24.04.12 = 
* Support changing plugin front-end display language via the 'locale' hook.
* Fixed font-style field.

= 24.02.16 = 
* Support custom taxonomy for Get_Post filter for administrator

= 24.02.11 = 
* Support custom taxonomy for Get_Post filter on the Database panel

= 24.01.30 = 
* Fixed non-negative values for x,y of box-shadow and text-shadow property

= 24.01.18 = 
* Support showing author bio for author boxes
* Fixed error loading invalid parameters for WooCommerce blocks

= 23.12.24 =
* Avoid render the empty parse_item query blocks
* Fixed: Ignore loaded posts does not work
* Fixed: category shortcode not show when there is no parent

= 23.12.18 =
* Fixed woo shop page does not show properly
* Remove SEO meta and graphs to not conflict with this plugin scope
* Support uploading site favicon
* Improve property popover design
* Add more patterns to the pattern library

= 23.12.04 =
* Fixed background toolbar not update background image
* Fixed Pattern library not load if cache timeout

= 23.12.03 =
* Enhanced block toolbars

= 23.11.10 =
* Fix Wrapper Grid Designer
* Generate Schema Graphs and Meta Tags automatically
* Support tag name for the text block

= 23.11.03 =
* Support auto youtube thumbnail inserter
* Support hotkeys to work with Appearance and Attributes properties
* Improve show/hide for hover effect
* Support Style Presets
* Support form template
* Support live content for database queries
* Redesign panels

= 23.10.24 =
* Enhance hover effect for selected blocks
* Support block toolbar navigator
* Add more icons and fonts
* Fix wrong locale for text blocks
* Fix wrong default database query params

= 23.10.22 =
* Support: Appender for empty wrapper blocks
* Fixed: cannot add styles for paragraphs in post editor
* Fixed: remove empty post images

= 23.10.19 =
* Minimized right side panels and highlight block that has database queries
* Show real post content in the Editor
* Add Thread and X-Twitter icon to the icon library
* Change position of panels for better exploration
* Fix wrong session states
* Wrapper toolbars not show in single post
* Support link control suggestion type
* Fix scrolling bugs
* Improve performance

= 23.10.13 =
* Improve editor performance
* Add more appearance styles
* Support scrolling and current link classes

= 23.10.07 =
* Initial Release

= 23.09.28 =
* Fixed: remove direct script enqueue
* Fixed: remove relative path defines
* New: provide public source code github links
* Fixed: update Tested Upto Version
* Fixed: sanitize variables to echo

= 23.09.11 =
* Switched to the CalVer
* Fixed all code issues related to WordPress Coding Standards
* Reorganized files as a Microservices Architecture
* Simplified our variable names to reduce the naming time
* Mapped code commenting to avoid updating the plugin solely for comment changes.

= 23.08.08 =
* Fixed: replaced move_uploaded_file with wp_handle_upload
* Fixed: added nonce verification for all data processes in the font library
* Fixed: cleaned up font credits to minify the initial release
* Fixed: removed unnecessary system option updates

= 23.07.19 =
* Fixed: incorrect stable tag
* Fixed: prevent accessing files directly
* Fixed: sanitized, escaped, and validated all i/o data
* Fixed: verify nonce before processing form data

== Upgrade Notice ==
= 23.07.10 =
First release with the most stable features