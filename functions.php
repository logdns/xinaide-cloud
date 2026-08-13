<?php
/**
 * xinaide-cloud theme bootstrap.
 *
 * @package xinaide-cloud
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'XINAIDE_CLOUD_VERSION', '1.4.0' );

require_once get_template_directory() . '/inc/theme-options.php';

function xinaide_cloud_setup() {
	load_theme_textdomain( 'xinaide-cloud', get_template_directory() . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'xinaide-card', 640, 400, true );
	add_image_size( 'xinaide-avatar', 160, 160, true );
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
			'socials'    => xinaide_cloud_get_socials(),
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

/**
 * Resolve an uploaded image URL to the auto-cropped square avatar size.
 * Falls back to the raw URL (CSS circle crop still applies) for external images.
 *
 * @param string $url Image URL saved in theme options.
 * @return string
 */
function xinaide_cloud_avatar_url( $url ) {
	$url = trim( (string) $url );
	if ( ! $url ) {
		return '';
	}
	$attachment_id = function_exists( 'attachment_url_to_postid' ) ? attachment_url_to_postid( $url ) : 0;
	if ( $attachment_id ) {
		$cropped = wp_get_attachment_image_src( $attachment_id, 'xinaide-avatar' );
		if ( is_array( $cropped ) && ! empty( $cropped[0] ) ) {
			return $cropped[0];
		}
	}
	return esc_url_raw( $url );
}

