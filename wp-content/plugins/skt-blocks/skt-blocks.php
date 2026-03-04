<?php
/**
 * Plugin Name: SKT Blocks
 * Description: Custom ACF block boilerplate for SKT Boilerplate. Includes one neutral demo block built with ACF.
 * Version: 3.0
 * Author: Cristian Cascante
 * Plugin URI: https://github.com/skanthemore
 * Author URI: https://github.com/skanthemore
 * Update URI: https://github.com/skanthemore/SKT-Boiler-Plate
 *
 * @package SKT\Blocks
 */

namespace SKT\Blocks;

defined( 'ABSPATH' ) || exit;

define( 'SKT_BLOCKS_PATH', plugin_dir_path( __FILE__ ) );
define( 'SKT_BLOCKS_URL', plugin_dir_url( __FILE__ ) );

load_block_field_definitions();

add_action( 'admin_init', __NAMESPACE__ . '\\check_acf_pro' );
add_action( 'acf/init', __NAMESPACE__ . '\\init' );
add_action( 'init', __NAMESPACE__ . '\\load_textdomain' );
add_filter( 'block_categories_all', __NAMESPACE__ . '\\add_block_category', 10, 1 );

/**
 * Check if ACF Pro is installed and active.
 *
 * @return void
 */
function check_acf_pro() {
	if ( is_admin() && current_user_can( 'activate_plugins' ) ) {
		if ( ! class_exists( 'acf_pro' ) ) {
			add_action( 'admin_notices', __NAMESPACE__ . '\\acf_notice' );
			deactivate_plugins( plugin_basename( __FILE__ ) );
			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}
		}
	}
}

/**
 * Display admin notice if ACF Pro is not installed.
 *
 * @return void
 */
function acf_notice() {
	?>
	<div class="error">
		<p><?php esc_html_e( 'SKT Blocks requires ACF Pro to be installed and active.', 'skt-blocks' ); ?></p>
	</div>
	<?php
}

/**
 * Initialize and load all registered blocks.
 *
 * @return void
 */
function init() {
	load_blocks();
}

/**
 * Load the plugin textdomain for translations.
 *
 * @return void
 */
function load_textdomain() {
	load_plugin_textdomain(
		'skt-blocks',
		false,
		dirname( plugin_basename( __FILE__ ) ) . '/languages'
	);
}

/**
 * Add custom block category for SKT blocks.
 *
 * @param array $categories Array of block categories.
 * @return array
 */
function add_block_category( $categories ) {
	$custom = array(
		array(
			'slug'  => 'skt',
			'title' => __( 'SKT Blocks', 'skt-blocks' ),
		),
	);
	return array_merge( $custom, $categories );
}

/**
 * Get the blocks that belong to the boilerplate.
 *
 * @return string[]
 */
function get_supported_blocks() {
	return array( 'sample-content' );
}

/**
 * Load the active theme color palette.
 *
 * @return array<int, array<string, string>>
 */
function get_theme_palette() {
	$palette_path = get_template_directory() . '/theme-data/colors.php';

	if ( file_exists( $palette_path ) ) {
		$palette = require $palette_path;

		if ( is_array( $palette ) ) {
			return $palette;
		}
	}

	return array(
		array(
			'name'  => __( 'Base', 'skt-blocks' ),
			'slug'  => 'base',
			'color' => '#ffffff',
		),
	);
}

/**
 * Build ACF select choices from the active theme palette.
 *
 * @return array<string, string>
 */
function get_theme_color_choices() {
	$choices = array();

	foreach ( get_theme_palette() as $color ) {
		if ( empty( $color['slug'] ) || empty( $color['name'] ) ) {
			continue;
		}

		$choices[ $color['slug'] ] = $color['name'];
	}

	return $choices;
}

/**
 * Get the default theme color slug.
 *
 * @return string
 */
function get_default_theme_color_slug() {
	$choices = get_theme_color_choices();
	$slugs   = array_keys( $choices );

	return isset( $slugs[0] ) ? (string) $slugs[0] : 'base';
}

/**
 * Register all supported blocks.
 *
 * @return void
 */
function load_blocks() {
	foreach ( get_supported_blocks() as $block_name ) {
		register_block( $block_name );
	}
}

/**
 * Load all block field definition files so they can attach to acf/init.
 *
 * @return void
 */
function load_block_field_definitions() {
	foreach ( get_supported_blocks() as $block_name ) {
		$block_php = SKT_BLOCKS_PATH . 'blocks/' . $block_name . '/block.php';

		if ( file_exists( $block_php ) ) {
			include_once $block_php;
		}
	}
}

/**
 * Register a block type from the blocks directory.
 *
 * @param string $block_name The name of the block to register.
 * @return void
 */
function register_block( $block_name ) {
	$block_path      = SKT_BLOCKS_PATH . "blocks/{$block_name}";
	$block_json_path = $block_path . '/block.json';

	if ( ! file_exists( $block_json_path ) ) {
		return;
	}

	register_block_type( $block_path );
}
