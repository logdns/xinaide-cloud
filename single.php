<?php get_header(); ?>
<div class="cloud-container article-layout page-spacing">
	<section class="article-column">
	<?php while ( have_posts() ) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-article cloud-panel' ); ?>>
			<header class="article-header">
				<?php $category = get_the_category(); if ( $category ) : ?><a class="category-pill" href="<?php echo esc_url( get_category_link( $category[0] ) ); ?>"><?php echo esc_html( $category[0]->name ); ?></a><?php endif; ?>
				<h1><?php the_title(); ?></h1>
				<div class="article-meta"><span><?php xinaide_cloud_posted_on(); ?></span><span><?php the_author(); ?></span><span><?php printf( esc_html__( '%d 分钟阅读', 'xinaide-cloud' ), xinaide_cloud_reading_time() ); ?></span><span><?php comments_number( '0 条评论', '1 条评论', '% 条评论' ); ?></span></div>
			</header>
			<?php if ( has_post_thumbnail() ) : ?><figure class="article-cover"><?php the_post_thumbnail( 'full' ); ?></figure><?php endif; ?>
			<div class="entry-content"><?php the_content(); wp_link_pages(); ?></div>
			<footer class="article-footer"><?php the_tags( '<div class="tag-list"><span>标签</span>', '', '</div>' ); ?></footer>
		</article>
		<nav class="post-navigation cloud-panel" aria-label="<?php esc_attr_e( '文章导航', 'xinaide-cloud' ); ?>"><?php previous_post_link( '<div><small>上一篇</small>%link</div>' ); next_post_link( '<div><small>下一篇</small>%link</div>' ); ?></nav>
		<?php if ( comments_open() || get_comments_number() ) : comments_template(); endif; ?>
	<?php endwhile; ?>
	</section>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>

