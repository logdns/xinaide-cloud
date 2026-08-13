<?php
/**
 * Theme options page for xinaide-cloud.
 *
 * @package xinaide-cloud
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function xinaide_cloud_option_defaults() {
	return array(
		'accent_color'           => '#18a88f',
		'heading_color'          => '#102a30',
		'max_width'              => 1320,
		'sidebar_width'          => 340,
		'card_radius'            => 16,
		'header_style'           => 'dark',
		'sidebar_position'       => 'right',
		'sticky_header'          => 1,
		'show_home_hero'         => 1,
		'hero_eyebrow'           => 'XINAI.DE · PRIVATE DIGITAL GARDEN',
		'hero_title'             => "在折腾里，\n记录世界。",
		'hero_text'              => '技术、生活与跨境实践，一个持续更新的私人知识花园。',
		'hero_background'        => '',
		'hero_height'            => 580,
		'hero_overlay'           => 46,
		'hero_primary_text'      => '开始阅读',
		'hero_primary_url'       => '#latest-posts',
		'hero_secondary_text'    => '关于小沨',
		'hero_secondary_url'     => '/about',
		'hero_stat_one_value'    => '16+',
		'hero_stat_one_label'    => '年持续记录',
		'hero_stat_two_value'    => '640+',
		'hero_stat_two_label'    => '篇内容沉淀',
		'hero_stat_three_value'  => '生活 × 技术',
		'hero_stat_three_label'  => '长期主义',
		'show_author'            => 1,
		'show_date'              => 1,
		'show_reading_time'      => 1,
		'show_comments'          => 1,
		'show_views'             => 1,
		'show_likes'             => 1,
		'show_breadcrumbs'       => 1,
		'show_toc'               => 1,
		'excerpt_length'         => 180,
		'title_only_search'      => 0,
		'default_cover'          => '',
		'show_profile_card'      => 1,
		'profile_title'          => '你好，我是小沨',
		'profile_text'           => '一个喜欢把技术折腾、生活经验和实用教程写下来的 80 后。',
		'profile_avatar'         => '',
		'profile_button_text'    => '了解更多',
		'profile_button_url'     => '/about',
		'contact_qr'             => '',
		'contact_title'          => '联系我',
		'footer_kicker'          => 'XINAI.DE · SINCE 2009',
		'footer_heading'         => '把折腾写成答案。',
		'footer_text'            => '记录技术、生活和一路踩过的坑，也希望这里的内容能帮到你。',
		'footer_copyright'       => '',
		'footer_icp'             => '',
		'footer_gov'             => '',
		'footer_gov_url'         => '',
		'social_github'          => 'https://github.com/logdns',
		'social_telegram'        => 'https://t.me/giffgaffbuy',
		'social_weibo'           => 'https://weibo.com/4346835',
		'social_bilibili'        => '',
		'social_x'               => 'https://twitter.com/logdns',
		'social_youtube'         => 'https://www.youtube.com/@xtom',
		'social_email'           => '270473446@qq.com',
		'social_wechat'          => '',
		'social_qq'              => '',
		'show_rss'               => 1,
		'show_uptime'            => 1,
		'site_launch_date'       => '2009-11-07',
		'show_status'            => 1,
		'status_url'             => 'https://status.xinai.de/',
		'status_text'            => '服务器运行状态',
		'seo_keywords'           => '',
		'seo_description'        => '',
		'share_image'            => '',
		'custom_css'             => '',
	);
}

function xinaide_cloud_get_options() {
	$options = get_option( 'xinaide_cloud_options', array() );
	return wp_parse_args( is_array( $options ) ? $options : array(), xinaide_cloud_option_defaults() );
}

function xinaide_cloud_get_option( $key ) {
	$options = xinaide_cloud_get_options();
	return isset( $options[ $key ] ) ? $options[ $key ] : '';
}

function xinaide_cloud_option_enabled( $key ) {
	return (bool) xinaide_cloud_get_option( $key );
}

function xinaide_cloud_sanitize_options( $input ) {
	$defaults = xinaide_cloud_option_defaults();
	$output   = array();
	$checks   = array( 'sticky_header', 'show_home_hero', 'show_author', 'show_date', 'show_reading_time', 'show_comments', 'show_views', 'show_likes', 'show_breadcrumbs', 'show_toc', 'title_only_search', 'show_profile_card', 'show_rss', 'show_uptime', 'show_status' );
	$urls     = array( 'hero_background', 'hero_primary_url', 'hero_secondary_url', 'profile_avatar', 'profile_button_url', 'contact_qr', 'default_cover', 'footer_gov_url', 'social_github', 'social_telegram', 'social_weibo', 'social_bilibili', 'social_x', 'social_youtube', 'status_url', 'share_image' );
	$textarea = array( 'hero_title', 'hero_text', 'profile_text', 'footer_text', 'custom_css' );
	$numbers  = array( 'max_width', 'sidebar_width', 'card_radius', 'hero_height', 'hero_overlay', 'excerpt_length' );

	foreach ( $defaults as $key => $default ) {
		$value = isset( $input[ $key ] ) ? $input[ $key ] : '';
		if ( in_array( $key, $checks, true ) ) {
			$output[ $key ] = empty( $value ) ? 0 : 1;
		} elseif ( in_array( $key, $urls, true ) ) {
			$output[ $key ] = ( 0 === strpos( (string) $value, '#' ) ) ? sanitize_text_field( $value ) : esc_url_raw( $value );
		} elseif ( in_array( $key, $textarea, true ) ) {
			$output[ $key ] = 'custom_css' === $key ? wp_strip_all_tags( $value ) : sanitize_textarea_field( $value );
		} elseif ( in_array( $key, $numbers, true ) ) {
			$output[ $key ] = absint( $value );
		} elseif ( 'accent_color' === $key || 'heading_color' === $key ) {
			$output[ $key ] = sanitize_hex_color( $value ) ?: $default;
		} elseif ( 'header_style' === $key ) {
			$output[ $key ] = in_array( $value, array( 'dark', 'light', 'glass' ), true ) ? $value : $default;
		} elseif ( 'sidebar_position' === $key ) {
			$output[ $key ] = in_array( $value, array( 'right', 'left' ), true ) ? $value : $default;
		} else {
			$output[ $key ] = sanitize_text_field( $value );
		}
	}

	return $output;
}

function xinaide_cloud_register_options() {
	register_setting(
		'xinaide_cloud_options_group',
		'xinaide_cloud_options',
		array(
			'type'              => 'array',
			'sanitize_callback' => 'xinaide_cloud_sanitize_options',
			'default'           => xinaide_cloud_option_defaults(),
		)
	);
}
add_action( 'admin_init', 'xinaide_cloud_register_options' );

function xinaide_cloud_options_menu() {
	add_theme_page(
		__( 'Xinaide Cloud 设置', 'xinaide-cloud' ),
		__( 'Xinaide Cloud', 'xinaide-cloud' ),
		'edit_theme_options',
		'xinaide-cloud-options',
		'xinaide_cloud_options_page'
	);
}
add_action( 'admin_menu', 'xinaide_cloud_options_menu' );

function xinaide_cloud_options_assets( $hook ) {
	if ( 'appearance_page_xinaide-cloud-options' !== $hook ) {
		return;
	}
	wp_enqueue_media();
	wp_enqueue_style( 'xinaide-cloud-admin', get_template_directory_uri() . '/assets/admin/options.css', array(), XINAIDE_CLOUD_VERSION );
	wp_enqueue_script( 'xinaide-cloud-admin', get_template_directory_uri() . '/assets/admin/options.js', array( 'jquery' ), XINAIDE_CLOUD_VERSION, true );
}
add_action( 'admin_enqueue_scripts', 'xinaide_cloud_options_assets' );

function xinaide_cloud_options_page() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}
	$options = xinaide_cloud_get_options();
	?>
	<div class="wrap xinaide-options">
		<header class="xinaide-options-hero">
			<div><span>XINAIDE.DE</span><h1><?php esc_html_e( 'Xinaide Cloud 主题控制台', 'xinaide-cloud' ); ?></h1><p><?php esc_html_e( '品牌、首页、阅读体验和页脚内容都可以在这里统一设置。', 'xinaide-cloud' ); ?></p></div>
			<a class="button button-secondary" href="<?php echo esc_url( home_url( '/' ) ); ?>" target="_blank" rel="noopener"><?php esc_html_e( '打开网站', 'xinaide-cloud' ); ?> ↗</a>
		</header>
		<?php settings_errors(); ?>
		<form method="post" action="options.php">
			<?php settings_fields( 'xinaide_cloud_options_group' ); ?>
			<div class="xinaide-options-grid">
				<?php xinaide_cloud_options_brand_panel( $options ); ?>
				<?php xinaide_cloud_options_hero_panel( $options ); ?>
				<?php xinaide_cloud_options_article_panel( $options ); ?>
				<?php xinaide_cloud_options_sidebar_panel( $options ); ?>
				<?php xinaide_cloud_options_footer_panel( $options ); ?>
				<?php xinaide_cloud_options_advanced_panel( $options ); ?>
			</div>
			<div class="xinaide-save-bar"><p><?php esc_html_e( '保存后刷新前台即可看到变化。', 'xinaide-cloud' ); ?></p><?php submit_button( __( '保存主题设置', 'xinaide-cloud' ), 'primary', 'submit', false ); ?></div>
		</form>
	</div>
	<?php
}

function xinaide_cloud_field( $options, $key, $label, $type = 'text', $description = '', $choices = array() ) {
	$value = isset( $options[ $key ] ) ? $options[ $key ] : '';
	$name  = 'xinaide_cloud_options[' . $key . ']';
	?>
	<div class="xinaide-field xinaide-field-<?php echo esc_attr( $type ); ?>">
		<label for="xinaide-<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></label>
		<?php if ( 'textarea' === $type ) : ?>
			<textarea id="xinaide-<?php echo esc_attr( $key ); ?>" name="<?php echo esc_attr( $name ); ?>" rows="4"><?php echo esc_textarea( $value ); ?></textarea>
		<?php elseif ( 'checkbox' === $type ) : ?>
			<label class="xinaide-switch"><input id="xinaide-<?php echo esc_attr( $key ); ?>" type="checkbox" name="<?php echo esc_attr( $name ); ?>" value="1" <?php checked( $value, 1 ); ?>><span></span><em><?php echo $value ? esc_html__( '已开启', 'xinaide-cloud' ) : esc_html__( '可开启', 'xinaide-cloud' ); ?></em></label>
		<?php elseif ( 'select' === $type ) : ?>
			<select id="xinaide-<?php echo esc_attr( $key ); ?>" name="<?php echo esc_attr( $name ); ?>"><?php foreach ( $choices as $choice_value => $choice_label ) : ?><option value="<?php echo esc_attr( $choice_value ); ?>" <?php selected( $value, $choice_value ); ?>><?php echo esc_html( $choice_label ); ?></option><?php endforeach; ?></select>
		<?php elseif ( 'image' === $type ) : ?>
			<div class="xinaide-media-field"><input id="xinaide-<?php echo esc_attr( $key ); ?>" type="url" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $value ); ?>"><button type="button" class="button xinaide-media-button" data-target="xinaide-<?php echo esc_attr( $key ); ?>"><?php esc_html_e( '选择图片', 'xinaide-cloud' ); ?></button></div><div class="xinaide-media-preview"><?php if ( $value ) : ?><img src="<?php echo esc_url( $value ); ?>" alt=""><?php endif; ?></div>
		<?php else : ?>
			<input id="xinaide-<?php echo esc_attr( $key ); ?>" type="<?php echo esc_attr( $type ); ?>" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $value ); ?>">
		<?php endif; ?>
		<?php if ( $description ) : ?><p class="description"><?php echo esc_html( $description ); ?></p><?php endif; ?>
	</div>
	<?php
}

function xinaide_cloud_panel_open( $icon, $title, $description ) {
	echo '<section class="xinaide-option-card"><header><span>' . esc_html( $icon ) . '</span><div><h2>' . esc_html( $title ) . '</h2><p>' . esc_html( $description ) . '</p></div></header><div class="xinaide-option-card-body">';
}

function xinaide_cloud_panel_close() {
	echo '</div></section>';
}

function xinaide_cloud_options_brand_panel( $o ) {
	xinaide_cloud_panel_open( '◈', '品牌与版式', '控制整站的视觉骨架和导航气质。' );
	xinaide_cloud_field( $o, 'accent_color', '品牌色', 'color' );
	xinaide_cloud_field( $o, 'heading_color', '标题颜色', 'color' );
	xinaide_cloud_field( $o, 'max_width', '内容最大宽度（px）', 'number', '推荐 1280–1400。' );
	xinaide_cloud_field( $o, 'sidebar_width', '侧栏宽度（px）', 'number' );
	xinaide_cloud_field( $o, 'card_radius', '卡片圆角（px）', 'number' );
	xinaide_cloud_field( $o, 'header_style', '页头风格', 'select', '', array( 'dark' => '深色大气', 'light' => '明亮简洁', 'glass' => '透明玻璃' ) );
	xinaide_cloud_field( $o, 'sidebar_position', '侧栏位置', 'select', '', array( 'right' => '右侧', 'left' => '左侧' ) );
	xinaide_cloud_field( $o, 'sticky_header', '吸顶导航', 'checkbox' );
	xinaide_cloud_panel_close();
}

function xinaide_cloud_options_hero_panel( $o ) {
	xinaide_cloud_panel_open( '▰', '首页横幅', '延续原站水景记忆，升级为沉浸式大横幅。' );
	xinaide_cloud_field( $o, 'show_home_hero', '显示首页横幅', 'checkbox' );
	xinaide_cloud_field( $o, 'hero_eyebrow', '横幅眉题' );
	xinaide_cloud_field( $o, 'hero_title', '横幅大标题', 'textarea', '支持换行。' );
	xinaide_cloud_field( $o, 'hero_text', '横幅说明', 'textarea' );
	xinaide_cloud_field( $o, 'hero_background', '横幅背景图', 'image', '留空时使用主题内置的原站水景图。' );
	xinaide_cloud_field( $o, 'hero_height', '横幅高度（px）', 'number' );
	xinaide_cloud_field( $o, 'hero_overlay', '深色遮罩（20–85）', 'number' );
	xinaide_cloud_field( $o, 'hero_primary_text', '主按钮文字' );
	xinaide_cloud_field( $o, 'hero_primary_url', '主按钮链接', 'url' );
	xinaide_cloud_field( $o, 'hero_secondary_text', '次按钮文字' );
	xinaide_cloud_field( $o, 'hero_secondary_url', '次按钮链接', 'url' );
	for ( $i = 1; $i <= 3; $i++ ) {
		$key = array( 1 => 'one', 2 => 'two', 3 => 'three' )[ $i ];
		xinaide_cloud_field( $o, 'hero_stat_' . $key . '_value', '数据 ' . $i . ' 数值' );
		xinaide_cloud_field( $o, 'hero_stat_' . $key . '_label', '数据 ' . $i . ' 说明' );
	}
	xinaide_cloud_panel_close();
}

function xinaide_cloud_options_article_panel( $o ) {
	xinaide_cloud_panel_open( '¶', '文章阅读体验', '决定文章标题区、信息与自动目录的显示。' );
	xinaide_cloud_field( $o, 'show_author', '显示作者', 'checkbox' );
	xinaide_cloud_field( $o, 'show_date', '显示发布日期', 'checkbox' );
	xinaide_cloud_field( $o, 'show_reading_time', '显示阅读时长', 'checkbox' );
	xinaide_cloud_field( $o, 'show_comments', '显示评论数', 'checkbox' );
	xinaide_cloud_field( $o, 'show_views', '显示热度', 'checkbox', '兼容 Kratos 的 views 文章字段。' );
	xinaide_cloud_field( $o, 'show_likes', '显示点赞', 'checkbox', '兼容 Kratos 的 love 文章字段。' );
	xinaide_cloud_field( $o, 'show_breadcrumbs', '显示面包屑', 'checkbox' );
	xinaide_cloud_field( $o, 'show_toc', '文章自动目录', 'checkbox', '正文含两个以上二级/三级标题时自动生成。' );
	xinaide_cloud_field( $o, 'excerpt_length', '列表摘要长度', 'number' );
	xinaide_cloud_field( $o, 'title_only_search', '搜索仅匹配标题', 'checkbox' );
	xinaide_cloud_field( $o, 'default_cover', '默认文章封面', 'image', '正文和特色图片都为空时使用。' );
	xinaide_cloud_panel_close();
}

function xinaide_cloud_options_sidebar_panel( $o ) {
	xinaide_cloud_panel_open( '◎', '侧栏与联系', '把站长介绍、头像和联系二维码放进侧栏。' );
	xinaide_cloud_field( $o, 'show_profile_card', '显示站长介绍卡', 'checkbox' );
	xinaide_cloud_field( $o, 'profile_title', '介绍标题' );
	xinaide_cloud_field( $o, 'profile_text', '介绍内容', 'textarea' );
	xinaide_cloud_field( $o, 'profile_avatar', '头像', 'image' );
	xinaide_cloud_field( $o, 'profile_button_text', '介绍按钮文字' );
	xinaide_cloud_field( $o, 'profile_button_url', '介绍按钮链接', 'url' );
	xinaide_cloud_field( $o, 'contact_title', '二维码标题' );
	xinaide_cloud_field( $o, 'contact_qr', '联系二维码', 'image' );
	xinaide_cloud_panel_close();
}

function xinaide_cloud_options_footer_panel( $o ) {
	xinaide_cloud_panel_open( '↘', '页脚与社交', '品牌说明、社交渠道与备案信息，前台自动以图标形式展示。' );
	xinaide_cloud_field( $o, 'footer_kicker', '页脚眉题', 'text', '显示在主标题上方的小字，如 XINAI.DE · SINCE 2009。' );
	xinaide_cloud_field( $o, 'footer_heading', '页脚主标题' );
	xinaide_cloud_field( $o, 'footer_text', '页脚说明', 'textarea' );
	xinaide_cloud_field( $o, 'social_github', 'GitHub 链接', 'url' );
	xinaide_cloud_field( $o, 'social_telegram', 'Telegram 链接', 'url' );
	xinaide_cloud_field( $o, 'social_weibo', '微博链接', 'url' );
	xinaide_cloud_field( $o, 'social_bilibili', 'Bilibili 链接', 'url' );
	xinaide_cloud_field( $o, 'social_x', 'X (Twitter) 链接', 'url' );
	xinaide_cloud_field( $o, 'social_youtube', 'YouTube 链接', 'url' );
	xinaide_cloud_field( $o, 'social_email', '联系邮箱', 'email', '前台点击即可复制。' );
	xinaide_cloud_field( $o, 'social_wechat', '微信号', 'text', '填写微信号，前台点击复制。' );
	xinaide_cloud_field( $o, 'social_qq', 'QQ 号', 'text', '填写 QQ 号，前台点击复制。' );
	xinaide_cloud_field( $o, 'show_rss', '显示 RSS 订阅入口', 'checkbox', '自动生成站点 RSS 地址，无需填写链接。' );
	xinaide_cloud_field( $o, 'show_uptime', '显示网站运行时间', 'checkbox', '页脚显示「网站运行：X年X天X时X分X秒」实时计时。' );
	xinaide_cloud_field( $o, 'site_launch_date', '建站日期', 'text', '格式 YYYY-MM-DD，按 UTC+8 计时，如 2009-11-07。' );
	xinaide_cloud_field( $o, 'show_status', '显示服务器状态入口', 'checkbox', '页脚显示服务器运行状态链接。' );
	xinaide_cloud_field( $o, 'status_url', '服务器状态页链接', 'url', '如 Uptime Kuma 状态页地址。' );
	xinaide_cloud_field( $o, 'status_text', '状态入口文字', 'text', '默认为「服务器运行状态」。' );
	xinaide_cloud_field( $o, 'footer_copyright', '自定义版权文字', 'text', '留空时自动显示年份和站点名称。' );
	xinaide_cloud_field( $o, 'footer_icp', '备案/补充信息' );
	xinaide_cloud_field( $o, 'footer_gov', '公安备案号' );
	xinaide_cloud_field( $o, 'footer_gov_url', '公安备案链接', 'url' );
	xinaide_cloud_panel_close();
}

function xinaide_cloud_options_advanced_panel( $o ) {
	xinaide_cloud_panel_open( '{ }', '高级设置', '为熟悉 CSS 的站长保留最后一层自由度。' );
	xinaide_cloud_field( $o, 'seo_keywords', '首页关键词', 'text', '使用英文逗号分隔。' );
	xinaide_cloud_field( $o, 'seo_description', '首页 SEO 描述', 'textarea' );
	xinaide_cloud_field( $o, 'share_image', '社交分享图片', 'image' );
	xinaide_cloud_field( $o, 'custom_css', '自定义 CSS', 'textarea', '直接输出到前台，请只填写 CSS。' );
	xinaide_cloud_panel_close();
}
