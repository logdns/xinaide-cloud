<?php get_header(); ?>
<?php if ( is_home() && ! is_paged() && xinaide_cloud_option_enabled( 'show_home_hero' ) ) : ?>
	<?php $hero_background = xinaide_cloud_get_option( 'hero_background' ) ?: get_template_directory_uri() . '/assets/images/hero-water.jpg'; ?>
	<section class="hero-section" style="--hero-image:url('<?php echo esc_url( $hero_background ); ?>')">
		<div class="cloud-container hero-inner">
			<div class="hero-copy">
				<p class="eyebrow"><?php echo esc_html( xinaide_cloud_get_option( 'hero_eyebrow' ) ); ?></p>
				<h1><?php echo nl2br( esc_html( xinaide_cloud_get_option( 'hero_title' ) ) ); ?></h1>
				<p class="hero-description"><?php echo esc_html( xinaide_cloud_get_option( 'hero_text' ) ); ?></p>
				<div class="hero-actions">
					<a class="hero-button hero-button-primary" href="<?php echo esc_url( xinaide_cloud_get_option( 'hero_primary_url' ) ); ?>"><?php echo esc_html( xinaide_cloud_get_option( 'hero_primary_text' ) ); ?> <span>↘</span></a>
					<a class="hero-button hero-button-secondary" href="<?php echo esc_url( xinaide_cloud_get_option( 'hero_secondary_url' ) ); ?>"><?php echo esc_html( xinaide_cloud_get_option( 'hero_secondary_text' ) ); ?> <span>→</span></a>
				</div>
			</div>
			<div class="hero-manifesto">
				<span class="manifesto-index">01 — 记录</span>
				<p>分享有用的经验，<br>也保留真实的生活。</p>
				<div class="manifesto-line"></div>
				<small>EST. 2009 · XINAI.DE</small>
			</div>
		</div>
		<div class="cloud-container hero-stats">
			<?php foreach ( array( 'one', 'two', 'three' ) as $stat ) : ?>
				<div><strong><?php echo esc_html( xinaide_cloud_get_option( 'hero_stat_' . $stat . '_value' ) ); ?></strong><span><?php echo esc_html( xinaide_cloud_get_option( 'hero_stat_' . $stat . '_label' ) ); ?></span></div>
			<?php endforeach; ?>
			<a href="#latest-posts" aria-label="<?php esc_attr_e( '向下浏览文章', 'xinaide-cloud' ); ?>">↓</a>
		</div>
	</section>
	<section class="topic-strip" aria-label="<?php esc_attr_e( '热门分类', 'xinaide-cloud' ); ?>">
		<div class="cloud-container topic-strip-inner"><span><?php esc_html_e( '探索主题', 'xinaide-cloud' ); ?></span><?php foreach ( get_categories( array( 'orderby' => 'count', 'order' => 'DESC', 'number' => 7 ) ) as $topic ) : ?><a href="<?php echo esc_url( get_category_link( $topic ) ); ?>"><?php echo esc_html( $topic->name ); ?><sup><?php echo esc_html( $topic->count ); ?></sup></a><?php endforeach; ?></div>
	</section>
<?php endif; ?>
<div class="cloud-container content-grid" id="latest-posts">
	<section class="posts-column">
		<header class="section-heading">
			<div><p class="eyebrow"><?php esc_html_e( 'LATEST STORIES · 持续更新', 'xinaide-cloud' ); ?></p><h1><?php echo is_home() ? esc_html__( '最新发布', 'xinaide-cloud' ) : esc_html( get_the_archive_title() ); ?></h1></div>
			<span class="section-rule"></span>
		</header>
		<?php
		$sticky_ids   = array_map( 'absint', (array) get_option( 'sticky_posts' ) );
		$sticky_strip = ( is_home() && ! is_paged() && $sticky_ids ) ? $sticky_ids : array();
		if ( $sticky_strip ) :
			$stickies = get_posts( array( 'post__in' => $sticky_strip, 'posts_per_page' => 5, 'ignore_sticky_posts' => true, 'post_status' => 'publish' ) );
			if ( $stickies ) :
				?>
		<section class="sticky-strip cloud-panel" aria-label="<?php esc_attr_e( '置顶文章', 'xinaide-cloud' ); ?>">
			<ul>
				<?php foreach ( $stickies as $sticky_post ) : ?>
				<li><span class="sticky-badge"><?php esc_html_e( '置顶', 'xinaide-cloud' ); ?></span><a href="<?php echo esc_url( get_permalink( $sticky_post ) ); ?>"><?php echo esc_html( get_the_title( $sticky_post ) ); ?></a><time datetime="<?php echo esc_attr( get_the_date( DATE_W3C, $sticky_post ) ); ?>"><?php echo esc_html( get_the_date( '', $sticky_post ) ); ?></time></li>
				<?php endforeach; ?>
			</ul>
		</section>
			<?php endif; ?>
		<?php endif; ?>
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); if ( $sticky_strip && in_array( get_the_ID(), $sticky_strip, true ) ) { continue; } get_template_part( 'template-parts/content', 'card' ); endwhile; ?>
			<?php the_posts_pagination( array( 'mid_size' => 2, 'prev_text' => '← ' . __( '上一页', 'xinaide-cloud' ), 'next_text' => __( '下一页', 'xinaide-cloud' ) . ' →' ) ); ?>
		<?php else : get_template_part( 'template-parts/content', 'none' ); endif; ?>
	</section>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
