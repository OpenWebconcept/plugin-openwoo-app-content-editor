<?php
/**
 * Helper class for Lists
 *
 * @package    OpenWoo_App_Content_Editor
 * @subpackage OpenWoo_App_Content_Editor/Admin
 * @author     Richard Korthuis <richardkorthuis@acato.nl>
 */

namespace OpenWoo_App_Content_Editor\Admin;

/**
 * Helper class for Lists
 */
class Lists {

	/**
	 * The singleton instance of this class.
	 *
	 * @access private
	 * @var    Lists|null $instance The singleton instance of this class.
	 */
	private static $instance = null;

	/**
	 * Get the singleton instance of this class.
	 *
	 * @return Lists The singleton instance of this class.
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new Lists();
		}

		return self::$instance;
	}

	/**
	 * Initialize the class and set its properties.
	 *
	 * @return void
	 */
	private function __construct() {
		add_action( 'cmb2_init', [ 'OpenWoo_App_Content_Editor\Admin\Lists', 'action_cmb2_init' ] );
		add_action( 'init', [ 'OpenWoo_App_Content_Editor\Admin\Lists', 'register_lists_post_type' ] );
	}

	/**
	 * Register the FAQ post type
	 *
	 * @return void
	 */
	public static function register_lists_post_type() {
		$labels = [
			'name'               => _x( 'Lists', 'post type general name', 'openwoo-app-content-editor' ),
			'singular_name'      => _x( 'List', 'post type singular name', 'openwoo-app-content-editor' ),
			'menu_name'          => _x( 'OpenWoo - Lists', 'admin menu', 'openwoo-app-content-editor' ),
			'name_admin_bar'     => _x( 'OpenWoo - List', 'add new on admin bar', 'openwoo-app-content-editor' ),
			'add_new'            => _x( 'Add New', 'lists', 'openwoo-app-content-editor' ),
			'add_new_item'       => __( 'Add New List', 'openwoo-app-content-editor' ),
			'new_item'           => __( 'New List', 'openwoo-app-content-editor' ),
			'edit_item'          => __( 'Edit List', 'openwoo-app-content-editor' ),
			'view_item'          => __( 'View List', 'openwoo-app-content-editor' ),
			'all_items'          => __( 'All Lists', 'openwoo-app-content-editor' ),
			'search_items'       => __( 'Search Lists', 'openwoo-app-content-editor' ),
			'parent_item_colon'  => __( 'Parent List:', 'openwoo-app-content-editor' ),
			'not_found'          => __( 'No Lists found.', 'openwoo-app-content-editor' ),
			'not_found_in_trash' => __( 'No Lists found in Trash.', 'openwoo-app-content-editor' ),
		];

		$args = [
			'labels'             => $labels,
			'description'        => __( 'Lists.', 'openwoo-app-content-editor' ),
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'menu_icon'          => 'dashicons-list-view',
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'supports'           => [ 'title' ],
			'taxonomies'         => [],
		];

		register_post_type( 'owace_lists', $args );
	}

	/**
	 * Register the CMB2 metaboxes
	 *
	 * @return void
	 */
	public static function action_cmb2_init() {
		self::add_lists_metaboxes();
	}

	/**
	 * Add the content blocks metaboxes.
	 *
	 * @return void
	 */
	private static function add_lists_metaboxes() {
		$cmb = new_cmb2_box(
			[
				'id'           => 'lists_metabox',
				'title'        => __( 'Lists', 'openwoo-app-content-editor' ),
				'object_types' => [ 'owace_lists' ],
			]
		);

		$group_id = $cmb->add_field(
			[
				'id'          => 'lists_group',
				'type'        => 'group',
				'description' => __( 'Add a new list item', 'openwoo-app-content-editor' ),
				'options'     => [
					'group_title'   => __( 'List Item {#}', 'openwoo-app-content-editor' ),
					'add_button'    => __( 'Add Another List Item', 'openwoo-app-content-editor' ),
					'remove_button' => __( 'Remove List Item', 'openwoo-app-content-editor' ),
					'sortable'      => true,
				],
			]
		);

		$cmb->add_group_field(
			$group_id,
			[
				'name' => __( 'URL', 'openwoo-app-content-editor' ),
				'id'   => 'url',
				'type' => 'text_url',
			]
		);

		$cmb->add_group_field(
			$group_id,
			[
				'name' => __( 'Text', 'openwoo-app-content-editor' ),
				'id'   => 'text',
				'type' => 'text',
			]
		);

		$cmb->add_group_field(
			$group_id,
			[
				'name' => __( 'Label', 'openwoo-app-content-editor' ),
				'id'   => 'label',
				'type' => 'text',
			]
		);
	}
}
