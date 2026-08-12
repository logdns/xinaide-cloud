<?php get_header(); ?>
<div class="cloud-container narrow-container page-spacing">
	<?php while ( have_posts() ) : the_post(); ?>
	<?php if ( xinaide_cloud_option_enabled( 'show_breadcrumbs' ) ) : xinaide_cloud_breadcrumbs(); endif; ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-article cloud-panel page-article' ); ?>><header class="article-header"><p class="eyebrow"><?php esc_html_e( 'PAGE · XINAI.DE', 'xinaide-cloud' ); ?></p><h1><?php the_title(); ?></h1></header><div class="entry-content"><?php the_content(); wp_link_pages(); ?></div></article>
	<?php if ( comments_open() || get_comments_number() ) : comments_template(); endif; endwhile; ?>
</div>
<?php get_footer(); ?>
