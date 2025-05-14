<?php
/**
 * Helper class for Pages
 *
 * @package    OpenWoo_App_Content_Editor
 * @subpackage OpenWoo_App_Content_Editor/Admin
 * @author     Richard Korthuis <richardkorthuis@acato.nl>
 */

namespace OpenWoo_App_Content_Editor\Admin;

/**
 * Helper class for Pages
 */
class Pages {

	/**
	 * The singleton instance of this class.
	 *
	 * @access private
	 * @var    Pages|null $instance The singleton instance of this class.
	 */
	private static $instance = null;

	/**
	 * Get the singleton instance of this class.
	 *
	 * @return Pages The singleton instance of this class.
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new Pages();
		}

		return self::$instance;
	}

	/**
	 * Initialize the class and set its properties.
	 *
	 * @return void
	 */
	private function __construct() {
		add_action( 'cmb2_init', [ 'OpenWoo_App_Content_Editor\Admin\Pages', 'action_cmb2_init' ] );
		add_action( 'init', [ 'OpenWoo_App_Content_Editor\Admin\Pages', 'register_faq_post_type' ] );
	}

	/**
	 * Register the Pages post type
	 *
	 * @return void
	 */
	public static function register_faq_post_type() {
		$labels = [
			'name'               => _x( 'Pages', 'post type general name', 'openwoo-app-content-editor' ),
			'singular_name'      => _x( 'Page', 'post type singular name', 'openwoo-app-content-editor' ),
			'menu_name'          => _x( 'OpenWoo - Pages', 'admin menu', 'openwoo-app-content-editor' ),
			'name_admin_bar'     => _x( 'OpenWoo - Page', 'add new on admin bar', 'openwoo-app-content-editor' ),
			'add_new'            => _x( 'Add New', 'faq', 'openwoo-app-content-editor' ),
			'add_new_item'       => __( 'Add New Page', 'openwoo-app-content-editor' ),
			'new_item'           => __( 'New Page', 'openwoo-app-content-editor' ),
			'edit_item'          => __( 'Edit Page', 'openwoo-app-content-editor' ),
			'view_item'          => __( 'View Page', 'openwoo-app-content-editor' ),
			'all_items'          => __( 'All Pages', 'openwoo-app-content-editor' ),
			'search_items'       => __( 'Search Pages', 'openwoo-app-content-editor' ),
			'parent_item_colon'  => __( 'Parent Page:', 'openwoo-app-content-editor' ),
			'not_found'          => __( 'No Pages found.', 'openwoo-app-content-editor' ),
			'not_found_in_trash' => __( 'No Pages found in Trash.', 'openwoo-app-content-editor' ),
		];

		$args = [
			'labels'             => $labels,
			'description'        => __( 'Pages.', 'openwoo-app-content-editor' ),
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'menu_icon'          => 'dashicons-admin-page',
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'supports'           => [ 'title' ],
			'taxonomies'         => [],
		];

		register_post_type( 'owace_page', $args );
	}

	/**
	 * Register the CMB2 metaboxes
	 *
	 * @return void
	 */
	public static function action_cmb2_init() {
		self::add_content_blocks_metaboxes();
		self::add_about_metaboxes();
		self::add_data_sources_metaboxes();
	}

	/**
	 * Add the content blocks metaboxes.
	 *
	 * @return void
	 */
	private static function add_content_blocks_metaboxes() {
		$cmb = new_cmb2_box(
			[
				'id'           => 'content_blocks_metabox',
				'title'        => __( 'Content Blocks', 'openwoo-app-content-editor' ),
				'object_types' => [ 'owace_page' ],
				'show_on'      => [ 'key' => 'slug', 'value' => 'home', 'compare' => '!=' ],
			]
		);

		$lists        = get_posts(
			[
				'post_type'   => 'owace_lists',
				'numberposts' => -1,
			]
		);
		$list_options = [];
		foreach ( $lists as $list ) {
			$list_options[ $list->ID ] = $list->post_title;
		}

		$cmb->add_field(
			[
				'id'      => 'content_blocks',
				'type'    => 'flexible',
				'options' => [
					'sortable' => true,
				],
				'layouts' => [
					'faq'   => [
						'title'  => __( 'FAQ', 'openwoo-app-content-editor' ),
						'fields' => [],
					],
					'text'  => [
						'title'  => __( 'Text', 'openwoo-app-content-editor' ),
						'fields' => [
							[
								'type' => 'wysiwyg',
								'name' => __( 'Text', 'openwoo-app-content-editor' ),
								'id'   => 'text',
							],
						],
					],
					'image' => [
						'title'  => __( 'Image', 'openwoo-app-content-editor' ),
						'fields' => [
							[
								'type'       => 'file',
								'name'       => __( 'Image', 'openwoo-app-content-editor' ),
								'id'         => 'image',
								'options'    => [
									'url' => false,
								],
								'query_args' => [
									'type' => 'image',
								],
							],
						],
					],
					'list'  => [
						'title'  => __( 'List', 'openwoo-app-content-editor' ),
						'fields' => [
							[
								'type'    => 'select',
								'name'    => __( 'List', 'openwoo-app-content-editor' ),
								'id'      => 'list',
								'desc'    => __( 'Select a list', 'openwoo-app-content-editor' ),
								'options' => $list_options,
							],
						],
					],
				],
			]
		);
	}

