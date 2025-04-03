<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and starts the plugin.
 *
 * @link              https://www.openwebconcept.nl
 * @package           OpenWoo_App_Content_Editor
 *
 * @wordpress-plugin
 * Plugin Name:       OpenWoo.App Content Editor
 * Plugin URI:        https://www.openwebconcept.nl
 * Description:       A content editor in WordPress for the OpenWoo.App.
 * Version:           0.0.1
 * Author:            Acato
 * Author URI:        https://www.acato.nl
 * License:           EUPL-1.2
 * License URI:       https://opensource.org/licenses/EUPL-1.2
 * Text Domain:       openwoo-app-content-editor
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'OWC_OWACE', '0.0.1' );

// Load Composer autoloader if available.
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
}

require_once plugin_dir_path( __FILE__ ) . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'class-autoloader.php';
spl_autoload_register( [ '\OpenWoo_App_Content_Editor\Autoloader', 'autoload' ] );
/**
 * Begins execution of the plugin.
 */
new \OpenWoo_App_Content_Editor\Plugin();
