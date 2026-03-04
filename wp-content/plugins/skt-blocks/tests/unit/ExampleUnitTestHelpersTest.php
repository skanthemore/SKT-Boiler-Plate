<?php
/**
 * Unit tests for Example Unit Test block helpers.
 */

use PHPUnit\Framework\TestCase;
use function SKT\Blocks\build_example_unit_test_state;

final class ExampleUnitTestHelpersTest extends TestCase {
	public function test_build_state_sets_highlight_and_custom_classes(): void {
		$state = build_example_unit_test_state( true, 'custom-tag another_tag' );

		$this->assertSame(
			'skt-example-unit-test is-highlighted custom-tag another_tag',
			$state['class']
		);
		$this->assertSame( 'true', $state['data_highlight'] );
	}

	public function test_build_state_strips_invalid_tokens_and_defaults_to_base_class(): void {
		$state = build_example_unit_test_state( false, '   <script> ##  ' );

		$this->assertSame(
			'skt-example-unit-test script',
			$state['class']
		);
		$this->assertSame( 'false', $state['data_highlight'] );
	}
}
