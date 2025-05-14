<?php
/**
 * Tools for CMB2
 *
 * @package    OpenWoo_App_Content_Editor
 * @subpackage OpenWoo_App_Content_Editor/Admin
 * @author     Richard Korthuis <richardkorthuis@acato.nl>
 */

namespace OpenWoo_App_Content_Editor\Admin;

/**
 * Helper class for FAQ
 */
class Cmb2_Tools {

	/**
	 * The singleton instance of this class.
	 *
	 * @access private
	 * @var    Cmb2_Tools|null $instance The singleton instance of this class.
	 */
	private static $instance = null;

	/**
	 * Get the singleton instance of this class.
	 *
	 * @return Cmb2_Tools The singleton instance of this class.
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new Cmb2_Tools();
		}

		return self::$instance;
	}

	/**
	 * Initialize the class and set its properties.
	 *
	 * @return void
	 */
	private function __construct() {
		add_filter( 'cmb2_show_on', [ 'OpenWoo_App_Content_Editor\Admin\Cmb2_Tools', 'show_on_slug' ], 10, 2 );
	}

	/**
	 * Show meta box based on slug.
	 *
	 * @param bool  $display Should we display the meta box.
	 * @param array<String, array<String, mixed>> $meta_box The current meta box.
	 *
	 * @return bool
	 */
	public static function show_on_slug( $display, $meta_box ) {
		if ( ! isset( $meta_box['show_on']['key'], $meta_box['show_on']['value'] ) ) {
			return $display;
		}

		if ( 'slug' !== $meta_box['show_on']['key'] ) {
			return $display;
		}

		$post_id = 0;

		// Get the current ID.
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( isset( $_GET['post'] ) ) {
			// phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$post_id = absint( wp_unslash( $_GET['post'] ) );
			// phpcs:ignore WordPress.Security.NonceVerification.Missing
		} elseif ( isset( $_POST['post_ID'] ) ) {
			// phpcs:ignore WordPress.Security.NonceVerification.Missing
			$post_id = absint( wp_unslash( $_POST['post_ID'] ) );
		}

		if ( ! $post_id ) {
			return $display;
		}

		$slug = get_post( $post_id )->post_name;

		if ( is_string( $meta_box['show_on']['value'] ) ) {
			$meta_box['show_on']['value'] = [ $meta_box['show_on']['value'] ];
		}

		// See if there's a match.
		if ( isset( $meta_box['show_on']['compare'] ) && '!=' === $meta_box['show_on']['compare'] ) {
			return ! in_array( $slug, $meta_box['show_on']['value'], true );
		}
		return in_array( $slug, $meta_box['show_on']['value'], true );
	}
}
