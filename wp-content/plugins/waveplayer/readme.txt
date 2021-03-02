=== Wave Player ===
Author: Luigi Pulcini
Homepage: www.waveplayer.info
Author Homepage: www.luigipulcini.com
Tags: audio, audio player, media, mp3, music, player, playlist, plugin, wave, waveform, waveplayer, wordpress
Version: 3.1.3
Tested up to: 5.5.1
WC tested up to: 4.6.0
Requires at least: 5.0
Requires PHP: 7.0
License: Envato Standard License
License URI: https://codecanyon.net/licenses/standard

WavePlayer is a fully customizable audio plugin for WordPress. Its interface is built around the waveform of the audio file that is playing back.

== Description ==

WavePlayer is a fully customizable, responsive HTML5 audio plugin for WordPress. Its interface is built around the waveform of the audio file that is playing back.
Visit the official page at [www.waveplayer.info](https://www.waveplayer.info)

Here is a list of the main features:

* responsive interface, with a modern looking style
* HTML5 support
* WordPress Multisite support
* four different sizes that automatically adapt to your page
* full integration with the WordPress Media Manager and WooCommerce
* Visual Editor in WordPress Post Editor
* archival of peak files for an instantaneous access to the waveforms

== Installation ==

*   In WordPress Plugins section, click on the Add new button, right beside the Plugins page title.
*   Click on the Upload Plugin button, right beside the Add Plugins page title.
*   Click on the Choose file button in order to select the location of your waveplayer.zip file.
*   Browse to the location where you downloaded the waveplayer.zip file.
*   Click on the Open button.
*   Once WordPress has finished uploading the plugin files, click on the Activate Plugin link.
*   The plugin is now active. You can click on the Settings link right below its name or go to Settings -> WavePlayer to configure its options.

== Changelog ==

= 3.1.3 =
* FIX: Peak files not being generated when Content-Length header is not received (usually when mod_deflate is active)
* FIX: Players that are hidden in the DOM are invoked by the sticky player
* FIX: Product players only being rendered in shop and single product pages but not in other archive-like pages (featured, related, etc.)

= 3.1.2 =
* NEW: AudioType can be manually redefined using the Custom JS option for compatibility purposes
* FIX: Peak files for newly uploaded files not being generated
* FIX: Uncaught Promise error in the console when clicking on the playlist

= 3.1.1 =
* NEW: Scrolling to a marker on the page is now optional
* FIX: WavePlayer not rendered for REST requests
* FIX: Lazy-loading interrupts the playback
* FIX: Smoother transition between tracks

= 3.1.0 =
* NEW: Faster loading of tracks and instances
* NEW: Time markers can be added to the page by specifying the data-marker attribute of any type of element
* NEW: Native support for Google Tag Manager
* NEW: Custom CSS and JS editors are now using CodeMirror
* NEW: All the XMLHttpRequest calls have been replaced with the Fetch API
* FIX: Graphic rendering was improved for both static and animated waveforms
* FIX: Frequency animation is now logarithmic instead of linear
* FIX: The non-minified script gets enqueued even when SCRIPT_DEBUG is false
* FIX: Waveform settings not applying in realtime in the Waveform option page
* FIX: Tumb'n'Wave skin not appearing in WC Product Table Pro
* FIX: Player icons font missing in the backend
* FIX: Taxonomy terms assignment not working properly in the modal dialog
* FIX: Peak regeneration always regenerating peaks regardless of the overwrite option

= 3.0.9 =
* FIX: Safari not being able to reconnect the ScriptProcessorNode (audio muted after first playback)
* FIX: Wrong version being printed in the setting page title

= 3.0.8 =
* NEW: Complete restyling of the option page in the backend
* FIX: WavePlayer block not available when Gutenberg 8.4.0 or later is installed
* FIX: Title in the popup variation form being duplicated
* FIX: Cart button not visible for remotely hosted preview files
* FIX: Likes increasing when user unlikes a track
* FIX: Autoplay option preventing the player from loading as expected

= 3.0.7 =
* NEW: The default skin for the player in the Barn2 Product Table is now selectable in the Product Table settings
* NEW: The FontAwesome resources are not loaded below the fold and optimized for better PageSpeed performance metrics
* FIX: Waveform not being rendered in the sticky player
* FIX: OceanWP images for non-audio product disappearing
* FIX: Reading local files that are not uploaded to the Media library returns an error
* FIX: Cache returning empty track list when using external files
* FIX: Variation form popup not showing a close button
* FIX: Multitrack instances fail to jump to the next instance when repeat is set to false

= 3.0.6 =
* NEW: Dynamic CSS moved below the fold and aggregated/minified for better page speed performance
* NEW: Lazy-loading of the instances that are not in the viewport
* NEW: Instance caching to improve the server response time
* FIX: Share buttons not working as expected
* FIX: The url attribute not transforming custom placeholders into links
* FIX: SVG icon definitions create an empty space at the bottom of the page

= 3.0.5 =
* FIX: Frontend breaking on websites without WooCommerce installed

= 3.0.4 =
* NEW: Completely refactored code in compliance with the WPCS (WordPress Coding Standards)
* NEW: Audio player fallback to mitigate the bug currently affecting iOS 13
* NEW: A more detailed positioning of the player in the single product page
* NEW: When playing remote audio files for the first time, the local copy is created via AJAX
* FIX: Barn2 WooCommerce Product Table support malfunctioning
* FIX: Improved out-of-the-box compatibility with WooCommerce Themes

= 3.0.3 =
* NEW: Added support to the most popular Premium and Free Themes
* NEW: It is now possible to select the default thumbnail size
* FIX: Peak files for external URLs not being stored correctly
* FIX: ID of parameter-less waveplayer shortcode (WC loop) being calculated incorrectly
* FIX: Long titles in the sticky player shrinking the waveform
* FIX: Typing a color code in the palette editor not working
* FIX: Empty thumbnail in sticky player for external files

= 3.0.2 =
* NEW: In the Gutenberg editor, it is now possible to transform an audio block into a WavePlayer block
* ENH: The transformations of previous shortcodes into Gutenberg blocks has been enhanced
* FIX: Automatic updates not working under certain installations
* FIX: Purchase code disappearing when saving the settings
* FIX: Peak files for external URLs not being stored correctly
* FIX: Duplicated featured image in the shop products
* FIX: Color picker malfunctioning in the Palettes tab
* FIX: Changes to the palette not being stored upon saving
* FIX: Cart icon not being updated in the sticky player when moving from track to track

= 3.0.1 =
* FIX: The 'cart' placeholder is not correct in the sticky player template
* FIX: The plugin crashes websites with Elementor
* FIX: Other minor or cosmetic bugs

= 3.0.0 =
* NEW: A completely re-designed code, for both server and client sides
* NEW: Native support for audio analysis, peak saving and waveform rendering without WaveSurfer.js
* NEW: WavePlayer Block for the new Gutenberg editor
* NEW: WavePlayer Widget for Elementor
* NEW: Custom column for Barn2 WooCommerce Product Table
* NEW: SoundCloud support for both tracks and playlists
* NEW: Waveform fully customizable animation
* NEW: Color schemes and 1-click color scheme generator
* NEW: Dark mode: light and dark color schemes automatically reacts to the visitor device setting
* NEW: Optimized AJAX endpoint for faster track data loading
* NEW: Fully customizable sticky player for the footer or header
* NEW: Interface templates, with unlimited possibilities of custom design
* NEW: possibility to use different interfaces for different sections of your website
* NEW: Possibility to choose a specific interface on a single instance
* NEW: Expansion interface packs, that you can purchase separately
* NEW: Customizable templates to create your own placeholders
* NEW: New updater class independent from external libraries
* NEW: Customizable font using Google fonts
* NEW: Cart buttons now allow to add both simple and variable products, with the possibility to select the product variation

= 2.4.2 =
* FIX: Minor script improvements

= 2.4.1 =
* CHANGE: The events triggered when interacting with the player have now been improved

= 2.4.0 =
* NEW: WavePlayer now accepts playlists of external files
* FIX: Minor optimizations to the main script

= 2.3.6 =
* BUGFIX: A bug in the main script preventing the player from loading in some configurations

= 2.3.5 =
* BUGFIX: The default placeholder gets the wrong class

= 2.3.4 =
* NEW: Improvements in the placeholder management

= 2.3.3 =
* NEW: It is now possible to manipulate the track array using the waveplayer_tracks_playlist filter

= 2.3.2 =
* BUGFIX: The CSS stylesheet contained an error causing the disappearance of the thumbnail of the tracks in WooCommerce

= 2.3.1 =
* BUGFIX: The download button increments the counter on click without downloading any file
* NEW: It is now possible to use WavePlayer in external sites using an embed HTML element (requires an embed-attachment.php template added to your Theme)

= 2.3.0 =
* NEW: The icons are now using Font Awesome 5.0
* NEW: A more streamlined HTML markup that makes it easier to customize the player using your favorite style
* NEW: How all the instances on a page load is now selectable in the Player Options settings
* NEW: In the Maintenance page of the Settings, you can now generate the peak files for all the audio attachments in the Media library.
* NEW: If WooCommerce is active and a track is associated with a product, two new placeholders are available in the Infobar and Playlist row templates: product_id and product_url
* NEW: The info available for each track can now be filtered to make any custom information available in the frontend.
* NEW: The thumbnail images use img elements with srcset and sizes attributes, allowing the browser to always select the best image resolution
* NEW: When using the "Add to cart" button, the icon now changes to a spinnner until the completion of the operation
* NEW: The cart button now reacts to the AJAX mini cart, so that when an item is removed from the cart using AJAX, the cart button reflects that change immediately (requires WooCommerce 3.5.0)
* NEW: You can now add your own information to each track using the filter hook
* FIX: In the post editor, it is now possible to edit the [audio] and [playlist] shortcodes, with a visual rendition of WavePlayer, if the overriding option is active
* FIX: The title attributes of the icon appearing in the Info bar or the playlist are now passed through the localization variable and, as such, they are fully translatable
* BUGFIX: WavePlayer hangs loading the instances when WordPress is installed in a subfolder of the root

= 2.2.2 =
* NEW: JS and CSS files are now minified. Moreover, the front-end comes with a single script.
* BUGFIX: The Custom CSS and Custom JS are not incorporated into the page

= 2.2.1 =
* NEW: When a new audio file is loaded for the first time, a message displays the progress of the audio analysis before rendering the waveform
* BUGFIX: In the Waveform tab of the Settings, the waveform preview is blank
* BUGFIX: In the post editor, sporadically the preview of the player does not show up correctly

= 2.2.0 =
* NEW: The title attribute of the icons in the info bar and playlist row are now translatable using the .po/.mo files
* FIX: The compatibility with Safari 9 and Safari 10 has been restored for desktops, tablets and smartphones
* FIX: Minor compatibility issues in the Product and Store pages
* BUGFIX: When pausing a track, the next playback always starts from the beginning instead of the current time
* BUGFIX: Spinning pause icon when the player completes a track loading

= 2.1.4 =
* BUGFIX: WavePlayer trigger an error while trying to generate waveforms for newly uploaded tracks

= 2.1.3 =
* BUGFIX: Social buttons broken with update to version 2.1.0

= 2.1.2 =
* BUGFIX: The cart button did not work properly starting from version 2.1.0

= 2.1.1 =
* NEW: WavePlayer can now correctly calculate the width of the waveform area even when the player instance is inside an hidden element
* CHANGE: Because of the previous feature, the 'AJAX Containers' option was permanently removed

= 2.1.0 =
* NEW: WavePlayer now supports all type of products in woocommerce
* CHANGE: In order to support all types of product in WooCommerce, the Preview Files are now in the "Advanced", instead of the "General" section
* NEW: Completely redesigned audio engine: using only one audio element per page, loading times and memory management are more optimized
* FIX: Minor fixes to the aspect of the player

= 2.0.16 =
* NEW: WavePlayer integration with WooCommerce now supports all kind of products (simple, variable, grouped)
* FIX: WavePlayer gives now the right priority to featured image and gallery for the WooCommerce products

= 2.0.15 =
* NEW: Nearly seamless loop playback when using one track per instance and repeat is active
* BUGFIX: PHP Warning when overriding a playlist shortcode

= 2.0.14 =
* NEW: Better integration with WooCommerce new gallery feature
* FIX: Play count now increases when only 10% of a track gets played
* FIX: Default thumbnail did not show up for any product using the new WooCommerce 3.0.0 and above

= 2.0.12 =
* NEW: WavePlayer now detects the visibility status of elements to automatically refresh the content of the waveform. This is particularly useful when including WavePlayer instances into dynamically toggable elements.
* BUGFIX: Clicking on a playlist item in scenario with multiple playlists on a single page always starts the first track of the last instance.

= 2.0.11 =
* NEW: Placeholders now include 'attributes' in the form %key{"attribute":value}%, for future template developments
* BUGFIX: Player size on WooCommerce Shop page did not correspond to settings
* BUGFIX: Social share links are populated with an incorrect URL
* BUGFIX: Default thumbnail doesn't show in the playlist
* BUGFIX: Under WooCommerce integration panel, a query assumes the posts table name is "wp_posts"

= 2.0.10 =
* NEW: Added a "limit" parameter to the shortcode, so you can get only the first n result in combination with the "music_genre" parameter
* FIX: WooCommerce 3.0 deprecated the Download Type option. This made WavePlayer's integration malfunctioning.
* BUGFIX: On iOS devices, playback does not start when clicking on a playlist row

= 2.0.9 =
* BUGFIX: Missing info and cover art for remote files.

= 2.0.8 =
* NEW: When the playlist is scrollable, jumping to a track makes the corresponding item in the list visible.

= 2.0.7 =
* BUGFIX: The option "Jump to the next player" does not stay checked saving the settings.

= 2.0.6 =
* BUGFIX: Downloads counter does not get updated

= 2.0.5 =
* NEW: WavePlayer now overrides both audio and playlist shortcodes
* BUGFIX: Install fails on WordPress versions older than 4.5

= 2.0.4 =
* NEW: WavePlayer now supports auto update from the Plugins page
* BUGFIX: WooCommerce product thumbnail not showing for non-music products

= 2.0.3 =
* BUGFIX: Players on WooCommerce product pages always show in large size

= 2.0.2 =
* NEW: Added a track sharer for LinkedIn
* BUGFIX: Peak files for new external files don't get generated

= 2.0.1 =
* BUGFIX: Player does not load on website where WooCommerce is not installed or active
* BUGFIX: Players don't show the spinning icon when page is loading
* BUGFIX: On WooCommerce Shop Page, first item never gets listed
* BUGFIX: When batch creating WooCommerce products, progress bar doesn't work properly

= 2.0.0 =
* NEW: A new customizable Playlist Panel. The webmaster can configure the info and buttons displayed on each row
* NEW: WooCommerce integration. Preview files and Music Type (singles or albums) for simple, virtual, music, downloadable products.
* NEW: WooCommerce integration. Plenty of options to automatically integrate the player in your music products.
* NEW: WooCommerce integration. The webmaster can now create products based on audio files using a batch process. It is also possible to add a cart button on both the Info Bar and the Playlist Panel that interact with WooCommerce cart through AJAX.
* NEW: Peak files now get generated upon uploading of new audio files.
* NEW: Loading time have been reduced enormously. WavePlayer now loads all the instances on one page with a single AJAX call to the server. This allows all the instances to load simultaneously.
* NEW: New placeholders to insert info and buttons (like, share, cart, statistics) in both the Info Bar and the Playlist Panel
* NEW: Plugin's options don't get removed from the database when removing the plugin. This is particularly useful when updating to a new version of the plugin without losing your favorite settings.
* NEW: Managing peak files from the Maintenance tab of the Settings page is now easier and more advanced.
* NEW: Thumbnails for audio files in the Media Library can now show the title of a track instead of the file.
* NEW: A new method "refresh" that allows you to force the redraw of the waveform and is particularly useful when loading or showing content via javascript
* NEW: Current position and total length of the current track are now shown on the waveform
* FIX: Minor CSS improvements

= 1.4.2 =
* BUGFIX: Info Bar broken when inserting the %file% placeholder.

= 1.4.1 =
* BUGFIX: Playback is not available until all instances in the page completed loading

= 1.4.0 =
* NEW: Thanks to a completely rewritten AJAX call strategy, instance loading is now twice as fast as before.
* NEW: In case of multiple instances in one page, the instances load in the order they appear on the page (from top to bottom).
* NEW: It is now possible to choose whether WavePlayer override the audio shortcode or not
* NEW: WavePlayer is now fully compatible with Internet Explorer 11. The compatibility with Internet Explorer 9 and 10 will be improved soon.
* BUGFIX: The audio shortcode did not look correctly in the Post Editor and it was not possible to edit its content

= 1.3.4 =
* NEW: When automatically replacing an audio shortcode, WavePlayer now tries to verify if the URL provided actually corresponds to an attachment in the Media Library. If it does, WavePlayer uses the attachment ID instead of its URL.

= 1.3.3 =
* BUGFIX: Automatic replacement of audio shortcodes does not work if the src attribute is not provided

= 1.3.2 =
* NEW: The Info Bar automatically hides if one of the placeholders used in the template does not get replaced by any data value
* NEW: A spinning icon shows the loading status of the player. This is particularly useful when loading a file for the first time or from a remote location.
* BUGFIX: Getting peaks for remote audio files generates cross domain XHR error

= 1.3.1 =
* BUGFIX: Track's title not displaying properly when original audio file does not have the corresponding ID3 tag

= 1.3.0 =
* NEW: Introducing a new taxonomy 'Music Genre' for attachments
* NEW: Create a player that will automatically include all audio files pertaining to one or more 'Music Genre'
* NEW: Create an instance simply providing the URL of an external audio file: WavePlayer will retrieve all the info stored in the ID3 tags, including a cover art picture if available, and make a local copy for a faster future access (only the ID3 tags and the cover art will be stored locally, not the audio file).
* NEW: Customize the default image that appears when a track does not have its own thumbnail
* FIX: Color Pickers now work also in the Media Manager, not only in the WavePlayer Settings page
* FIX: Minor interface improvements

= 1.2.2 =
* BUGFIX: Default settings not applying correctly to the shortcode when editing its properties in the Media Manager
* BUGFIX: 'autoplay' not working properly in combination with 'repeat_all'
* FIX: A recent Chrome update changed some CSS default behaviors that messed up with the aspect of the player controls
* FIX: Minor improvements to the styling of the player controls

= 1.2.1 =
* BUGFIX: WavePlayer preview not showing properly in the post editor on some WordPress multisite installations

= 1.2.0 =
* NEW: Multisite support. WavePlayer is now fully compatible with any WordPress Multisite installation
* FIX: Graphic improvements in Safari

= 1.1.2 =
* NEW: Added a volume control
* NEW: Added a button to toggle the visibility of the title bar
* BUGFIX: "No container found" error in javascript of the admin area
* BUGFIX: the "NEXT" skip button disappears on last track even with repeat_all activated if the playlist only contains two tracks

= 1.0.18 =
* First release
