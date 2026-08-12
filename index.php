<?php get_header(); ?>
<?php if ( is_home() && ! is_paged() ) : ?>
	<section class="hero-section">
		<div class="cloud-container hero-inner">
			<div class="hero-copy">
				<p class="eyebrow"><?php echo esc_html( get_theme_mod( 'xinaide_cloud_hero_eyebrow', 'PRIVATE DIGITAL GARDEN' ) ); ?></p>
				<h1><?php echo esc_html( get_theme_mod( 'xinaide_cloud_hero_title', '私人小天地' ) ); ?></h1>
				<p><?php echo esc_html( get_theme_mod( 'xinaide_cloud_hero_text', '谈天说地，记录折腾、学习与生活。' ) ); ?></p>
				<a class="hero-link" href="#latest-posts"><?php esc_html_e( '浏览最新文章', 'xinaide-cloud' ); ?> <span>↓</span></a>
			</div>
			<div class="hero-scene" aria-hidden="true">
				<span class="scene-sun"></span>
				<div class="scene-card scene-card-main"><span class="scene-cloud">☁</span><small>xinai.de</small></div>
				<div class="scene-note note-one"><i></i> 记录生活</div>
				<div class="scene-note note-two"><i></i> 分享折腾</div>
				<span class="scene-spark spark-one">✦</span><span class="scene-spark spark-two">✦</span>
			</div>
		</div>
	</section>
<?php endif; ?>
<div class="cloud-container content-grid" id="latest-posts">
	<section class="posts-column">
		<header class="section-heading">
			<div><p class="eyebrow"><?php esc_html_e( 'LATEST STORIES', 'xinaide-cloud' ); ?></p><h1><?php echo is_home() ? esc_html__( '最新文章', 'xinaide-cloud' ) : esc_html( get_the_archive_title() ); ?></h1></div>
			<span class="section-rule"></span>
		</header>
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); get_template_part( 'template-parts/content', 'card' ); endwhile; ?>
			<?php the_posts_pagination( array( 'mid_size' => 2, 'prev_text' => '← ' . __( '上一页', 'xinaide-cloud' ), 'next_text' => __( '下一页', 'xinaide-cloud' ) . ' →' ) ); ?>
		<?php else : get_template_part( 'template-parts/content', 'none' ); endif; ?>
	</section>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
