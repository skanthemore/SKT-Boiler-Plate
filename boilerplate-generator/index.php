<?php
declare(strict_types=1);

require_once __DIR__ . '/src/BoilerplateBuilder.php';

$defaults = array(
	'project_name' => '',
	'project_slug' => '',
	'prefix'       => '',
);

$values = $defaults;
$error  = '';
$result = null;

if ( 'POST' === $_SERVER['REQUEST_METHOD'] ) {
	$values = array(
		'project_name' => trim( (string) ( $_POST['project_name'] ?? '' ) ),
		'project_slug' => trim( (string) ( $_POST['project_slug'] ?? '' ) ),
		'prefix'       => trim( (string) ( $_POST['prefix'] ?? '' ) ),
	);

	try {
		$builder = new BoilerplateBuilder( __DIR__ );
		$result  = $builder->build( $values );
	} catch ( Throwable $exception ) {
		$error = $exception->getMessage();
	}
}

/**
 * Escape HTML output.
 *
 * @param string $value Raw value.
 * @return string
 */
function boilerplate_generator_escape( string $value ): string {
	return htmlspecialchars( $value, ENT_QUOTES, 'UTF-8' );
}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Boilerplate Generator</title>
	<link rel="stylesheet" href="assets/app.css">
</head>
<body>
	<main class="generator-shell">
		<section class="generator-hero">
			<div class="generator-brand-row">
				<div>
					<h1>SKT Boilerplate</h1>
					<p class="generator-subtitle">by Skanthemore / Cristian Cascante</p>
				</div>
				<a class="generator-github" href="https://github.com/skanthemore" target="_blank" rel="noreferrer">
					<svg viewBox="0 0 24 24" aria-hidden="true">
						<path d="M12 .5C5.65.5.5 5.66.5 12.02c0 5.09 3.29 9.41 7.86 10.94.58.11.79-.25.79-.56 0-.28-.01-1.19-.02-2.15-3.2.7-3.88-1.36-3.88-1.36-.52-1.34-1.28-1.69-1.28-1.69-1.05-.72.08-.71.08-.71 1.16.08 1.77 1.19 1.77 1.19 1.03 1.77 2.7 1.26 3.35.96.1-.75.4-1.26.72-1.55-2.56-.29-5.26-1.29-5.26-5.73 0-1.27.45-2.3 1.18-3.11-.12-.29-.51-1.47.11-3.07 0 0 .97-.31 3.17 1.19a10.93 10.93 0 0 1 5.77 0c2.2-1.5 3.17-1.19 3.17-1.19.62 1.6.23 2.78.11 3.07.73.81 1.18 1.84 1.18 3.11 0 4.45-2.7 5.43-5.28 5.72.41.36.78 1.08.78 2.18 0 1.58-.01 2.85-.01 3.24 0 .31.21.68.8.56a11.53 11.53 0 0 0 7.85-10.94C23.5 5.66 18.34.5 12 .5Z" fill="currentColor"/>
					</svg>
					<span>github.com/skanthemore</span>
				</a>
			</div>
			<p class="generator-intro">A working WordPress boilerplate built from a live custom theme and blocks plugin, then exported as reusable starter packages when the setup is ready.</p>
			<div class="generator-about">
				<p>This exists to keep project setup opinionated but practical: evolve the base on real client work, distill what proves reusable, and ship a clean starting point without dragging project-specific noise into the next build.</p>
				<ul class="generator-bullets">
					<li>Opinionated defaults</li>
					<li>Clean structure</li>
					<li>Fast start</li>
				</ul>
			</div>
		</section>

		<section class="generator-panel">
			<form method="post" class="generator-form">
				<div class="field-grid">
					<label class="field">
						<span>Project name</span>
						<input type="text" name="project_name" value="<?php echo boilerplate_generator_escape( $values['project_name'] ); ?>" placeholder="Acme Studio" required>
						<small>Used for theme and plugin labels.</small>
					</label>

					<label class="field">
						<span>Project slug</span>
						<input type="text" name="project_slug" value="<?php echo boilerplate_generator_escape( $values['project_slug'] ); ?>" placeholder="acme-studio">
						<small>Optional. Lowercase and dashes. Auto-generated if empty.</small>
					</label>

					<label class="field">
						<span>Code prefix</span>
						<input type="text" name="prefix" value="<?php echo boilerplate_generator_escape( $values['prefix'] ); ?>" placeholder="acme">
						<small>Used for PHP functions, CSS classes and block namespace.</small>
					</label>
				</div>

				<div class="generator-actions">
					<button type="submit">Generate boilerplate ZIPs</button>
				</div>
			</form>

			<?php if ( '' !== $error ) : ?>
				<div class="notice notice-error">
					<strong>Build failed.</strong>
					<span><?php echo boilerplate_generator_escape( $error ); ?></span>
				</div>
			<?php endif; ?>

			<?php if ( is_array( $result ) ) : ?>
				<div class="notice notice-success">
					<strong>Build ready.</strong>
					<span><?php echo boilerplate_generator_escape( $result['project_name'] ); ?> exported with prefix <code><?php echo boilerplate_generator_escape( $result['prefix'] ); ?></code>.</span>
				</div>

				<div class="result-grid">
					<article class="result-card">
						<h2>Theme ZIP</h2>
						<p><code><?php echo boilerplate_generator_escape( $result['theme_slug'] ); ?></code></p>
						<a href="<?php echo boilerplate_generator_escape( $result['theme_zip'] ); ?>">Download theme</a>
					</article>

					<article class="result-card">
						<h2>Plugin ZIP</h2>
						<p><code><?php echo boilerplate_generator_escape( $result['plugin_slug'] ); ?></code></p>
						<a href="<?php echo boilerplate_generator_escape( $result['plugin_zip'] ); ?>">Download plugin</a>
					</article>

					<article class="result-card">
						<h2>Bundle ZIP</h2>
						<p><code><?php echo boilerplate_generator_escape( $result['project_slug'] ); ?>-boilerplate</code></p>
						<a href="<?php echo boilerplate_generator_escape( $result['bundle_zip'] ); ?>">Download bundle</a>
					</article>
				</div>

				<ul class="result-meta">
					<li>Theme directory: <code><?php echo boilerplate_generator_escape( $result['theme_slug'] ); ?></code></li>
					<li>Plugin directory: <code><?php echo boilerplate_generator_escape( $result['plugin_slug'] ); ?></code></li>
					<li>Block namespace: <code><?php echo boilerplate_generator_escape( $result['block_namespace'] ); ?></code></li>
					<li>Build ID: <code><?php echo boilerplate_generator_escape( $result['build_id'] ); ?></code></li>
				</ul>
			<?php endif; ?>
		</section>
	</main>

	<footer class="generator-footer">
		<div class="generator-footer__inner">
			<div>
				<p class="generator-footer__title">Made by Cristian Cascante</p>
				<p class="generator-footer__note">A reusable base should absorb what real projects prove, not what theory invents too early.</p>
			</div>
			<div class="generator-footer__meta">
				<nav class="generator-footer__links" aria-label="External links">
					<a href="https://cristiancascante.com/" target="_blank" rel="noreferrer">Web</a>
					<a href="https://www.linkedin.com/in/cristiancascante/" target="_blank" rel="noreferrer">LinkedIn</a>
					<a href="https://github.com/skanthemore" target="_blank" rel="noreferrer">GitHub</a>
				</nav>
				<p class="generator-footer__version">Version 3.0 beta</p>
			</div>
		</div>
	</footer>

	<script>
		const projectNameInput = document.querySelector('input[name="project_name"]');
		const projectSlugInput = document.querySelector('input[name="project_slug"]');
		const prefixInput = document.querySelector('input[name="prefix"]');

		const slugify = (value) => value
			.toLowerCase()
			.trim()
			.replace(/[^a-z0-9]+/g, '-')
			.replace(/^-+|-+$/g, '');

		const prefixify = (value) => value
			.toLowerCase()
			.trim()
			.replace(/[^a-z0-9_]+/g, '_')
			.replace(/^_+|_+$/g, '')
			.replace(/_+/g, '_');

		projectNameInput.addEventListener('input', () => {
			if ('' === projectSlugInput.value.trim()) {
				projectSlugInput.placeholder = slugify(projectNameInput.value);
			}

			if ('' === prefixInput.value.trim()) {
				prefixInput.placeholder = prefixify(slugify(projectNameInput.value).replace(/-/g, '_'));
			}
		});
	</script>
</body>
</html>
