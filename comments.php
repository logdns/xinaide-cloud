<?php if ( post_password_required() ) { return; } ?>
<section id="comments" class="comments-area cloud-panel">
	<?php if ( have_comments() ) : ?><h2 class="comments-title"><?php printf( esc_html( _nx( '%1$s 条评论', '%1$s 条评论', get_comments_number(), 'comments title', 'xinaide-cloud' ) ), number_format_i18n( get_comments_number() ) ); ?></h2><ol class="comment-list"><?php wp_list_comments( array( 'style' => 'ol', 'short_ping' => true, 'avatar_size' => 44 ) ); ?></ol><?php the_comments_navigation(); ?><?php endif; ?>
	<?php comment_form(); ?>
</section>

