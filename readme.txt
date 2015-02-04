=== Submission Form for Testimonials by WooThemes ===
Contributors: @danieldudzic
Donate link:
Tags: testimonials, testimonials-by-woothemes, woothemes
Requires at least: 4.0.0
Tested up to: 4.0.0
Stable tag: 1.0.0
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

A small, nifty plugin that extends Testimonials by WooThemes and enables your users testimonials submissions via a simple form.

== Description ==

Hey there! I'm your new starter plugin.

Looking for a helping hand? [View plugin documentation](http://domain.com/).

== Usage ==

To display the testimonials submission form via a theme or a custom plugin, please use the following code:

`<?php do_action( 'woothemes_testimonials_submission_form' ); ?>`

To add parameters, please use any of the following arguments, using the syntax provided below:

* 'notify' => 'example@email.com, dummy@email.com' (email addresses that will receive notification messages)
* 'captcha' => 'true' (enable the captcha)

`<?php do_action( 'woothemes_testimonials_submission_form', array( 'notify' => 'example@email.com', 'captcha' => 'true' ) ); ?>`

The same arguments apply to the shortcode which is `[woothemes_testimonials_submission_form]` and the template tag, which is `<?php woothemes_testimonials_submission_form(); ?>`.

== Usage Examples ==

do_action() call:

`<?php do_action( 'woothemes_testimonials_submission_form', array( 'notify' => 'example@email.com', 'captcha' => 'true' ) ); ?>`

Template tag:

`<?php woothemes_testimonials_submission_form( array( 'captcha' => 'true' ) ); ?>`


Shortcode:

`[woothemes_testimonials_submission_form captcha="true" notify="dummy@email.com"]`

== Installation ==

Installing "Submission Form for Testimonials by WooThemes" can be done either by searching for "Submission Form for Testimonials by WooThemes" via the "Plugins > Add New" screen in your WordPress dashboard, or by using the following steps:

1. Download the plugin via WordPress.org.
1. Upload the ZIP file through the "Plugins > Add New > Upload" screen in your WordPress dashboard.
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place `<?php do_action( 'woothemes_testimonials_submission_form' ); ?>` in your templates, or use the provided shortcode.

= How do I contribute? =

We encourage everyone to contribute their ideas, thoughts and code snippets. This can be done by forking the [repository over at GitHub](https://github.com/danieldudzic/woothemes-testimonials-submission-form/).

== Upgrade Notice ==

= 1.0.0 =
* XXXX-XX-XX
* Initial release. Woo!

== Changelog ==

= 1.0.0 =
* XXXX-XX-XX
* Initial release. Woo!