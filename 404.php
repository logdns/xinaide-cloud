<?php get_header(); ?>
<section class="error-page-wrap">
	<div class="error-orbit" aria-hidden="true"><i></i><i></i><i></i></div>
	<div class="cloud-container error-page">
		<p class="eyebrow">ERROR · LOST IN XINAI.DE</p>
		<span class="error-code">404</span>
		<h1><?php esc_html_e( '这条路暂时没有内容。', 'xinaide-cloud' ); ?></h1>
		<p><?php esc_html_e( '可能是链接已经移动，也可能只是打错了地址。试试搜索，或者回到首页继续探索。', 'xinaide-cloud' ); ?></p>
		<?php get_search_form(); ?>
		<a class="hero-button hero-button-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>">← <?php esc_html_e( '返回首页', 'xinaide-cloud' ); ?></a>
	</div>
</section>
<?php get_footer(); ?>
