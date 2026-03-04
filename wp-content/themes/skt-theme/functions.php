<?php
/**
 * SKT Boilerplate — theme functions
 *
 * @package skt-theme
 */

require get_template_directory() . '/inc/theme-enqueue.php';
require get_template_directory() . '/inc/theme-setup.php';
require get_template_directory() . '/inc/theme-acf.php';
require get_template_directory() . '/inc/theme-blocks.php';
require get_template_directory() . '/inc/theme-cpts.php';
require get_template_directory() . '/inc/theme-performance.php';

foreach ( glob( get_template_directory() . '/theme-data/*.php' ) as $file ) {
	require $file;
}

add_filter( 'nav_menu_link_attributes', 'skt_add_menu_link_class', 10, 3 );

/**
 * Add custom class to nav links (e.g. for styling).
 *
 * @param array    $atts HTML attributes applied to the menu item's <a> element.
 * @param WP_Post  $item Menu item data object.
 * @param stdClass $args An object of wp_nav_menu() arguments.
 * @return array Modified HTML attributes for the menu item link.
 */
function skt_add_menu_link_class( $atts, $item, $args ) {
	if ( 'primary' === $args->theme_location ) {
		$atts['class'] = 'skt-nav__link';
	}
	return $atts;
}

/**
 * Output inline SVG from theme assets.
 *
 * @param string $filename The name of the SVG file to load.
 * @param string $folder   The folder name where the SVG is located. Default is 'svg'.
 * @return string The SVG file contents or an HTML comment if file not found.
 */
function skt_inline_svg( $filename, $folder = 'svg' ) {
	$filepath = get_template_directory() . "/assets/{$folder}/{$filename}";
	if ( file_exists( $filepath ) ) {
		return file_get_contents( $filepath );
	}
	return '<!-- SVG not found: ' . esc_html( $filename ) . ' -->';
}
