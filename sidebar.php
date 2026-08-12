<aside class="sidebar" aria-label="<?php esc_attr_e( '侧栏', 'xinaide-cloud' ); ?>">
	<section class="widget cloud-panel search-widget"><h2 class="widget-title"><?php esc_html_e( '站内搜索', 'xinaide-cloud' ); ?></h2><?php get_search_form(); ?></section>
	<?php if ( is_active_sidebar( 'sidebar-1' ) ) : dynamic_sidebar( 'sidebar-1' ); else : ?>
	<section class="widget cloud-panel"><h2 class="widget-title"><?php esc_html_e( '分类', 'xinaide-cloud' ); ?></h2><ul class="cloud-categories"><?php wp_list_categories( array( 'title_li' => '', 'show_count' => true ) ); ?></ul></section>
	<section class="widget cloud-panel"><h2 class="widget-title"><?php esc_html_e( '热门标签', 'xinaide-cloud' ); ?></h2><div class="tag-cloud"><?php wp_tag_cloud( array( 'smallest' => 13, 'largest' => 13, 'unit' => 'px', 'number' => 18 ) ); ?></div></section>
	<?php endif; ?>
</aside>

