<?php
/**
 * Theme color palette.
 *
 * @package SKT_Boilerplate
 */

$source_colors = array(
	'base'      => '#FFFDF7',
	'primary'   => '#003223',
	'secondary' => '#c4d7b2',
	'begie'     => '#fbf3e9',
	'highlight' => '#e1ead4',
);

return array_map(
	function ( $color, $key ) {
		return array(
			'name'  => ucfirst( $key ),
			'slug'  => $key,
			'color' => $color,
		);
	},
	array_values( $source_colors ),
	array_keys( $source_colors )
);
