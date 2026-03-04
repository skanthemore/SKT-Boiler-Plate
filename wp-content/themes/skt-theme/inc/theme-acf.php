<?php
/**
 * Add Options Page for Footer.
 *
 * @package skt-theme
 */

add_action( 'acf/init', 'skt_register_footer_options_page' );

/**
 * Register the footer options page when ACF is available.
 *
 * @return void
 */
function skt_register_footer_options_page() {
	if ( function_exists( 'acf_add_options_page' ) ) {
		acf_add_options_page(
			array(
				'page_title' => __( 'Footer Settings', 'skt-theme' ),
				'menu_title' => __( 'Footer', 'skt-theme' ),
				'menu_slug'  => 'skt-footer-settings',
				'capability' => 'edit_theme_options',
				'redirect'   => false,
			)
		);
	}
}