function xinaide_cloud_get_post_cover( $post_id = 0 ) {
	$post_id = $post_id ?: get_the_ID();
	if ( has_post_thumbnail( $post_id ) ) {
		$featured = get_the_post_thumbnail_url( $post_id, 'xinaide-card' );
		if ( ! $featured ) {
			$featured = get_the_post_thumbnail_url( $post_id, 'full' );
		}
		if ( $featured ) {
			return $featured;
		}
	}

	$content = get_post_field( 'post_content', $post_id );
	if ( $content ) {
		// 优先读取懒加载插件写入的 data-src / data-original，再退回普通 src。
		$patterns = array(
			'/<img\b[^>]*?\b(?:data-src|data-original)\s*=\s*[\"\']([^\"\']+)[\"\']/i',
			'/<img\b[^>]*?(?<![\w-])src\s*=\s*[\"\']([^\"\']+)[\"\']/i',
		);
		foreach ( $patterns as $pattern ) {
			if ( ! preg_match_all( $pattern, $content, $matches ) ) {
				continue;
			}
			foreach ( $matches[1] as $candidate ) {
				$candidate = html_entity_decode( trim( $candidate ) );
				// 跳过表情、笑脸和 base64 占位图，避免把装饰图当作文章封面。
				if ( '' === $candidate || 0 === strpos( $candidate, 'data:' ) || preg_match( '#(images/core/emoji|images/smilies)#i', $candidate ) ) {
					continue;
				}
				if ( 0 === strpos( $candidate, '//' ) ) {
					$candidate = ( is_ssl() ? 'https:' : 'http:' ) . $candidate;
				}
				return esc_url_raw( $candidate );
			}
		}
	}

	$default = xinaide_cloud_get_option( 'default_cover' );
	return $default ? esc_url_raw( $default ) : esc_url_raw( get_template_directory_uri() . '/assets/images/hero-water.jpg' );
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

/**
 * Site uptime text like "16年283天9时11分41秒", counted from the configured
 * launch date (Beijing time, UTC+8) to keep parity with the original site.
 *
 * @return string
 */
function xinaide_cloud_uptime_text() {
	$launch = trim( (string) xinaide_cloud_get_option( 'site_launch_date' ) );
	if ( ! preg_match( '/^(\d{4})-(\d{1,2})-(\d{1,2})$/', $launch, $m ) || ! checkdate( (int) $m[2], (int) $m[3], (int) $m[1] ) ) {
		return '';
	}
	// 建站时刻按 UTC+8 零点折算成时间戳，差值与访客时区无关。
	$from  = gmmktime( 0, 0, 0, (int) $m[2], (int) $m[3], (int) $m[1] ) - 8 * HOUR_IN_SECONDS;
	$diff  = max( 0, time() - $from );
	$years = (int) floor( $diff / ( 365 * DAY_IN_SECONDS ) );
	$diff -= $years * 365 * DAY_IN_SECONDS;
	$days  = (int) floor( $diff / DAY_IN_SECONDS );
	$diff -= $days * DAY_IN_SECONDS;
	$hours = (int) floor( $diff / HOUR_IN_SECONDS );
	$diff -= $hours * HOUR_IN_SECONDS;
	$mins  = (int) floor( $diff / MINUTE_IN_SECONDS );
	$secs  = $diff - $mins * MINUTE_IN_SECONDS;
	return sprintf( '%d年%d天%d时%d分%d秒', $years, $days, $hours, $mins, $secs );
}

function xinaide_cloud_fallback_menu() {
	echo '<ul class="menu">';
	wp_list_pages( array( 'title_li' => '', 'depth' => 1 ) );
	echo '</ul>';
}

/**
 * Build the footer social channel list.
 *
 * Each item: key, label, type (link|mailto|copy), href/value, tip.
 * Falls back to RSS so the footer is never empty even when nothing is configured.
 *
 * @return array<int,array<string,string>>
 */
function xinaide_cloud_get_socials() {
	$socials = array();
	$links   = array(
		'github'   => array( 'GitHub', 'social_github' ),
		'telegram' => array( 'Telegram', 'social_telegram' ),
		'weibo'    => array( '微博', 'social_weibo' ),
		'bilibili' => array( 'Bilibili', 'social_bilibili' ),
		'x'        => array( 'X', 'social_x' ),
		'youtube'  => array( 'YouTube', 'social_youtube' ),
	);
	foreach ( $links as $key => $link ) {
		$url = xinaide_cloud_get_option( $link[1] );
		if ( $url ) {
			$socials[] = array( 'key' => $key, 'label' => $link[0], 'type' => 'link', 'href' => esc_url_raw( $url ), 'tip' => $link[0] );
		}
	}
	$email = xinaide_cloud_get_option( 'social_email' );
	if ( $email ) {
		$socials[] = array( 'key' => 'email', 'label' => '邮箱', 'type' => 'copy', 'value' => $email, 'tip' => $email, 'href' => 'mailto:' . antispambot( $email ) );
	}
	$wechat = xinaide_cloud_get_option( 'social_wechat' );
	if ( $wechat ) {
		$socials[] = array( 'key' => 'wechat', 'label' => '微信', 'type' => 'copy', 'value' => $wechat, 'tip' => '微信号：' . $wechat );
	}
	$qq = xinaide_cloud_get_option( 'social_qq' );
	if ( $qq ) {
		$socials[] = array( 'key' => 'qq', 'label' => 'QQ', 'type' => 'copy', 'value' => $qq, 'tip' => 'QQ：' . $qq );
	}
	if ( xinaide_cloud_option_enabled( 'show_rss' ) ) {
		$socials[] = array( 'key' => 'rss', 'label' => 'RSS', 'type' => 'link', 'href' => esc_url_raw( get_bloginfo( 'rss2_url' ) ), 'tip' => '订阅 RSS' );
	}
	return apply_filters( 'xinaide_cloud_socials', $socials );
}

/**
 * Inline SVG icon for a social channel.
 *
 * @param string $key Social channel key.
 * @return string SVG markup.
 */
function xinaide_cloud_social_icon( $key ) {
	$paths = array(
		'github'   => '<path d="M12 .5C5.65.5.5 5.65.5 12c0 5.08 3.29 9.39 7.86 10.91.58.11.79-.25.79-.55v-2.17c-3.2.7-3.87-1.36-3.87-1.36-.52-1.33-1.28-1.68-1.28-1.68-1.05-.71.08-.7.08-.7 1.16.08 1.77 1.19 1.77 1.19 1.03 1.76 2.7 1.25 3.36.96.1-.75.4-1.26.72-1.55-2.55-.29-5.23-1.28-5.23-5.68 0-1.26.45-2.28 1.19-3.09-.12-.29-.52-1.46.11-3.05 0 0 .97-.31 3.18 1.18a11.1 11.1 0 0 1 5.8 0c2.2-1.49 3.17-1.18 3.17-1.18.63 1.59.23 2.76.12 3.05.74.81 1.18 1.83 1.18 3.09 0 4.41-2.69 5.38-5.25 5.67.41.36.78 1.05.78 2.13v3.16c0 .3.2.67.8.55A11.51 11.51 0 0 0 23.5 12C23.5 5.65 18.35.5 12 .5Z"/>',
		'telegram' => '<path d="M23.9 3.6 20.3 20.6c-.27 1.2-.98 1.5-1.98.93l-5.48-4.04-2.64 2.55c-.3.3-.54.54-1.1.54l.39-5.53L19.6 5.9c.44-.39-.1-.61-.68-.22L6.46 13.9.99 12.2c-1.19-.37-1.21-1.19.25-1.76L22.5 2.35c.99-.36 1.86.22 1.4 1.25Z"/>',
		'weibo'    => '<path d="M10.1 20.9c-3.9.4-7.2-1.3-7.5-3.9-.3-2.5 2.7-4.9 6.6-5.3 3.9-.4 7.2 1.3 7.5 3.9.3 2.5-2.7 4.9-6.6 5.3Zm4.4-3.1c-.2 1.6-2.3 2.9-4.7 2.9-2.4.1-4.4-1.1-4.2-2.7.2-1.6 2.3-2.9 4.7-2.9s4.4 1.1 4.2 2.7Zm-3.1.3c-.9-.1-1.9.3-2.1 1-.2.7.5 1.3 1.4 1.4.9.1 1.9-.3 2.1-1 .2-.7-.5-1.3-1.4-1.4Zm-.8.4c-.3 0-.5.2-.6.4 0 .2.2.4.5.4.3 0 .5-.2.6-.4 0-.2-.2-.4-.5-.4Zm7.2-3.2c-.4.1-.8-.2-.9-.6-.3-1.1-1.4-1.8-2.5-1.5-.4.1-.8-.2-.9-.6-.1-.4.2-.8.6-.9 2-.5 3.9.8 4.4 2.8.1.4-.2.8-.7.8Zm2.3-1c-.4.1-.8-.2-.9-.6-.6-2.3-2.9-3.7-5.2-3.1-.4.1-.8-.2-.9-.6-.1-.4.2-.8.6-.9 3.1-.8 6.2 1.1 7 4.2.1.4-.2.8-.6 1Zm-6.2 5.3c-2.3 2.4-5.9 3.1-8.1 1.5-2.1-1.5-2.3-4.5-.5-6.9-.4.1-.8.3-1.2.5-2.3 1.3-3.2 3.7-2.1 5.5 1.2 1.9 4.1 2.2 6.6.9 1.6-.8 2.9-2.1 3.6-3.6.6-.3 1.2-.7 1.7-1.1.2.4.2.9 0 1.2Z"/>',
		'bilibili' => '<path d="M6.3 3.2c.3-.3.8-.3 1.1 0L9 4.8h6L16.6 3.2c.3-.3.8-.3 1.1 0 .3.3.3.8 0 1.1l-.8.8h1.3c1.9 0 3.4 1.5 3.4 3.4v8.9c0 1.9-1.5 3.4-3.4 3.4H5.8c-1.9 0-3.4-1.5-3.4-3.4V8.5c0-1.9 1.5-3.4 3.4-3.4h1.3l-.8-.8c-.3-.3-.3-.8 0-1.1ZM5.8 6.7c-1 0-1.8.8-1.8 1.8v8.9c0 1 .8 1.8 1.8 1.8h12.4c1 0 1.8-.8 1.8-1.8V8.5c0-1-.8-1.8-1.8-1.8H5.8Zm3 3.9c.5 0 .9.4.9.9v1.8c0 .5-.4.9-.9.9s-.9-.4-.9-.9v-1.8c0-.5.4-.9.9-.9Zm6.4 0c.5 0 .9.4.9.9v1.8c0 .5-.4.9-.9.9s-.9-.4-.9-.9v-1.8c0-.5.4-.9.9-.9Z"/>',
		'x'        => '<path d="M18.9 1.2h3.7l-8.1 9.3L24 23.2h-7.5l-5.9-7.7-6.7 7.7H.2l8.7-9.9L0 1.2h7.7l5.3 7 5.9-7Zm-1.3 19.8h2L6.6 3.3h-2.2l13.2 17.7Z"/>',
		'youtube'  => '<path d="M23.5 6.2a3 3 0 0 0-2.1-2.1C19.5 3.5 12 3.5 12 3.5s-7.5 0-9.4.6A3 3 0 0 0 .5 6.2 31.3 31.3 0 0 0 0 12a31.3 31.3 0 0 0 .5 5.8 3 3 0 0 0 2.1 2.1c1.9.6 9.4.6 9.4.6s7.5 0 9.4-.6a3 3 0 0 0 2.1-2.1A31.3 31.3 0 0 0 24 12a31.3 31.3 0 0 0-.5-5.8ZM9.5 15.6V8.4L15.8 12l-6.3 3.6Z"/>',
		'email'    => '<path d="M2.4 4.5h19.2c.5 0 .9.4.9.9v13.2c0 .5-.4.9-.9.9H2.4c-.5 0-.9-.4-.9-.9V5.4c0-.5.4-.9.9-.9Zm9.6 7.7L3.3 6.3v11.9h17.4V6.3L12 12.2Zm-7.5-6h15L12 10.4 4.5 6.2Z"/>',
		'wechat'   => '<path d="M9.3 3.5C5.2 3.5 1.9 6.3 1.9 9.7c0 1.9 1 3.6 2.7 4.8l-.7 2.1 2.4-1.2c.6.2 1.2.3 1.9.4-.1-.4-.2-.9-.2-1.4 0-3.3 3.2-6 7.1-6 .3 0 .6 0 .9.1-.6-2.8-3.5-5-6.7-5Zm-2.7 3.6c.5 0 .9.4.9.9s-.4.9-.9.9-.9-.4-.9-.9.4-.9.9-.9Zm5.4 0c.5 0 .9.4.9.9s-.4.9-.9.9-.9-.4-.9-.9.4-.9.9-.9Zm10.1 7.3c0-2.8-2.8-5.1-6.2-5.1s-6.2 2.3-6.2 5.1 2.8 5.1 6.2 5.1c.7 0 1.4-.1 2-.3l2 1-.6-1.7c1.7-1 2.8-2.5 2.8-4.1Zm-8.3-.9c-.4 0-.8-.3-.8-.8s.4-.8.8-.8.8.3.8.8-.4.8-.8.8Zm4.1 0c-.4 0-.8-.3-.8-.8s.4-.8.8-.8.8.3.8.8-.3.8-.8.8Z"/>',
		'qq'       => '<path d="M12 2.5c-3 0-5.4 2.3-5.4 5.5 0 .3 0 .6.1.9-.5.9-1.2 2.3-1.2 3.6 0 .4.4.6.7.3.3-.2.6-.7.9-1.1.3 1.5 1.2 2.9 2.4 3.7-.9.3-1.9.7-2.4 1-.6.3-.8.8-.4 1.2.6.6 2.1 1 3.3 1 .9 0 1.6-.3 2-.6.4.3 1.1.6 2 .6 1.2 0 2.7-.4 3.3-1 .4-.4.2-.9-.4-1.2-.5-.3-1.5-.7-2.4-1 1.2-.8 2.1-2.2 2.4-3.7.3.4.6.9.9 1.1.3.3.7.1.7-.3 0-1.3-.7-2.7-1.2-3.6.1-.3.1-.6.1-.9 0-3.2-2.4-5.5-5.4-5.5Z"/>',
		'rss'      => '<path d="M4 4.4v3.1c6.9 0 12.5 5.6 12.5 12.5h3.1C19.6 11.3 12.7 4.4 4 4.4Zm0 6.2v3.1c3.5 0 6.3 2.8 6.3 6.3h3.1c0-5.2-4.2-9.4-9.4-9.4ZM6.2 16a2.2 2.2 0 1 0 0 4.4 2.2 2.2 0 0 0 0-4.4Z"/>',
	);
	$path = isset( $paths[ $key ] ) ? $paths[ $key ] : '<circle cx="12" cy="12" r="9"/>';
	return '<svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor" aria-hidden="true" focusable="false">' . $path . '</svg>';
}
