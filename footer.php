<?php /** Footer template. @package xinaide-cloud */ ?>
</main>
<footer class="site-footer">
	<div class="cloud-container footer-grid">
		<div class="footer-intro">
			<span class="footer-kicker"><?php echo esc_html( xinaide_cloud_get_option( 'footer_kicker' ) ); ?></span>
			<h2><?php echo esc_html( xinaide_cloud_get_option( 'footer_heading' ) ); ?></h2>
			<p><?php echo esc_html( xinaide_cloud_get_option( 'footer_text' ) ); ?></p>
			<div class="footer-socials" id="xinaide-cloud-footer-app">
				<?php foreach ( xinaide_cloud_get_socials() as $social ) : ?>
					<?php if ( 'copy' === $social['type'] ) : ?>
						<button type="button" class="footer-social" data-copy="<?php echo esc_attr( $social['value'] ); ?>" title="<?php echo esc_attr( $social['tip'] ); ?>" aria-label="<?php echo esc_attr( $social['tip'] ); ?>"><?php echo xinaide_cloud_social_icon( $social['key'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></button>
					<?php else : ?>
						<a class="footer-social" href="<?php echo esc_url( $social['href'] ); ?>" target="_blank" rel="noopener nofollow" title="<?php echo esc_attr( $social['tip'] ); ?>" aria-label="<?php echo esc_attr( $social['label'] ); ?>"><?php echo xinaide_cloud_social_icon( $social['key'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</div>
		<nav class="footer-nav" aria-label="<?php esc_attr_e( '页脚导航', 'xinaide-cloud' ); ?>">
			<h3><?php esc_html_e( '继续探索', 'xinaide-cloud' ); ?></h3>
			<?php wp_nav_menu( array( 'theme_location' => 'footer', 'container' => false, 'fallback_cb' => 'xinaide_cloud_fallback_menu', 'depth' => 1 ) ); ?>
		</nav>
		<div class="footer-categories"><h3><?php esc_html_e( '热门分类', 'xinaide-cloud' ); ?></h3><ul><?php wp_list_categories( array( 'title_li' => '', 'orderby' => 'count', 'order' => 'DESC', 'number' => 6, 'show_count' => false ) ); ?></ul></div>
		<div class="footer-facts"><h3><?php esc_html_e( '关于本站', 'xinaide-cloud' ); ?></h3><strong><?php echo esc_html( wp_count_posts()->publish ); ?></strong><span><?php esc_html_e( '篇公开文章', 'xinaide-cloud' ); ?></span><strong><?php echo esc_html( xinaide_cloud_site_years() ); ?></strong><span><?php esc_html_e( '年持续记录', 'xinaide-cloud' ); ?></span></div>
	</div>
	<div class="cloud-container footer-bottom">
		<span><?php $copyright = xinaide_cloud_get_option( 'footer_copyright' ); echo $copyright ? esc_html( $copyright ) : 'Copyright © ' . esc_html( wp_date( 'Y' ) ) . ' ' . esc_html( get_bloginfo( 'name' ) ); ?></span>
		<?php if ( xinaide_cloud_option_enabled( 'show_uptime' ) && xinaide_cloud_uptime_text() ) : ?>
			<span class="footer-uptime"><?php esc_html_e( '网站运行：', 'xinaide-cloud' ); ?><span id="xinaide-uptime" class="footer-uptime-value" data-launch="<?php echo esc_attr( xinaide_cloud_get_option( 'site_launch_date' ) ); ?>"><?php echo esc_html( xinaide_cloud_uptime_text() ); ?></span></span>
		<?php endif; ?>
		<?php if ( xinaide_cloud_option_enabled( 'show_status' ) && xinaide_cloud_get_option( 'status_url' ) ) : ?>
			<span class="footer-status"><a href="<?php echo esc_url( xinaide_cloud_get_option( 'status_url' ) ); ?>" target="_blank" rel="noopener nofollow"><?php echo esc_html( xinaide_cloud_get_option( 'status_text' ) ?: __( '服务器运行状态', 'xinaide-cloud' ) ); ?></a></span>
		<?php endif; ?>
		<span class="footer-credits"><?php echo esc_html( xinaide_cloud_get_option( 'footer_icp' ) ); ?><?php if ( xinaide_cloud_get_option( 'footer_icp' ) && xinaide_cloud_get_option( 'footer_gov' ) ) : ?> · <?php endif; ?><?php if ( xinaide_cloud_get_option( 'footer_gov' ) ) : ?><a href="<?php echo esc_url( xinaide_cloud_get_option( 'footer_gov_url' ) ); ?>" target="_blank" rel="nofollow"><?php echo esc_html( xinaide_cloud_get_option( 'footer_gov' ) ); ?></a> · <?php endif; ?><?php esc_html_e( 'Powered by WordPress · xinaide-cloud', 'xinaide-cloud' ); ?></span>
	</div>
</footer>
<?php if ( xinaide_cloud_option_enabled( 'show_uptime' ) && xinaide_cloud_get_option( 'site_launch_date' ) ) : ?>
<script>
(function () {
	var el = document.getElementById('xinaide-uptime');
	if (!el) { return; }
	var parts = (el.getAttribute('data-launch') || '').split('-');
	if (parts.length < 3) { return; }
	var created = Date.UTC(+parts[0], +parts[1] - 1, +parts[2]) / 1000;
	var tick = function () {
		// 与旧站一致，按 UTC+8 计时。
		var seconds = Math.max(0, Math.round((Date.now() + 8 * 3600 * 1000) / 1000) - created);
		var y = Math.floor(seconds / (365 * 86400)); seconds -= y * 365 * 86400;
		var d = Math.floor(seconds / 86400); seconds -= d * 86400;
		var h = Math.floor(seconds / 3600); seconds -= h * 3600;
		var m = Math.floor(seconds / 60); seconds -= m * 60;
		el.textContent = y + '年' + d + '天' + h + '时' + m + '分' + seconds + '秒';
	};
	tick();
	setInterval(tick, 1000);
})();
</script>
<?php endif; ?>
<?php wp_footer(); ?>
</body>
</html>
