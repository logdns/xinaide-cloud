<?php
/**
 * xinaide-cloud theme bootstrap.
 *
 * @package xinaide-cloud
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'XINAIDE_CLOUD_VERSION', '1.1.0' );

function xinaide_cloud_setup() {
	load_theme_textdomain( 'xinaide-cloud', get_template_directory() . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'custom-logo', array( 'height' => 80, 'width' => 80, 'flex-height' => true, 'flex-width' => true ) );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	register_nav_menus(
		array(
			'primary' => __( '主导航', 'xinaide-cloud' ),
			'footer'  => __( '页脚导航', 'xinaide-cloud' ),
		)
	);
}
add_action( 'after_setup_theme', 'xinaide_cloud_setup' );

function xinaide_cloud_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'xinaide_cloud_content_width', 860 );
}
add_action( 'after_setup_theme', 'xinaide_cloud_content_width', 0 );

function xinaide_cloud_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( '博客侧栏', 'xinaide-cloud' ),
			'id'            => 'sidebar-1',
			'description'   => __( '显示在文章列表与文章页右侧。', 'xinaide-cloud' ),
			'before_widget' => '<section id="%1$s" class="widget cloud-panel %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'xinaide_cloud_widgets_init' );

function xinaide_cloud_assets() {
	$theme = wp_get_theme();
	$version = $theme->get( 'Version' ) ?: XINAIDE_CLOUD_VERSION;
	wp_enqueue_style( 'xinaide-cloud-style', get_stylesheet_uri(), array(), $version );

	$asset_file = get_template_directory() . '/assets/dist/app.css';
	if ( file_exists( $asset_file ) ) {
		wp_enqueue_style( 'xinaide-cloud-app', get_template_directory_uri() . '/assets/dist/app.css', array(), (string) filemtime( $asset_file ) );
	}

	$script_file = get_template_directory() . '/assets/dist/app.js';
	if ( file_exists( $script_file ) ) {
		wp_enqueue_script( 'xinaide-cloud-app', get_template_directory_uri() . '/assets/dist/app.js', array(), (string) filemtime( $script_file ), true );
		wp_script_add_data( 'xinaide-cloud-app', 'type', 'module' );
		wp_localize_script(
			'xinaide-cloud-app',
			'xinaideCloud',
			array(
				'homeUrl'    => esc_url_raw( home_url( '/' ) ),
				'searchUrl'  => esc_url_raw( home_url( '/' ) ),
				'siteName'   => get_bloginfo( 'name' ),
				'isLoggedIn' => is_user_logged_in(),
				'adminUrl'   => esc_url_raw( admin_url() ),
				'labels'     => array(
					'menu'       => __( '菜单', 'xinaide-cloud' ),
					'close'      => __( '关闭', 'xinaide-cloud' ),
					'search'     => __( '搜索文章', 'xinaide-cloud' ),
					'placeholder'=> __( '输入关键词…', 'xinaide-cloud' ),
					'light'      => __( '浅色模式', 'xinaide-cloud' ),
					'dark'       => __( '深色模式', 'xinaide-cloud' ),
				),
			)
		);
	}
}
add_action( 'wp_enqueue_scripts', 'xinaide_cloud_assets' );

function xinaide_cloud_excerpt_length() {
	return 110;
}
add_filter( 'excerpt_length', 'xinaide_cloud_excerpt_length', 99 );

function xinaide_cloud_excerpt_more() {
	return '…';
}
add_filter( 'excerpt_more', 'xinaide_cloud_excerpt_more' );

function xinaide_cloud_posted_on() {
	printf(
		'<time datetime="%1$s">%2$s</time>',
		esc_attr( get_the_date( DATE_W3C ) ),
		esc_html( get_the_date() )
	);
}

function xinaide_cloud_reading_time() {
	$content = wp_strip_all_tags( get_post_field( 'post_content', get_the_ID() ) );
	$count   = function_exists( 'mb_strlen' ) ? mb_strlen( $content, 'UTF-8' ) : strlen( $content );
	return max( 1, (int) ceil( $count / 500 ) );
}

function xinaide_cloud_fallback_menu() {
	echo '<ul class="menu">';
	wp_list_pages( array( 'title_li' => '', 'depth' => 1 ) );
	echo '</ul>';
}

function xinaide_cloud_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'xinaide_cloud_home',
		array( 'title' => __( 'Xinaide Cloud 首页', 'xinaide-cloud' ), 'priority' => 35 )
	);
	$settings = array(
		'hero_eyebrow' => array( 'label' => __( '首页眉题', 'xinaide-cloud' ), 'default' => 'PRIVATE DIGITAL GARDEN' ),
		'hero_title'   => array( 'label' => __( '首页标题', 'xinaide-cloud' ), 'default' => '私人小天地' ),
		'hero_text'    => array( 'label' => __( '首页说明', 'xinaide-cloud' ), 'default' => '谈天说地，记录折腾、学习与生活。' ),
	);
	foreach ( $settings as $key => $args ) {
		$wp_customize->add_setting( 'xinaide_cloud_' . $key, array( 'default' => $args['default'], 'sanitize_callback' => 'sanitize_text_field' ) );
		$wp_customize->add_control( 'xinaide_cloud_' . $key, array( 'section' => 'xinaide_cloud_home', 'label' => $args['label'], 'type' => 'text' ) );
	}
}
add_action( 'customize_register', 'xinaide_cloud_customize_register' );
