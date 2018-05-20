<?php

/**
 * Plugin Name:       URL Shortener
 * Plugin URI:        https://github.com/CodeNegar/url-shortener-wordpress-plugin
 * Description:       This is a simple WordPress plugin for https://github.com/CodeNegar/url-shortener
 * Version:           1.0.0
 * Author:            Farhad Ahmadi
 * License:           GPL-2.0+
 * Based on:          wppb.io Boilerplate
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       url-shortener
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Current plugin version.
define( 'URL_SHORTENER_VERSION', '1.0.0' );

// The core plugin hooks.
require plugin_dir_path( __FILE__ ) . 'includes/class-url-shortener.php';

// Admin settings page
require plugin_dir_path( __FILE__ ) . 'includes/class-url-shortener-settings.php';

// Execute the plugin.
function run_url_shortener() {

	$plugin = new Url_Shortener();
	$plugin->get_version();
}

run_url_shortener();