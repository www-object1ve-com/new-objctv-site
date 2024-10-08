<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'ACF_Admin_Tool_Import' ) ) :

	class ACF_Admin_Tool_Import extends ACF_Admin_Tool {

		/**
		 *  initialize
		 *
		 *  This function will initialize the admin tool
		 *
		 *  @date    10/10/17
		 *  @since   5.6.3
		 *
		 *  @param   n/a
		 *  @return  n/a
		 */

		function initialize() {

			// vars
			$this->name  = 'import';
			$this->title = __( 'Import Field Groups', 'acf' );
			$this->icon  = 'dashicons-upload';

		}


		/**
		 *  html
		 *
		 *  This function will output the metabox HTML
		 *
		 *  @date    10/10/17
		 *  @since   5.6.3
		 *
		 *  @param   n/a
		 *  @return  n/a
		 */

		function html() {

			?>
		<div class="acf-postbox-header">
			<h2 class="acf-postbox-title"><?php esc_html_e( 'Import', 'acf' ); ?></h2>
			<div class="acf-tip"><i tabindex="0" class="acf-icon acf-icon-help acf-js-tooltip" title="<?php esc_attr_e( 'Select the Advanced Custom Fields JSON file you would like to import. When you click the import button below, ACF will import the items in that file.', 'acf' ); ?>">?</i></div>
		</div>
		<div class="acf-postbox-inner">
			<div class="acf-fields">
				<?php

				acf_render_field_wrap(
					array(
						'label'    => __( 'Select File', 'acf' ),
						'type'     => 'file',
						'name'     => 'acf_import_file',
						'value'    => false,
						'uploader' => 'basic',
					)
				);

				?>
			</div>
			<p class="acf-submit">
				<input type="submit" class="acf-btn" value="<?php _e( 'Import JSON', 'acf' ); ?>" />
			</p>
		</div>
			<?php

		}

		/**
		 * Imports the selected ACF posts and returns an admin notice on completion.
		 *
		 * @date 10/10/17
		 * @since 5.6.3
		 *
		 * @return ACF_Admin_Notice
		 */
		public function submit() {
			// Check file size.
			if ( empty( $_FILES['acf_import_file']['size'] ) ) {
				return acf_add_admin_notice( __( 'No file selected', 'acf' ), 'warning' );
			}

			$file = acf_sanitize_files_array( $_FILES['acf_import_file'] );

			// Check errors.
			if ( $file['error'] ) {
				return acf_add_admin_notice( __( 'Error uploading file. Please try again', 'acf' ), 'warning' );
			}

			// Check file type.
			if ( pathinfo( $file['name'], PATHINFO_EXTENSION ) !== 'json' ) {
				return acf_add_admin_notice( __( 'Incorrect file type', 'acf' ), 'warning' );
			}

			// Read JSON.
			$json = file_get_contents( $file['tmp_name'] );
			$json = json_decode( $json, true );

			// Check if empty.
			if ( ! $json || ! is_array( $json ) ) {
				return acf_add_admin_notice( __( 'Import file empty', 'acf' ), 'warning' );
			}

			// Ensure $json is an array of posts.
			if ( isset( $json['key'] ) ) {
				$json = array( $json );
			}

			// Remember imported post ids.
			$ids = array();

			// Loop over json.
			foreach ( $json as $to_import ) {
				// Search database for existing post.
				$post_type = acf_determine_internal_post_type( $to_import['key'] );
				$post      = acf_get_internal_post_type_post( $to_import['key'], $post_type );

				if ( $post ) {
					$to_import['ID'] = $post->ID;
				}

				// Import the post.
				$to_import = acf_import_internal_post_type( $to_import, $post_type );

				// Append message.
				$ids[] = $to_import['ID'];
			}

			// Count number of imported posts.
			$total = count( $ids );

			// Generate text.
			$text = sprintf( _n( 'Imported 1 item', 'Imported %s items', $total, 'acf' ), $total );

			// Add links to text.
			$links = array();
			foreach ( $ids as $id ) {
				$links[] = '<a href="' . get_edit_post_link( $id ) . '">' . get_the_title( $id ) . '</a>';
			}
			$text .= ' ' . implode( ', ', $links );

			// Add notice.
			return acf_add_admin_notice( $text, 'success' );
		}

	}

	// Initialize.
	acf_register_admin_tool( 'ACF_Admin_Tool_Import' );

endif; // class_exists check.

?>
