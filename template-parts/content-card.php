<?php /** Post card. @package xinaide-cloud */ ?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card cloud-panel' ); ?>>
	<?php $cover = xinaide_cloud_get_post_cover(); if ( $cover ) : ?>
		<a class="post-card-media" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
			<img src="<?php echo esc_url( $cover ); ?>" alt="" loading="lazy">
			<?php if ( is_sticky() ) : ?><span class="post-status">TOP</span><?php elseif ( xinaide_cloud_get_likes() >= 100 || get_comments_number() >= 20 ) : ?><span class="post-status">HOT</span><?php endif; ?>
		</a>
	<?php endif; ?>
	<div class="post-card-body">
		<div class="post-kicker">
			<?php $category = get_the_category(); if ( $category ) : ?>
				<a class="category-pill" href="<?php echo esc_url( get_category_link( $category[0] ) ); ?>"><?php echo esc_html( $category[0]->name ); ?></a>
			<?php endif; ?>
			<?php if ( xinaide_cloud_option_enabled( 'show_date' ) ) : xinaide_cloud_posted_on(); endif; ?>
		</div>
		<h2 class="post-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<div class="post-excerpt"><?php the_excerpt(); ?></div>
		<div class="post-card-meta">
			<?php if ( xinaide_cloud_option_enabled( 'show_views' ) ) : ?><span>◉ <?php echo esc_html( xinaide_cloud_get_views() ); ?> <?php esc_html_e( '热度', 'xinaide-cloud' ); ?></span><?php endif; ?>
			<?php if ( xinaide_cloud_option_enabled( 'show_likes' ) ) : ?><span>♡ <?php echo esc_html( xinaide_cloud_get_likes() ); ?></span><?php endif; ?>
			<?php if ( xinaide_cloud_option_enabled( 'show_author' ) ) : ?><span>BY <?php echo esc_html( get_the_author() ); ?></span><?php endif; ?>
			<?php if ( xinaide_cloud_option_enabled( 'show_reading_time' ) ) : ?><span><?php printf( esc_html__( '%d 分钟', 'xinaide-cloud' ), xinaide_cloud_reading_time() ); ?></span><?php endif; ?>
			<a class="read-more" href="<?php the_permalink(); ?>"><?php esc_html_e( '阅读全文', 'xinaide-cloud' ); ?> <span aria-hidden="true">→</span></a>
		</div>
	</div>
</article>
