<?php
/**
 * Sample Content - front template.
 *
 * @package SKT_Blocks
 */

$eyebrow          = get_field( 'eyebrow' );
$block_title      = get_field( 'title' );
$block_text       = get_field( 'text' );
$button_link      = get_field( 'button_link' );
$image_id         = get_field( 'image' );
$background_color = get_field( 'background_color' );

if ( ! $block_title && ! $block_text && ! $image_id && ! is_admin() ) {
	return;
}

$style         = '';
$button_target = '';
$button_rel    = '';

if ( is_string( $background_color ) && '' !== $background_color ) {
	$style = '--skt-sample-content-bg: var(--skt-color-' . sanitize_html_class( $background_color ) . ');';
}

if ( is_array( $button_link ) && ! empty( $button_link['target'] ) ) {
	$button_target = (string) $button_link['target'];
}

if ( '_blank' === $button_target ) {
	$button_rel = 'noopener';
}

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'skt-sample-content',
		'style' => $style,
	)
);
?>
<section <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- get_block_wrapper_attributes() returns safe wrapper markup. ?>>
	<div class="skt-sample-content__copy">
		<?php if ( $eyebrow ) : ?>
			<p class="skt-sample-content__eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
		<?php endif; ?>

		<?php if ( $block_title ) : ?>
			<h2 class="skt-sample-content__title"><?php echo esc_html( $block_title ); ?></h2>
		<?php endif; ?>

		<?php if ( $block_text ) : ?>
			<div class="skt-sample-content__text"><?php echo wp_kses_post( wpautop( $block_text ) ); ?></div>
		<?php endif; ?>

		<?php if ( is_array( $button_link ) && ! empty( $button_link['url'] ) && ! empty( $button_link['title'] ) ) : ?>
			<p class="skt-sample-content__actions">
				<a
					class="skt-sample-content__button"
					href="<?php echo esc_url( $button_link['url'] ); ?>"
					<?php echo '' !== $button_target ? 'target="' . esc_attr( $button_target ) . '"' : ''; ?>
					<?php echo '' !== $button_rel ? ' rel="' . esc_attr( $button_rel ) . '"' : ''; ?>
				>
					<?php echo esc_html( $button_link['title'] ); ?>
				</a>
			</p>
		<?php endif; ?>
	</div>

	<?php if ( $image_id ) : ?>
		<figure class="skt-sample-content__media">
			<?php
			echo wp_get_attachment_image(
				(int) $image_id,
				'large',
				false,
				array(
					'class'    => 'skt-sample-content__image',
					'loading'  => 'lazy',
					'decoding' => 'async',
				)
			);
			?>
		</figure>
	<?php endif; ?>
</section>
