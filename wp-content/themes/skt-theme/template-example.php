<?php
/**
 * Template Name: Example (SKT Boilerplate)
 *
 * Example page showing how theme design tokens (--skt-color-*, --skt-spacing-*,
 * --skt-width-default, etc.) are used with .skt-example-card and .skt-example-section.
 *
 * @package skt-theme
 */

get_header();
?>

<main class="skt-container skt-main" id="main-content" tabindex="-1">
	<h1 class="skt-example-title"><?php esc_html_e( 'Example page', 'skt-theme' ); ?></h1>
	<p class="skt-example-intro"><?php esc_html_e( 'This template shows how to use the theme CSS variables (design tokens) in your components.', 'skt-theme' ); ?></p>

	<section class="skt-example-section" aria-labelledby="example-cards-heading">
		<h2 id="example-cards-heading" class="skt-example-section__title"><?php esc_html_e( 'Example component (cards)', 'skt-theme' ); ?></h2>
		<div class="skt-example-section__grid">
			<div class="skt-example-card">
				<h3 class="skt-example-card__title"><?php esc_html_e( 'Card 1', 'skt-theme' ); ?></h3>
				<p class="skt-example-card__text"><?php esc_html_e( 'This card uses var(--skt-color-primary), var(--skt-color-base) and var(--skt-spacing-*) for colors and spacing.', 'skt-theme' ); ?></p>
			</div>
			<div class="skt-example-card">
				<h3 class="skt-example-card__title"><?php esc_html_e( 'Card 2', 'skt-theme' ); ?></h3>
				<p class="skt-example-card__text"><?php esc_html_e( 'Add more components following the same pattern and reusing the tokens defined in theme-data/.', 'skt-theme' ); ?></p>
			</div>
		</div>
	</section>
</main>

<?php
get_footer();
