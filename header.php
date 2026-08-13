<?php
/** Header template. @package xinaide-cloud */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#102f35">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( '跳至正文', 'xinaide-cloud' ); ?></a>
<header class="site-header" id="masthead">
	<div class="header-accent" aria-hidden="true"></div>
	<div class="cloud-container header-inner">
		<div class="site-brand-wrap">
			<?php $brand_avatar = xinaide_cloud_avatar_url( xinaide_cloud_get_option( 'brand_avatar' ) ); ?>
			<?php if ( has_custom_logo() ) : ?><div class="custom-logo-wrap"><?php the_custom_logo(); ?></div><?php elseif ( $brand_avatar ) : ?><a class="brand-mark brand-mark-image" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" aria-label="<?php bloginfo( 'name' ); ?>"><img src="<?php echo esc_url( $brand_avatar ); ?>" alt=""></a><?php else : ?><a class="brand-mark" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" aria-label="<?php bloginfo( 'name' ); ?>">心</a><?php endif; ?>
			<a class="brand-copy" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<strong><?php bloginfo( 'name' ); ?></strong>
				<small><?php bloginfo( 'description' ); ?></small>
			</a>
		</div>
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
<?php if ( ! is_home() && ! is_front_page() && ! is_404() ) : ?>
	<?php $inner_background = xinaide_cloud_get_option( 'hero_background' ) ?: get_template_directory_uri() . '/assets/images/hero-water.jpg'; ?>
	<section class="inner-banner" style="--hero-image:url('<?php echo esc_url( $inner_background ); ?>')">
		<div class="cloud-container inner-banner-content">
			<p><?php echo is_archive() ? esc_html__( 'ARCHIVE · XINAI.DE', 'xinaide-cloud' ) : ( is_search() ? esc_html__( 'SEARCH · XINAI.DE', 'xinaide-cloud' ) : esc_html__( 'PRIVATE DIGITAL GARDEN', 'xinaide-cloud' ) ); ?></p>
			<strong><?php echo is_archive() ? wp_kses_post( get_the_archive_title() ) : ( is_search() ? esc_html__( '搜索与发现', 'xinaide-cloud' ) : esc_html( xinaide_cloud_get_option( 'hero_title' ) ) ); ?></strong>
			<span><?php echo is_archive() && get_the_archive_description() ? wp_kses_post( wp_strip_all_tags( get_the_archive_description() ) ) : esc_html( get_bloginfo( 'description' ) ); ?></span>
		</div>
	</section>
<?php endif; ?>
<main id="content" class="site-content">
