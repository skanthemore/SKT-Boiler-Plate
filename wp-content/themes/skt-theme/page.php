<?php
/**
 * Page template.
 *
 * @package skt-theme
 */

get_header();
?>
<main class="skt-container skt-main" id="main-content" tabindex="-1">
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="skt-entry-header">
					<h1 class="skt-entry-title"><?php the_title(); ?></h1>
				</header>

				<div class="skt-entry-content">
					<?php the_content(); ?>
				</div>
			</article>
		<?php endwhile; ?>

		<?php the_posts_navigation(); ?>

	<?php else : ?>
		<p><?php esc_html_e( 'No posts found.', 'skt-theme' ); ?></p>
	<?php endif; ?>
</main>

<?php
get_footer();
