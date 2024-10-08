<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'ACF_Admin_Post_Types' ) ) :

	/**
	 * The ACF Post Types admin controller class
	 */
	class ACF_Admin_Post_Types extends ACF_Admin_Internal_Post_Type_List {

		/**
		 * The slug for the internal post type.
		 *
		 * @since 6.1
		 * @var string
		 */
		public $post_type = 'acf-post-type';

		/**
		 * The admin body class used for the post type.
		 *
		 * @since 6.1
		 * @var string
		 */
		public $admin_body_class = 'acf-admin-post-types';

		/**
		 * Add any menu items required for post types.
		 *
		 * @since 6.1
		 */
		public function admin_menu() {
			$parent_slug = 'edit.php?post_type=acf-field-group';
			$cap         = acf_get_setting( 'capability' );
			add_submenu_page( $parent_slug, __( 'Post Types', 'acf' ), __( 'Post Types', 'acf' ), $cap, 'edit.php?post_type=acf-post-type' );
		}

		/**
		 * Customizes the admin table columns.
		 *
		 * @date    1/4/20
		 * @since   5.9.0
		 *
		 * @param array $_columns The columns array.
		 * @return array
		 */
		public function admin_table_columns( $_columns ) {
			// Set the "no found" label to be our custom HTML for no results.
			global $wp_post_types;
			$this->not_found_label                                = $wp_post_types[ $this->post_type ]->labels->not_found;
			$wp_post_types[ $this->post_type ]->labels->not_found = $this->get_not_found_html();

			$columns = array(
				'cb'               => $_columns['cb'],
				'title'            => $_columns['title'],
				'acf-description'  => __( 'Description', 'acf' ),
				'acf-key'          => __( 'Key', 'acf' ),
				'acf-taxonomies'   => __( 'Taxonomies', 'acf' ),
				'acf-field-groups' => __( 'Field Groups', 'acf' ),
				'acf-count'        => __( 'Posts', 'acf' ),
			);

			if ( acf_get_local_json_files() ) {
				$columns['acf-json'] = __( 'Local JSON', 'acf' );
			}

			return $columns;
		}

		/**
		 * Renders a specific admin table column.
		 *
		 * @date    17/4/20
		 * @since   5.9.0
		 *
		 * @param string $column_name The name of the column to display.
		 * @param array  $post        The main ACF post array.
		 * @return void
		 */
		public function render_admin_table_column( $column_name, $post ) {
			switch ( $column_name ) {
				case 'acf-key':
					echo '<i class="acf-icon acf-icon-key-solid"></i>';
					echo esc_html( $post['key'] );
					break;

				// Description.
				case 'acf-description':
					if ( $post['description'] ) {
						echo '<span class="acf-description">' . acf_esc_html( $post['description'] ) . '</span>';
					}
					break;

				case 'acf-taxonomies':
					$this->render_admin_table_column_taxonomies( $post );
					break;

				case 'acf-field-groups':
					$this->render_admin_table_column_field_groups( $post );
					break;

				case 'acf-count':
					$num_posts = wp_count_posts( $post['post_type'] );
					if ( is_object( $num_posts ) && property_exists( $num_posts, 'publish' ) ) {
						echo esc_html( $num_posts->publish );
					} else {
						echo 0;
					}
					break;

				// Local JSON.
				case 'acf-json':
					$this->render_admin_table_column_local_status( $post );
					break;
			}
		}

		/**
		 * Renders the field groups attached to the post type in the list table.
		 *
		 * @since 6.1
		 *
		 * @param array $post_type The main post type array.
		 * @return void
		 */
		public function render_admin_table_column_field_groups( $post_type ) {
			$field_groups = acf_get_field_groups( array( 'post_type' => $post_type['post_type'] ) );

			if ( empty( $field_groups ) ) {
				return;
			}

			$labels        = wp_list_pluck( $field_groups, 'title' );
			$limit         = 3;
			$shown_labels  = array_slice( $labels, 0, $limit );
			$hidden_labels = array_slice( $labels, $limit );
			$text          = implode( ', ', $shown_labels );

			if ( ! empty( $hidden_labels ) ) {
				$text .= ', <span class="acf-more-items acf-tooltip-js" title="' . implode( ', ', $hidden_labels ) . '">+' . count( $hidden_labels ) . '</span>';
			}

			echo acf_esc_html( $text );
		}

		/**
		 * Renders the taxonomies attached to the post type in the list table.
		 *
		 * @since 6.1
		 *
		 * @param array $post_type The main post type array.
		 * @return void
		 */
		public function render_admin_table_column_taxonomies( $post_type ) {
			if ( ! is_array( $post_type['taxonomies'] ) || empty( $post_type['taxonomies'] ) ) {
				return;
			}

			$labels = array();

			foreach ( $post_type['taxonomies'] as $tax_slug ) {
				$taxonomy = get_taxonomy( $tax_slug );

				if ( ! is_object( $taxonomy ) || empty( $taxonomy->label ) ) {
					continue;
				}

				$labels[] = $taxonomy->label;
			}

			$limit         = 3;
			$shown_labels  = array_slice( $labels, 0, $limit );
			$hidden_labels = array_slice( $labels, $limit );
			$text          = implode( ', ', $shown_labels );

			if ( ! empty( $hidden_labels ) ) {
				$text .= ', <span class="acf-more-items acf-tooltip-js" title="' . implode( ', ', $hidden_labels ) . '">+' . count( $hidden_labels ) . '</span>';
			}

			echo acf_esc_html( $text );
		}

		/**
		 * Gets the translated action notice text for list table actions (activate, deactivate, sync, etc.).
		 *
		 * @since 6.1
		 *
		 * @param string $action The action being performed.
		 * @param int    $count  The number of items the action was performed on.
		 * @return string
		 */
		public function get_action_notice_text( $action, $count = 1 ) {
			$text  = '';
			$count = (int) $count;

			switch ( $action ) {
				case 'acfactivatecomplete':
					$text = sprintf(
						/* translators: %s number of post types activated */
						_n( 'Post type activated.', '%s post types activated.', $count, 'acf' ),
						$count
					);
					break;
				case 'acfdeactivatecomplete':
					$text = sprintf(
						/* translators: %s number of post types deactivated */
						_n( 'Post type deactivated.', '%s post types deactivated.', $count, 'acf' ),
						$count
					);
					break;
				case 'acfduplicatecomplete':
					$text = sprintf(
						/* translators: %s number of post types duplicated */
						_n( 'Post type duplicated.', '%s post types duplicated.', $count, 'acf' ),
						$count
					);
					break;
				case 'acfsynccomplete':
					$text = sprintf(
						/* translators: %s number of post types synchronised */
						_n( 'Post type synchronised.', '%s post types synchronised.', $count, 'acf' ),
						$count
					);
					break;
			}

			return $text;
		}

	}

	// Instantiate.
	acf_new_instance( 'ACF_Admin_Post_Types' );

endif; // Class exists check.
