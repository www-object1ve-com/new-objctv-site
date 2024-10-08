<?php

global $acf_taxonomy;

foreach ( acf_get_combined_taxonomy_settings_tabs() as $tab_key => $tab_label ) {
	acf_render_field_wrap(
		array(
			'type'  => 'tab',
			'label' => $tab_label,
			'key'   => 'acf_taxonomy_tabs',
		)
	);

	switch ( $tab_key ) {
		case 'general':
			acf_render_field_wrap(
				array(
					'type'         => 'true_false',
					'key'          => 'sort',
					'name'         => 'sort',
					'prefix'       => 'acf_taxonomy',
					'value'        => $acf_taxonomy['sort'],
					'label'        => __( 'Sort Terms', 'acf' ),
					'instructions' => __( 'Whether terms in this taxonomy should be sorted in the order they are provided to `wp_set_object_terms()`.', 'acf' ),
					'ui'           => true,
				)
			);

			acf_render_field_wrap(
				array(
					'type'         => 'true_false',
					'key'          => 'default_term_enabled',
					'name'         => 'default_term_enabled',
					'prefix'       => 'acf_taxonomy[default_term]',
					'value'        => $acf_taxonomy['default_term']['default_term_enabled'],
					'label'        => __( 'Default Term', 'acf' ),
					'instructions' => __( 'Create a term for the taxonomy that cannot be deleted. It will not be selected for posts by default.', 'acf' ),
					'ui'           => true,
				)
			);
			?>
			
			<hr class="acf-divider" />
			
			<?php
			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'default_term_name',
					'key'          => 'default_term_name',
					'prefix'       => 'acf_taxonomy[default_term]',
					'value'        => isset( $acf_taxonomy['default_term']['default_term_name'] ) ? $acf_taxonomy['default_term']['default_term_name'] : '',
					'label'        => __( 'Term Name', 'acf' ),
					'instructions' => __( 'The name of the default term.', 'acf' ),
					'required'     => 1,
					'conditions'   => array(
						'field'    => 'default_term_enabled',
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
					'name'         => 'default_term_slug',
					'key'          => 'default_term_slug',
					'prefix'       => 'acf_taxonomy[default_term]',
					'value'        => isset( $acf_taxonomy['default_term']['default_term_slug'] ) ? $acf_taxonomy['default_term']['default_term_slug'] : '',
					'label'        => __( 'Term Slug', 'acf' ),
					'instructions' => __( 'Single word, no spaces. Underscores and dashes allowed.', 'acf' ),
					'conditions'   => array(
						'field'    => 'default_term_enabled',
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
					'name'         => 'description',
					'key'          => 'default_term_description',
					'prefix'       => 'acf_taxonomy[default_term]',
					'value'        => isset( $acf_taxonomy['default_term']['default_term_description'] ) ? $acf_taxonomy['default_term']['default_term_description'] : '',
					'label'        => __( 'Term Description', 'acf' ),
					'instructions' => __( 'A descriptive summary of the term.', 'acf' ),
					'conditions'   => array(
						'field'    => 'default_term_enabled',
						'operator' => '==',
						'value'    => '1',
					),
				),
				'div',
				'field'
			);
			?>
			
			<hr class="acf-divider" />
			
			<?php
			acf_render_field_wrap(
				array(
					'type'         => 'textarea',
					'name'         => 'description',
					'prefix'       => 'acf_taxonomy',
					'value'        => $acf_taxonomy['description'],
					'label'        => __( 'Description', 'acf' ),
					'instructions' => __( 'A descriptive summary of the taxonomy.', 'acf' ),
				),
				'div',
				'field'
			);
			break;
		case 'labels':
			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'key'          => 'menu_name',
					'name'         => 'menu_name',
					'prefix'       => 'acf_taxonomy[labels]',
					'value'        => $acf_taxonomy['labels']['menu_name'],
					'data'         => array(
						/* translators: %s Plural form of taxonomy name */
						'label'     => '%s',
						'replace'   => 'plural',
						'transform' => 'none',
					),
					'label'        => __( 'Menu Label', 'acf' ),
					'instructions' => __( 'Assigns the menu name text.', 'acf' ),
					'placeholder'  => __( 'Genres', 'acf' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'all_items',
					'prefix'       => 'acf_taxonomy[labels]',
					'value'        => $acf_taxonomy['labels']['all_items'],
					'data'         => array(
						/* translators: %s Plural form of taxonomy name */
						'label'   => __( 'All %s', 'acf' ),
						'replace' => 'plural',
					),
					'label'        => __( 'All Items', 'acf' ),
					'instructions' => __( 'Assigns the all items text.', 'acf' ),
					'placeholder'  => __( 'All Tags', 'acf' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'key'          => 'edit_item',
					'name'         => 'edit_item',
					'prefix'       => 'acf_taxonomy[labels]',
					'value'        => $acf_taxonomy['labels']['edit_item'],
					'data'         => array(
						/* translators: %s Singular form of taxonomy name */
						'label'   => __( 'Edit %s', 'acf' ),
						'replace' => 'singular',
					),
					'label'        => __( 'Edit Item', 'acf' ),
					'instructions' => __( 'At the top of the editor screen when editing a term.', 'acf' ),
					'placeholder'  => __( 'Edit Tag', 'acf' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'key'          => 'view_item',
					'name'         => 'view_item',
					'prefix'       => 'acf_taxonomy[labels]',
					'value'        => $acf_taxonomy['labels']['view_item'],
					'data'         => array(
						/* translators: %s Singular form of taxonomy name */
						'label'   => __( 'View %s', 'acf' ),
						'replace' => 'singular',
					),
					'label'        => __( 'View Item', 'acf' ),
					'instructions' => __( 'In the admin bar to view term during editing.', 'acf' ),
					'placeholder'  => __( 'View Tag', 'acf' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'key'          => 'update_item',
					'name'         => 'update_item',
					'prefix'       => 'acf_taxonomy[labels]',
					'value'        => $acf_taxonomy['labels']['update_item'],
					'data'         => array(
						/* translators: %s Singular form of taxonomy name */
						'label'   => __( 'Update %s', 'acf' ),
						'replace' => 'singular',
					),
					'label'        => __( 'Update Item', 'acf' ),
					'instructions' => __( 'Assigns the update item text.', 'acf' ),
					'placeholder'  => __( 'Update Tag', 'acf' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'key'          => 'add_new_item',
					'name'         => 'add_new_item',
					'prefix'       => 'acf_taxonomy[labels]',
					'value'        => $acf_taxonomy['labels']['add_new_item'],
					'data'         => array(
						/* translators: %s Singular form of taxonomy name */
						'label'   => __( 'Add New %s', 'acf' ),
						'replace' => 'singular',
					),
					'label'        => __( 'Add New Item', 'acf' ),
					'instructions' => __( 'Assigns the add new item text.', 'acf' ),
					'placeholder'  => __( 'Add New Tag', 'acf' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'key'          => 'new_item_name',
					'name'         => 'new_item_name',
					'prefix'       => 'acf_taxonomy[labels]',
					'value'        => $acf_taxonomy['labels']['new_item_name'],
					'data'         => array(
						/* translators: %s Singular form of taxonomy name */
						'label'   => __( 'New %s Name', 'acf' ),
						'replace' => 'singular',
					),
					'label'        => __( 'New item name', 'acf' ),
					'instructions' => __( 'Assigns the new item name text.', 'acf' ),
					'placeholder'  => __( 'New Tag Name', 'acf' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'key'          => 'parent_item',
					'name'         => 'parent_item',
					'prefix'       => 'acf_taxonomy[labels]',
					'value'        => $acf_taxonomy['labels']['parent_item'],
					'data'         => array(
						/* translators: %s Singular form of taxonomy name */
						'label'   => __( 'Parent %s', 'acf' ),
						'replace' => 'singular',
					),
					'label'        => __( 'Parent Item', 'acf' ),
					'instructions' => __( 'Assigns parent item text. Only used on hierarchical taxonomies.', 'acf' ),
					'placeholder'  => __( 'Parent Category', 'acf' ),
					'conditions'   => array(
						'field'    => 'hierarchical',
						'operator' => '==',
						'value'    => '0',
					),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'key'          => 'parent_item_colon',
					'name'         => 'parent_item_colon',
					'prefix'       => 'acf_taxonomy[labels]',
					'value'        => isset( $acf_taxonomy['labels']['parent_item_colon'] ) ? $acf_taxonomy['labels']['parent_item_colon'] : '',
					'data'         => array(
						/* translators: %s Singular form of taxonomy name */
						'label'   => __( 'Parent %s', 'acf' ),
						'replace' => 'singular',
					),
					'label'        => __( 'Parent Item with Colon', 'acf' ),
					'instructions' => __( 'Assigns parent item text, but with a colon (:) added to the end.', 'acf' ),
					'placeholder'  => __( 'Parent Category:', 'acf' ),
					'conditions'   => array(
						'field'    => 'hierarchical',
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
					'name'         => 'search_items',
					'prefix'       => 'acf_taxonomy[labels]',
					'value'        => $acf_taxonomy['labels']['search_items'],
					'data'         => array(
						/* translators: %s Plural form of taxonomy name */
						'label'   => __( 'Search %s', 'acf' ),
						'replace' => 'plural',
					),
					'label'        => __( 'Search Items', 'acf' ),
					'instructions' => __( 'Assigns search items text.', 'acf' ),
					'placeholder'  => __( 'Search Tags', 'acf' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'popular_items',
					'prefix'       => 'acf_taxonomy[labels]',
					'value'        => $acf_taxonomy['labels']['popular_items'],
					'data'         => array(
						/* translators: %s Plural form of taxonomy name */
						'label'   => __( 'Popular %s', 'acf' ),
						'replace' => 'plural',
					),
					'label'        => __( 'Popular items', 'acf' ),
					'instructions' => __( 'Assigns popular items text. Only used for non-hierarchical taxonomies.', 'acf' ),
					'placeholder'  => __( 'Popular tags', 'acf' ),
					'conditions'   => array(
						'field'    => 'hierarchical',
						'operator' => '==',
						'value'    => '0',
					),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'key'          => 'separate_items_with_commas',
					'name'         => 'separate_items_with_commas',
					'prefix'       => 'acf_taxonomy[labels]',
					'value'        => $acf_taxonomy['labels']['separate_items_with_commas'],
					'data'         => array(
						/* translators: %s Plural form of taxonomy name */
						'label'   => __( 'Separate %s with commas', 'acf' ),
						'replace' => 'plural',
					),
					'label'        => __( 'Separate Items with Commas', 'acf' ),
					'instructions' => __( 'Assigns the separate item with commas text used in the taxonomy meta box. Only used on non-hierarchical taxonomies.', 'acf' ),
					'placeholder'  => __( 'Separate tags with commas', 'acf' ),
					'conditions'   => array(
						'field'    => 'hierarchical',
						'operator' => '==',
						'value'    => '0',
					),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'key'          => 'add_or_remove_items',
					'name'         => 'add_or_remove_items',
					'prefix'       => 'acf_taxonomy[labels]',
					'value'        => $acf_taxonomy['labels']['add_or_remove_items'],
					'data'         => array(
						/* translators: %s Plural form of taxonomy name */
						'label'   => __( 'Add or remove %s', 'acf' ),
						'replace' => 'plural',
					),
					'label'        => __( 'Add or Remove Items', 'acf' ),
					'instructions' => __( 'Assigns the add or remove items text used in the meta box when JavaScript is disabled. Only used on non-hierarchical taxonomies', 'acf' ),
					'placeholder'  => __( 'Add or remove tags', 'acf' ),
					'conditions'   => array(
						'field'    => 'hierarchical',
						'operator' => '==',
						'value'    => '0',
					),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'key'          => 'choose_from_most_used',
					'name'         => 'choose_from_most_used',
					'prefix'       => 'acf_taxonomy[labels]',
					'value'        => $acf_taxonomy['labels']['choose_from_most_used'],
					'data'         => array(
						/* translators: %s Plural form of taxonomy name */
						'label'   => __( 'Choose from the most used %s', 'acf' ),
						'replace' => 'plural',
					),
					'label'        => __( 'Choose From Most Used', 'acf' ),
					'instructions' => __( "Assigns the 'choose from most used' text used in the meta box when JavaScript is disabled. Only used on non-hierarchical taxonomies.", 'acf' ),
					'placeholder'  => __( 'Choose from the most used tags', 'acf' ),
					'conditions'   => array(
						'field'    => 'hierarchical',
						'operator' => '==',
						'value'    => '0',
					),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'key'          => 'most_used',
					'name'         => 'most_used',
					'prefix'       => 'acf_taxonomy[labels]',
					'value'        => $acf_taxonomy['labels']['most_used'],
					'label'        => __( 'Most Used', 'acf' ),
					'instructions' => __( 'Assigns text to the Title field of the Most Used tab.', 'acf' ),
					'default'      => __( 'Most Used', 'acf' ),
					'placeholder'  => __( 'Most Used', 'acf' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'key'          => 'not_found',
					'name'         => 'not_found',
					'prefix'       => 'acf_taxonomy[labels]',
					'value'        => $acf_taxonomy['labels']['not_found'],
					'data'         => array(
						/* translators: %s Plural form of taxonomy name */
						'label'   => __( 'No %s found', 'acf' ),
						'replace' => 'plural',
					),
					'label'        => __( 'Not Found', 'acf' ),
					'instructions' => __( "Assigns the text displayed when clicking the 'choose from most used' text in the taxonomy meta box when no tags are available, and assigns the text used in the terms list table when there are no items for a taxonomy.", 'acf' ),
					'placeholder'  => __( 'No tags found', 'acf' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'key'          => 'no_terms',
					'name'         => 'no_terms',
					'prefix'       => 'acf_taxonomy[labels]',
					'value'        => $acf_taxonomy['labels']['no_terms'],
					'data'         => array(
						/* translators: %s Plural form of taxonomy name */
						'label'   => __( 'No %s', 'acf' ),
						'replace' => 'plural',
					),
					'label'        => __( 'No Terms', 'acf' ),
					'instructions' => __( 'Assigns the text displayed in the posts and media list tables when no tags or categories are available.', 'acf' ),
					'placeholder'  => __( 'No tags', 'acf' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'key'          => 'name_field_description',
					'name'         => 'name_field_description',
					'prefix'       => 'acf_taxonomy[labels]',
					'value'        => $acf_taxonomy['labels']['name_field_description'],
					'label'        => __( 'Name Field Description', 'acf' ),
					'instructions' => __( 'Describes the Name field on the Edit Tags screen.', 'acf' ),
					'placeholder'  => __( 'The name is how it appears on your site', 'acf' ),
					'default'      => __( 'The name is how it appears on your site', 'acf' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'key'          => 'slug_field_description',
					'name'         => 'slug_field_description',
					'prefix'       => 'acf_taxonomy[labels]',
					'value'        => $acf_taxonomy['labels']['slug_field_description'],
					'label'        => __( 'Slug Field Description', 'acf' ),
					'instructions' => __( 'Describes the Slug field on the Edit Tags screen.', 'acf' ),
					'placeholder'  => __( 'The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.', 'acf' ),
					'default'      => __( 'The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.', 'acf' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'key'          => 'parent_field_description',
					'name'         => 'parent_field_description',
					'prefix'       => 'acf_taxonomy[labels]',
					'value'        => isset( $acf_taxonomy['labels']['parent_field_description'] ) ? $acf_taxonomy['labels']['parent_field_description'] : '',
					'label'        => __( 'Parent Field Description', 'acf' ),
					'instructions' => __( 'Describes the Parent field on the Edit Tags screen.', 'acf' ),
					'placeholder'  => __( 'Assign a parent term to create a hierarchy. The term Jazz, for example, would be the parent of Bebop and Big Band', 'acf' ),
					'default'      => __( 'Assign a parent term to create a hierarchy. The term Jazz, for example, would be the parent of Bebop and Big Band', 'acf' ),
					'conditions'   => array(
						'field'    => 'hierarchical',
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
					'key'          => 'desc_field_description',
					'name'         => 'desc_field_description',
					'prefix'       => 'acf_taxonomy[labels]',
					'value'        => $acf_taxonomy['labels']['desc_field_description'],
					'label'        => __( 'Description Field Description', 'acf' ),
					'instructions' => __( 'Describes the Description field on the Edit Tags screen.', 'acf' ),
					'placeholder'  => __( 'The description is not prominent by default; however, some themes may show it.', 'acf' ),
					'default'      => __( 'The description is not prominent by default; however, some themes may show it.', 'acf' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'key'          => 'filter_by_item',
					'name'         => 'filter_by_item',
					'prefix'       => 'acf_taxonomy[labels]',
					'value'        => $acf_taxonomy['labels']['filter_by_item'],
					'data'         => array(
						/* translators: %s Singular form of taxonomy name */
						'label'   => __( 'Filter by %s', 'acf' ),
						'replace' => 'singular',
					),
					'label'        => __( 'Filter by Item', 'acf' ),
					'instructions' => __( 'Assigns text to the filter button in the posts lists table.', 'acf' ),
					'placeholder'  => __( 'Filter by category', 'acf' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'key'          => 'items_list_navigation',
					'name'         => 'items_list_navigation',
					'prefix'       => 'acf_taxonomy[labels]',
					'value'        => $acf_taxonomy['labels']['items_list_navigation'],
					'data'         => array(
						/* translators: %s Plural form of taxonomy name */
						'label'     => __( '%s list navigation', 'acf' ),
						'replace'   => 'plural',
						'transform' => 'none',
					),
					'label'        => __( 'Items List Navigation', 'acf' ),
					'instructions' => __( 'Assigns text to the table pagination hidden heading.', 'acf' ),
					'placeholder'  => __( 'Tags list navigation', 'acf' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'key'          => 'items_list',
					'name'         => 'items_list',
					'prefix'       => 'acf_taxonomy[labels]',
					'value'        => $acf_taxonomy['labels']['items_list'],
					'data'         => array(
						/* translators: %s Plural form of taxonomy name */
						'label'     => __( '%s list', 'acf' ),
						'replace'   => 'plural',
						'transform' => 'none',
					),
					'label'        => __( 'Items List', 'acf' ),
					'instructions' => __( 'Assigns text to the table hidden heading.', 'acf' ),
					'placeholder'  => __( 'Items list', 'acf' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'key'          => 'back_to_items',
					'name'         => 'back_to_items',
					'prefix'       => 'acf_taxonomy[labels]',
					'value'        => $acf_taxonomy['labels']['back_to_items'],
					'data'         => array(
						/* translators: %s Plural form of taxonomy name */
						'label'   => __( '← Back to %s', 'acf' ),
						'replace' => 'plural',
					),
					'label'        => __( 'Back to Items', 'acf' ),
					'instructions' => __( 'Assigns the text used to link back to the main index after updating a term.', 'acf' ),
					'placeholder'  => __( '← Back to tags', 'acf' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'key'          => 'item_link',
					'name'         => 'item_link',
					'prefix'       => 'acf_taxonomy[labels]',
					'value'        => $acf_taxonomy['labels']['item_link'],
					'data'         => array(
						/* translators: %s Singular form of taxonomy name */
						'label'     => __( '%s Link', 'acf' ),
						'replace'   => 'singular',
						'transform' => 'none',
					),
					'label'        => __( 'Item Link', 'acf' ),
					'instructions' => __( 'Assigns a title for navigation link block variation used in the block editor.', 'acf' ),
					'placeholder'  => __( 'Tag Link', 'acf' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'key'          => 'item_link_description',
					'name'         => 'item_link_description',
					'prefix'       => 'acf_taxonomy[labels]',
					'value'        => $acf_taxonomy['labels']['item_link_description'],
					'data'         => array(
						/* translators: %s Singular form of taxonomy name */
						'label'   => __( 'A link to a %s', 'acf' ),
						'replace' => 'singular',
					),
					'label'        => __( 'Item Link Description', 'acf' ),
					'instructions' => __( 'Describes a navigation link block variation used in the block editor..', 'acf' ),
					'placeholder'  => __( 'A link to a tag', 'acf' ),
				),
				'div',
				'field'
			);
			break;
		case 'visibility':
			acf_render_field_wrap(
				array(
					'type'         => 'true_false',
					'key'          => 'show_ui',
					'name'         => 'show_ui',
					'prefix'       => 'acf_taxonomy',
					'value'        => $acf_taxonomy['show_ui'],
					'label'        => __( 'Admin Editor Support', 'acf' ),
					'instructions' => __( 'Items can be edited and managed in the admin dashboard.', 'acf' ),
					'default'      => 1,
					'ui'           => true,
				),
				'div'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'true_false',
					'key'          => 'show_in_menu',
					'name'         => 'show_in_menu',
					'prefix'       => 'acf_taxonomy',
					'value'        => $acf_taxonomy['show_in_menu'],
					'label'        => __( 'Show in Admin Menu', 'acf' ),
					'instructions' => __( 'Admin editor navigation in the sidebar menu.', 'acf' ),
					'default'      => 1,
					'ui'           => true,
					'conditions'   => array(
						'field'    => 'show_ui',
						'operator' => '==',
						'value'    => '1',
					),
				)
			);

			acf_render_field_wrap(
				array(
					'type'         => 'true_false',
					'key'          => 'show_in_nav_menus',
					'name'         => 'show_in_nav_menus',
					'prefix'       => 'acf_taxonomy',
					'value'        => $acf_taxonomy['show_in_nav_menus'],
					'label'        => __( 'Appearance Menus Support', 'acf' ),
					'instructions' => __( "Allow items to be added to menus in the 'Appearance' > 'Menus' screen. Must be turned on in 'Screen options'.", 'acf' ),
					'default'      => 1,
					'ui'           => true,
				)
			);

			acf_render_field_wrap(
				array(
					'type'         => 'true_false',
					'key'          => 'show_tagcloud',
					'name'         => 'show_tagcloud',
					'prefix'       => 'acf_taxonomy',
					'value'        => $acf_taxonomy['show_tagcloud'],
					'label'        => __( 'Tag Cloud', 'acf' ),
					'instructions' => __( 'List the taxonomy in the Tag Cloud Widget controls.', 'acf' ),
					'default'      => 1,
					'ui'           => true,
				)
			);

			acf_render_field_wrap(
				array(
					'type'         => 'true_false',
					'key'          => 'show_in_quick_edit',
					'name'         => 'show_in_quick_edit',
					'prefix'       => 'acf_taxonomy',
					'value'        => $acf_taxonomy['show_in_quick_edit'],
					'label'        => __( 'Quick Edit', 'acf' ),
					'instructions' => __( 'Show the taxonomy in the quick/bulk edit panel.', 'acf' ),
					'default'      => 1,
					'ui'           => true,
				)
			);

			acf_render_field_wrap(
				array(
					'type'         => 'true_false',
					'key'          => 'show_admin_column',
					'name'         => 'show_admin_column',
					'prefix'       => 'acf_taxonomy',
					'value'        => $acf_taxonomy['show_admin_column'],
					'label'        => __( 'Show admin column', 'acf' ),
					'instructions' => __( 'Display a column for the taxonomy on post type listing screens.', 'acf' ),
					'ui'           => true,
				)
			);
			break;
		case 'permalinks':
			acf_render_field_wrap(
				array(
					'type'         => 'true_false',
					'name'         => 'pretty_permalinks',
					'key'          => 'pretty_permalinks',
					'prefix'       => 'acf_taxonomy[rewrite]',
					'value'        => $acf_taxonomy['rewrite']['pretty_permalinks'],
					'label'        => __( 'Pretty Permalinks', 'acf' ),
					'instructions' => __( 'Rewrite the URL using the taxonomy key as the slug. Your permalink structure will be {url}', 'acf' ),
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
					'prefix'       => 'acf_taxonomy[rewrite]',
					'value'        => $acf_taxonomy['rewrite']['slug'],
					'label'        => __( 'URL Slug', 'acf' ),
					'instructions' => __( 'Customize the slug used in the URL', 'acf' ),
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
					'prefix'       => 'acf_taxonomy[rewrite]',
					'value'        => $acf_taxonomy['rewrite']['with_front'],
					'label'        => __( 'Front URL Prefix', 'acf' ),
					'instructions' => __( 'Alters the permalink structure to add the `WP_Rewrite::$front` prefix to URLs.', 'acf' ),
					'ui'           => true,
					'default'      => 1,
					'conditions'   => array(
						'field'    => 'pretty_permalinks',
						'operator' => '==',
						'value'    => '1',
					),
				),
				'div'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'true_false',
					'name'         => 'hierarchical',
					'key'          => 'hierarchical',
					'prefix'       => 'acf_taxonomy[rewrite]',
					'value'        => $acf_taxonomy['rewrite']['hierarchical'],
					'label'        => __( 'Hierarchical', 'acf' ),
					'instructions' => __( 'Parent-child terms in URLs for hierarchical taxonomies.', 'acf' ),
					'ui'           => true,
					'default'      => 0,
					'conditions'   => array(
						'field'    => 'pretty_permalinks',
						'operator' => '==',
						'value'    => '1',
					),
				),
				'div'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'true_false',
					'name'         => 'publicly_queryable',
					'key'          => 'publicly_queryable',
					'prefix'       => 'acf_taxonomy',
					'value'        => $acf_taxonomy['publicly_queryable'],
					'label'        => __( 'Publicly Queryable', 'acf' ),
					'instructions' => __( 'URLs for an item and items can be accessed with a query string.', 'acf' ),
					'default'      => 1,
					'ui'           => true,
				)
			);

			acf_render_field_wrap(
				array(
					'type'         => 'true_false',
					'name'         => 'query_var',
					'key'          => 'query_var',
					'prefix'       => 'acf_taxonomy',
					'value'        => $acf_taxonomy['query_var'],
					'label'        => __( 'Query Variable Support', 'acf' ),
					'instructions' => __( 'Terms can be accessed using the non-pretty permalink, e.g., {query_var}={term_slug}.', 'acf' ),
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
					'prefix'       => 'acf_taxonomy',
					'value'        => $acf_taxonomy['query_var_name'],
					'label'        => __( 'Query Variable', 'acf' ),
					'instructions' => __( 'Customize the query variable name', 'acf' ),
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
			break;
		case 'rest_api':
			acf_render_field_wrap(
				array(
					'type'         => 'true_false',
					'key'          => 'show_in_rest',
					'name'         => 'show_in_rest',
					'prefix'       => 'acf_taxonomy',
					'value'        => $acf_taxonomy['show_in_rest'],
					'label'        => __( 'Show in REST API', 'acf' ),
					'instructions' => __( 'Expose this post type in the REST API.', 'acf' ),
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
					'key'          => 'rest_base',
					'name'         => 'rest_base',
					'prefix'       => 'acf_taxonomy',
					'value'        => $acf_taxonomy['rest_base'],
					'label'        => __( 'Base URL', 'acf' ),
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
					'prefix'       => 'acf_taxonomy',
					'value'        => $acf_taxonomy['rest_namespace'],
					'label'        => __( 'Namespace Route', 'acf' ),
					'instructions' => __( 'The namespace part of the REST API URL.', 'acf' ),
					'placeholder'  => 'wp/v2',
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
					'key'          => 'rest_controller_class',
					'name'         => 'rest_controller_class',
					'prefix'       => 'acf_taxonomy',
					'value'        => $acf_taxonomy['rest_controller_class'],
					'label'        => __( 'Controller Class', 'acf' ),
					'instructions' => __( 'Optional custom controller to use instead of `WP_REST_Terms_Controller `.', 'acf' ),
					'placeholder'  => 'WP_REST_Terms_Controller',
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

	do_action( "acf/taxonomy/render_settings_tab/{$tab_key}", $acf_taxonomy );
}
