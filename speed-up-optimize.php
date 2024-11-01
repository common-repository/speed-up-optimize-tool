<?php
/**
 * Plugin Name: App Performance Tool
 * Version: 1.0.10
 * Plugin URI: https://pantheon.io/
 * Description:
 * Author: Carl Alberto
 * Author URI: https://pantheon.io/
 * Requires at least: 4.0
 * Tested up to: 6.1.1
 *
 * Text Domain: speed-up-optimize
 * Domain Path: /languages/
 *
 * @package App Perf
 * @author Carl Alberto
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Load plugin class files.
require_once 'includes/class-speed-up-optimize.php';
require_once 'includes/class-speed-up-optimize-settings.php';

// Load plugin libraries.
require_once 'includes/lib/class-speed-up-optimize-admin-api.php';

// Load custom functionalities.
require_once 'includes/class-speed-up-optimize-main.php';

require_once 'includes/lib/class-suo-environments.php';

/**
 * Returns the main instance of Speed_Up_Optimize to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object Speed_Up_Optimize
 */
function speed_up_optimize() {
	// Plugin main variables.
	$latest_plugin_version = '1.0.10';
	$settings_prefix       = 'plg1_';

	$pluginoptions = array(
		'settings_prefix' => $settings_prefix,
	);

	$instance = Speed_Up_Optimize::instance(
		__FILE__,
		$latest_plugin_version,
		$pluginoptions
	);

	if ( is_null( $instance->settings ) ) {
		$instance->settings = Speed_Up_Optimize_Settings::instance( $instance );
	}

	return $instance;
}

speed_up_optimize();
