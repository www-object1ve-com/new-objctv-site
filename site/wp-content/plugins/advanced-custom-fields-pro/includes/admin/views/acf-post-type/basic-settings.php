<?php
global $acf_post_type;

acf_render_field_wrap(
	array(
		'label'        => __( 'Singular label', 'acf' ),
		'placeholder'  => __( 'e.g. Movie', 'acf' ),
		'type'         => 'text',
		'name'         => 'singular_name',
		'key'          => 'singular_name',
		'class'        => 'acf_slugify_to_key acf_singular_label',
		'prefix'       => 'acf_post_type[labels]',
		'value'        => $acf_post_type['labels']['singular_name'],
		'required'     => true,
	),
	'div',
	'field'
);

acf_render_field_wrap(
	array(
		'label'        => __( 'Plural label', 'acf' ),
		'placeholder'  => __( 'e.g. Movies', 'acf' ),
		'type'         => 'text',
		'name'         => 'name',
		'key'          => 'name',
		'class'        => 'acf_plural_label',
		'prefix'       => 'acf_post_type[labels]',
		'value'        => $acf_post_type['labels']['name'],
		'required'     => true,
	),
	'div',
	'field'
);

acf_render_field_wrap(
	array(
		'label'        => __( 'Post Type Key', 'acf' ),
		'instructions' => __( 'Single word, no spaces. Underscores and dashes allowed', 'acf' ),
		'placeholder'  => __( 'e.g. movie', 'acf' ),
		'type'         => 'text',
		'name'         => 'post_type',
		'key'          => 'post_type',
		'class'        => 'acf_slugified_key',
		'prefix'       => 'acf_post_type',
		'value'        => $acf_post_type['post_type'],
		'required'     => true,
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
		'name'         => 'public',
		'key'          => 'public',
		'prefix'       => 'acf_post_type',
		'value'        => $acf_post_type['public'],
		'label'        => __( 'Public', 'acf' ),
		'instructions' => __( 'Visible on the frontend and in the admin dashboard', 'acf' ),
		'ui'           => true,
		'default'      => 1,
	),
	'div'
);

acf_render_field_wrap(
	array(
		'type'         => 'true_false',
		'name'         => 'hierarchical',
		'key'          => 'hierarchical',
		'prefix'       => 'acf_post_type',
		'value'        => $acf_post_type['hierarchical'],
		'label'        => __( 'Hierarchical', 'acf' ),
		'instructions' => __( 'Hierarchical post types can have descendants (like pages)', 'acf' ),
		'ui'           => true,
	),
	'div'
);

do_action( 'acf/post_type/basic_settings', $acf_post_type );

?>

<hr class="acf-divider" />

<?php

acf_render_field_wrap(
	array(
		'label'        => __( 'Advanced configuration', 'acf' ),
		'instructions' => __( "I know what I'm doing, show me all the options", 'acf' ),
		'type'         => 'true_false',
		'name'         => 'advanced_configuration',
		'key'          => 'advanced_configuration',
		'prefix'       => 'acf_post_type',
		'value'        => $acf_post_type['advanced_configuration'],
		'ui'           => 1,
		'class'        => 'acf-advanced-settings-toggle',
	)
);

?>
<div class="acf-hidden">
	<input type="hidden" name="acf_post_type[key]" value="<?php echo $acf_post_type['key']; ?>" />
</div>
<?php
