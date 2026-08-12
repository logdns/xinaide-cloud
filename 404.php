<?php get_header(); ?>
<div class="cloud-container error-page page-spacing"><div class="cloud-panel"><span class="error-code">404</span><p class="eyebrow">LOST IN THE CLOUD</p><h1><?php esc_html_e( '这朵云里没有你要找的页面', 'xinaide-cloud' ); ?></h1><p><?php esc_html_e( '链接可能已经移动，试试搜索或回到首页。', 'xinaide-cloud' ); ?></p><?php get_search_form(); ?><a class="text-link" href="<?php echo esc_url( home_url( '/' ) ); ?>">← <?php esc_html_e( '返回首页', 'xinaide-cloud' ); ?></a></div></div>
<?php get_footer(); ?>

