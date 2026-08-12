<?php get_header(); ?>
<div class="cloud-container content-grid page-spacing">
	<section class="posts-column">
		<header class="archive-header cloud-panel"><p class="eyebrow"><?php esc_html_e( 'SEARCH', 'xinaide-cloud' ); ?></p><h1><?php printf( esc_html__( '“%s”的搜索结果', 'xinaide-cloud' ), esc_html( get_search_query() ) ); ?></h1></header>
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); get_template_part( 'template-parts/content', 'card' ); endwhile; the_posts_pagination(); else : get_template_part( 'template-parts/content', 'none' ); endif; ?>
	</section>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>

