=== Youtube Sidebar Widget ===
Contributors: douglaskarr, srcoley
Tags: youtube, sidebar, widget, channeled, playlist, username, video
Requires at least: 2.0.2
Tested up to: 4.0.0
Stable tag: 1.3.4
Version: 1.3.4

List video thumbnails from a Youtube video, account, or playlist in your WordPress theme using widgets. Play the videos right on your theme!

== Description ==

You can specify a YouTube video ID, username (or channel), or playlist id to pull videos from, how many videos to pull, and a filter to pull only the videos you mean to(only if you're pulling by username).

== Installation ==

1. Install the Youtube Sidebar Widget either via the WordPress.org plugin directory, or by uploading the files to your server
2. After activating the Youtube Sidebar Widget, navigate to `Appearance` -> `Widgets`
3. Place the `Youtube Sidebar Widget` widget into a widget slot
4. Configure settings and save!

== Frequently Asked Questions ==

= Is this plugin widget ready? =

Yes!

= Where do I find the Playlist ID? = 

Go to the page of one of the videos in the playlist. In the url you will see something like `&list=PL71B8152559FA2805`, remove the `&list=PL` from the string and you've found your Playlist ID Since v1.2, The "PL" does not need to be removed.

= Can I use a Channel ID? = 

Yes, you can use the Channel ID instead of the username!

== Screenshots ==

1. YouTube Sidebar Widget settings
2. YouTube Sidebar Widget as implemented in the http://marketingtechblog.com sidebar
3. YouTube Sidebar Widget displaying video on http://marketingtechblog.com

== Changelog ==

= 1.3.4 =

* Bugfix: Updated the script and CSS load path so that it works on sites in subdirectories

= 1.3.3 =

* Enhancement: Updated play button to the YouTube play button

= 1.3.2 =

* Enhancement: Added .ysw-autoplay class to autoplay videos initiated with the .ysw-youtube class.

= 1.3.1 =

* Bugfix: Fixed major bug with both ssl and the .ysw-youtube class

= 1.3 =

* Enhancement: Added an autoplay widget setting
* Enhancement: Added .ysw-youtube class that can be added to elements along with an id attribute with a value equal to the YouTube video's ID hash. Clicking these elements will cause the video to appear.

= 1.2.3 =

* Bugfix: Fixed Video ID label on widget settings

= 1.2.2 =

* Bugfix: Turned php all errors off

= 1.2.1 =
* Bugfix: Fixed titles options bug

= 1.2.0 =
* Enhancement: Added Video ID capabilities
* Enhancement: Improved getting videos via username and playlist ID
* Enhancement: You can leave the PL prefix on the playlist ID if you like
* Bugfix: Fixed various CSS issues(Chrome, FF, IE 789)
* Bugfix: Fixed titles option bug

= 1.1.8 =

* Bugfix: Fixes width setting bugs

= 1.1.7 =

* Enhancement: You can now set the video thumbnail width from within the widget options

= 1.1.6 =

* Bugfix: Fixed bugged, tagging new version

= 1.1.5 =

* Enhancement: Now uses curl instead of file_get_contents, etc..

= 1.1.4 =

* Bugfix: Fixed playlist support bug.

= 1.1.3 =

* Bugfix: Widget will no longer display errors with the YouTube data feeds are not available

= 1.1.2 =

* Enhancement: Added YouTube playlist support

= 1.1.1 =

* Bugfix: Fix filter bug

= 1.1 =

* Enhancement: Utilize wp_enqueue_script
* Enhancement: Added screenshots
* Bugfix: Fixed css overlay bugs

= 1.0 =
* Launch!

