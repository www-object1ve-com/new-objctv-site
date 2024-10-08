<?php
/**
 * ACF Admin Post Type Class
 *
 *  @class ACF_Admin_Post_Type
 *
 *  @package    ACF
 *  @subpackage Admin
 */

if ( ! class_exists( 'ACF_Admin_Post_Type' ) ) :

	/**
	 *  ACF Admin Post Type Class
	 *
	 *  All the logic for editing a post type.
	 */
	class ACF_Admin_Post_type extends ACF_Admin_Internal_Post_Type {

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
		public $admin_body_class = 'acf-admin-single-post-type';

		/**
		 * Constructs the class.
		 *
		 * @since   5.0.0
		 *
		 * @return  void
		 */
		// public function __construct() {
		// parent::__construct();
		// }

		/**
		 * This function will customize the message shown when editing a post type.
		 *
		 * @since 5.0.0
		 *
		 * @param array $messages Post type messages.
		 * @return array
		 */
		public function post_updated_messages( $messages ) {
			$messages['acf-post-type'] = array(
				0  => '', // Unused. Messages start at index 1.
				1  => $this->post_type_created_message(), // Updated.
				2  => $this->post_type_created_message(),
				3  => __( 'Post type deleted.', 'acf' ),
				4  => __( 'Post type updated.', 'acf' ),
				5  => false, // Post type does not support revisions.
				6  => $this->post_type_created_message( true ), // Created.
				7  => __( 'Post type saved.', 'acf' ),
				8  => __( 'Post type submitted.', 'acf' ),
				9  => __( 'Post type scheduled for.', 'acf' ),
				10 => __( 'Post type draft updated.', 'acf' ),
			);

			return $messages;
		}

		/**
		 * Renders the post type created message.
		 *
		 * @since 6.1
		 *
		 * @param bool $created True if the post was just created.
		 * @return string
		 */
		public function post_type_created_message( $created = false ) {
			global $post_id;

			$title = get_the_title( $post_id );

			/* translators: %s post type name */
			$item_saved_text = sprintf( __( '%s post type updated', 'acf' ), $title );
			/* translators: %s post type name */
			$add_fields_text = sprintf( __( 'Add fields to %s', 'acf' ), $title );

			if ( $created ) {
				/* translators: %s post type name */
				$item_saved_text = sprintf( __( '%s post type created', 'acf' ), $title );
			}

			$add_fields_link      = wp_nonce_url(
				admin_url( 'post-new.php?post_type=acf-field-group&use_post_type=' . $post_id ),
				'add-fields-' . $post_id
			);
			$create_taxonomy_link = wp_nonce_url(
				admin_url( 'post-new.php?post_type=acf-taxonomy&use_post_type=' . $post_id ),
				'create-taxonomy-' . $post_id
			);

			ob_start(); ?>
			<p class="acf-item-saved-text"><?php echo esc_html( $item_saved_text ); ?></p>
			<div class="acf-item-saved-links">
				<a href="<?php echo esc_url( $add_fields_link ); ?>"><?php echo esc_html( $add_fields_text ); ?></a>
				<a class="acf-link-field-groups" href="#"><?php esc_html_e( 'Link existing field groups', 'acf' ); ?></a>
				<a href="<?php echo esc_url( $create_taxonomy_link ); ?>"><?php esc_html_e( 'Create new taxonomy', 'acf' ); ?></a>
			</div>
			<?php
			return ob_get_clean();
		}

		/**
		 * Enqueues any scripts necessary for internal post type.
		 *
		 * @since 5.0.0
		 *
		 * @return void
		 */
		public function admin_enqueue_scripts() {
			// TODO: Check this is OK.
			parent::admin_enqueue_scripts();

			wp_enqueue_style( 'acf-field-group' );
			// wp_enqueue_script( 'acf-field-group' );

			acf_localize_text(
				array()
			);

			acf_localize_data(
				array()
			);

			do_action( 'acf/post_type/admin_enqueue_scripts' );
		}

		/**
		 *  Sets up all functionality for the taxonomy edit page to work.
		 *
		 *  @since   3.1.8
		 *
		 *  @return  void
		 */
		public function admin_head() {

			// global.
			global $post, $acf_post_type;

			// set global var.
			$acf_post_type = acf_get_internal_post_type( $post->ID, $this->post_type );

			// metaboxes.
			add_meta_box( 'acf-basic-settings', __( 'Basic Settings', 'acf' ), array( $this, 'mb_basic_settings' ), 'acf-post-type', 'normal', 'high' );
			add_meta_box( 'acf-advanced-settings', __( 'Advanced Settings', 'acf' ), array( $this, 'mb_advanced_settings' ), 'acf-post-type', 'normal', 'high' );

			// actions.
			add_action( 'post_submitbox_misc_actions', array( $this, 'post_submitbox_misc_actions' ), 10, 0 );
			add_action( 'edit_form_after_title', array( $this, 'edit_form_after_title' ), 10, 0 );

			// filters.
			add_filter( 'screen_settings', array( $this, 'screen_settings' ), 10, 1 );
			add_filter( 'get_user_option_screen_layout_acf-post-type', array( $this, 'screen_layout' ), 10, 1 );
			add_filter( 'get_user_option_metaboxhidden_acf-post-type', array( $this, 'force_basic_settings' ), 10, 1 );
			add_filter( 'get_user_option_closedpostboxes_acf-post-type', array( $this, 'force_basic_settings' ), 10, 1 );

			// 3rd party hook.
			do_action( 'acf/post_type/admin_head' );
		}

		/**
		 *  This action will allow ACF to render metaboxes after the title
		 *
		 *  @date    17/08/13
		 *
		 *  @return void
		 */
		public function edit_form_after_title() {

			// globals.
			global $post;

			// render post data.
			acf_form_data(
				array(
					'screen'        => 'post_type',
					'post_id'       => $post->ID,
					'delete_fields' => 0,
					'validation'    => 0,
				)
			);
		}

		/**
		 * This function will add extra HTML to the acf form data element
		 *
		 *  @since   5.3.8
		 *
		 *  @param array $args Arguments array to pass through to action.
		 *  @return void
		 */
		public function form_data( $args ) {
			do_action( 'acf/post_type/form_data', $args );
		}

		/**
		 * This function will append extra l10n strings to the acf JS object
		 *
		 * @since   5.3.8
		 *
		 * @param   array $l10n The array of translated strings.
		 * @return  $l10n
		 */
		public function admin_l10n( $l10n ) {
			return apply_filters( 'acf/post_type/admin_l10n', $l10n );
		}

		/**
		 * Admin footer third party hook support
		 *
		 * @since   5.3.2
		 *
		 * @return void
		 */
		public function admin_footer() {
			do_action( 'acf/post_type/admin_footer' );
		}

		/**
		 * Screen settings html output
		 *
		 * @since   3.6.0
		 *
		 * @param string $html Current screen settings HTML.
		 * @return string $html
		 */
		public function screen_settings( $html ) {
			// TODO: Add any screen settings for the acf-post-type CPT.
			return $html;
		}

		/**
		 * Sets the "Edit Post Type" screen to use a one-column layout.
		 *
		 * @param int $columns Number of columns for layout.
		 *
		 * @return int
		 */
		public function screen_layout( $columns = 0 ) {
			return 1;
		}

		/**
		 * Force basic settings to always be visible
		 *
		 * @param array $hidden_metaboxes The metaboxes hidden on this page.
		 *
		 * @return array
		 */
		public function force_basic_settings( $hidden_metaboxes ) {
			if ( ! is_array( $hidden_metaboxes ) ) {
				return $hidden_metaboxes;
			}
			return array_diff( $hidden_metaboxes, array( 'acf-basic-settings' ) );
		}

		/**
		 * This function will customize the publish metabox
		 *
		 * @since   5.2.9
		 *
		 * @return void
		 */
		public function post_submitbox_misc_actions() {
			global $acf_post_type;
			$status_label = $acf_post_type['active'] ? _x( 'Active', 'post status', 'acf' ) : _x( 'Inactive', 'post status', 'acf' );

			?>
			<script type="text/javascript">
				(function($) {
					$('#post-status-display').html( '<?php echo esc_html( $status_label ); ?>' );
				})(jQuery);
			</script>
			<?php
		}

		/**
		 * Saves taxonomy data.
		 *
		 * @since 1.0.0
		 *
		 * @param int     $post_id The post ID.
		 * @param WP_Post $post    The post object.
		 *
		 * @return int $post_id
		 */
		public function save_post( $post_id, $post ) {
			if ( ! $this->verify_save_post( $post_id, $post ) ) {
				return $post_id;
			}

			// Disable filters to ensure ACF loads raw data from DB.
			acf_disable_filters();

			// phpcs:disable WordPress.Security.NonceVerification.Missing -- Validated in $this->verify_save_post() above.
			// phpcs:disable WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Sanitized when saved.
			$_POST['acf_post_type']['ID']    = $post_id;
			$_POST['acf_post_type']['title'] = isset( $_POST['acf_post_type']['labels']['name'] ) ? $_POST['acf_post_type']['labels']['name'] : '';

			// Save the post type.
			acf_update_internal_post_type( $_POST['acf_post_type'], $this->post_type ); // phpcs:ignore WordPress.Security.NonceVerification.Missing -- Validated in verify_save_post
			// phpcs:enable WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
			// phpcs:enable WordPress.Security.NonceVerification.Missing

			return $post_id;
		}

		/**
		 * Renders HTML for the basic settings metabox.
		 *
		 * @since 5.0.0
		 *
		 * @return void
		 */
		public function mb_basic_settings() {
			global $acf_post_type;

			if ( ! acf_is_internal_post_type_key( $acf_post_type['key'], 'acf-post-type' ) ) {
				$acf_post_type['key'] = uniqid( 'post_type_' );
			}

			acf_get_view( $this->post_type . '/basic-settings' );
		}


		/**
		 * Renders the HTML for the advanced settings metabox.
		 *
		 * @since   5.0.0
		 *
		 * @return void
		 */
		public function mb_advanced_settings() {
			global $acf_post_type;

			// field key (leave in for compatibility).
			/*
			if ( ! acf_is_taxonomy_key( $acf_post_type['key'] ) ) {

				$acf_post_type['key'] = uniqid( 'group_' );

			}*/

			acf_get_view( $this->post_type . '/advanced-settings' );
		}

	}

	new ACF_Admin_Post_Type();

endif; // Class exists check.

?>
