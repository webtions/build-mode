# Build Mode – Maintenance Page

> Put your WordPress site into maintenance mode with one click.
> Show **only the content** of a page you choose (no header/footer/navigation) while admins keep working.

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

### 0.1.0 — 8 Sep 2025
- Initial release
- Settings: enable toggle + maintenance page select
- Admin Bar toggle with nonce protection
- Minimal frontend wrapper rendering **content-only**
- Sends 503 + Retry-After (24h, filterable)
- Security hardening and WPCS/PHPStan compliance

</details>
