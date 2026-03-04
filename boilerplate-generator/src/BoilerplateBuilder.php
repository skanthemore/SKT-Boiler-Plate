<?php
declare(strict_types=1);

/**
 * Build WordPress boilerplate exports from the active theme and plugin.
 */
final class BoilerplateBuilder {
	/**
	 * Generator root path.
	 *
	 * @var string
	 */
	private $generator_root;

	/**
	 * Source theme path.
	 *
	 * @var string
	 */
	private $theme_source;

	/**
	 * Source plugin path.
	 *
	 * @var string
	 */
	private $plugin_source;

	/**
	 * Builds path.
	 *
	 * @var string
	 */
	private $builds_root;

	/**
	 * Constructor.
	 *
	 * @param string $generator_root Generator root path.
	 */
	public function __construct( string $generator_root ) {
		$this->generator_root = rtrim( $generator_root, '/\\' );
		$this->theme_source   = dirname( $this->generator_root ) . '/wp-content/themes/skt-theme';
		$this->plugin_source  = dirname( $this->generator_root ) . '/wp-content/plugins/skt-blocks';
		$this->builds_root    = $this->generator_root . '/builds';
	}

	/**
	 * Build theme and plugin ZIP files.
	 *
	 * @param array<string, mixed> $input Raw form input.
	 * @return array<string, mixed>
	 */
	public function build( array $input ): array {
		$config = $this->normalize_config( $input );

		$this->assert_sources_exist();
		$this->cleanup_old_builds();

		$build_id     = gmdate( 'Ymd-His' ) . '-' . $config['project_slug'] . '-' . bin2hex( random_bytes( 2 ) );
		$build_root   = $this->builds_root . '/' . $build_id;
		$bundle_name  = $config['project_slug'] . '-boilerplate';
		$bundle_root  = $build_root . '/' . $bundle_name;
		$theme_root   = $bundle_root . '/theme/' . $config['theme_slug'];
		$plugin_root  = $bundle_root . '/plugin/' . $config['plugin_slug'];
		$theme_zip    = $build_root . '/' . $config['theme_slug'] . '.zip';
		$plugin_zip   = $build_root . '/' . $config['plugin_slug'] . '.zip';
		$bundle_zip   = $build_root . '/' . $bundle_name . '.zip';
		$manifest     = $build_root . '/manifest.json';

		$this->ensure_directory( $theme_root );
		$this->ensure_directory( $plugin_root );

		$this->copy_tree( $this->theme_source, $theme_root, $config );
		$this->copy_tree( $this->plugin_source, $plugin_root, $config );

		$this->create_zip( $theme_root, $theme_zip, $config['theme_slug'] );
		$this->create_zip( $plugin_root, $plugin_zip, $config['plugin_slug'] );
		$this->create_zip( $bundle_root, $bundle_zip, $bundle_name );

		$result = array(
			'build_id'      => $build_id,
			'project_name'  => $config['project_name'],
			'project_slug'  => $config['project_slug'],
			'prefix'        => $config['prefix'],
			'theme_slug'    => $config['theme_slug'],
			'plugin_slug'   => $config['plugin_slug'],
			'theme_zip'     => 'builds/' . $build_id . '/' . basename( $theme_zip ),
			'plugin_zip'    => 'builds/' . $build_id . '/' . basename( $plugin_zip ),
			'bundle_zip'    => 'builds/' . $build_id . '/' . basename( $bundle_zip ),
			'generated_at'  => gmdate( DATE_ATOM ),
			'block_namespace' => $config['block_namespace'],
		);

		file_put_contents( $manifest, json_encode( $result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES ) );

		return $result;
	}

