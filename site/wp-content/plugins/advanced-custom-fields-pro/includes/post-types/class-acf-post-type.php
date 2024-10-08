<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'ACF_Post_Type' ) ) {
	class ACF_Post_Type extends ACF_Internal_Post_Type {

		/**
		 * The ACF internal post type name.
		 *
		 * @var string
		 */
		public $post_type = 'acf-post-type';

		/**
		 * The prefix for the key used in the main post array.
		 *
		 * @var string
		 */
		public $post_key_prefix = 'post_type_';

		/**
		 * The cache key for a singular post.
		 *
		 * @var string
		 */
		public $cache_key = 'acf_get_post_type_post:key:';

		/**
		 * The cache key for a collection of posts.
		 *
		 * @var string
		 */
		public $cache_key_plural = 'acf_get_post_type_posts';

		/**
		 * The hook name for a singular post.
		 *
		 * @var string
		 */
		public $hook_name = 'post_type';

		/**
		 * The hook name for a collection of posts.
		 *
		 * @var string
		 */
		public $hook_name_plural = 'post_types';

		/**
		 * The name of the store used for the post type.
		 *
		 * @var string
		 */
		public $store = 'post-types';

		/**
		 * Constructs the class.
		 */
		public function __construct() {
			// Include admin classes in admin.
			if ( is_admin() ) {
				acf_include( 'includes/admin/post-types/admin-post-type.php' );
				acf_include( 'includes/admin/post-types/admin-post-types.php' );
			}

			parent::__construct();

			add_action( 'acf/init', array( $this, 'register_post_types' ), 6 );
		}

		/**
		 * Register activated post types with WordPress
		 *
		 * @since 6.1
		 */
		public function register_post_types() {
			foreach ( $this->get_posts( array( 'active' => true ) ) as $post_type ) {
				$post_type_key  = $post_type['post_type'];
				$post_type_args = $this->get_post_type_args( $post_type );

				register_post_type( $post_type_key, $post_type_args );
			}
		}

		/**
		 * Gets the default settings array for an ACF post type.
		 *
		 * @return array
		 */
		public function get_settings_array() {
			return array(
				// ACF-specific settings.
				'ID'                       => 0,
				'key'                      => '',
				'title'                    => '',
				'menu_order'               => 0,
				'active'                   => true,
				'post_type'                => '', // First $post_type param passed to register_post_type().
				'advanced_configuration'   => false,
				'permalink_rewrite'        => 'post_type_key',
				// Settings passed to register_post_type().
				'labels'                   => array(
					'name'                     => '',
					'singular_name'            => '',
					'menu_name'                => '',
					'all_items'                => '',
					'add_new'                  => '',
					'add_new_item'             => '',
					'edit_item'                => '',
					'new_item'                 => '',
					'view_item'                => '',
					'view_items'               => '',
					'search_items'             => '',
					'not_found'                => '',
					'not_found_in_trash'       => '',
					'parent_item_colon'        => '',
					'archives'                 => '',
					'attributes'               => '',
					'featured_image'           => '',
					'set_featured_image'       => '',
					'remove_featured_image'    => '',
					'use_featured_image'       => '',
					'insert_into_item'         => '',
					'uploaded_to_this_item'    => '',
					'filter_items_list'        => '',
					'filter_by_date'           => '',
					'items_list_navigation'    => '',
					'items_list'               => '',
					'item_published'           => '',
					'item_published_privately' => '',
					'item_reverted_to_draft'   => '',
					'item_scheduled'           => '',
					'item_updated'             => '',
					'item_link'                => '',
					'item_link_description'    => '',
				),
				'description'              => '',
				'public'                   => true, // WP defaults false, ACF defaults true.
				'hierarchical'             => false,
				'exclude_from_search'      => false,
				'publicly_queryable'       => true,
				'show_ui'                  => true,
				'show_in_menu'             => true,
				'show_in_nav_menus'        => true,
				'show_in_admin_bar'        => true,
				'show_in_rest'             => true,
				'rest_base'                => '',
				'rest_namespace'           => 'wp/v2',
				'rest_controller_class'    => 'WP_REST_Posts_Controller',
				'menu_position'            => null,
				'menu_icon'                => '',
				'rename_capabilities'      => false,
				'singular_capability_name' => 'post',
				'plural_capability_name'   => 'posts',
				'supports'                 => array( 'title', 'editor' ),
				'taxonomies'               => array(),
				'has_archive'              => false,
				'has_archive_slug'         => '',
				'rewrite'                  => array(
					'pretty_permalinks' => true, // ACF-specific option.
					'slug'              => '',
					'feeds'             => false,
					'pages'             => true,
					'with_front'        => true,
				),
				'query_var'                => true,
				'query_var_name'           => '', // ACF-specific option.
				'can_export'               => true,
				'delete_with_user'         => false,
			);
		}

		/**
		 * Validates an ACF internal post type.
		 *
		 * @since 6.1
		 *
		 * @param array $post The main post array.
		 * @return array
		 */
		public function validate_post( $post = array() ) {
			// Bail early if already valid.
			if ( is_array( $post ) && ! empty( $post['_valid'] ) ) {
				return $post;
			}

			$defaults = $this->get_settings_array();
			$post     = wp_parse_args(
				$post,
				$defaults
			);

			// Convert types.
			$post['ID']         = (int) $post['ID'];
			$post['menu_order'] = (int) $post['menu_order'];

			foreach ( $post as $setting => $value ) {
				if ( isset( $defaults[ $setting ] ) ) {
					$default_type = gettype( $defaults[ $setting ] );

					// register_post_type() needs proper booleans.
					if ( 'boolean' === $default_type && in_array( $value, array( '0', '1' ), true ) ) {
						$post[ $setting ] = (bool) $value;
					}
				}
			}

			// Post is now valid.
			$post['_valid'] = true;

			/**
			 * Filters the ACF post array to validate settings.
			 *
			 * @date    12/02/2014
			 * @since   5.0.0
			 *
			 * @param   array $post The post array.
			 */
			return apply_filters( "acf/validate_{$this->hook_name}", $post );
		}

		/**
		 * Parses ACF post type settings and returns an array of post type
		 * args that can be easily handled by `register_post_type()`.
		 *
		 * Omits settings that line up with the WordPress defaults to reduce the size
		 * of the array passed to `register_post_type()`, which might be exported.
		 *
		 * @since 6.1
		 *
		 * @param array $post The main ACF post type settings array.
		 * @return array
		 */
		public function get_post_type_args( $post ) {
			$args = array();

			// Make sure any provided labels are strings and not empty.
			$labels = array_filter( $post['labels'] );
			$labels = array_map( 'strval', $labels );

			if ( ! empty( $labels ) ) {
				$args['labels'] = $labels;
			}

			// Description is an optional string.
			if ( ! empty( $post['description'] ) ) {
				$args['description'] = (string) $post['description'];
			}

			// ACF requires the public setting to decide other settings.
			$args['public'] = ! empty( $post['public'] );

			// WordPress and ACF both default to false, so this can be omitted if still false.
			if ( ! empty( $post['hierarchical'] ) ) {
				$args['hierarchical'] = true;
			}

			// WordPress defaults to the opposite of $args['public'].
			$exclude_from_search = (bool) $post['exclude_from_search'];
			if ( $exclude_from_search !== $args['public'] ) {
				$args['exclude_from_search'] = $exclude_from_search;
			}

			// WordPress defaults to the same as $args['public'].
			$publicly_queryable = (bool) $post['publicly_queryable'];
			if ( $publicly_queryable !== $args['public'] ) {
				$args['publicly_queryable'] = $publicly_queryable;
			}

			// WordPress defaults to the same as $args['public'].
			$show_ui = (bool) $post['show_ui'];
			if ( $show_ui !== $args['public'] ) {
				$args['show_ui'] = $show_ui;
			}

			// WordPress defaults to the same as $args['show_ui'], can be string or boolean.
			$show_in_menu = $post['show_in_menu'];
			if ( is_string( $show_in_menu ) ) {
				$args['show_in_menu'] = $show_in_menu;
			} elseif ( $show_in_menu !== $show_ui ) {
				$args['show_in_menu'] = (bool) $show_in_menu;
			}

			// WordPress defaults to the same as $args['public'].
			$show_in_nav_menus = (bool) $post['show_in_nav_menus'];
			if ( $show_in_nav_menus !== $args['public'] ) {
				$args['show_in_nav_menus'] = $show_in_nav_menus;
			}

			// WordPress defaults to the same as $show_in_menu.
			$show_in_admin_bar = (bool) $post['show_in_admin_bar'];
			if ( $show_in_admin_bar !== $show_in_menu ) {
				$args['show_in_admin_bar'] = $show_in_admin_bar;
			}

			// ACF defaults to true, but can be overridden.
			$show_in_rest         = (bool) $post['show_in_rest'];
			$args['show_in_rest'] = $show_in_rest;

			// WordPress defaults to $post_type.
			$rest_base = (string) $post['rest_base'];
			if ( ! empty( $rest_base ) && $rest_base !== $post['post_type'] ) {
				$args['rest_base'] = $rest_base;
			}

			// WordPress defaults to "wp/v2".
			$rest_namespace = (string) $post['rest_namespace'];
			if ( ! empty( $rest_namespace ) && 'wp/v2' !== $rest_namespace ) {
				$args['rest_namespace'] = $post['rest_namespace'];
			}

			// WordPress defaults to "WP_REST_Posts_Controller".
			$rest_controller_class = (string) $post['rest_controller_class'];
			if ( ! empty( $rest_controller_class ) && 'WP_REST_Posts_Controller' !== $rest_controller_class ) {
				$args['rest_controller_class'] = $rest_controller_class;
			}

			// WordPress defaults to `null` (below the comments menu item).
			$menu_position = (int) $post['menu_position'];
			if ( $menu_position ) {
				$args['menu_position'] = $menu_position;
			}

			// WordPress defaults to the same icon as the posts icon.
			$menu_icon = (string) $post['menu_icon'];
			if ( ! empty( $menu_icon ) ) {
				$args['menu_icon'] = $menu_icon;
			}

			// WordPress defaults to "post" for `$args['capability_type']`, but can also take an array.
			$rename_capabilities = (bool) $post['rename_capabilities'];
			if ( $rename_capabilities ) {
				$singular_capability_name = (string) $post['singular_capability_name'];
				$plural_capability_name   = (string) $post['plural_capability_name'];
				$capability_type          = 'post';

				if ( ! empty( $singular_capability_name ) && ! empty( $plural_capability_name ) ) {
					$capability_type = array( $singular_capability_name, $plural_capability_name );
				} elseif ( ! empty( $singular_capability_name ) ) {
					$capability_type = $singular_capability_name;
				}

				if ( $capability_type !== 'post' && $capability_type !== array( 'post', 'posts' ) ) {
					$args['capability_type'] = $capability_type;
				}
			}

			// TODO: We don't handle the `capabilities` arg at the moment, but may in the future.

			// TODO: We don't handle the `map_meta_cap` arg at the moment, but may in the future.

			// WordPress defaults to the "title" and "editor" supports, but none can be provided by passing false (WP 3.5+).
			$supports = is_array( $post['supports'] ) ? $post['supports'] : array();
			$supports = array_filter( array_map( 'strval', $supports ) );

			if ( empty( $supports ) ) {
				$args['supports'] = false;
			} else {
				$args['supports'] = $supports;
			}

			// TODO: We don't handle the `register_meta_box_cb` arg at the moment, but may in the future.

			// WordPress doesn't register any default taxonomies.
			$taxonomies = $post['taxonomies'];
			if ( ! is_array( $taxonomies ) ) {
				$taxonomies = (array) $taxonomies;
			}

			$taxonomies = array_filter( $taxonomies );
			if ( ! empty( $taxonomies ) ) {
				$args['taxonomies'] = $taxonomies;
			}

			// WordPress and ACF default to false, true or a string can also be provided.
			$has_archive = (bool) $post['has_archive'];
			if ( $has_archive ) {
				$has_archive_slug = (string) $post['has_archive_slug'];

				if ( ! empty( $has_archive_slug ) ) {
					$args['has_archive'] = $has_archive_slug;
				} else {
					$args['has_archive'] = true;
				}
			}

			// The rewrite arg can be a boolean or array of further settings. WordPress and ACF default to true.
			$rewrite         = (array) $post['rewrite'];
			$rewrite_enabled = true;
			$rewrite_args    = array();

			// Value of ACF toggle (not passed to `register_post_type()`).
			if ( isset( $rewrite['pretty_permalinks'] ) && ! $rewrite['pretty_permalinks'] ) {
				$rewrite_enabled = false;
			}

			// Rewrite slug defaults to $post_type key.
			if ( isset( $rewrite['slug'] ) && $rewrite['slug'] !== $post['post_type'] ) {
				$rewrite_args['slug'] = (string) $rewrite['slug'];
			}

			// WordPress defaults to true.
			if ( isset( $rewrite['with_front'] ) && ! $rewrite['with_front'] ) {
				$rewrite_args['with_front'] = false;
			}

			// WordPress defaults to value of `$args['has_archive']`.
			if ( isset( $rewrite['feeds'] ) && (bool) $rewrite['feeds'] !== $has_archive ) {
				$rewrite_args['feeds'] = (bool) $rewrite['feeds'];
			}

			// WordPress defaults to true.
			if ( isset( $rewrite['pages'] ) && ! $rewrite['feeds'] ) {
				$rewrite_args['pages'] = false;
			}

			// Assemble rewrite args.
			if ( ! empty( $rewrite_args ) ) {
				$args['rewrite'] = $rewrite_args;
			} elseif ( ! $rewrite_enabled ) {
				$args['rewrite'] = false;
			}

			// WordPress and ACF default to $post_type key, a boolean can also be used.
			$query_var = (bool) $post['query_var'];
			if ( $query_var ) {
				$query_var_name = (string) $post['query_var_name'];

				if ( ! empty( $query_var_name ) && $query_var_name !== $post['post_type'] ) {
					$args['query_var'] = $query_var_name;
				}
			} else {
				$args['query_var'] = false;
			}

			// WordPress and ACF default to true.
			$can_export = (bool) $post['can_export'];
			if ( ! $can_export ) {
				$args['can_export'] = false;
			}

			// ACF defaults to false, while WordPress defaults to omitting (deletes only if author support is added).
			$args['delete_with_user'] = (bool) $post['delete_with_user'];

			return apply_filters( 'acf/post_type_args', $args, $post );
		}

		/**
		 * Register the CPT required for ACF post types.
		 */
		public function register_post_type() {
			$cap = acf_get_setting( 'capability' );
			register_post_type(
				$this->post_type,
				array(
					'labels'          => array(
						'name'               => __( 'Post Types', 'acf' ),
						'singular_name'      => __( 'Post Type', 'acf' ),
						'add_new'            => __( 'Add New', 'acf' ),
						'add_new_item'       => __( 'Add New Post Type', 'acf' ),
						'edit_item'          => __( 'Edit Post Type', 'acf' ),
						'new_item'           => __( 'New Post Type', 'acf' ),
						'view_item'          => __( 'View Post Type', 'acf' ),
						'search_items'       => __( 'Search Post Types', 'acf' ),
						'not_found'          => __( 'No Post Types found', 'acf' ),
						'not_found_in_trash' => __( 'No Post Types found in Trash', 'acf' ),
					),
					'public'          => false,
					'hierarchical'    => true,
					'show_ui'         => true,
					'show_in_menu'    => false,
					'_builtin'        => false,
					'capability_type' => 'post',
					'capabilities'    => array(
						'edit_post'    => $cap,
						'delete_post'  => $cap,
						'edit_posts'   => $cap,
						'delete_posts' => $cap,
					),
					'supports'        => false,
					'rewrite'         => false,
					'query_var'       => false,
				)
			);
		}

		/**
		 * Returns a string that can be used to create a post type in PHP.
		 *
		 * @since 6.1
		 *
		 * @param array $post The main post type array.
		 * @return string
		 */
		public function export_post_as_php( $post = array() ) {
			$return = '';
			if ( empty( $post ) ) {
				return $return;
			}

			$post_type_key = $post['post_type'];

			// Validate and prepare the post for export.
			$post = $this->validate_post( $post );
			$args = $this->get_post_type_args( $post );
			$code = var_export( $args, true );

			if ( ! $code ) {
				return $return;
			}

			$code = $this->format_code_for_export( $code );

			$return .= "register_post_type( '{$post_type_key}', {$code} );\r\n\r\n";

			return esc_textarea( $return );
		}

		/**
		 * Flush rewrite rules whenever anything changes about a post type.
		 *
		 * @since 6.1
		 *
		 * @param array $post The main post type array.
		 */
		public function flush_post_cache( $post ) {
			parent::flush_post_cache( $post );
			flush_rewrite_rules();
		}

	}

}

acf_new_instance( 'ACF_Post_Type' );
