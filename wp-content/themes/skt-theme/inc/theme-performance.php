<?php
/**
 * Theme performance tweaks
 *
 * @package SKT_Boilerplate
 */

remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'wp_head', 'wp_generator' );

/**
 * Adds defer attribute to script tags
 *
 * @param string $tag The script tag.
 * @return string Modified script tag with defer attribute.
 */
function skt_defer_scripts( $tag ) {
	if ( is_admin() ) {
		return $tag;
	}
	return str_replace( ' src', ' defer src', $tag );
}
