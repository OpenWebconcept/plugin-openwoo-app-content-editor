<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @package    OpenWoo_App_Content_Editor
 * @subpackage OpenWoo_App_Content_Editor/Admin
 * @author     Richard Korthuis <richardkorthuis@acato.nl>
 */

namespace OpenWoo_App_Content_Editor\Admin;

/**
 * The admin-specific functionality of the plugin.
 *
 * @package    OpenWoo_App_Content_Editor
 * @subpackage OpenWoo_App_Content_Editor/Admin
 */
class Admin {

	/**
	 * The singleton instance of this class.
	 *
	 * @access private
	 * @var    Admin|null $instance The singleton instance of this class.
	 */
	private static $instance = null;

	/**
	 * Get the singleton instance of this class.
	 *
	 * @return Admin The singleton instance of this class.
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new Admin();
		}

		return self::$instance;
	}
	/**
	 * Initialize the class and set its properties.
	 *
	 * @return void
	 */
	private function __construct() {
		add_action( 'admin_notices', [ 'OpenWoo_App_Content_Editor\Admin\Admin', 'admin_notices' ] );
		add_action( 'admin_init', [ 'OpenWoo_App_Content_Editor\Admin\Admin', 'check_plugin_dependency' ] );
	}

	/**
	 * Show admin notices
	 *
	 * @return void
	 */
	public static function admin_notices() {
		$error_message = get_transient( 'owc_owace_dependency_transient' );

		if ( $error_message ) {
			echo "<div class='error'><p>" . esc_html( $error_message ) . '</p></div>';
		}
	}

	/**
	 * Check if CMB2 plugin is installed and activated
	 *
	 * @return void
	 */
	public static function check_plugin_dependency() {
		if ( ! is_plugin_active( 'cmb2/init.php' )
			|| ! is_plugin_active( 'cmb2-flexible-content/cmb2-flexible-content-field.php' )
		) {
			set_transient( 'owc_owace_dependency_transient', __( 'The plugin OpenWoo.App Content Editor requires CMB2 plugin and CMB2 Field Type: Flexible Content plugin to be installed and activated. The plugin has been deactivated.', 'openwoo-app-content-editor' ), 100 );
			deactivate_plugins( plugin_basename( dirname( __DIR__, 2 ) . '/openwoo-app-content-editor.php' ) );
		} else {
			delete_transient( 'owc_owace_dependency_transient' );
		}
	}
}
