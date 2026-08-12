<aside class="sidebar" aria-label="<?php esc_attr_e( '侧栏', 'xinaide-cloud' ); ?>">
	<?php if ( xinaide_cloud_option_enabled( 'show_profile_card' ) ) : ?>
	<section class="widget cloud-panel profile-widget">
		<div class="profile-visual">
			<?php if ( xinaide_cloud_get_option( 'profile_avatar' ) ) : ?><img src="<?php echo esc_url( xinaide_cloud_get_option( 'profile_avatar' ) ); ?>" alt=""><?php else : ?><span>心</span><?php endif; ?>
			<i aria-hidden="true"></i>
		</div>
		<p class="profile-kicker">ABOUT THE AUTHOR</p>
		<h2><?php echo esc_html( xinaide_cloud_get_option( 'profile_title' ) ); ?></h2>
		<p><?php echo esc_html( xinaide_cloud_get_option( 'profile_text' ) ); ?></p>
		<a class="profile-link" href="<?php echo esc_url( xinaide_cloud_get_option( 'profile_button_url' ) ); ?>"><?php echo esc_html( xinaide_cloud_get_option( 'profile_button_text' ) ); ?> <span>→</span></a>
	</section>
	<?php endif; ?>

	<section class="widget cloud-panel search-widget"><div class="widget-number">01</div><h2 class="widget-title"><?php esc_html_e( '站内搜索', 'xinaide-cloud' ); ?></h2><?php get_search_form(); ?></section>

	<?php if ( xinaide_cloud_get_option( 'contact_qr' ) ) : ?>
	<section class="widget cloud-panel contact-widget"><div class="widget-number">02</div><h2 class="widget-title"><?php echo esc_html( xinaide_cloud_get_option( 'contact_title' ) ); ?></h2><img src="<?php echo esc_url( xinaide_cloud_get_option( 'contact_qr' ) ); ?>" alt="<?php echo esc_attr( xinaide_cloud_get_option( 'contact_title' ) ); ?>"></section>
	<?php endif; ?>

	<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	<?php else : ?>
	<section class="widget cloud-panel"><div class="widget-number">03</div><h2 class="widget-title"><?php esc_html_e( '分类导航', 'xinaide-cloud' ); ?></h2><ul class="cloud-categories"><?php wp_list_categories( array( 'title_li' => '', 'show_count' => true ) ); ?></ul></section>
	<section class="widget cloud-panel"><div class="widget-number">04</div><h2 class="widget-title"><?php esc_html_e( '最近更新', 'xinaide-cloud' ); ?></h2><ul class="recent-post-list"><?php wp_get_archives( array( 'type' => 'postbypost', 'limit' => 5 ) ); ?></ul></section>
	<section class="widget cloud-panel"><div class="widget-number">05</div><h2 class="widget-title"><?php esc_html_e( '热门标签', 'xinaide-cloud' ); ?></h2><div class="tag-cloud"><?php wp_tag_cloud( array( 'smallest' => 13, 'largest' => 13, 'unit' => 'px', 'number' => 18 ) ); ?></div></section>
	<?php endif; ?>
</aside>
