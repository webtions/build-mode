# Build Mode – Maintenance Mode & Coming Soon Page

[![Build Mode Plugin](https://img.youtube.com/vi/w8S94TE6FV4/0.jpg)](https://www.youtube.com/watch?v=w8S94TE6FV4)

**Build Mode** lets you put your WordPress site into **maintenance mode** or display a **coming‑soon page** / **under‑construction page** with one click.

**Important:** Build Mode intentionally renders **only the main page content** to avoid exposing menus or links during maintenance. Theme styles/scripts still load so your content looks correct.

If this plugin helps you, please consider ⭐️ leaving a 5-star review on WordPress.org.

---

## Features

- One-click **toggle in the Admin Bar**
- Pick any existing **Page** as the maintenance screen
- Shows **only page content** (no theme header/footer/nav)
- Sends proper **HTTP 503** status + **Retry-After** (defaults to 24h)
- Admins bypass automatically; capability is filterable
- Works with classic & block themes
- Lightweight, secure, PHPCS + PHPStan clean

---

## Security

Found a security issue? Please report responsibly to `support@themeist.com`.

---

## License

GPL-3.0
See the license: https://www.gnu.org/licenses/gpl-3.0.txt

---

## Development

<details>
<summary><strong>Show setup</strong></summary>

### Clone & Install

    git clone https://github.com/webtions/build-mode.git
    cd build-mode
    composer install

### Useful Commands

**Lint (PHP syntax):**

    composer lint

**Check code style (WPCS):**

    composer check

**Fix fixable style issues:**

    composer fix

**Static analysis (PHPStan):**

    composer analyze

**Run tests (if present):**

    composer test

> This plugin follows the official WordPress Coding Standards:
> https://developer.wordpress.org/coding-standards/

</details>

---

## Changelog

<details>
<summary><strong>View changelog</strong></summary>

### 1.0.0 — 5 Jan 2026
- Feature: Added "Create Maintenance Page" button for one-click setup.
- Feature: Added "Simple Maintenance Mode" block pattern.
- Enhancement: Improved settings UI with quick actions.

### 0.2.0 — 16 Dec 2025
- Fix: Allowed query strings in static asset URLs to prevent 404/MIME type errors.
- Feature: Added "Edit Page" shortcut link in settings.

### 0.1.0 — 8 Sep 2025
- Initial release
- Settings: enable toggle + maintenance page select
- Admin Bar toggle with nonce protection
- Minimal frontend wrapper rendering **content-only**
- Sends 503 + Retry-After (24h, filterable)
- Security hardening and WPCS/PHPStan compliance

</details>
