<?php
/**
 * Example Unit Test block helpers.
 *
 * @package SKT_Blocks
 */

namespace SKT\Blocks;

/**
 * Build render state for the Example Unit Test block.
 *
 * This helper is intentionally framework-agnostic so it can be unit-tested
 * without booting WordPress.
 *
 * @param bool   $is_highlighted Whether the block should use highlighted style.
 * @param string $custom_classes Optional class names coming from block supports.
 * @return array{class: string, data_highlight: string}
 */
function build_example_unit_test_state( $is_highlighted, $custom_classes = '' ) {
	$classes = array( 'skt-example-unit-test' );

	if ( $is_highlighted ) {
		$classes[] = 'is-highlighted';
	}

	if ( is_string( $custom_classes ) && '' !== trim( $custom_classes ) ) {
		foreach ( preg_split( '/\s+/', trim( $custom_classes ) ) as $class_name ) {
			$sanitized_class = preg_replace( '/[^A-Za-z0-9_-]/', '', (string) $class_name );

			if ( '' !== $sanitized_class ) {
				$classes[] = $sanitized_class;
			}
		}
	}

	return array(
		'class'          => implode( ' ', array_values( array_unique( $classes ) ) ),
		'data_highlight' => $is_highlighted ? 'true' : 'false',
	);
}
