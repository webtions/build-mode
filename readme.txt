=== Build Mode – Maintenance Mode & Coming Soon Page ===
Contributors: hchouhan, themeist
Donate link: https://themeist.com/plugins/build-mode/
Tags: maintenance mode, maintenance page, coming soon page, under construction, coming soon
Requires at least: 6.0
Tested up to: 6.9
Stable tag: 0.2.0
Requires PHP: 7.4
License: GPL-3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.txt

Maintenance Mode & Coming Soon Made Easy – Display any page as your maintenance or coming-soon screen, no coding required.

== Description ==

**Build Mode** lets you put your WordPress site into **maintenance mode** or display a **coming‑soon page** / **under‑construction page** with one click. Instead of a generic message, you can select and display any page you’ve built — with the Block Editor, Classic Editor, or a page builder. Visitors will see your chosen **maintenance or coming‑soon page**, styled using your theme’s CSS and JS, while logged‑in administrators continue working behind the scenes.

When Build Mode is active, only the content area of your chosen maintenance page is displayed. The header, footer and navigation are automatically removed.

### Features
- Enable or disable Build Mode from the **Admin Bar**
- Choose any page as your custom **maintenance**, **coming‑soon** or **under‑construction** screen
- Logged‑in admins bypass maintenance mode automatically
- Sends correct **503** and **Retry‑After** headers (SEO‑friendly)
- Lightweight and secure, built with WordPress best practices
- Compatible with classic and block themes
- Translation‑ready

### Use cases
- Show a custom **under‑maintenance** or **coming‑soon** screen while you redesign or update your site
- Let search engines know your downtime is temporary with proper HTTP headers
- Keep working on your site privately without showing a broken layout to visitors

[Plugin Page on Themeist](https://themeist.com/plugins/build-mode/)
[GitHub Repo](https://github.com/webtions/build-mode)

== Installation ==

1. Go to **Plugins → Add New** in your WordPress dashboard.
2. Search for **Build Mode**, then click **Install Now** → **Activate**.
3. Go to **Settings → Build Mode**, select your maintenance or coming‑soon page, and check the **Enable Build Mode** box.
4. Click **Save Changes** to activate maintenance mode.
5. You can also enable/disable Build Mode anytime from the **Admin Bar** menu.

== Frequently Asked Questions ==

= Can I design my own maintenance or coming‑soon page? =
Yes — use any page built with the Block Editor, Classic Editor or a page builder.

= Will administrators still see the full site? =
Yes. Logged‑in users with the required capability (default: `manage_options`) bypass Build Mode.

= Does this impact SEO? =
No. Build Mode sends proper HTTP 503 + `Retry-After` headers (default: 24 hours) to signal temporary downtime.

= Can I use Build Mode for a coming‑soon or under‑construction page? =
Yes. By selecting a specific page in the plugin settings, you can show a custom coming‑soon or under‑construction screen while you build or redesign your site.

= Can editors manage Build Mode? =
By default, only Administrators can toggle it. Developers can change this using the `build_mode_capability` filter.

= For developers: are there filters available? =
Yes, Build Mode provides two filters.

1. `build_mode_capability` — Change the capability required to manage Build Mode.
   Example (allow Editors):
   ```
   add_filter( 'build_mode_capability', function () {
       return 'edit_pages';
   } );
   ```

2. `build_mode_retry_after` — Control the Retry‑After header value (in seconds).
   Default is 24 hours (`DAY_IN_SECONDS`). Example (set to 1 hour):
   ```
   add_filter( 'build_mode_retry_after', function () {
       return HOUR_IN_SECONDS;
   } );
   ```

= Where can I get help? =
You can ask your question in the [WordPress.org Support Forum](https://wordpress.org/support/plugin/build-mode/)

== Changelog ==

= 0.2.0 – (16 Dec 2025) =
* Fix: Allowed query strings in static asset URLs to prevent 404/MIME type errors.
* Feature: Added "Edit Page" shortcut link in settings.

= 0.1.0 – (8 Sep 2025) =
* Initial release
