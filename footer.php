<?php /** Footer template. @package xinaide-cloud */ ?>
</main>
<footer class="site-footer">
	<div class="cloud-container footer-grid">
		<div class="footer-intro">
			<span class="footer-kicker">XINAI.DE · SINCE 2009</span>
			<h2><?php echo esc_html( xinaide_cloud_get_option( 'footer_heading' ) ); ?></h2>
			<p><?php echo esc_html( xinaide_cloud_get_option( 'footer_text' ) ); ?></p>
			<div class="footer-socials">
				<?php if ( xinaide_cloud_get_option( 'social_github' ) ) : ?><a href="<?php echo esc_url( xinaide_cloud_get_option( 'social_github' ) ); ?>" target="_blank" rel="noopener nofollow">GitHub ↗</a><?php endif; ?>
				<?php if ( xinaide_cloud_get_option( 'social_telegram' ) ) : ?><a href="<?php echo esc_url( xinaide_cloud_get_option( 'social_telegram' ) ); ?>" target="_blank" rel="noopener nofollow">Telegram ↗</a><?php endif; ?>
				<?php if ( xinaide_cloud_get_option( 'social_email' ) ) : ?><a href="mailto:<?php echo esc_attr( antispambot( xinaide_cloud_get_option( 'social_email' ) ) ); ?>">Email ↗</a><?php endif; ?>
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
		<span><?php echo esc_html( xinaide_cloud_get_option( 'footer_icp' ) ); ?><?php if ( xinaide_cloud_get_option( 'footer_icp' ) && xinaide_cloud_get_option( 'footer_gov' ) ) : ?> · <?php endif; ?><?php if ( xinaide_cloud_get_option( 'footer_gov' ) ) : ?><a href="<?php echo esc_url( xinaide_cloud_get_option( 'footer_gov_url' ) ); ?>" target="_blank" rel="nofollow"><?php echo esc_html( xinaide_cloud_get_option( 'footer_gov' ) ); ?></a> · <?php endif; ?><?php esc_html_e( 'Powered by WordPress · xinaide-cloud', 'xinaide-cloud' ); ?></span>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
