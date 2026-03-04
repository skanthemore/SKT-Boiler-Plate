<?php
/**
 * Theme enqueue
 *
 * @package skt-theme
 */

add_action( 'wp_enqueue_scripts', 'skt_enqueue_assets' );
add_action( 'wp_enqueue_scripts', 'skt_dequeue_block_styles', 20 );
add_action( 'wp_enqueue_scripts', 'skt_enqueue_inline_fonts', 20 );

/**
 * Read a local theme asset for inline output.
 *
 * @param string $relative_path Relative path inside the theme directory.
 * @return string
 */
function skt_get_inline_asset_contents( $relative_path ) {
	$asset_path = get_template_directory() . $relative_path;

	if ( ! file_exists( $asset_path ) ) {
		return '';
	}

	// phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- Reading a local theme asset file for inline CSS output.
	$contents = file_get_contents( $asset_path );

	return false !== $contents ? $contents : '';
}

/**
 * Enqueue theme assets.
 *
 * @return void
 */
function skt_enqueue_assets() {
	$theme_uri  = get_template_directory_uri();
	$theme_path = get_template_directory();

	$critical_path = $theme_path . '/assets/css/critical.css';
	if ( file_exists( $critical_path ) ) {
		wp_register_style( 'skt-critical', false );
		wp_enqueue_style( 'skt-critical' );
		wp_add_inline_style( 'skt-critical', skt_get_inline_asset_contents( '/assets/css/critical.css' ) );
	}

	$style_path = $theme_path . '/assets/css/style.css';
	wp_enqueue_style(
		'skt-style',
		$theme_uri . '/assets/css/style.css',
		array(),
		file_exists( $style_path ) ? filemtime( $style_path ) : null
	);

	$main_js = $theme_path . '/assets/js/main.js';
	if ( file_exists( $main_js ) ) {
		wp_enqueue_script(
			'skt-main',
			$theme_uri . '/assets/js/main.js',
			array(),
			filemtime( $main_js ),
			array(
				'strategy'  => 'defer',
				'in_footer' => true,
				)
			);
	}

	$header_menu_js = $theme_path . '/assets/js/header-menu.js';
	if ( file_exists( $header_menu_js ) ) {
		wp_enqueue_script(
			'skt-header-menu',
			$theme_uri . '/assets/js/header-menu.js',
			array(),
			filemtime( $header_menu_js ),
			array(
				'strategy'  => 'defer',
				'in_footer' => true,
			)
		);
	}
}

/**
 * Remove default block-related front-end styles.
 *
 * @return void
 */
function skt_dequeue_block_styles() {
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
	wp_dequeue_style( 'classic-theme-styles' );
}

/**
 * Enqueue inline font definitions.
 *
 * @return void
 */
function skt_enqueue_inline_fonts() {
	$fonts_css = skt_get_inline_asset_contents( '/assets/fonts/fonts.css' );

	if ( '' !== $fonts_css ) {
		$fonts_css = str_replace( '__SKT_THEME_URI__', get_template_directory_uri(), $fonts_css );

		wp_register_style( 'skt-fonts-inline', false );
		wp_enqueue_style( 'skt-fonts-inline' );
		wp_add_inline_style( 'skt-fonts-inline', $fonts_css );
	}
}
