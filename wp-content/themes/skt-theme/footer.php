<?php
/**
 * Footer
 *
 * @package skt-theme
 */

?>
	<footer class="skt-footer" id="site-footer">
		<div class="skt-footer__inner">
			<nav class="skt-footer__nav" aria-label="<?php esc_attr_e( 'Footer menu', 'skt-theme' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer',
						'menu_class'     => 'skt-footer__links',
						'container'      => false,
						'depth'          => 1,
						'fallback_cb'    => false,
						'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
					)
				);
				?>
			</nav>
			<div class="skt-footer__credit">
				&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( get_bloginfo( 'name' ) ); ?>
			</div>
		</div>
	</footer>

	<?php wp_footer(); ?>
</body>
</html>
