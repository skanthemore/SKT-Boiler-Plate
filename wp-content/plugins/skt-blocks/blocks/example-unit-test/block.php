<?php
/**
 * Exemple amb test unitari - ACF fields.
 *
 * @package SKT_Blocks
 */

namespace SKT\Blocks;

add_action( 'acf/init', __NAMESPACE__ . '\\register_example_unit_test_fields' );

/**
 * Register Exemple amb test unitari fields.
 *
 * @return void
 */
function register_example_unit_test_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'      => 'group_skt_example_unit_test',
			'title'    => __( 'Exemple amb test unitari', 'skt-blocks' ),
			'fields'   => array(
				array(
					'key'      => 'field_example_unit_test_text',
					'label'    => __( 'Message', 'skt-blocks' ),
					'name'     => 'message',
					'type'     => 'text',
					'required' => 1,
				),
				array(
					'key'           => 'field_example_unit_test_highlight',
					'label'         => __( 'Highlight style', 'skt-blocks' ),
					'name'          => 'highlight',
					'type'          => 'true_false',
					'ui'            => 1,
					'default_value' => 0,
				),
			),
			'location'  => array(
				array(
					array(
						'param'    => 'block',
						'operator' => '==',
						'value'    => 'skt/example-unit-test',
					),
				),
			),
		)
	);
}