	/**
	 * Normalize form input into a build configuration.
	 *
	 * @param array<string, mixed> $input Raw form input.
	 * @return array<string, mixed>
	 */
	private function normalize_config( array $input ): array {
		$project_name = trim( (string) ( $input['project_name'] ?? '' ) );
		$project_slug = trim( (string) ( $input['project_slug'] ?? '' ) );
		$prefix       = trim( (string) ( $input['prefix'] ?? '' ) );

		if ( '' === $project_name ) {
			throw new RuntimeException( 'Project name is required.' );
		}

		$project_slug = '' !== $project_slug ? $this->slugify( $project_slug ) : $this->slugify( $project_name );
		$prefix       = '' !== $prefix ? $this->sanitize_prefix( $prefix ) : str_replace( '-', '_', $project_slug );

		if ( '' === $project_slug ) {
			throw new RuntimeException( 'Project slug could not be generated.' );
		}

		if ( '' === $prefix ) {
			throw new RuntimeException( 'Prefix could not be generated.' );
		}

		$theme_slug      = $this->suffix_slug( $project_slug, 'theme' );
		$plugin_slug     = $this->suffix_slug( $project_slug, 'blocks' );
		$theme_name      = $project_name . ' Theme';
		$plugin_name     = $project_name . ' Blocks';
		$css_prefix      = str_replace( '_', '-', $prefix );
		$namespace_root  = $this->studly_case( $prefix );
		$block_namespace = $css_prefix;

		return array(
			'project_name'         => $project_name,
			'project_slug'         => $project_slug,
			'prefix'               => $prefix,
			'theme_slug'           => $theme_slug,
			'plugin_slug'          => $plugin_slug,
			'theme_name'           => $theme_name,
			'plugin_name'          => $plugin_name,
			'theme_textdomain'     => $theme_slug,
			'plugin_textdomain'    => $plugin_slug,
			'php_prefix'           => $prefix . '_',
			'css_prefix'           => $css_prefix . '-',
			'block_namespace'      => $block_namespace,
			'namespace'            => $namespace_root . '\\Blocks',
			'path_replacements'    => $this->build_path_replacements(
				$theme_slug,
				$plugin_slug,
				$prefix
			),
			'content_replacements' => $this->build_content_replacements(
				$project_name,
				$theme_name,
				$plugin_name,
				$theme_slug,
				$plugin_slug,
				$prefix,
				$css_prefix,
				$namespace_root,
				$block_namespace
			),
		);
	}

	/**
	 * Build path replacement pairs.
	 *
	 * @param string $theme_slug Theme slug.
	 * @param string $plugin_slug Plugin slug.
	 * @param string $prefix Prefix.
	 * @return array<string, string>
	 */
	private function build_path_replacements( string $theme_slug, string $plugin_slug, string $prefix ): array {
		return array(
			'skt-blocks.php' => $plugin_slug . '.php',
			'skt-blocks.pot' => $plugin_slug . '.pot',
			'group_skt_'     => 'group_' . $prefix . '_',
		);
	}

	/**
	 * Build content replacement pairs.
	 *
	 * @param string $project_name Project name.
	 * @param string $theme_name Theme display name.
	 * @param string $plugin_name Plugin display name.
	 * @param string $theme_slug Theme slug.
	 * @param string $plugin_slug Plugin slug.
	 * @param string $prefix Prefix.
	 * @param string $css_prefix CSS prefix without trailing dash.
	 * @param string $namespace_root Namespace root.
	 * @param string $block_namespace Block namespace.
	 * @return array<string, string>
	 */
	private function build_content_replacements(
		string $project_name,
		string $theme_name,
		string $plugin_name,
		string $theme_slug,
		string $plugin_slug,
		string $prefix,
		string $css_prefix,
		string $namespace_root,
		string $block_namespace
	): array {
		return array(
			'SKT Boilerplate'                    => $theme_name,
			'SKT Blocks'                         => $plugin_name,
			'SKT\\Blocks'                        => $namespace_root . '\\Blocks',
			'SKT_Boilerplate'                    => $theme_slug,
			'SKT_Theme'                          => $theme_slug,
			'skt-theme'                          => $theme_slug,
			'skt-blocks'                         => $plugin_slug,
			'group_skt_'                         => 'group_' . $prefix . '_',
			'skt/'                               => $block_namespace . '/',
			"'value'    => 'skt/"               => "'value'    => '" . $block_namespace . '/',
			"'value' => 'skt/"                  => "'value' => '" . $block_namespace . '/',
			"\"name\": \"skt/"                   => "\"name\": \"" . $block_namespace . '/',
			"\"category\": \"skt\""             => "\"category\": \"" . $block_namespace . '"',
			"'slug'  => 'skt',"                 => "'slug'  => '" . $block_namespace . "',",
			"'slug' => 'skt',"                  => "'slug' => '" . $block_namespace . "',",
			'/wp-content/themes/skt-theme/'     => '/wp-content/themes/' . $theme_slug . '/',
			'skt_'                               => $prefix . '_',
			'skt-'                               => $css_prefix . '-',
			'Theme Name:   ' . $theme_name . ' Theme' => 'Theme Name:   ' . $theme_name,
			'Plugin Name: ' . $plugin_name . ' Blocks' => 'Plugin Name: ' . $plugin_name,
			'Custom ACF blocks for the **' . $theme_name . ' Theme** theme.' => 'Custom ACF blocks for the **' . $theme_name . '** theme.',
			'Custom ACF blocks for ' . $theme_name . ' Theme.' => 'Custom ACF blocks for ' . $theme_name . '.',
			'for the **' . $theme_name . ' Theme**' => 'for the **' . $theme_name . '**',
			$project_name . ' Theme Theme'      => $theme_name,
			$project_name . ' Blocks Blocks'    => $plugin_name,
		);
	}

