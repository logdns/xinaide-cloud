<?php
/** Header template. @package xinaide-cloud */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#f7f9fc">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( '跳至正文', 'xinaide-cloud' ); ?></a>
<header class="site-header" id="masthead">
	<div class="cloud-container header-inner">
		<a class="site-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<span class="brand-mark" aria-hidden="true">心</span>
			<span class="brand-copy">
				<strong><?php bloginfo( 'name' ); ?></strong>
				<small><?php bloginfo( 'description' ); ?></small>
			</span>
		</a>
		<nav class="desktop-nav" aria-label="<?php esc_attr_e( '主导航', 'xinaide-cloud' ); ?>">
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'fallback_cb' => 'xinaide_cloud_fallback_menu', 'depth' => 2 ) ); ?>
		</nav>
		<div id="xinaide-cloud-toolbar" class="cloud-toolbar" data-nav-target="mobile-navigation">
			<button class="toolbar-fallback" type="button" aria-label="<?php esc_attr_e( '打开搜索', 'xinaide-cloud' ); ?>">⌕</button>
		</div>
	</div>
	<div id="mobile-navigation" class="mobile-nav-source" hidden>
		<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'fallback_cb' => 'xinaide_cloud_fallback_menu', 'depth' => 2 ) ); ?>
	</div>
</header>
<main id="content" class="site-content">

