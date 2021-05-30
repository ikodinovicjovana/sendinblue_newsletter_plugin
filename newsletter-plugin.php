<?php
/**
 * Sendinblue Newsletter Wordpress Plugin
 *
 * Plugin Name: Sendinblue Newsletter
 * Description: Creating newsletter using Sendinblue Api
 * Version:     1.0.0
 * Author:      Jovana Ikodinovic
 * Requires PHP: 7.4
 * License:     GPLv2 or later
 * License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * Text Domain: sendinblue-news
 */

namespace Jovana\SendInBlue;

define( 'SENDINBLUE_NEWSLETTER_VERSION', '1.0.0' );
define( 'SENDINBLUE_NEWSLETTER_URL', plugin_dir_url(__FILE__));
define( 'SENDINBLUE_NEWSLETTER_PATH', __FILE__);
define( 'SENDINBLUE_NEWSLETTER_PLUGIN_DIR', plugin_dir_path(__FILE__));

include "vendor/autoload.php";

new NewsletterInit();
new NewsletterForm();



