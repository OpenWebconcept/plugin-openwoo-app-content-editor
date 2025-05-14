<?php
/**
 * The OWACE_Controller class.
 *
 * @package    OpenWoo_App_Content_Editor
 * @subpackage OpenWoo_App_Content_Editor/Rest_Api
 * @author     Richard Korthuis <richardkorthuis@acato.nl>
 */

namespace OpenWoo_App_Content_Editor\Rest_Api;

/**
 * The OWACE_Controller class.
 */
class OWACE_Controller extends \WP_REST_Posts_Controller {

	/**
	 * The singleton instance of this class.
	 *
	 * @access private
	 * @var    OWACE_Controller|null $instance The singleton instance of this class.
	 */
	private static $instance = null;

	/**
	 * Get the singleton instance of this class.
	 *
	 * @return OWACE_Controller The singleton instance of this class.
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new OWACE_Controller();
		}

		return self::$instance;
	}

	/**
	 * Initialize the class and set its properties.
	 *
	 * @return void
	 */
	private function __construct() {
		add_action( 'init', [ $this, 'init' ] );
		add_action( 'rest_api_init', [ $this, 'register_routes' ] );
	}

	/**
	 * Initialize the controller.
	 *
	 * @return void
	 */
	public function init() {
		parent::__construct( 'owace_faq' );

		$this->namespace = 'owc/owace/v1';
		$this->rest_base = 'api';
	}

	/**
	 * Register the routes for the objects of the controller.
	 *
	 * Main endpoint.
	 *
	 * @link https://url/wp-json/owc/owace/v1
	 *
	 * Endpoint to retrieve all pages.
	 * @link https://url/wp-json/owc/owace/v1/api/public/pages
	 *
	 * Endpoint to retrieve a specific page by slug.
	 * @link https://url/wp-json/owc/owace/v1/api/public/pages/{slug}
	 *
	 * Endpoint to retrieve all faqs.
	 * @link https://url/wp-json/owc/owace/v1/api/public/faqs
	 *
	 * Endpoint to retrieve a specific faq by id.
	 * @link https://url/wp-json/owc/owace/v1/api/public/faqs/{id}
	 *
	 * Endpoint to retrieve all menus.
	 * @link https://url/wp-json/owc/owace/v1/api/public/menu
	 *
	 * Endpoint to retrieve a specific menu by slug.
	 * @link https://url/wp-json/owc/owace/v1/api/public/menu/{slug}
	 *
	 * @return void
	 */
	public function register_routes() {
		register_rest_route(
			$this->namespace,
			'/api/public/pages',
			[
				'methods'             => \WP_REST_Server::READABLE,
				'callback'            => [ $this, 'get_pages' ],
				'permission_callback' => '__return_true',
				'args'                => [],
			]
		);

		register_rest_route(
			$this->namespace,
			'/api/public/pages/(?P<slug>[a-zA-Z0-9-]+)',
			[
				'methods'             => \WP_REST_Server::READABLE,
				'callback'            => [ $this, 'get_page_by_slug' ],
				'permission_callback' => '__return_true',
				'args'                => [],
			]
		);

		register_rest_route(
			$this->namespace,
			'/api/public/faqs',
			[
				'methods'             => \WP_REST_Server::READABLE,
				'callback'            => [ $this, 'get_faqs' ],
				'permission_callback' => '__return_true',
				'args'                => [],
			]
		);

		register_rest_route(
			$this->namespace,
			'/api/public/faqs/(?P<id>[0-9]+)',
			[
				'methods'             => \WP_REST_Server::READABLE,
				'callback'            => [ $this, 'get_faq_by_id' ],
				'permission_callback' => '__return_true',
				'args'                => [],
			]
		);

		register_rest_route(
			$this->namespace,
			'/api/public/menu',
			[
				'methods'             => \WP_REST_Server::READABLE,
				'callback'            => [ $this, 'get_menus' ],
				'permission_callback' => '__return_true',
				'args'                => [],
			]
		);

		register_rest_route(
			$this->namespace,
			'/api/public/menu/(?P<slug>[a-zA-Z0-9-]+)',
			[
				'methods'             => \WP_REST_Server::READABLE,
				'callback'            => [ $this, 'get_menu_by_slug' ],
				'permission_callback' => '__return_true',
				'args'                => [],
			]
		);
	}

