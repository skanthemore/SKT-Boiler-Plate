<?php
/**
 * Theme setup and design tokens.
 *
 * @package skt-theme
 */

require_once get_template_directory() . '/theme-data/helpers.php';

add_action( 'after_setup_theme', 'skt_setup' );
add_action( 'after_setup_theme', 'skt_editor_colors' );
add_action( 'after_setup_theme', 'skt_editor_font_sizes' );
add_action( 'after_setup_theme', 'skt_editor_spacings' );
add_filter( 'show_admin_bar', '__return_false' );
add_action( 'wp_head', 'skt_output_palette_vars' );
add_action( 'wp_head', 'skt_output_theme_vars' );
add_action( 'admin_head', 'skt_output_theme_vars' );

/**
 * Configure theme supports and menus.
 *
 * @return void
 */
function skt_setup() {
	load_theme_textdomain( 'skt-theme', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'align-wide' );

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'skt-theme' ),
			'footer'  => __( 'Footer Menu', 'skt-theme' ),
		)
	);
}

/**
 * Register the editor color palette from theme tokens.
 *
 * @return void
 */
function skt_editor_colors() {
	$colors = require get_template_directory() . '/theme-data/colors.php';
	add_theme_support( 'editor-color-palette', $colors );
}

/**
 * Output color variables for the front end.
 *
 * @return void
 */
function skt_output_palette_vars() {
	$colors = include get_template_directory() . '/theme-data/colors.php';
	echo '<style>:root {';
	foreach ( $colors as $color ) {
		printf( '--skt-color-%s: %s;', esc_attr( $color['slug'] ), esc_attr( $color['color'] ) );
	}
	echo '}</style>';
}

/**
 * Register the editor font sizes from theme tokens.
 *
 * @return void
 */
function skt_editor_font_sizes() {
	$font_sizes = require get_template_directory() . '/theme-data/font-sizes.php';
	add_theme_support( 'editor-font-sizes', $font_sizes );
}

/**
 * Register the editor spacing scale from theme tokens.
 *
 * @return void
 */
function skt_editor_spacings() {
	$spacings = require get_template_directory() . '/theme-data/spacings.php';
	add_theme_support( 'custom-spacing', true );
	add_theme_support( 'editor-spacing-sizes', $spacings );
}

/**
 * Output theme CSS custom properties.
 *
 * @return void
 */
function skt_output_theme_vars() {
	$custom     = require get_template_directory() . '/theme-data/custom.php';
	$colors     = require get_template_directory() . '/theme-data/colors.php';
	$font_sizes = require get_template_directory() . '/theme-data/font-sizes.php';
	$spacings   = require get_template_directory() . '/theme-data/spacings.php';

	echo '<style>:root {';
	foreach ( $custom as $group => $tokens ) {
		foreach ( $tokens as $key => $value ) {
			echo '--skt-' . esc_attr( $group ) . '-' . esc_attr( $key ) . ':' . $value . ';';
		}
	}
	foreach ( $colors as $color ) {
		echo '--skt-color-' . esc_attr( $color['slug'] ) . ':' . esc_attr( $color['color'] ) . ';';
	}
	foreach ( $font_sizes as $font ) {
		echo '--skt-font-size-' . esc_attr( $font['slug'] ) . ':' . esc_attr( $font['size'] ) . ';';
	}
	foreach ( $spacings as $space ) {
		echo '--skt-spacing-' . esc_attr( $space['slug'] ) . ':' . esc_attr( $space['size'] ) . ';';
	}
	echo '}</style>';
}