	/**
	 * Copy a source tree into the build output.
	 *
	 * @param string $source Source path.
	 * @param string $destination Destination path.
	 * @param array<string, mixed> $config Build config.
	 * @param string $relative Relative path.
	 * @return void
	 */
	private function copy_tree( string $source, string $destination, array $config, string $relative = '' ): void {
		$entries = scandir( $source );

		if ( false === $entries ) {
			throw new RuntimeException( 'Unable to read source directory: ' . $source );
		}

		foreach ( $entries as $entry ) {
			if ( '.' === $entry || '..' === $entry ) {
				continue;
			}

			$source_path   = $source . '/' . $entry;
			$relative_path = '' === $relative ? $entry : $relative . '/' . $entry;

			if ( $this->should_skip( $relative_path, $entry ) ) {
				continue;
			}

			$target_relative = $this->apply_replacements( $relative_path, $config['path_replacements'] );
			$target_path     = $destination . '/' . $target_relative;

			if ( is_dir( $source_path ) ) {
				$this->ensure_directory( $target_path );
				$this->copy_tree( $source_path, $destination, $config, $relative_path );
				continue;
			}

			$this->ensure_directory( dirname( $target_path ) );

			$contents = file_get_contents( $source_path );

			if ( false === $contents ) {
				throw new RuntimeException( 'Unable to read file: ' . $source_path );
			}

			if ( $this->should_rewrite_contents( $source_path, $contents ) ) {
				$contents = $this->apply_replacements( $contents, $config['content_replacements'] );
				file_put_contents( $target_path, $contents );
				continue;
			}

			copy( $source_path, $target_path );
		}
	}

