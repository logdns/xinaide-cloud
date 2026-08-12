<?php get_header(); ?>
<div class="cloud-container article-layout page-spacing">
	<section class="article-column">
	<?php while ( have_posts() ) : the_post(); ?>
		<?php if ( xinaide_cloud_option_enabled( 'show_breadcrumbs' ) ) : xinaide_cloud_breadcrumbs(); endif; ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-article cloud-panel' ); ?>>
			<header class="article-header">
				<div class="article-header-top"><?php $category = get_the_category(); if ( $category ) : ?><a class="category-pill" href="<?php echo esc_url( get_category_link( $category[0] ) ); ?>"><?php echo esc_html( $category[0]->name ); ?></a><?php endif; ?><span>ARTICLE · <?php echo esc_html( get_the_ID() ); ?></span></div>
				<h1><?php the_title(); ?></h1>
				<div class="article-meta">
					<?php if ( xinaide_cloud_option_enabled( 'show_date' ) ) : ?><span><b>发布</b><?php xinaide_cloud_posted_on(); ?></span><?php endif; ?>
					<?php if ( xinaide_cloud_option_enabled( 'show_author' ) ) : ?><span><b>作者</b><?php the_author(); ?></span><?php endif; ?>
					<?php if ( xinaide_cloud_option_enabled( 'show_reading_time' ) ) : ?><span><b>阅读</b><?php printf( esc_html__( '%d 分钟', 'xinaide-cloud' ), xinaide_cloud_reading_time() ); ?></span><?php endif; ?>
					<?php if ( xinaide_cloud_option_enabled( 'show_views' ) ) : ?><span><b>热度</b><?php echo esc_html( xinaide_cloud_get_views() ); ?></span><?php endif; ?>
					<?php if ( xinaide_cloud_option_enabled( 'show_comments' ) ) : ?><span><b>评论</b><?php comments_number( '0', '1', '%' ); ?></span><?php endif; ?>
				</div>
			</header>
			<?php if ( has_post_thumbnail() ) : ?><figure class="article-cover"><?php the_post_thumbnail( 'full' ); ?></figure><?php endif; ?>
			<?php if ( xinaide_cloud_option_enabled( 'show_toc' ) ) : ?><aside class="article-toc" data-xinaide-toc hidden><div><span>CONTENTS</span><strong><?php esc_html_e( '本文目录', 'xinaide-cloud' ); ?></strong></div><ol></ol></aside><?php endif; ?>
			<div class="entry-content"><?php the_content(); wp_link_pages(); ?></div>
			<footer class="article-footer">
				<div><?php the_tags( '<div class="tag-list"><span>标签</span>', '', '</div>' ); ?><p><?php esc_html_e( '最后更新：', 'xinaide-cloud' ); ?><?php echo esc_html( get_the_modified_date() ); ?></p></div>
				<?php if ( xinaide_cloud_option_enabled( 'show_likes' ) ) : ?><button class="article-like" type="button" data-xinaide-like data-post-id="<?php the_ID(); ?>"><span aria-hidden="true">♡</span><b data-like-count><?php echo esc_html( xinaide_cloud_get_likes() ); ?></b><em><?php esc_html_e( '觉得有用', 'xinaide-cloud' ); ?></em></button><?php endif; ?>
			</footer>
		</article>
		<nav class="post-navigation cloud-panel" aria-label="<?php esc_attr_e( '文章导航', 'xinaide-cloud' ); ?>"><?php previous_post_link( '<div><small>上一篇</small>%link</div>' ); next_post_link( '<div><small>下一篇</small>%link</div>' ); ?></nav>
		<?php if ( comments_open() || get_comments_number() ) : comments_template(); endif; ?>
	<?php endwhile; ?>
	</section>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>

