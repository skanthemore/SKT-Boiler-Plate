<?php
/**
 * Header
 *
 * @package skt-theme
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php if ( file_exists( get_template_directory() . '/assets/img/favicon.png' ) ) : ?>
		<link rel="icon" href="<?php echo esc_url( get_template_directory_uri() . '/assets/img/favicon.png' ); ?>" type="image/png">
	<?php endif; ?>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a href="#main-content" class="skt-skip-link"><?php esc_html_e( 'Skip to content', 'skt-theme' ); ?></a>

<header class="skt-header" id="site-header">
	<div class="skt-header__inner">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="skt-header__logo-link" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
			<span class="skt-header__site-title"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>
		</a>

		<nav class="skt-header__nav" aria-label="<?php esc_attr_e( 'Primary menu', 'skt-theme' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'menu_class'     => 'skt-header__menu',
					'container'      => false,
					'fallback_cb'    => false,
				)
			);
			?>
		</nav>

		<button
			type="button"
			class="skt-header__icon js-menu-toggle"
			aria-label="<?php esc_attr_e( 'Open menu', 'skt-theme' ); ?>"
			aria-controls="mobile-menu"
			aria-expanded="false"
			data-open-label="<?php echo esc_attr( __( 'Open menu', 'skt-theme' ) ); ?>"
			data-close-label="<?php echo esc_attr( __( 'Close menu', 'skt-theme' ) ); ?>"
		>
			<svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
				<path d="M11 1V21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
				<path d="M21 11L0.999999 11" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
			</svg>
		</button>
	</div>

	<div class="skt-mobile-menu" id="mobile-menu" aria-hidden="true" hidden>
		<div class="skt-mobile-menu__inner">
			<button
				type="button"
				class="skt-mobile-menu__close js-menu-toggle"
				aria-label="<?php esc_attr_e( 'Close menu', 'skt-theme' ); ?>"
				aria-controls="mobile-menu"
				aria-expanded="false"
			>
				<svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
					<path d="M11 1V21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
					<path d="M21 11L0.999999 11" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
				</svg>
			</button>
		</div>
		<nav class="skt-mobile-menu__nav" aria-label="<?php esc_attr_e( 'Mobile menu', 'skt-theme' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'menu_class'     => 'skt-mobile-menu__list',
					'container'      => false,
					'fallback_cb'    => false,
				)
			);
			?>
		</nav>
	</div>
</header>
