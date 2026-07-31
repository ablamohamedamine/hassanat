

# Hassanat

**Hassanat** is a lightweight WordPress plugin that displays Islamic Adhkar (remembrances of God) to website visitors through elegant, non-intrusive pop-up notifications. Designed with a privacy-first approach, it requests user consent before displaying notifications and respects visitor preferences using browser cookies. The interface is fully optimized for Arabic and RTL layouts, featuring the classic Amiri font.

## Features
- 🔒 **Privacy-First Consent:** Prompts visitors before showing notifications
- 🍪 **Persistent Preferences:** Saves user consent/decline status for 365 days via cookies
- 📖 **Random Dhikr Rotation:** Fetches and displays Adhkar randomly from a JSON dataset
- ⚡ **AJAX-Powered:** Smooth, non-blocking updates with secure WordPress nonce verification
- 🌍 **RTL & Arabic Optimized:** Native right-to-left layout and typography
- 📦 **Lightweight Architecture:** Object-oriented PHP, zero database queries, async script loading

## Requirements
- WordPress 5.5 or higher
- PHP 7.0 or higher
- jQuery (bundled with WordPress)

## Installation
1. Download or clone this repository.
2. Upload the `hassanat` folder to your WordPress plugins directory (`/wp-content/plugins/`).
3. Activate the plugin from the **Plugins** menu in your WordPress admin dashboard.
4. Ensure the `data/adhkar.json` file exists in the plugin directory. This file supplies the Dhikr texts used in the notifications.

## Usage
Once activated, Hassanat runs automatically on the frontend of your site:

- **Consent Prompt:** First-time visitors are shown a consent popup asking if they wish to receive Adhkar notifications.
- **Notification Display:** If the user accepts, a notification popup appears after a randomized delay (1–15 seconds), displaying a randomly selected Dhikr.
- **User Interaction:** Visitors can click "تمت القراءة" (Read) to close and schedule the next notification, or "لا أريد ذكر الله" (No thanks) to opt out. The plugin saves this choice in a `hassanat` cookie.
- **Customizing Content:** To modify or add new remembrances, edit the `data/adhkar.json` file inside the plugin folder. Maintain the nested array structure expected by the frontend JavaScript.

## Architecture Overview
- `includes/class-consent-handler.php`: Renders the consent template and manages the initial cookie check.
- `includes/class-notification-handler.php`: Handles AJAX endpoints (`hassanat_display_notification`, `hassanat_change_dhikr`), nonce verification, and notification rendering.
- `assets/js/main.js`: Manages popup visibility, AJAX communication, random Dhikr selection, and cookie persistence.
- `assets/css/notifications-style.css`: RTL-styled popups with custom button states and transition effects.

## License
Hassanat is licensed under the [GNU General Public License v3](http://www.gnu.org/licenses/gpl.html).

## Author
Developed by **Mohamed Amine Abla**  
Website: [https://ablamohamedamine.com](https://ablamohamedamine.com)
