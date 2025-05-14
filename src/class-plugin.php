<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the public-facing side of the site and
 * the admin area.
 *
 * @package    OpenWoo_App_Content_Editor
 * @author     Richard Korthuis <richardkorthuis@acato.nl>
 */

namespace OpenWoo_App_Content_Editor;

use OpenWoo_App_Content_Editor\Admin\Admin;
use OpenWoo_App_Content_Editor\Admin\Categories;
use OpenWoo_App_Content_Editor\Admin\Pages;
use OpenWoo_App_Content_Editor\Admin\FAQ;
use OpenWoo_App_Content_Editor\Admin\Lists;
use OpenWoo_App_Content_Editor\Admin\Menus;
use OpenWoo_App_Content_Editor\Rest_Api\OWACE_Controller;

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and public-facing site hooks.
 *
 * @package    OpenWoo_App_Content_Editor
 */
class Plugin {
	/**
	 * Define the core functionality of the plugin.
	 */
	public function __construct() {
		/**
		 * Enable internationalization.
		 */
		I18n::get_instance();

		/**
		 * Register admin specific functionality.
		 */
		Admin::get_instance();
		Pages::get_instance();
		FAQ::get_instance();
		Lists::get_instance();
		Menus::get_instance();
		Categories::get_instance();

		/**
		 * Register REST API specific functionality.
		 */
		OWACE_Controller::get_instance();
	}
}
