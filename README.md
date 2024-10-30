=== HTML to PDF Converter ===

Contributors: html2pdfapp
Tags: pdf, html, save, print, page, page to pdf, save to pdf, convert to pdf, pdf button, conversion, converter, html2pdf, html2pdf.app
Requires at least: 5.0
Requires PHP: 7.0
Tested up to: 6.6.2
Stable tag: 1.0.7
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A WordPress plugin that allows you to convert any WordPress page or post to a PDF file using the [html2pdf.app](https://html2pdf.app) API.

== Description ==

The "HTML to PDF Converter" WordPress plugin created by [html2pdf.app](https://html2pdf.app), provides an easy way to convert any WordPress page or post to a PDF file. Simply install the plugin, configure your API key and conversion settings, and use the shortcode  `[html2pdf text="Save as PDF"]` to add a PDF conversion link to any page or post on your site.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/html-to-pdf-converter` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the "Plugins" screen in WordPress.
3. Configure plugin going to the configuration page: "Settings -> HTML to PDF".
4. Use the `[html2pdf text="Save as PDF"]` shortcode to display the PDF conversion link on your site.

== Plugin Settings ==

To configure the plugin, go to the "Settings -> HTML to PDF" page and enter your html2pdf.app API key. You can get the API key by registering an account on https://dash.html2pdf.app/registration.

You can also customize the PDF conversion settings, including the format, orientation (portrait or landscape), margins, and custom page size.

== Usage ==

To display the PDF conversion link using the shortcode, simply add the following shortcode to any page or post: `[html2pdf text="Save as PDF"]`

== Examples ==

Use "media" parameter to activate special styles for printing: `[html2pdf text="Save as PDF" media="print"]`.

CSS example to show only relevant part of the web page:

<pre>
@media print {
  /* Hide everything */
  * {
      visibility: hidden;
      margin: 0;
      padding: 0;
  }

  /* Make only your desired content visible */
  .your-visible-content * {
      visibility: visible;
  }

  /* Optionally hide the conversion link from the PDF */
  .html2pdf_button {
      visibility: hidden!important;
  }
}
</pre>

== Screenshots ==

Screenshot of the plugin settings page.
![HTML  to PDF converter](/assets/html-to-pdf-converter.png "HTML  to PDF converter")

== Frequently Asked Questions ==

== Changelog ==

= 1.0.7 =
* Update icon, increase compatibility with the latest wordpress version

= 1.0.6 =
* Update readme file with examples

= 1.0.5 =
* Add possibility to pass media parameter through the shortcode

= 1.0.4 =
* Improve error reporting

= 1.0.3 =
* Icon, author URI and support email added

= 1.0.2 =
* Initial version

Initial release of the plugin.
