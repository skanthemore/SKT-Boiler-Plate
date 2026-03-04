<?php
/**
 * Theme spacing sizes (for typography rhythm).
 *
 * @package SKT_Boilerplate
 */

$min = '375px';
$max = '1440px';
$rem = 16;

$source_sizes = array(
	's'  => array( '60px', '60px', 'Spacing Small' ),
	'm'  => array( '80px', '80px', 'Spacing Medium' ),
	'l'  => array( '120px', '120px', 'Spacing Large' ),
	'xl' => array( '150px', '150px', 'Spacing X-Large' ),
);

return array_map(
	function ( $values, $key ) use ( $min, $max, $rem ) {
		return array(
			'name' => $values[2],
			'slug' => $key,
			'size' => calculate_clamp( $values[0], $values[1], $min, $max, $rem ),
		);
	},
	array_values( $source_sizes ),
	array_keys( $source_sizes )
);
