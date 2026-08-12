<?php get_header(); ?>
<div class="cloud-container content-grid page-spacing">
	<section class="posts-column">
		<header class="archive-header cloud-panel">
			<p class="eyebrow"><?php esc_html_e( 'ARCHIVE', 'xinaide-cloud' ); ?></p>
			<?php the_archive_title( '<h1>', '</h1>' ); the_archive_description( '<div class="archive-description">', '</div>' ); ?>
		</header>
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); get_template_part( 'template-parts/content', 'card' ); endwhile; the_posts_pagination(); else : get_template_part( 'template-parts/content', 'none' ); endif; ?>
	</section>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>

