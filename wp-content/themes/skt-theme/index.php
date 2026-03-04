<?php
/**
 * Main index template.
 *
 * @package skt-theme
 */

get_header();
?>
<main class="skt-container skt-main" id="main-content" tabindex="-1">
	<?php
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="skt-entry-header">
					<?php if ( is_singular() ) : ?>
						<h1 class="skt-entry-title"><?php the_title(); ?></h1>
					<?php else : ?>
						<h2 class="skt-entry-title">
							<a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a>
						</h2>
					<?php endif; ?>
				</header>

				<div class="skt-entry-content">
					<?php the_content(); ?>
				</div>
			</article>
			<?php
		endwhile;
		?>

		<?php the_posts_navigation(); ?>

	<?php else : ?>
		<p><?php esc_html_e( 'No posts found.', 'skt-theme' ); ?></p>
	<?php endif; ?>
</main>

<?php
get_footer();
?>