	/**
	 * Add the about metaboxes to the homepage.
	 *
	 * @return void
	 */
	private static function add_about_metaboxes() {
		$cmb = new_cmb2_box(
			[
				'id'           => 'about_metabox',
				'title'        => __( 'About', 'openwoo-app-content-editor' ),
				'object_types' => [ 'owace_page' ],
				'show_on'      => [ 'key' => 'slug', 'value' => 'home' ],
			]
		);

		$cmb->add_field(
			[
				'type' => 'text',
				'name' => __( 'Title', 'openwoo-app-content-editor' ),
				'id'   => 'about_title',
			]
		);

		$cmb->add_field(
			[
				'type' => 'wysiwyg',
				'name' => __( 'Description', 'openwoo-app-content-editor' ),
				'id'   => 'about_description',
			]
		);

		$cmb->add_field(
			[
				'type'       => 'file',
				'name'       => __( 'Image', 'openwoo-app-content-editor' ),
				'id'         => 'about_image',
				'options'    => [
					'url' => false,
				],
				'query_args' => [
					'type' => 'image',
				],
			]
		);
	}

	/**
	 * Add the data sources metaboxes to the homepage.
	 *
	 * @return void
	 */
	private static function add_data_sources_metaboxes() {
		$cmb = new_cmb2_box(
			[
				'id'           => 'data_sources_metabox',
				'title'        => __( 'Data sources', 'openwoo-app-content-editor' ),
				'object_types' => [ 'owace_page' ],
				'show_on'      => [ 'key' => 'slug', 'value' => 'home' ],
			]
		);

		$group_id = $cmb->add_field(
			[
				'id'          => 'data_sources_group',
				'type'        => 'group',
				'description' => __( 'Add a new data source item', 'openwoo-app-content-editor' ),
				'options'     => [
					'group_title'   => __( 'Data Source Item {#}', 'openwoo-app-content-editor' ),
					'add_button'    => __( 'Add Another Data Source', 'openwoo-app-content-editor' ),
					'remove_button' => __( 'Remove Data Source', 'openwoo-app-content-editor' ),
					'sortable'      => true,
				],
			]
		);

		$cmb->add_group_field(
			$group_id,
			[
				'name' => __( 'Title', 'openwoo-app-content-editor' ),
				'id'   => 'title',
				'type' => 'text',
			]
		);

		$cmb->add_group_field(
			$group_id,
			[
				'name' => __( 'Icon', 'openwoo-app-content-editor' ),
				'id'   => 'icon',
				'type' => 'select',
				'options_cb' => [ 'OpenWoo_App_Content_Editor\Admin\Icons', 'get_icons' ],
				'show_option_none' => true,
			]
		);

		$cmb->add_group_field(
			$group_id,
			[
				'name' => __( 'Description', 'openwoo-app-content-editor' ),
				'id'   => 'content',
				'type' => 'text',
			]
		);

		$cmb->add_group_field(
			$group_id,
			[
				'name' => __( 'Link label', 'openwoo-app-content-editor' ),
				'id'   => 'link',
				'type' => 'text',
			]
		);

		$cmb->add_group_field(
			$group_id,
			[
				'name' => __( 'Link URL', 'openwoo-app-content-editor' ),
				'id'   => 'url',
				'type' => 'text_url',
			]
		);
	}
}
