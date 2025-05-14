<?php
/**
 * Helper class for Categories
 *
 * @package    OpenWoo_App_Content_Editor
 * @subpackage OpenWoo_App_Content_Editor/Admin
 * @author     Richard Korthuis <richardkorthuis@acato.nl>
 */

namespace OpenWoo_App_Content_Editor\Admin;

/**
 * Helper class for Categories
 */
class Categories {

	/**
	 * The singleton instance of this class.
	 *
	 * @access private
	 * @var    Categories|null $instance The singleton instance of this class.
	 */
	private static $instance = null;

	/**
	 * Get the singleton instance of this class.
	 *
	 * @return Categories The singleton instance of this class.
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new Categories();
		}

		return self::$instance;
	}

	/**
	 * Initialize the class and set its properties.
	 *
	 * @return void
	 */
	private function __construct() {
		add_action( 'cmb2_init', [ 'OpenWoo_App_Content_Editor\Admin\Categories', 'action_cmb2_init' ] );
		add_action( 'init', [ 'OpenWoo_App_Content_Editor\Admin\Categories', 'register_categories_post_type' ] );
	}

	/**
	 * Register the Categories post type
	 *
	 * @return void
	 */
	public static function register_categories_post_type() {
		$labels = [
			'name'               => _x( 'Categories', 'post type general name', 'openwoo-app-content-editor' ),
			'singular_name'      => _x( 'Category', 'post type singular name', 'openwoo-app-content-editor' ),
			'menu_name'          => _x( 'OpenWoo - Categories', 'admin menu', 'openwoo-app-content-editor' ),
			'name_admin_bar'     => _x( 'OpenWoo - Category', 'add new on admin bar', 'openwoo-app-content-editor' ),
			'add_new'            => _x( 'Add New', 'categories', 'openwoo-app-content-editor' ),
			'add_new_item'       => __( 'Add New Category', 'openwoo-app-content-editor' ),
			'new_item'           => __( 'New Category', 'openwoo-app-content-editor' ),
			'edit_item'          => __( 'Edit Category', 'openwoo-app-content-editor' ),
			'view_item'          => __( 'View Category', 'openwoo-app-content-editor' ),
			'all_items'          => __( 'All Categories', 'openwoo-app-content-editor' ),
			'search_items'       => __( 'Search Categories', 'openwoo-app-content-editor' ),
			'parent_item_colon'  => __( 'Parent Category:', 'openwoo-app-content-editor' ),
			'not_found'          => __( 'No Categories found.', 'openwoo-app-content-editor' ),
			'not_found_in_trash' => __( 'No Categories found in Trash.', 'openwoo-app-content-editor' ),
		];

		$args = [
			'labels'             => $labels,
			'description'        => __( 'Categories.', 'openwoo-app-content-editor' ),
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'menu_icon'          => 'dashicons-category',
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'supports'           => [ 'title' ],
			'taxonomies'         => [],
		];

		register_post_type( 'owace_category', $args );
	}

	/**
	 * Register the CMB2 metaboxes
	 *
	 * @return void
	 */
	public static function action_cmb2_init() {
		self::add_category_metaboxes();
	}

	/**
	 * Add the category metaboxes.
	 *
	 * @return void
	 */
	private static function add_category_metaboxes() {
		$cmb = new_cmb2_box(
			[
				'id'           => 'category_metabox',
				'title'        => __( 'Category', 'openwoo-app-content-editor' ),
				'object_types' => [ 'owace_category' ],
			]
		);

		$cmb->add_field(
			[
				'id'   => 'icon',
				'type' => 'text',
				'name' => __( 'Icon', 'openwoo-app-content-editor' ),
			]
		);

		$cmb->add_field(
			[
				'id'   => 'content',
				'type' => 'text',
				'name' => __( 'Description', 'openwoo-app-content-editor' ),
			]
		);

		$cmb->add_field(
			[
				'id'   => 'link',
				'type' => 'text',
				'name' => __( 'Link label', 'openwoo-app-content-editor' ),
			]
		);

		$cmb->add_field(
			[
				'id'   => 'url',
				'type' => 'text_url',
				'name' => __( 'Link URL', 'openwoo-app-content-editor' ),
			]
		);

		$cmb->add_field(
			[
				'id'   => 'is_external',
				'type' => 'checkbox',
				'name' => __( 'Externe link', 'openwoo-app-content-editor' ),
			]
		);

		$cmb->add_field(
			[
				'id'         => 'sort',
				'type'       => 'text',
				'name'       => __( 'Sort Order', 'openwoo-app-content-editor' ),
				'attributes' => [
					'type' => 'number',
				],
			]
		);
	}
}
