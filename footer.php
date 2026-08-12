<?php /** Footer template. @package xinaide-cloud */ ?>
</main>
<footer class="site-footer">
	<div class="cloud-container footer-grid">
		<div>
			<a class="footer-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
			<p><?php bloginfo( 'description' ); ?></p>
		</div>
		<nav aria-label="<?php esc_attr_e( '页脚导航', 'xinaide-cloud' ); ?>">
			<?php wp_nav_menu( array( 'theme_location' => 'footer', 'container' => false, 'fallback_cb' => false, 'depth' => 1 ) ); ?>
		</nav>
	</div>
	<div class="cloud-container footer-bottom">
		<span>Copyright © <?php echo esc_html( wp_date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?></span>
		<span><?php esc_html_e( 'Powered by WordPress · xinaide-cloud', 'xinaide-cloud' ); ?></span>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>

