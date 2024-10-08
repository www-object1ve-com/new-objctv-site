<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'ACF_Taxonomy' ) ) {
	class ACF_Taxonomy extends ACF_Internal_Post_Type {

		/**
		 * The ACF internal post type name.
		 *
		 * @var string
		 */
		public $post_type = 'acf-taxonomy';

		/**
		 * The prefix for the key used in the main post array.
		 *
		 * @var string
		 */
		public $post_key_prefix = 'taxonomy_';

		/**
		 * The cache key for a singular post.
		 *
		 * @var string
		 */
		public $cache_key = 'acf_get_taxonomy_post:key:';

		/**
		 * The cache key for a collection of posts.
		 *
		 * @var string
		 */
		public $cache_key_plural = 'acf_get_taxonomy_posts';

		/**
		 * The hook name for a singular post.
		 *
		 * @var string
		 */
		public $hook_name = 'taxonomy';

		/**
		 * The hook name for a collection of posts.
		 *
		 * @var string
		 */
		public $hook_name_plural = 'taxonomies';

		/**
		 * The name of the store used for the post type.
		 *
		 * @var string
		 */
		public $store = 'taxonomies';

		/**
		 * Constructs the class.
		 */
		public function __construct() {
			// Include admin classes in admin.
			if ( is_admin() ) {
				acf_include( 'includes/admin/post-types/admin-taxonomy.php' );
				acf_include( 'includes/admin/post-types/admin-taxonomies.php' );
			}

			parent::__construct();

			add_action( 'acf/init', array( $this, 'register_taxonomies' ), 6 );
		}

		/**
		 * Register activated taxonomies with WordPress
		 *
		 * @since 6.1
		 */
		public function register_taxonomies() {
			$taxonomies = $this->get_posts( array( 'active' => true ) );
			foreach ( $taxonomies as $taxonomy ) {
				$args = $this->get_taxonomy_args( $taxonomy );
				register_taxonomy( $taxonomy['taxonomy'], (array) $taxonomy['object_type'], $args );
			}
		}

		/**
		 * Gets the default settings array for an ACF taxonomy.
		 *
		 * @return array
		 */
		public function get_settings_array() {
			return array(
				// ACF-specific settings.
				'ID'                     => 0,
				'key'                    => '',
				'title'                  => '',
				'menu_order'             => 0,
				'active'                 => true,
				'taxonomy'               => '', // Taxonomy key passed as first param to register_taxonomy().
				'object_type'            => array(), // Converted to objects array passed as second parameter.
				'advanced_configuration' => 0,
				// Settings passed to register_taxonomy().
				'labels'                 => array(
					'singular_name'              => '',
					'name'                       => '',
					'menu_name'                  => '',
					'search_items'               => '',
					'popular_items'              => '',
					'all_items'                  => '',
					'parent_item'                => '',
					'parent_item_colon'          => '',
					'name_field_description'     => '',
					'slug_field_description'     => '',
					'parent_field_description'   => '',
					'desc_field_description'     => '',
					'edit_item'                  => '',
					'view_item'                  => '',
					'update_item'                => '',
					'add_new_item'               => '',
					'new_item_name'              => '',
					'separate_items_with_commas' => '',
					'add_or_remove_items'        => '',
					'choose_from_most_used'      => '',
					'not_found'                  => '',
					'no_terms'                   => '',
					'filter_by_item'             => '',
					'items_list_navigation'      => '',
					'items_list'                 => '',
					'most_used'                  => '',
					'back_to_items'              => '',
					'item_link'                  => '',
					'item_link_description'      => '',
				),
				'description'            => '',
				'public'                 => true,
				'publicly_queryable'     => true,
				'hierarchical'           => false,
				'show_ui'                => true,
				'show_in_menu'           => true,
				'show_in_nav_menus'      => true,
				'show_in_rest'           => true,
				'rest_base'              => '',
				'rest_namespace'         => 'wp/v2',
				'rest_controller_class'  => 'WP_REST_Terms_Controller',
				'show_tagcloud'          => true,
				'show_in_quick_edit'     => true,
				'show_admin_column'      => false,
				'rewrite'                => array(
					'pretty_permalinks' => true,
					'slug'              => '',
					'with_front'        => true,
					'hierarchical'      => false,
				),
				'query_var'              => true,
				'query_var_name'         => '',
				'default_term'           => array(
					'default_term_enabled'     => false,
					'default_term_name'        => '',
					'default_term_slug'        => '',
					'default_term_description' => '',
				),
				'sort'                   => null,
			);
		}

		/**
		 * Register the CPT required for ACF taxonomies.
		 */
		public function register_post_type() {
			$cap = acf_get_setting( 'capability' );
			register_post_type(
				$this->post_type,
				array(
					'labels'          => array(
						'name'               => __( 'Taxonomies', 'acf' ),
						'singular_name'      => __( 'Taxonomies', 'acf' ),
						'add_new'            => __( 'Add New', 'acf' ),
						'add_new_item'       => __( 'Add New Taxonomy', 'acf' ),
						'edit_item'          => __( 'Edit Taxonomy', 'acf' ),
						'new_item'           => __( 'New Taxonomy', 'acf' ),
						'view_item'          => __( 'View Taxonomy', 'acf' ),
						'search_items'       => __( 'Search Taxonomies', 'acf' ),
						'not_found'          => __( 'No Taxonomies found', 'acf' ),
						'not_found_in_trash' => __( 'No Taxonomies found in Trash', 'acf' ),
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
		 * Parses ACF taxonomy settings and returns an array of taxonomy
		 * args that can be easily handled by `register_taxonomy()`.
		 *
		 * Omits settings that line up with the WordPress defaults to reduce the size
		 * of the array passed to `register_taxonomy()`, which might be exported.
		 *
		 * @since 6.1
		 *
		 * @param array $post The main ACF taxonomy settings array.
		 * @return array
		 */
		public function get_taxonomy_args( $post ) {
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

			// WordPress defaults to the same as $args['show_ui'].
			$show_in_menu = $post['show_in_menu'];
			if ( $show_in_menu !== $show_ui ) {
				$args['show_in_menu'] = (bool) $show_in_menu;
			}

			// WordPress defaults to the same as $args['public'].
			$show_in_nav_menus = (bool) $post['show_in_nav_menus'];
			if ( $show_in_nav_menus !== $args['public'] ) {
				$args['show_in_nav_menus'] = $show_in_nav_menus;
			}

			// ACF defaults to true, but can be overridden.
			$show_in_rest         = (bool) $post['show_in_rest'];
			$args['show_in_rest'] = $show_in_rest;

			// WordPress defaults to `$taxonomy`.
			$rest_base = (string) $post['rest_base'];
			if ( ! empty( $rest_base ) && $rest_base !== $post['taxonomy'] ) {
				$args['rest_base'] = $rest_base;
			}

			// WordPress defaults to "wp/v2".
			$rest_namespace = (string) $post['rest_namespace'];
			if ( ! empty( $rest_namespace ) && 'wp/v2' !== $rest_namespace ) {
				$args['rest_namespace'] = $post['rest_namespace'];
			}

			// WordPress defaults to `WP_REST_Terms_Controller`.
			$rest_controller_class = (string) $post['rest_controller_class'];
			if ( ! empty( $rest_controller_class ) && 'WP_REST_Terms_Controller' !== $rest_controller_class ) {
				$args['rest_controller_class'] = $rest_controller_class;
			}

			// WordPress defaults to the same as `$args['show_ui']`.
			$show_tagcloud = (bool) $post['show_tagcloud'];
			if ( $show_tagcloud !== $show_ui ) {
				$args['show_tagcloud'] = $show_tagcloud;
			}

			// WordPress defaults to the same as `$args['show_ui']`.
			$show_in_quick_edit = (bool) $post['show_in_quick_edit'];
			if ( $show_in_quick_edit !== $show_ui ) {
				$args['show_in_quick_edit'] = $show_tagcloud;
			}

			// WordPress defaults to false.
			$show_admin_column = (bool) $post['show_admin_column'];
			if ( $show_admin_column ) {
				$args['show_admin_column'] = true;
			}

			// The rewrite arg can be a boolean or array of further settings. WordPress and ACF default to true.
			$rewrite         = (array) $post['rewrite'];
			$rewrite_enabled = true;
			$rewrite_args    = array();

			// Value of ACF toggle (not passed to `register_taxonomy()`).
			if ( isset( $rewrite['pretty_permalinks'] ) && ! $rewrite['pretty_permalinks'] ) {
				$rewrite_enabled = false;
			}

			// Rewrite slug defaults to $post_type key.
			if ( isset( $rewrite['slug'] ) && $rewrite['slug'] !== $post['taxonomy'] ) {
				$rewrite_args['slug'] = (string) $rewrite['slug'];
			}

			// WordPress defaults to true.
			if ( isset( $rewrite['with_front'] ) && ! $rewrite['with_front'] ) {
				$rewrite_args['with_front'] = false;
			}

			// WordPress defaults to false.
			if ( isset( $rewrite['hierarchical'] ) && $rewrite['hierarchical'] ) {
				$rewrite_args['hierarchical'] = true;
			}

			if ( $rewrite_enabled && ! empty( $rewrite_args ) ) {
				$args['rewrite'] = $rewrite_args;
			} elseif ( ! $rewrite_enabled ) {
				$args['rewrite'] = false;
			}

			// WordPress and ACF default to $taxonomy key, a boolean can also be used.
			$query_var = (bool) $post['query_var'];
			if ( $query_var ) {
				$query_var_name = (string) $post['query_var_name'];

				if ( ! empty( $query_var_name ) && $query_var_name !== $post['taxonomy'] ) {
					$args['query_var'] = $query_var_name;
				}
			} else {
				$args['query_var'] = false;
			}

			// WordPress accepts a string or an array of term info, but always converts into an array.
			$default_term = (array) $post['default_term'];
			if ( isset( $default_term['default_term_enabled'] ) && $default_term['default_term_enabled'] ) {
				$args['default_term'] = array();

				if ( isset( $default_term['default_term_name'] ) && ! empty( $default_term['default_term_name'] ) ) {
					$args['default_term']['name'] = (string) $default_term['default_term_name'];
				}

				if ( isset( $default_term['default_term_slug'] ) && ! empty( $default_term['default_term_slug'] ) ) {
					$args['default_term']['slug'] = (string) $default_term['default_term_slug'];
				}

				if ( isset( $default_term['default_term_description'] ) && ! empty( $default_term['default_term_description'] ) ) {
					$args['default_term']['description'] = (string) $default_term['default_term_description'];
				}
			}

			// WordPress defaults to null, equivalent to false.
			$sort = (bool) $post['sort'];
			if ( $sort ) {
				$args['sort'] = true;
			}

			return apply_filters( 'acf/taxonomy_args', $args, $post );
		}

		/**
		 * Returns a string that can be used to create a taxonomy in PHP.
		 *
		 * @since 6.1
		 *
		 * @param array $post The main taxonomy array.
		 * @return string
		 */
		public function export_post_as_php( $post = array() ) {
			$return = '';
			if ( empty( $post ) ) {
				return $return;
			}

			$post         = $this->validate_post( $post );
			$taxonomy_key = $post['taxonomy'];
			$objects      = (array) $post['object_type'];
			$objects      = var_export( $objects, true );
			$args         = $this->get_taxonomy_args( $post );
			$args         = var_export( $args, true );

			if ( ! $args ) {
				return $return;
			}

			$args    = $this->format_code_for_export( $args );
			$objects = $this->format_code_for_export( $objects );

			$return .= "register_taxonomy('{$taxonomy_key}', $objects, {$args} );\r\n\r\n";

			return esc_textarea( $return );
		}

		/**
		 * Flush rewrite rules whenever anything changes about a taxonomy.
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

acf_new_instance( 'ACF_Taxonomy' );
