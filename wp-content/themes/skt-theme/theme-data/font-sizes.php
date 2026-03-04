<?php
/**
 * Theme font sizes.
 *
 * @package SKT_Boilerplate
 */

$min = '375px';
$max = '1440px';
$rem = 16;

$source_sizes = array(
	'h1'     => array( '40px', '55px', 'Heading 1' ),
	'h2'     => array( '32px', '50px', 'Heading 2' ),
	'h3'     => array( '20px', '40px', 'Heading 3' ),
	'h4'     => array( '32px', '32px', 'Heading 4' ),
	'h5'     => array( '20px', '20px', 'Heading 5' ),
	'body-l' => array( '18px', '18px', 'Body Large' ),
	'body-m' => array( '16px', '16px', 'Body Medium' ),
	'body-s' => array( '14px', '14px', 'Body Small' ),
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
