<?php

global $acf_post_type;

// Allow preselecting the linked taxonomies based on previously created taxonomy.
$acf_use_taxonomy = acf_request_arg( 'use_taxonomy', false );
if ( $acf_use_taxonomy && wp_verify_nonce( acf_request_arg( '_wpnonce' ), 'create-post-type-' . $acf_use_taxonomy ) ) {
	$acf_linked_taxonomy = acf_get_internal_post_type( (int) $acf_use_taxonomy, 'acf-taxonomy' );

	if ( $acf_linked_taxonomy && isset( $acf_linked_taxonomy['taxonomy'] ) ) {
		$acf_post_type['taxonomies'] = array( $acf_linked_taxonomy['taxonomy'] );
	}
}

foreach ( acf_get_combined_post_type_settings_tabs() as $tab_key => $tab_label ) {
	acf_render_field_wrap(
		array(
			'type'  => 'tab',
			'label' => $tab_label,
			'key'   => 'acf_post_type_tabs',
		)
	);

	switch ( $tab_key ) {
		case 'general':
			acf_render_field_wrap(
				array(
					'type'         => 'select',
					'name'         => 'taxonomies',
					'key'          => 'taxonomies',
					'prefix'       => 'acf_post_type',
					'value'        => $acf_post_type['taxonomies'],
					'label'        => __( 'Linked taxonomies', 'acf' ),
					'instructions' => __( 'Select existing taxonomies to classify items of the post type.', 'acf' ),
					'choices'      => acf_get_taxonomy_labels(),
					'ui'           => true,
					'allow_null'   => true,
					'multiple'     => true,
				),
				'div',
				'field'
			);
			?>

			<hr class="acf-divider" />

			<?php
			$available_supports = array(
				'title'           => __( 'Title', 'acf' ),
				'author'          => __( 'Author', 'acf' ),
				'comments'        => __( 'Comments', 'acf' ),
				'trackbacks'      => __( 'Trackbacks', 'acf' ),
				'editor'          => __( 'Editor', 'acf' ),
				'excerpt'         => __( 'Excerpt', 'acf' ),
				'revisions'       => __( 'Revisions', 'acf' ),
				'page-attributes' => __( 'Page attributes', 'acf' ),
				'thumbnail'       => __( 'Featured image', 'acf' ),
				'custom-fields'   => __( 'Custom fields', 'acf' ),
				'post-formats'    => __( 'Post formats', 'acf' ),
			);
			$available_supports = apply_filters( 'acf/post_type/available_supports', $available_supports );

			acf_render_field_wrap(
				array(
					'type'         => 'checkbox',
					'name'         => 'supports',
					'key'          => 'supports',
					'label'        => __( 'Supports', 'acf' ),
					'instructions' => __( 'Enable various features in the content editor.', 'acf' ),
					'prefix'       => 'acf_post_type',
					'value'        => $acf_post_type['supports'],
					'choices'      => $available_supports,
				),
				'div'
			);
			?>
			
			<hr class="acf-divider" />
			
			<?php
			acf_render_field_wrap(
				array(
					'type'         => 'textarea',
					'name'         => 'description',
					'key'          => 'description',
					'prefix'       => 'acf_post_type',
					'value'        => $acf_post_type['description'],
					'label'        => __( 'Description', 'acf' ),
					'instructions' => __( 'A descriptive summary of the post type.', 'acf' ),
				),
				'div',
				'field'
			);

			break;
		case 'labels':
			acf_render_field_wrap(
				array(
					'type'        => 'text',
					'name'        => 'menu_name',
					'key'         => 'menu_name',
					'prefix'      => 'acf_post_type[labels]',
					'value'       => $acf_post_type['labels']['menu_name'],
					'data'        => array(
						'label'     => '%s',
						'replace'   => 'plural',
						'transform' => 'none',
					),
					'label'       => __( 'Menu name', 'acf' ),
					'placeholder' => __( 'Movies', 'acf' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'all_items',
					'key'          => 'all_items',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['all_items'],
					'data'         => array(
						/* translators: %s Plural form of post type name */
						'label'   => __( 'All %s', 'acf' ),
						'replace' => 'plural',
					),
					'label'        => __( 'All items', 'acf' ),
					'instructions' => __( 'In the post type submenu in the admin dashboard.', 'acf' ),
					'placeholder'  => __( 'e.g. All movies', 'acf' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'edit_item',
					'key'          => 'edit_item',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['edit_item'],
					'data'         => array(
						/* translators: %s Singular form of post type name */
						'label'   => __( 'Edit %s', 'acf' ),
						'replace' => 'singular',
					),
					'label'        => __( 'Edit item', 'acf' ),
					'instructions' => __( 'At the top of the editor screen when editing an item.', 'acf' ),
					'placeholder'  => __( 'e.g. Edit movies', 'acf' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'view_item',
					'key'          => 'view_item',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['view_item'],
					'data'         => array(
						/* translators: %s Singular form of post type name */
						'label'   => __( 'View %s', 'acf' ),
						'replace' => 'singular',
					),
					'label'        => __( 'View item', 'acf' ),
					'instructions' => __( 'In the admin bar to view item when editing it.', 'acf' ),
					'placeholder'  => __( 'e.g. View movie', 'acf' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'view_items',
					'key'          => 'view_items',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['view_items'],
					'data'         => array(
						/* translators: %s Plural form of post type name */
						'label'   => __( 'View %s', 'acf' ),
						'replace' => 'plural',
					),
					'label'        => __( 'View items', 'acf' ),
					'instructions' => __( 'Appears in the admin bar in the ‘All Posts’ view, provided the post type supports archives and the home page is not an archive of that post type.', 'acf' ),
					'placeholder'  => __( 'Placeholder text', 'acf' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'add_new_item',
					'key'          => 'add_new_item',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['add_new_item'],
					'data'         => array(
						/* translators: %s Singular form of post type name */
						'label'   => __( 'Add new %s', 'acf' ),
						'replace' => 'singular',
					),
					'label'        => __( 'Add new item', 'acf' ),
					'instructions' => __( 'At the top of the editor screen when adding a new item.', 'acf' ),
					'placeholder'  => __( 'e.g. Add new movie', 'acf' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'add_new',
					'key'          => 'add_new',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['add_new'],
					'label'        => __( 'Add new', 'acf' ),
					'instructions' => __( 'In the post type submenu in the admin dashboard.', 'acf' ),
					'placeholder'  => __( 'Add new', 'acf' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'new_item',
					'key'          => 'new_item',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['new_item'],
					'data'         => array(
						/* translators: %s Singular form of post type name */
						'label'   => __( 'New %s', 'acf' ),
						'replace' => 'singular',
					),
					'label'        => __( 'New item name', 'acf' ),
					'instructions' => __( 'In the post type submenu in the admin dashboard.', 'acf' ),
					'placeholder'  => __( 'e.g. New movie', 'acf' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'parent_item_colon',
					'key'          => 'parent_item_colon',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['parent_item_colon'],
					'data'         => array(
						/* translators: %s Singular form of post type name */
						'label'   => __( 'Parent %s:', 'acf' ),
						'replace' => 'singular',
					),
					'label'        => __( 'Parent Item Prefix', 'acf' ),
					'instructions' => __( 'For hierarchical types in the post type list screen.', 'acf' ),
					'placeholder'  => __( 'Parent movie:', 'acf' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'search_items',
					'key'          => 'search_items',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['search_items'],
					'data'         => array(
						/* translators: %s Singular form of post type name */
						'label'   => __( 'Search %s', 'acf' ),
						'replace' => 'plural',
					),
					'label'        => __( 'Search items', 'acf' ),
					'instructions' => __( 'At the top of the items screen when searching for an item.', 'acf' ),
					'placeholder'  => __( 'e.g. Search movies', 'acf' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'not_found',
					'key'          => 'not_found',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['not_found'],
					'data'         => array(
						/* translators: %s Plural form of post type name */
						'label'   => __( 'No %s found', 'acf' ),
						'replace' => 'plural',
					),
					'label'        => __( 'No Items Found', 'acf' ),
					'instructions' => __( 'At the top of the post type list screen when there are no posts to display.', 'acf' ),
					'placeholder'  => __( 'e.g. No movies found', 'acf' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'not_found_in_trash',
					'key'          => 'not_found_in_trash',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['not_found_in_trash'],
					'data'         => array(
						/* translators: %s Plural form of post type name */
						'label'   => __( 'No %s found in Trash', 'acf' ),
						'replace' => 'plural',
					),
					'label'        => __( 'No Items Found in Trash', 'acf' ),
					'instructions' => __( 'At the top of the post type list screen when there are no posts in the trash.', 'acf' ),
					'placeholder'  => __( 'e.g. No movies found', 'acf' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'archives',
					'key'          => 'archives',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['archives'],
					'data'         => array(
						/* translators: %s Singular form of post type name */
						'label'     => __( '%s Archives', 'acf' ),
						'replace'   => 'singular',
						'transform' => 'none',
					),
					'label'        => __( 'Archives Nav Menu', 'acf' ),
					'instructions' => __( "Adds 'Post Type Archive' items with this label to the list of posts shown when adding items to an existing menu in a CPT with archives enabled. Only appears when editing menus in ‘Live Preview’ mode and a custom archive slug has been provided.", 'acf' ),
					'placeholder'  => __( 'Movie Archives', 'acf' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'attributes',
					'key'          => 'attributes',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['attributes'],
					'data'         => array(
						/* translators: %s Singular form of post type name */
						'label'     => __( '%s Attributes', 'acf' ),
						'replace'   => 'singular',
						'transform' => 'none',
					),
					'label'        => __( 'Attributes Meta Box', 'acf' ),
					'instructions' => __( 'In the editor used for the title of the post attributes meta box.', 'acf' ),
					'placeholder'  => __( 'Movie Attributes', 'acf' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'featured_image',
					'key'          => 'featured_image',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['featured_image'],
					'label'        => __( 'Featured Image Meta Box', 'acf' ),
					'instructions' => __( 'In the editor used for the title of the featured image meta box.', 'acf' ),
					'placeholder'  => __( 'Featured image', 'acf' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'set_featured_image',
					'key'          => 'set_featured_image',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['set_featured_image'],
					'label'        => __( 'Set Featured Image', 'acf' ),
					'instructions' => __( 'As the button label when setting the featured image.', 'acf' ),
					'placeholder'  => __( 'Set featured image', 'acf' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'remove_featured_image',
					'key'          => 'remove_featured_image',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['remove_featured_image'],
					'label'        => __( 'Remove Featured Image', 'acf' ),
					'instructions' => __( 'As the button label when removing the featured image.', 'acf' ),
					'placeholder'  => __( 'Remove featured image', 'acf' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'use_featured_image',
					'key'          => 'use_featured_image',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['use_featured_image'],
					'label'        => __( 'Use Featured Image', 'acf' ),
					'instructions' => __( 'As the button label for selecting to use an image as the featured image.', 'acf' ),
					'placeholder'  => __( 'Use as featured image', 'acf' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'insert_into_item',
					'key'          => 'insert_into_item',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['insert_into_item'],
					'data'         => array(
						/* translators: %s Singular form of post type name */
						'label'   => __( 'Insert into %s', 'acf' ),
						'replace' => 'singular',
					),
					'label'        => __( 'Insert Into Media Button', 'acf' ),
					'instructions' => __( 'As the button label when adding media to content.', 'acf' ),
					'placeholder'  => __( 'Insert into movie', 'acf' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'uploaded_to_this_item',
					'key'          => 'uploaded_to_this_item',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['uploaded_to_this_item'],
					'data'         => array(
						/* translators: %s Singular form of post type name */
						'label'   => __( 'Uploaded to this %s', 'acf' ),
						'replace' => 'singular',
					),
					'label'        => __( 'Uploaded to This Item', 'acf' ),
					'instructions' => __( 'In the media modal showing all media uploaded to this item.', 'acf' ),
					'placeholder'  => __( 'Uploaded to this movie', 'acf' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'filter_items_list',
					'key'          => 'filter_items_list',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['filter_items_list'],
					'data'         => array(
						/* translators: %s Plural form of post type name */
						'label'   => __( 'Filter %s list', 'acf' ),
						'replace' => 'plural',
					),
					'label'        => __( 'Filter Items List', 'acf' ),
					'instructions' => __( 'Used by screen readers for the filter links heading on the post type list screen.', 'acf' ),
					'placeholder'  => __( 'Filter movies list', 'acf' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'filter_by_date',
					'key'          => 'filter_by_date',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['filter_by_date'],
					'data'         => array(
						/* translators: %s Plural form of post type name */
						'label'   => __( 'Filter %s by date', 'acf' ),
						'replace' => 'plural',
					),
					'label'        => __( 'Filter Items By Date', 'acf' ),
					'instructions' => __( 'Used by screen readers for the filter by date heading on the post type list screen.', 'acf' ),
					'placeholder'  => __( 'Filter movies by date', 'acf' ),
				),
				'div',
				'field'
			);


			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'items_list_navigation',
					'key'          => 'items_list_navigation',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['items_list_navigation'],
					'data'         => array(
						/* translators: %s Plural form of post type name */
						'label'     => __( '%s list navigation', 'acf' ),
						'replace'   => 'plural',
						'transform' => 'none',
					),
					'label'        => __( 'Items list navigation', 'acf' ),
					'instructions' => __( 'Used by screen readers for the filter list pagination on the post type list screen.', 'acf' ),
					'placeholder'  => __( 'e.g. Movies list navigation', 'acf' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'items_list',
					'key'          => 'items_list',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['items_list'],
					'data'         => array(
						/* translators: %s Plural form of post type name */
						'label'     => __( '%s list', 'acf' ),
						'replace'   => 'plural',
						'transform' => 'none',
					),
					'label'        => __( 'Items list', 'acf' ),
					'instructions' => __( 'Used by screen readers for the items list on the post type list screen.', 'acf' ),
					'placeholder'  => __( 'e.g. Movies list', 'acf' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'item_published',
					'key'          => 'item_published',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['item_published'],
					'data'         => array(
						/* translators: %s Singular form of post type name */
						'label'     => __( '%s published', 'acf' ),
						'replace'   => 'singular',
						'transform' => 'none',
					),
					'label'        => __( 'Item Published.', 'acf' ),
					'instructions' => __( 'In the editor notice after publishing an item.', 'acf' ),
					'placeholder'  => __( 'Movie published.', 'acf' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'item_published_privately',
					'key'          => 'item_published_privately',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['item_published_privately'],
					'data'         => array(
						/* translators: %s Singular form of post type name */
						'label'     => __( '%s published privately.', 'acf' ),
						'replace'   => 'singular',
						'transform' => 'none',
					),
					'label'        => __( 'Item Published Privately', 'acf' ),
					'instructions' => __( 'In the editor notice after publishing a private item.', 'acf' ),
					'placeholder'  => __( 'Movie published privately.', 'acf' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'item_reverted_to_draft',
					'key'          => 'item_reverted_to_draft',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['item_reverted_to_draft'],
					'data'         => array(
						/* translators: %s Singular form of post type name */
						'label'     => __( '%s reverted to draft.', 'acf' ),
						'replace'   => 'singular',
						'transform' => 'none',
					),
					'label'        => __( 'Item Reverted to Draft', 'acf' ),
					'instructions' => __( 'In the editor notice after reverting an item to draft.', 'acf' ),
					'placeholder'  => __( 'Movie reverted to draft.', 'acf' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'item_scheduled',
					'key'          => 'item_scheduled',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['item_scheduled'],
					'data'         => array(
						/* translators: %s Singular form of post type name */
						'label'     => __( '%s scheduled.', 'acf' ),
						'replace'   => 'singular',
						'transform' => 'none',
					),
					'label'        => __( 'Item Scheduled', 'acf' ),
					'instructions' => __( 'In the editor notice after scheduling an item.', 'acf' ),
					'placeholder'  => __( 'Movie scheduled.', 'acf' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'item_updated',
					'key'          => 'item_updated',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['item_updated'],
					'data'         => array(
						/* translators: %s Singular form of post type name */
						'label'     => __( '%s updated.', 'acf' ),
						'replace'   => 'singular',
						'transform' => 'none',
					),
					'label'        => __( 'Item Updated', 'acf' ),
					'instructions' => __( 'In the editor notice after an item is updated.', 'acf' ),
					'placeholder'  => __( 'Movie updated.', 'acf' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'item_link',
					'key'          => 'item_link',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['item_link'],
					'data'         => array(
						/* translators: %s Singular form of post type name */
						'label'     => __( '%s Link', 'acf' ),
						'replace'   => 'singular',
						'transform' => 'none',
					),
					'label'        => __( 'Item Link', 'acf' ),
					'instructions' => __( 'Title for a navigation link block variation.', 'acf' ),
					'placeholder'  => __( 'Movie Link', 'acf' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'item_link_description',
					'key'          => 'item_link_description',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['item_link_description'],
					'data'         => array(
						/* translators: %s Singular form of post type name */
						'label'     => __( 'A link to a %s.', 'acf' ),
						'replace'   => 'singular',
						'transform' => 'none',
					),
					'label'        => __( 'Item Link Description', 'acf' ),
					'instructions' => __( 'Description for a navigation link block variation.', 'acf' ),
					'placeholder'  => __( 'A link to a movie.', 'acf' ),
				),
				'div',
				'field'
			);
			break;
		case 'visibility':
			acf_render_field_wrap(
				array(
					'type'         => 'true_false',
					'name'         => 'show_ui',
					'key'          => 'show_ui',
					'prefix'       => 'acf_post_type',
					'value'        => $acf_post_type['show_ui'],
					'label'        => __( 'Admin Editor Support', 'acf' ),
					'instructions' => __( 'Items can be edited and managed in the admin dashboard.', 'acf' ),
					'ui'           => true,
					'default'      => 1,
				)
			);

			acf_render_field_wrap(
				array(
					'type'         => 'true_false',
					'name'         => 'show_in_menu',
					'key'          => 'show_in_menu',
					'prefix'       => 'acf_post_type',
					'value'        => $acf_post_type['show_in_menu'],
					'label'        => __( 'Show in Admin Menu', 'acf' ),
					'instructions' => __( 'Admin editor navigation in the sidebar menu.', 'acf' ),
					'ui'           => true,
					'default'      => 1,
				)
			);

			acf_render_field_wrap(
				array(
					'type'         => 'true_false',
					'name'         => 'show_in_nav_menus',
					'key'          => 'show_in_nav_menus',
					'prefix'       => 'acf_post_type',
					'value'        => $acf_post_type['show_in_nav_menus'],
					'label'        => __( 'Appearance Menus Support', 'acf' ),
					'instructions' => __( "Allow items to be added to menus in the 'Appearance' > 'Menus' screen. Must be turned on in 'Screen options'.", 'acf' ),
					'ui'           => true,
					'default'      => 1,
				)
			);

			acf_render_field_wrap(
				array(
					'type'         => 'true_false',
					'name'         => 'show_in_admin_bar',
					'key'          => 'show_in_admin_bar',
					'prefix'       => 'acf_post_type',
					'value'        => $acf_post_type['show_in_admin_bar'],
					'label'        => __( 'Show in Admin Bar', 'acf' ),
					'instructions' => __( "Appears as an item in the 'New' menu in the admin bar.", 'acf' ),
					'ui'           => true,
					'default'      => 1,
				)
			);

			acf_render_field_wrap(
				array(
					'type'         => 'true_false',
					'name'         => 'exclude_from_search',
					'key'          => 'exclude_from_search',
					'prefix'       => 'acf_post_type',
					'value'        => $acf_post_type['exclude_from_search'],
					'label'        => __( 'Exclude from search', 'acf' ),
					'instructions' => __( 'Sets whether posts should be excluded from search results.', 'acf' ),
					'ui'           => true,
				)
			);

			$acf_dashicon_class_name = __( 'Dashicon class name', 'acf' );
			$acf_dashicon_link       = '<a href="https://developer.wordpress.org/resource/dashicons/" target="_blank">' . $acf_dashicon_class_name . '</a>';

			$acf_menu_icon_instructions = sprintf(
				/* translators: %s = "dashicon class name", link to the WordPress dashicon documentation. */
				__( 'The icon used for the post type menu item in the admin dashboard. Can be a URL or %s to use for icon.', 'acf' ),
				$acf_dashicon_link
			);
			?>
			
			<hr class="acf-divider" />
			
			<?php
			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'menu_icon',
					'key'          => 'menu_icon',
					'prefix'       => 'acf_post_type',
					'value'        => $acf_post_type['menu_icon'],
					'label'        => __( 'Menu Icon', 'acf' ),
					'instructions' => $acf_menu_icon_instructions,
					'conditions'   => array(
						'field'    => 'show_in_menu',
						'operator' => '==',
						'value'    => 1,
					),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'number',
					'name'         => 'menu_position',
					'key'          => 'menu_position',
					'prefix'       => 'acf_post_type',
					'value'        => $acf_post_type['menu_position'],
					'label'        => __( 'Menu Position', 'acf' ),
					'instructions' => __( 'The position in the sidebar menu in the admin dashboard.', 'acf' ),
					'conditions'   => array(
						'field'    => 'show_in_menu',
						'operator' => '==',
						'value'    => 1,
					),
				),
				'div',
				'field'
			);

			break;
		case 'permissions':
			acf_render_field_wrap(
				array(
					'type'         => 'true_false',
					'name'         => 'rename_capabilities',
					'key'          => 'rename_capabilities',
					'prefix'       => 'acf_post_type',
					'value'        => $acf_post_type['rename_capabilities'],
					'label'        => __( 'Rename Capabilities', 'acf' ),
					'instructions' => __( "By default the capabilities of the post type will inherit the 'Post' capability names, eg. edit_post, delete_posts. Enable to use post type specific capabilities, eg. edit_{singular}, delete_{plural}.", 'acf' ),
					'default'      => false,
					'ui'           => true,
				),
				'div'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'singular_capability_name',
					'key'          => 'singular_capability_name',
					'prefix'       => 'acf_post_type',
					'value'        => $acf_post_type['singular_capability_name'],
					'label'        => __( 'Singular Capability Name', 'acf' ),
					'instructions' => __( 'Choose another post type to base the capabilities for this post type.', 'acf' ),
					'conditions'   => array(
						'field'    => 'rename_capabilities',
						'operator' => '==',
						'value'    => '1',
					),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'plural_capability_name',
					'key'          => 'plural_capability_name',
					'prefix'       => 'acf_post_type',
					'value'        => $acf_post_type['plural_capability_name'],
					'label'        => __( 'Plural Capability Name', 'acf' ),
					'instructions' => __( 'Optionally provide a plural to be used in capabilities.', 'acf' ),
					'conditions'   => array(
						'field'    => 'rename_capabilities',
						'operator' => '==',
						'value'    => '1',
					),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'true_false',
					'name'         => 'can_export',
					'key'          => 'can_export',
					'prefix'       => 'acf_post_type',
					'value'        => $acf_post_type['can_export'],
					'label'        => __( 'Can export', 'acf' ),
					'instructions' => __( "Allow the post type to be exported from 'Tools' > 'Export'.", 'acf' ),
					'default'      => 1,
					'ui'           => 1,
				),
				'div'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'true_false',
					'name'         => 'delete_with_user',
					'key'          => 'delete_with_user',
					'prefix'       => 'acf_post_type',
					'value'        => $acf_post_type['delete_with_user'],
					'label'        => __( 'Delete with user', 'acf' ),
					'instructions' => __( 'Delete items by a user when that user is deleted.', 'acf' ),
					'ui'           => 1,
				),
				'div'
			);
			break;
		case 'permalinks':
			acf_render_field_wrap(
				array(
					'type'         => 'true_false',
					'name'         => 'pretty_permalinks',
					'key'          => 'pretty_permalinks',
					'prefix'       => 'acf_post_type[rewrite]',
					'value'        => $acf_post_type['rewrite']['pretty_permalinks'],
					'label'        => __( 'Pretty Permalinks', 'acf' ),
					'instructions' => __( 'Rewrite the URL using the post type key as the slug. Your permalink structure will be {url}.', 'acf' ),
					'ui'           => 1,
					'default'      => 1,
				),
				'div'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'slug',
					'key'          => 'slug',
					'prefix'       => 'acf_post_type[rewrite]',
					'value'        => $acf_post_type['rewrite']['slug'],
					'label'        => __( 'URL Slug', 'acf' ),
					'instructions' => __( 'Customize the slug used in the URL.', 'acf' ),
					'conditions'   => array(
						'field'    => 'pretty_permalinks',
						'operator' => '==',
						'value'    => '1',
					),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'true_false',
					'name'         => 'with_front',
					'key'          => 'with_front',
					'prefix'       => 'acf_post_type[rewrite]',
					'value'        => $acf_post_type['rewrite']['with_front'],
					'label'        => __( 'Front URL Prefix', 'acf' ),
					'instructions' => __( 'Alters the permalink structure to add the `WP_Rewrite::$front` prefix to URLs.', 'acf' ),
					'ui'           => true,
					'default'      => 1,
					'conditions'   => array(
						'field'    => 'pretty_permalinks',
						'operator' => '==',
						'value'    => '1',
					),
				)
			);

			acf_render_field_wrap(
				array(
					'type'         => 'true_false',
					'name'         => 'feeds',
					'key'          => 'feeds',
					'prefix'       => 'acf_post_type[rewrite]',
					'value'        => $acf_post_type['rewrite']['feeds'],
					'label'        => __( 'Feed URL', 'acf' ),
					'instructions' => __( 'RSS feed URL for the post type items.', 'acf' ),
					'ui'           => true,
					'conditions'   => array(
						'field'    => 'pretty_permalinks',
						'operator' => '==',
						'value'    => '1',
					),
				)
			);

			acf_render_field_wrap(
				array(
					'type'         => 'true_false',
					'name'         => 'pages',
					'key'          => 'pages',
					'prefix'       => 'acf_post_type[rewrite]',
					'value'        => $acf_post_type['rewrite']['pages'],
					'label'        => __( 'Pagination', 'acf' ),
					'instructions' => __( 'Pagination support for the items URLs such as the archives.', 'acf' ),
					'ui'           => true,
					'default'      => 1,
					'conditions'   => array(
						'field'    => 'pretty_permalinks',
						'operator' => '==',
						'value'    => '1',
					),
				)
			);

			acf_render_field_wrap(
				array(
					'type'         => 'true_false',
					'name'         => 'has_archive',
					'key'          => 'has_archive',
					'prefix'       => 'acf_post_type',
					'value'        => $acf_post_type['has_archive'],
					'label'        => __( 'Archive', 'acf' ),
					'instructions' => __( 'Has an item archive that can be customized with an archive template file in your theme.', 'acf' ),
					'ui'           => true,
				),
				'div'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'has_archive_slug',
					'key'          => 'has_archive_slug',
					'prefix'       => 'acf_post_type',
					'value'        => $acf_post_type['has_archive_slug'],
					'label'        => __( 'Archive Slug', 'acf' ),
					'instructions' => __( 'Custom slug for the Archive URL.', 'acf' ),
					'ui'           => true,
					'conditions'   => array(
						'field'    => 'has_archive',
						'operator' => '==',
						'value'    => '1',
					),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'true_false',
					'name'         => 'query_var',
					'key'          => 'query_var',
					'prefix'       => 'acf_post_type',
					'value'        => $acf_post_type['query_var'],
					'label'        => __( 'Query Variable Support', 'acf' ),
					'instructions' => __( 'Items can be accessed using the non-pretty permalink, eg. {post_type}={post_slug}.', 'acf' ),
					'default'      => 1,
					'ui'           => true,
				),
				'div'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'query_var_name',
					'key'          => 'query_var_name',
					'prefix'       => 'acf_post_type',
					'value'        => $acf_post_type['query_var_name'],
					'label'        => __( 'Query Variable', 'acf' ),
					'instructions' => __( 'Customize the query variable name.', 'acf' ),
					'ui'           => true,
					'conditions'   => array(
						'field'    => 'query_var',
						'operator' => '==',
						'value'    => '1',
					),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'true_false',
					'name'         => 'publicly_queryable',
					'key'          => 'publicly_queryable',
					'prefix'       => 'acf_post_type',
					'value'        => $acf_post_type['publicly_queryable'],
					'label'        => __( 'Publicly Queryable', 'acf' ),
					'instructions' => __( 'URLs for an item and items can be accessed with a query string.', 'acf' ),
					'default'      => 1,
					'ui'           => true,
				),
				'div'
			);
			break;
		case 'rest_api':
			acf_render_field_wrap(
				array(
					'type'         => 'true_false',
					'name'         => 'show_in_rest',
					'key'          => 'show_in_rest',
					'prefix'       => 'acf_post_type',
					'value'        => $acf_post_type['show_in_rest'],
					'label'        => __( 'Show in REST API', 'acf' ),
					'instructions' => __( 'Exposes this post type in the REST API. Required to use the block editor.', 'acf' ),
					'default'      => 1,
					'ui'           => true,
				),
				'div'
			);
			?>
			
			<hr class="acf-divider" />
			
			<?php
			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'rest_base',
					'key'          => 'rest_base',
					'prefix'       => 'acf_post_type',
					'value'        => $acf_post_type['rest_base'],
					'label'        => __( 'Rest base', 'acf' ),
					'instructions' => __( 'The base slug for the post type REST API URLs.', 'acf' ),
					'conditions'   => array(
						'field'    => 'show_in_rest',
						'operator' => '==',
						'value'    => '1',
					),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'rest_namespace',
					'key'          => 'rest_namespace',
					'prefix'       => 'acf_post_type',
					'value'        => $acf_post_type['rest_namespace'],
					'label'        => __( 'Namespace Route', 'acf' ),
					'instructions' => __( 'The namespace part of the REST API URL.', 'acf' ),
					'conditions'   => array(
						'field'    => 'show_in_rest',
						'operator' => '==',
						'value'    => '1',
					),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'rest_controller_class',
					'key'          => 'rest_controller_class',
					'prefix'       => 'acf_post_type',
					'value'        => $acf_post_type['rest_controller_class'],
					'label'        => __( 'Controller class', 'acf' ),
					'instructions' => __( 'Optional custom controller to use instead of `WP_REST_Posts_Controller`.', 'acf' ),
					'default'      => 'WP_REST_Posts_Controller',
					'conditions'   => array(
						'field'    => 'show_in_rest',
						'operator' => '==',
						'value'    => '1',
					),
				),
				'div',
				'field'
			);
			break;
	}

	do_action( "acf/post_type/render_settings_tab/{$tab_key}", $acf_post_type );
}

