<?php
/**
 * xinaide-cloud theme bootstrap.
 *
 * @package xinaide-cloud
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'XINAIDE_CLOUD_VERSION', '1.2.0' );

require_once get_template_directory() . '/inc/theme-options.php';

function xinaide_cloud_setup() {
	load_theme_textdomain( 'xinaide-cloud', get_template_directory() . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'custom-background' );
	add_theme_support( 'editor-styles' );
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
		wp_add_inline_style( 'xinaide-cloud-app', xinaide_cloud_dynamic_css() );
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
				'ajaxUrl'    => esc_url_raw( admin_url( 'admin-ajax.php' ) ),
				'likeNonce'  => wp_create_nonce( 'xinaide_cloud_like' ),
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

function xinaide_cloud_dynamic_css() {
	$accent       = xinaide_cloud_get_option( 'accent_color' );
	$heading      = xinaide_cloud_get_option( 'heading_color' );
	$width        = min( 1520, max( 1080, absint( xinaide_cloud_get_option( 'max_width' ) ) ) );
	$sidebar      = min( 420, max( 280, absint( xinaide_cloud_get_option( 'sidebar_width' ) ) ) );
	$radius       = min( 40, max( 8, absint( xinaide_cloud_get_option( 'card_radius' ) ) ) );
	$hero_height  = min( 760, max( 420, absint( xinaide_cloud_get_option( 'hero_height' ) ) ) );
	$hero_overlay = min( 85, max( 20, absint( xinaide_cloud_get_option( 'hero_overlay' ) ) ) ) / 100;
	$custom       = xinaide_cloud_get_option( 'custom_css' );

	return sprintf(
		':root{--cloud-primary:%1$s;--cloud-primary-deep:%1$s;--cloud-heading:%2$s;--cloud-max-width:%3$dpx;--cloud-sidebar-width:%4$dpx;--cloud-radius:%5$dpx;--cloud-hero-height:%6$dpx;--cloud-hero-overlay:%7$s;}%8$s',
		esc_html( $accent ),
		esc_html( $heading ),
		$width,
		$sidebar,
		$radius,
		$hero_height,
		$hero_overlay,
		$custom ? "\n" . wp_strip_all_tags( $custom ) : ''
	);
}

function xinaide_cloud_body_classes( $classes ) {
	$classes[] = 'header-style-' . sanitize_html_class( xinaide_cloud_get_option( 'header_style' ) );
	$classes[] = 'sidebar-position-' . sanitize_html_class( xinaide_cloud_get_option( 'sidebar_position' ) );
	if ( ! xinaide_cloud_option_enabled( 'sticky_header' ) ) {
		$classes[] = 'header-not-sticky';
	}
	return $classes;
}
add_filter( 'body_class', 'xinaide_cloud_body_classes' );

function xinaide_cloud_excerpt_length() {
	return max( 60, absint( xinaide_cloud_get_option( 'excerpt_length' ) ) );
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

function xinaide_cloud_get_post_cover( $post_id = 0 ) {
	$post_id = $post_id ?: get_the_ID();
	if ( has_post_thumbnail( $post_id ) ) {
		return get_the_post_thumbnail_url( $post_id, 'large' );
	}

	$content = get_post_field( 'post_content', $post_id );
	if ( $content && preg_match( '/<img[^>]+src=[\"\']([^\"\']+)[\"\']/i', $content, $matches ) ) {
		return esc_url_raw( $matches[1] );
	}

	return esc_url_raw( xinaide_cloud_get_option( 'default_cover' ) );
}

function xinaide_cloud_get_views( $post_id = 0 ) {
	$post_id = $post_id ?: get_the_ID();
	return max( 0, (int) get_post_meta( $post_id, 'views', true ) );
}

function xinaide_cloud_get_likes( $post_id = 0 ) {
	$post_id = $post_id ?: get_the_ID();
	return max( 0, (int) get_post_meta( $post_id, 'love', true ) );
}

function xinaide_cloud_record_view() {
	if ( ! is_singular( 'post' ) || is_preview() || is_admin() ) {
		return;
	}
	$post_id = get_queried_object_id();
	$cookie  = 'xinaide_viewed_' . $post_id;
	if ( $post_id && empty( $_COOKIE[ $cookie ] ) ) {
		update_post_meta( $post_id, 'views', xinaide_cloud_get_views( $post_id ) + 1 );
		setcookie( $cookie, '1', time() + 6 * HOUR_IN_SECONDS, COOKIEPATH ?: '/', COOKIE_DOMAIN, is_ssl(), true );
	}
}
add_action( 'template_redirect', 'xinaide_cloud_record_view' );

function xinaide_cloud_like_post() {
	check_ajax_referer( 'xinaide_cloud_like', 'nonce' );
	$post_id = isset( $_POST['post_id'] ) ? absint( $_POST['post_id'] ) : 0;
	if ( ! $post_id || 'publish' !== get_post_status( $post_id ) ) {
		wp_send_json_error( array( 'message' => __( '文章不存在。', 'xinaide-cloud' ) ), 404 );
	}
	$cookie = 'xinaide_liked_' . $post_id;
	if ( ! empty( $_COOKIE[ $cookie ] ) ) {
		wp_send_json_error( array( 'message' => __( '你已经点过赞了。', 'xinaide-cloud' ), 'count' => xinaide_cloud_get_likes( $post_id ) ) );
	}
	$count = xinaide_cloud_get_likes( $post_id ) + 1;
	update_post_meta( $post_id, 'love', $count );
	setcookie( $cookie, '1', time() + YEAR_IN_SECONDS, COOKIEPATH ?: '/', COOKIE_DOMAIN, is_ssl(), false );
	wp_send_json_success( array( 'count' => $count ) );
}
add_action( 'wp_ajax_xinaide_cloud_like', 'xinaide_cloud_like_post' );
add_action( 'wp_ajax_nopriv_xinaide_cloud_like', 'xinaide_cloud_like_post' );

function xinaide_cloud_title_only_search( $search, $query ) {
	if ( is_admin() || ! $query->is_search() || ! xinaide_cloud_option_enabled( 'title_only_search' ) || ! $query->get( 's' ) ) {
		return $search;
	}
	global $wpdb;
	$needle = '%' . $wpdb->esc_like( $query->get( 's' ) ) . '%';
	return $wpdb->prepare( " AND ({$wpdb->posts}.post_title LIKE %s) ", $needle );
}
add_filter( 'posts_search', 'xinaide_cloud_title_only_search', 20, 2 );

function xinaide_cloud_social_meta() {
	$description = is_front_page() || is_home() ? xinaide_cloud_get_option( 'seo_description' ) : '';
	if ( is_singular() ) {
		$description = wp_trim_words( wp_strip_all_tags( get_post_field( 'post_content', get_queried_object_id() ) ), 36, '…' );
	}
	$description = $description ?: get_bloginfo( 'description' );
	$image       = is_singular() ? xinaide_cloud_get_post_cover( get_queried_object_id() ) : xinaide_cloud_get_option( 'share_image' );
	$title       = is_singular() ? get_the_title( get_queried_object_id() ) : get_bloginfo( 'name' );
	$url         = is_singular() ? get_permalink( get_queried_object_id() ) : home_url( '/' );
	if ( is_front_page() && xinaide_cloud_get_option( 'seo_keywords' ) ) {
		echo '<meta name="keywords" content="' . esc_attr( xinaide_cloud_get_option( 'seo_keywords' ) ) . '">' . "\n";
	}
	echo '<meta name="description" content="' . esc_attr( $description ) . '">' . "\n";
	echo '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '">' . "\n";
	echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
	echo '<meta property="og:description" content="' . esc_attr( $description ) . '">' . "\n";
	echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";
	if ( $image ) {
		echo '<meta property="og:image" content="' . esc_url( $image ) . '">' . "\n";
	}
}
add_action( 'wp_head', 'xinaide_cloud_social_meta', 3 );

function xinaide_cloud_breadcrumbs() {
	if ( is_front_page() ) {
		return;
	}
	echo '<nav class="breadcrumbs" aria-label="' . esc_attr__( '面包屑导航', 'xinaide-cloud' ) . '">';
	echo '<a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( '首页', 'xinaide-cloud' ) . '</a><span>／</span>';
	if ( is_single() ) {
		$categories = get_the_category();
		if ( $categories ) {
			echo '<a href="' . esc_url( get_category_link( $categories[0] ) ) . '">' . esc_html( $categories[0]->name ) . '</a><span>／</span>';
		}
		echo '<span aria-current="page">' . esc_html( get_the_title() ) . '</span>';
	} elseif ( is_page() ) {
		echo '<span aria-current="page">' . esc_html( get_the_title() ) . '</span>';
	} elseif ( is_search() ) {
		echo '<span aria-current="page">' . esc_html__( '搜索结果', 'xinaide-cloud' ) . '</span>';
	} else {
		echo '<span aria-current="page">' . wp_kses_post( get_the_archive_title() ) . '</span>';
	}
	echo '</nav>';
}

function xinaide_cloud_site_years() {
	$first = get_posts( array( 'numberposts' => 1, 'orderby' => 'date', 'order' => 'ASC', 'fields' => 'ids', 'post_status' => 'publish' ) );
	if ( ! $first ) {
		return 1;
	}
	return max( 1, (int) wp_date( 'Y' ) - (int) get_the_date( 'Y', $first[0] ) + 1 );
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
