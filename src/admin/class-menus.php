<?php
/**
 * Helper class for Menus
 *
 * @package    OpenWoo_App_Content_Editor
 * @subpackage OpenWoo_App_Content_Editor/Admin
 * @author     Richard Korthuis <richardkorthuis@acato.nl>
 */

namespace OpenWoo_App_Content_Editor\Admin;

/**
 * Helper class for Menus
 */
class Menus {

	/**
	 * The singleton instance of this class.
	 *
	 * @access private
	 * @var    Menus|null $instance The singleton instance of this class.
	 */
	private static $instance = null;

	/**
	 * Get the singleton instance of this class.
	 *
	 * @return Menus The singleton instance of this class.
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new Menus();
		}

		return self::$instance;
	}

	/**
	 * Initialize the class and set its properties.
	 *
	 * @return void
	 */
	private function __construct() {
		add_action( 'init', [ 'OpenWoo_App_Content_Editor\Admin\Menus', 'add_menus' ] );
	}

	/**
	 * Add menus
	 *
	 * @return void
	 */
	public static function add_menus() {
		register_nav_menus(
			[
				'owace-this-website-menu' => esc_html__( 'OpenWoo - This website', 'openwoo-app-content-editor' ),
				'owace-quick-links-menu'  => esc_html__( 'OpenWoo - Quick links', 'openwoo-app-content-editor' ),
			]
		);
	}
}