	/**
	 * Get all faqs.
	 *
	 * @return \WP_Error|\WP_REST_Response
	 */
	public function get_faqs() {
		$faqs = get_posts(
			[
				'post_type'      => 'owace_faq',
				'posts_per_page' => - 1,
				// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query -- We need both existing and non-existing meta values for the sort to work correctly.
				'meta_query'     => [
					'relation' => 'OR',
					[
						'key'     => 'faq_sortorder',
						'compare' => 'NOT EXISTS',
					],
					[
						'key'     => 'faq_sortorder',
						'compare' => 'EXISTS',
					],
				],
				'orderby'        => [
					'meta_value_num' => 'ASC',
					'date'           => 'DESC',
				],
			]
		);

		$response = [];
		foreach ( $faqs as $faq ) {
			$response[] = [
				'id'       => $faq->ID,
				'question' => $faq->post_title,
				'answer'   => get_post_meta( $faq->ID, 'faq_answer', true ),
				'sort'     => (int) get_post_meta( $faq->ID, 'faq_sortorder', true ),
			];
		}

		return rest_ensure_response( [ 'data' => $response ] );
	}

	/**
	 * Get a faq by id.
	 *
	 * @param \WP_REST_Request<array<string, mixed>> $request The request object.
	 *
	 * @return \WP_Error|\WP_REST_Response
	 */
	public function get_faq_by_id( $request ) {
		$id = $request->get_param( 'id' );

		$faq = get_post( $id );

		if ( ! $faq ) {
			return new \WP_Error( 'faq_not_found', 'FAQ not found', [ 'status' => 404 ] );
		}

		$data = [
			'data' => [
				'id'       => $faq->ID,
				'question' => $faq->post_title,
				'answer'   => get_post_meta( $faq->ID, 'faq_answer', true ),
				'sort'     => (int) get_post_meta( $faq->ID, 'faq_sortorder', true ),
			],
		];

		return rest_ensure_response( $data );
	}

	/**
	 * Get all pages.
	 *
	 * @return \WP_Error|\WP_REST_Response
	 */
	public function get_pages() {
		$pages = get_posts(
			[
				'post_type'      => 'owace_page',
				'posts_per_page' => - 1,
			]
		);

		$response = [];
		foreach ( $pages as $page ) {
			$response[] = [
				'id'         => $page->ID,
				'name'       => $page->post_title,
				'slug'       => $page->post_name,
				'created_at' => $page->post_date,
				'updated_at' => $page->post_modified,
			];
		}

		return rest_ensure_response( [ 'data' => $response ] );
	}

