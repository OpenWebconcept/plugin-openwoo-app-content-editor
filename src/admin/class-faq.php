<?php
/**
 * Helper class for FAQ
 *
 * @package    OpenWoo_App_Content_Editor
 * @subpackage OpenWoo_App_Content_Editor/Admin
 * @author     Richard Korthuis <richardkorthuis@acato.nl>
 */

namespace OpenWoo_App_Content_Editor\Admin;

/**
 * Helper class for FAQ
 */
class FAQ {

	/**
	 * The singleton instance of this class.
	 *
	 * @access private
	 * @var    FAQ|null $instance The singleton instance of this class.
	 */
	private static $instance = null;

	/**
	 * Get the singleton instance of this class.
	 *
	 * @return FAQ The singleton instance of this class.
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new FAQ();
		}

		return self::$instance;
	}

	/**
	 * Initialize the class and set its properties.
	 *
	 * @return void
	 */
	private function __construct() {
		add_action( 'cmb2_init', [ 'OpenWoo_App_Content_Editor\Admin\FAQ', 'action_cmb2_init' ] );
		add_action( 'init', [ 'OpenWoo_App_Content_Editor\Admin\FAQ', 'register_faq_post_type' ] );
	}

	/**
	 * Register the FAQ post type
	 *
	 * @return void
	 */
	public static function register_faq_post_type() {
		$labels = [
			'name'               => _x( 'FAQs', 'post type general name', 'openwoo-app-content-editor' ),
			'singular_name'      => _x( 'FAQ', 'post type singular name', 'openwoo-app-content-editor' ),
			'menu_name'          => _x( 'OpenWoo - FAQs', 'admin menu', 'openwoo-app-content-editor' ),
			'name_admin_bar'     => _x( 'OpenWoo - FAQ', 'add new on admin bar', 'openwoo-app-content-editor' ),
			'add_new'            => _x( 'Add New', 'faq', 'openwoo-app-content-editor' ),
			'add_new_item'       => __( 'Add New FAQ', 'openwoo-app-content-editor' ),
			'new_item'           => __( 'New FAQ', 'openwoo-app-content-editor' ),
			'edit_item'          => __( 'Edit FAQ', 'openwoo-app-content-editor' ),
			'view_item'          => __( 'View FAQ', 'openwoo-app-content-editor' ),
			'all_items'          => __( 'All FAQs', 'openwoo-app-content-editor' ),
			'search_items'       => __( 'Search FAQs', 'openwoo-app-content-editor' ),
			'parent_item_colon'  => __( 'Parent FAQ:', 'openwoo-app-content-editor' ),
			'not_found'          => __( 'No FAQs found.', 'openwoo-app-content-editor' ),
			'not_found_in_trash' => __( 'No FAQs found in Trash.', 'openwoo-app-content-editor' ),
		];

		$args = [
			'labels'             => $labels,
			'description'        => __( 'FAQ.', 'openwoo-app-content-editor' ),
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'menu_icon'          => 'dashicons-editor-help',
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'supports'           => [ 'title' ],
			'taxonomies'         => [],
		];

		register_post_type( 'owace_faq', $args );
	}

	/**
	 * Register the CMB2 metaboxes
	 *
	 * @return void
	 */
	public static function action_cmb2_init() {
		self::add_faq_metaboxes();
	}

	/**
	 * Add the content blocks metaboxes.
	 *
	 * @return void
	 */
	private static function add_faq_metaboxes() {
		$cmb = new_cmb2_box(
			[
				'id'           => 'faq_metabox',
				'title'        => __( 'FAQ', 'openwoo-app-content-editor' ),
				'object_types' => [ 'owace_faq' ],
			]
		);

		$cmb->add_field(
			[
				'id'   => 'faq_answer',
				'type' => 'wysiwyg',
				'name' => __( 'Answer', 'openwoo-app-content-editor' ),
			]
		);

		$cmb->add_field(
			[
				'id'         => 'faq_sortorder',
				'type'       => 'text',
				'name'       => __( 'Sort Order', 'openwoo-app-content-editor' ),
				'attributes' => [
					'type' => 'number',
				],
			]
		);
	}
}
