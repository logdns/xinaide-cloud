<?php /** Post card. @package xinaide-cloud */ ?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card cloud-panel' ); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<a class="post-card-media" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
			<?php the_post_thumbnail( 'large', array( 'loading' => 'lazy' ) ); ?>
		</a>
	<?php endif; ?>
	<div class="post-card-body">
		<div class="post-kicker">
			<?php $category = get_the_category(); if ( $category ) : ?>
				<a class="category-pill" href="<?php echo esc_url( get_category_link( $category[0] ) ); ?>"><?php echo esc_html( $category[0]->name ); ?></a>
			<?php endif; ?>
			<?php xinaide_cloud_posted_on(); ?>
		</div>
		<h2 class="post-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<div class="post-excerpt"><?php the_excerpt(); ?></div>
		<div class="post-card-meta">
			<span><?php echo esc_html( get_the_author() ); ?></span>
			<span><?php printf( esc_html__( '%d 分钟阅读', 'xinaide-cloud' ), xinaide_cloud_reading_time() ); ?></span>
			<a class="read-more" href="<?php the_permalink(); ?>"><?php esc_html_e( '阅读全文', 'xinaide-cloud' ); ?> <span aria-hidden="true">→</span></a>
		</div>
	</div>
</article>

