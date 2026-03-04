<?php
/**
 * Helper functions for SKT Boilerplate theme
 *
 * @package SKT_Boilerplate
 */

if ( ! function_exists( 'calculate_clamp' ) ) {

	/**
	 * Generate a CSS clamp() string between two values.
	 *
	 * @param string $min     Minimum font/spacing size (px).
	 * @param string $max     Maximum font/spacing size (px).
	 * @param string $bp_min  Minimum viewport width (px).
	 * @param string $bp_max  Maximum viewport width (px).
	 * @param int    $rem     Root font-size in px (default 16).
	 *
	 * @return string CSS clamp() function
	 */
	function calculate_clamp( $min, $max, $bp_min = '375px', $bp_max = '1440px', $rem = 16 ) {
		$min_val = floatval( $min );
		$max_val = floatval( $max );

		$bp_min_val = intval( $bp_min );
		$bp_max_val = intval( $bp_max );

		$min_rem = $min_val / $rem;
		$max_rem = $max_val / $rem;

		$fluid = sprintf(
			'%frem + ((%f - %f) * ((100vw - %dpx) / (%d - %d)))',
			$min_rem,
			$max_rem,
			$min_rem,
			$bp_min_val,
			$bp_max_val,
			$bp_min_val
		);

		return sprintf( 'clamp(%frem, calc(%s), %frem)', $min_rem, $fluid, $max_rem );
	}
}
