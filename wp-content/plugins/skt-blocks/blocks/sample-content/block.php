<?php
/**
 * Sample Content - ACF fields.
 *
 * @package SKT_Blocks
 */

namespace SKT\Blocks;

add_action( 'acf/init', __NAMESPACE__ . '\\register_sample_content_fields' );

/**
 * Register Sample Content fields.
 *
 * @return void
 */
function register_sample_content_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'      => 'group_skt_sample_content',
			'title'    => __( 'Sample Content', 'skt-blocks' ),
			'fields'   => array(
				array(
					'key'   => 'field_sample_content_eyebrow',
					'label' => __( 'Eyebrow', 'skt-blocks' ),
					'name'  => 'eyebrow',
					'type'  => 'text',
				),
				array(
					'key'      => 'field_sample_content_title',
					'label'    => __( 'Title', 'skt-blocks' ),
					'name'     => 'title',
					'type'     => 'text',
					'required' => 1,
				),
				array(
					'key'   => 'field_sample_content_text',
					'label' => __( 'Text', 'skt-blocks' ),
					'name'  => 'text',
					'type'  => 'textarea',
					'rows'  => 5,
				),
				array(
					'key'           => 'field_sample_content_link',
					'label'         => __( 'Button link', 'skt-blocks' ),
					'name'          => 'button_link',
					'type'          => 'link',
					'return_format' => 'array',
				),
				array(
					'key'           => 'field_sample_content_image',
					'label'         => __( 'Image', 'skt-blocks' ),
					'name'          => 'image',
					'type'          => 'image',
					'return_format' => 'id',
					'preview_size'  => 'large',
					'library'       => 'all',
				),
				array(
					'key'           => 'field_sample_content_background_color',
					'label'         => __( 'Background color', 'skt-blocks' ),
					'name'          => 'background_color',
					'type'          => 'select',
					'choices'       => get_theme_color_choices(),
					'default_value' => get_default_theme_color_slug(),
					'instructions'  => __( 'This list is loaded from the active theme palette.', 'skt-blocks' ),
					'ui'            => 1,
				),
			),
			'location'  => array(
				array(
					array(
						'param'    => 'block',
						'operator' => '==',
						'value'    => 'skt/sample-content',
					),
				),
			),
		)
	);
}
