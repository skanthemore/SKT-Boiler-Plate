<?php
/**
 * Example Unit Test - front template.
 *
 * @package SKT_Blocks
 */

$message        = get_field( 'message' );
$is_highlighted = (bool) get_field( 'highlight' );

if ( ! $message && ! is_admin() ) {
	return;
}

$custom_class = '';

if ( isset( $block['className'] ) && is_string( $block['className'] ) ) {
	$custom_class = $block['className'];
}

$state = \SKT\Blocks\build_example_unit_test_state( $is_highlighted, $custom_class );

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class'          => $state['class'],
		'data-highlight' => $state['data_highlight'],
	)
);
?>
<div <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- get_block_wrapper_attributes() returns safe wrapper markup. ?>>
	<p class="skt-example-unit-test__text"><?php echo esc_html( $message ); ?></p>
</div>