	/**
	 * Get a page by slug.
	 *
	 * @param \WP_REST_Request<array<string, mixed>> $request The request object.
	 *
	 * @return \WP_Error|\WP_REST_Response
	 */
	public function get_page_by_slug( $request ) {
		$slug = $request->get_param( 'slug' );

		$page = get_page_by_path( $slug, OBJECT, 'owace_page' );

		if ( ! $page ) {
			return new \WP_Error( 'page_not_found', 'Page not found', [ 'status' => 404 ] );
		}

		$data = [
			'data' => [
				'id'         => $page->ID,
				'name'       => $page->post_title,
				'slug'       => $page->post_name,
				'created_at' => $page->post_date,
				'updated_at' => $page->post_modified,
			],
		];

		$content_blocks = get_post_meta( $page->ID, 'content_blocks', true );
		if ( ! empty( $content_blocks ) ) {
			foreach ( $content_blocks as $content_block ) {
				switch ( $content_block['layout'] ) {
					case 'text':
						$data['data']['contents'][] = [
							'type' => 'RichText',
							'data' => [
								'content' => wpautop( $content_block['text'] ),
							],
						];
						break;
					case 'image':
						// Since we get an image url we have to convert it to an attachment id.
						$id = attachment_url_to_postid( $content_block['image'] );

						$data['data']['contents'][] = [
							'type' => 'Image',
							'data' => [
								'id'        => $id,
								'name'      => get_the_title( $id ),
								'file_name' => basename( get_attached_file( $id ) ),
								'mime_type' => get_post_mime_type( $id ),
								'url'       => $content_block['image'],
								'srcset'    => wp_get_attachment_image_srcset( $id ),
							],
						];
						break;
					case 'list':
						$list = get_post_meta( $content_block['list'], 'lists_group', true );

						$data['data']['contents'][] = [
							'type' => 'DataList',
							'data' => [
								'rows' => $list,
							],
						];
						break;
					case 'faq':
						$faqs = get_posts(
							[
								'post_type'      => 'owace_faq',
								'posts_per_page' => - 1,
								// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query -- We need both existing and non-existing meta values for the sort to work correctly.
								'meta_query'     => [
									'relation' => 'OR',
									[
										'key'     => 'faq_sortorder',
										'compare' => 'NOT EXISTS',
									],
									[
										'key'     => 'faq_sortorder',
										'compare' => 'EXISTS',
									],
								],
								'orderby'        => [
									'meta_value_num' => 'ASC',
									'date'           => 'DESC',
								],
							]
						);

						$faq_data = [
							'type' => 'Faq',
							'data' => [],
						];
						foreach ( $faqs as $faq ) {
							$faq_data['data']['faqs'][] = [
								'id'         => $faq->ID,
								'question'   => $faq->post_title,
								'answer'     => get_post_meta( $faq->ID, 'faq_answer', true ),
								'sort'       => (int) get_post_meta( $faq->ID, 'faq_sortorder', true ),
								'created_at' => $faq->post_date,
								'updated_at' => $faq->post_modified,
							];
						}

						$data['data']['contents'][] = $faq_data;

						break;
				}
			}
		}

		return rest_ensure_response( $data );
	}

	/**
	 * Get the menus.
	 *
	 * @return \WP_Error|\WP_HTTP_Response|\WP_REST_Response|mixed
	 */
	public function get_menus() {
		$data['data'] = [];
		foreach ( [ 'owace-this-website-menu', 'owace-quick-links-menu' ] as $location_slug ) {
			$data['data'][ $location_slug ] = $this->get_menu_item_by_slug( $location_slug );
		}

		return rest_ensure_response( $data );
	}

	/**
	 * Get the menu by slug.
	 *
	 * @param \WP_REST_Request<array<string, mixed>> $request The request object.
	 *
	 * @return \WP_Error|\WP_HTTP_Response|\WP_REST_Response|mixed
	 */
	public function get_menu_by_slug( $request ) {
		$slug = $request->get_param( 'slug' );

		$data['data'] = $this->get_menu_item_by_slug( $slug );

		return rest_ensure_response( $data );
	}

	/**
	 * Get the menu items by slug.
	 *
	 * @param string $slug The slug of the menu.
	 *
	 * @return array<string, mixed>
	 */
	private function get_menu_item_by_slug( $slug ) {
		$menu_locations = get_nav_menu_locations();
		if ( ! isset( $menu_locations[ $slug ] ) ) {
			return [];
		}
		$menu_object = wp_get_nav_menu_object( $menu_locations[ $slug ] );
		if ( ! $menu_object ) {
			return [];
		}
		$menu_items = wp_get_nav_menu_items( $menu_object->term_id );
		$menu       = [
			'id'    => $menu_object->term_id,
			'name'  => $menu_object->name,
			'items' => [],
		];
		foreach ( $menu_items as $menu_item ) {
			$menu['items'][] = [
				'id'         => $menu_item->ID,
				'label'      => $menu_item->title,
				'url'        => $menu_item->url,
				'parent_id'  => (int) $menu_item->menu_item_parent,
				'menu_order' => $menu_item->menu_order,
				'target'     => $menu_item->target,
			];
		}

		return $menu;
	}
}
