<?php

global $acf_taxonomy;

acf_render_field_wrap(
	array(
		'label'        => __( 'Singular label', 'acf' ),
		'placeholder'  => __( 'e.g. Genre', 'acf' ),
		'type'         => 'text',
		'key'          => 'singular_name',
		'name'         => 'singular_name',
		'class'        => 'acf_slugify_to_key acf_singular_label',
		'prefix'       => 'acf_taxonomy[labels]',
		'value'        => $acf_taxonomy['labels']['singular_name'],
		'required'     => 1,
	),
	'div',
	'field'
);

acf_render_field_wrap(
	array(
		'label'        => __( 'Plural label', 'acf' ),
		'placeholder'  => __( 'e.g. Genres', 'acf' ),
		'type'         => 'text',
		'key'          => 'name',
		'name'         => 'name',
		'class'        => 'acf_plural_label',
		'prefix'       => 'acf_taxonomy[labels]',
		'value'        => $acf_taxonomy['labels']['name'],
		'required'     => 1,
	),
	'div',
	'field'
);

acf_render_field_wrap(
	array(
		'label'        => __( 'Taxonomy Key', 'acf' ),
		'instructions' => __( 'Single word, no spaces. Underscores and dashes allowed', 'acf' ),
		'placeholder'  => __( 'e.g. genre', 'acf' ),
		'type'         => 'text',
		'key'          => 'taxonomy',
		'name'         => 'taxonomy',
		'class'        => 'acf_slugified_key',
		'prefix'       => 'acf_taxonomy',
		'value'        => $acf_taxonomy['taxonomy'],
		'required'     => 1,
	),
	'div',
	'field'
);

// Allow preselecting the linked post types based on previously created post type.
$acf_use_post_type = acf_request_arg( 'use_post_type', false );
if ( $acf_use_post_type && wp_verify_nonce( acf_request_arg( '_wpnonce' ), 'create-taxonomy-' . $acf_use_post_type ) ) {
	$acf_linked_post_type = acf_get_internal_post_type( (int) $acf_use_post_type, 'acf-post-type' );

	if ( $acf_linked_post_type && isset( $acf_linked_post_type['post_type'] ) ) {
		$acf_taxonomy['object_type'] = array( $acf_linked_post_type['post_type'] );
	}
}

acf_render_field_wrap(
	array(
		'label'        => __( 'Post Types', 'acf' ),
		'type'         => 'select',
		'name'         => 'object_type',
		'prefix'       => 'acf_taxonomy',
		'value'        => $acf_taxonomy['object_type'],
		'choices'      => acf_get_pretty_post_types(),
		'multiple'     => 1,
		'ui'           => 1,
		'allow_null'   => 1,
		'instructions' => __( 'One or many post types that can be classified with this taxonomy', 'acf' ),
	),
	'div',
	'field'
);

?>

<hr class="acf-divider" />

<?php

acf_render_field_wrap(
	array(
		'type'         => 'true_false',
		'key'          => 'public',
		'name'         => 'public',
		'prefix'       => 'acf_taxonomy',
		'value'        => $acf_taxonomy['public'],
		'label'        => __( 'Public', 'acf' ),
		'instructions' => __( 'Makes a taxonomy visible on the frontend and in the admin dashboard.', 'acf' ),
		'ui'           => true,
		'default'      => 1,
	)
);

acf_render_field_wrap(
	array(
		'type'         => 'true_false',
		'key'          => 'hierarchical',
		'name'         => 'hierarchical',
		'prefix'       => 'acf_taxonomy',
		'value'        => $acf_taxonomy['hierarchical'],
		'label'        => __( 'Hierarchical', 'acf' ),
		'instructions' => __( 'Hierarchical taxonomies can have descendants (like categories)', 'acf' ),
		'ui'           => true,
	),
	'div'
);

do_action( 'acf/taxonomy/basic_settings', $acf_taxonomy );

?>

<hr class="acf-divider" />

<?php

acf_render_field_wrap(
	array(
		'label'        => __( 'Advanced configuration', 'acf' ),
		'instructions' => __( "I know what I'm doing, show me all the options", 'acf' ),
		'type'         => 'true_false',
		'key'          => 'advanced_configuration',
		'name'         => 'advanced_configuration',
		'prefix'       => 'acf_taxonomy',
		'value'        => $acf_taxonomy['advanced_configuration'],
		'ui'           => 1,
		'class'        => 'acf-advanced-settings-toggle',
	)
);

?>
	<div class="acf-hidden">
		<input type="hidden" name="acf_taxonomy[key]" value="<?php echo $acf_taxonomy['key']; ?>" />
	</div>
<?php