	/**
	 * Decide whether a file should be skipped.
	 *
	 * @param string $relative_path Relative path.
	 * @param string $basename File or directory name.
	 * @return bool
	 */
	private function should_skip( string $relative_path, string $basename ): bool {
		$skip_names = array(
			'.git',
			'.github',
			'.idea',
			'.vscode',
			'.DS_Store',
			'node_modules',
			'php_errorlog',
			'debug.log',
			'error_log',
		);

		if ( in_array( $basename, $skip_names, true ) ) {
			return true;
		}

		if ( '.' === substr( $basename, 0, 1 ) ) {
			return true;
		}

		foreach ( array( '.log', '.sql', '.sqlite', '.zip' ) as $suffix ) {
			if ( str_ends_with( $relative_path, $suffix ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Decide whether file contents should be rewritten as text.
	 *
	 * @param string $path Source path.
	 * @param string $contents File contents.
	 * @return bool
	 */
	private function should_rewrite_contents( string $path, string $contents ): bool {
		$binary_extensions = array(
			'png',
			'jpg',
			'jpeg',
			'gif',
			'webp',
			'ico',
			'woff',
			'woff2',
			'ttf',
			'eot',
			'zip',
			'pdf',
			'mp4',
			'mov',
		);

		$extension = strtolower( pathinfo( $path, PATHINFO_EXTENSION ) );

		if ( in_array( $extension, $binary_extensions, true ) ) {
			return false;
		}

		return false === strpos( $contents, "\0" );
	}

	/**
	 * Create a ZIP archive from a directory.
	 *
	 * @param string $source_dir Source directory.
	 * @param string $zip_path ZIP path.
	 * @param string $root_name Root name inside ZIP.
	 * @return void
	 */
	private function create_zip( string $source_dir, string $zip_path, string $root_name ): void {
		if ( class_exists( 'ZipArchive' ) ) {
			$this->create_zip_with_extension( $source_dir, $zip_path, $root_name );
			return;
		}

		$this->create_zip_with_binary( $source_dir, $zip_path, $root_name );
	}

	/**
	 * Create a ZIP archive with the ZipArchive extension.
	 *
	 * @param string $source_dir Source directory.
	 * @param string $zip_path ZIP path.
	 * @param string $root_name Root name inside ZIP.
	 * @return void
	 */
	private function create_zip_with_extension( string $source_dir, string $zip_path, string $root_name ): void {
		$zip = new ZipArchive();
		$result = $zip->open( $zip_path, ZipArchive::CREATE | ZipArchive::OVERWRITE );

		if ( true !== $result ) {
			throw new RuntimeException( 'Unable to create ZIP archive: ' . $zip_path );
		}

		$zip->addEmptyDir( $root_name );

		$iterator = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator( $source_dir, FilesystemIterator::SKIP_DOTS ),
			RecursiveIteratorIterator::SELF_FIRST
		);

		foreach ( $iterator as $item ) {
			$pathname     = $item->getPathname();
			$relative     = substr( $pathname, strlen( $source_dir ) + 1 );
			$archive_name = $root_name . '/' . str_replace( '\\', '/', $relative );

			if ( $item->isDir() ) {
				$zip->addEmptyDir( $archive_name );
				continue;
			}

			$zip->addFile( $pathname, $archive_name );
		}

		$zip->close();
	}

	/**
	 * Create a ZIP archive with the system zip binary.
	 *
	 * @param string $source_dir Source directory.
	 * @param string $zip_path ZIP path.
	 * @param string $root_name Root name inside ZIP.
	 * @return void
	 */
	private function create_zip_with_binary( string $source_dir, string $zip_path, string $root_name ): void {
		$source_parent = dirname( $source_dir );
		$source_name   = basename( $source_dir );

		if ( $source_name !== $root_name ) {
			throw new RuntimeException( 'ZIP root mismatch without ZipArchive support.' );
		}

		$zip_binary = trim( (string) shell_exec( 'command -v zip' ) );

		if ( '' === $zip_binary ) {
			throw new RuntimeException( 'ZIP export requires either the PHP ZipArchive extension or the zip binary.' );
		}

		$command = sprintf(
			'cd %s && %s -rq %s %s 2>&1',
			escapeshellarg( $source_parent ),
			escapeshellarg( $zip_binary ),
			escapeshellarg( $zip_path ),
			escapeshellarg( $source_name )
		);

		$output = array();
		$code   = 0;

		exec( $command, $output, $code );

		if ( 0 !== $code ) {
			throw new RuntimeException( 'zip command failed: ' . implode( PHP_EOL, $output ) );
		}
	}

	/**
	 * Ensure a directory exists.
	 *
	 * @param string $path Directory path.
	 * @return void
	 */
	private function ensure_directory( string $path ): void {
		if ( is_dir( $path ) ) {
			return;
		}

		if ( ! mkdir( $path, 0775, true ) && ! is_dir( $path ) ) {
			throw new RuntimeException( 'Unable to create directory: ' . $path );
		}
	}

	/**
	 * Assert the source theme and plugin exist.
	 *
	 * @return void
	 */
	private function assert_sources_exist(): void {
		if ( ! is_dir( $this->theme_source ) ) {
			throw new RuntimeException( 'Active theme source not found: ' . $this->theme_source );
		}

		if ( ! is_dir( $this->plugin_source ) ) {
			throw new RuntimeException( 'Active plugin source not found: ' . $this->plugin_source );
		}
	}

	/**
	 * Delete old build folders.
	 *
	 * @return void
	 */
	private function cleanup_old_builds(): void {
		if ( ! is_dir( $this->builds_root ) ) {
			return;
		}

		$threshold = time() - 86400;
		$entries   = scandir( $this->builds_root );

		if ( false === $entries ) {
			return;
		}

		foreach ( $entries as $entry ) {
			if ( '.' === $entry || '..' === $entry || '.gitignore' === $entry || 'index.php' === $entry ) {
				continue;
			}

			$path = $this->builds_root . '/' . $entry;

			if ( ! is_dir( $path ) || filemtime( $path ) >= $threshold ) {
				continue;
			}

			$this->delete_tree( $path );
		}
	}

	/**
	 * Recursively delete a directory tree.
	 *
	 * @param string $path Directory path.
	 * @return void
	 */
	private function delete_tree( string $path ): void {
		$iterator = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator( $path, FilesystemIterator::SKIP_DOTS ),
			RecursiveIteratorIterator::CHILD_FIRST
		);

		foreach ( $iterator as $item ) {
			if ( $item->isDir() ) {
				rmdir( $item->getPathname() );
				continue;
			}

			unlink( $item->getPathname() );
		}

		rmdir( $path );
	}

	/**
	 * Apply replacements in longest-key order.
	 *
	 * @param string $value Source value.
	 * @param array<string, string> $replacements Replacement map.
	 * @return string
	 */
	private function apply_replacements( string $value, array $replacements ): string {
		uksort(
			$replacements,
			static function ( string $left, string $right ): int {
				return strlen( $right ) <=> strlen( $left );
			}
		);

		return str_replace( array_keys( $replacements ), array_values( $replacements ), $value );
	}

	/**
	 * Create a URL-friendly slug.
	 *
	 * @param string $value Source string.
	 * @return string
	 */
	private function slugify( string $value ): string {
		$value = trim( $value );

		if ( function_exists( 'iconv' ) ) {
			$transliterated = iconv( 'UTF-8', 'ASCII//TRANSLIT//IGNORE', $value );

			if ( false !== $transliterated ) {
				$value = $transliterated;
			}
		}

		$value = strtolower( $value );
		$value = preg_replace( '/[^a-z0-9]+/', '-', $value ) ?? '';
		$value = trim( $value, '-' );

		return $value;
	}

	/**
	 * Create a sanitized prefix.
	 *
	 * @param string $value Raw prefix.
	 * @return string
	 */
	private function sanitize_prefix( string $value ): string {
		$value = strtolower( $value );
		$value = preg_replace( '/[^a-z0-9_]+/', '_', $value ) ?? '';
		$value = trim( $value, '_' );
		$value = preg_replace( '/_+/', '_', $value ) ?? '';

		if ( '' === $value ) {
			return '';
		}

		if ( preg_match( '/^[0-9]/', $value ) ) {
			$value = 'project_' . $value;
		}

		return $value;
	}

	/**
	 * Append a suffix only if it is missing.
	 *
	 * @param string $slug Base slug.
	 * @param string $suffix Required suffix.
	 * @return string
	 */
	private function suffix_slug( string $slug, string $suffix ): string {
		if ( str_ends_with( $slug, '-' . $suffix ) ) {
			return $slug;
		}

		return $slug . '-' . $suffix;
	}

	/**
	 * Convert a string into StudlyCase.
	 *
	 * @param string $value Source string.
	 * @return string
	 */
	private function studly_case( string $value ): string {
		$parts = preg_split( '/[^a-z0-9]+/i', $value ) ?: array();
		$parts = array_filter( $parts );

		$parts = array_map(
			static function ( string $part ): string {
				return ucfirst( strtolower( $part ) );
			},
			$parts
		);

		return implode( '', $parts );
	}
}
