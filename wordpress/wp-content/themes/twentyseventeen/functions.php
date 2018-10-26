<?php
/**
 * Twenty Seventeen functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 */

/**
 * Twenty Seventeen only works in WordPress 4.7 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.7-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
	return;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function twentyseventeen_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/twentyseventeen
	 * If you're building a theme based on Twenty Seventeen, use a find and replace
	 * to change 'twentyseventeen' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'twentyseventeen' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	add_image_size( 'twentyseventeen-featured-image', 2000, 1200, true );

	add_image_size( 'twentyseventeen-thumbnail-avatar', 100, 100, true );

	// Set the default content width.
	$GLOBALS['content_width'] = 525;

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'top'    => __( 'Top Menu', 'twentyseventeen' ),
		'social' => __( 'Social Links Menu', 'twentyseventeen' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'audio',
	) );

	// Add theme support for Custom Logo.
	add_theme_support( 'custom-logo', array(
		'width'       => 250,
		'height'      => 250,
		'flex-width'  => true,
	) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, and column width.
 	 */
	add_editor_style( array( 'assets/css/editor-style.css', twentyseventeen_fonts_url() ) );

	// Define and register starter content to showcase the theme on new sites.
	$starter_content = array(
		'widgets' => array(
			// Place three core-defined widgets in the sidebar area.
			'sidebar-1' => array(
				'text_business_info',
				'search',
				'text_about',
			),

			// Add the core-defined business info widget to the footer 1 area.
			'sidebar-2' => array(
				'text_business_info',
			),

			// Put two core-defined widgets in the footer 2 area.
			'sidebar-3' => array(
				'text_about',
				'search',
			),
		),

		// Specify the core-defined pages to create and add custom thumbnails to some of them.
		'posts' => array(
			'home',
			'about' => array(
				'thumbnail' => '{{image-sandwich}}',
			),
			'contact' => array(
				'thumbnail' => '{{image-espresso}}',
			),
			'blog' => array(
				'thumbnail' => '{{image-coffee}}',
			),
			'homepage-section' => array(
				'thumbnail' => '{{image-espresso}}',
			),
		),

		// Create the custom image attachments used as post thumbnails for pages.
		'attachments' => array(
			'image-espresso' => array(
				'post_title' => _x( 'Espresso', 'Theme starter content', 'twentyseventeen' ),
				'file' => 'assets/images/espresso.jpg', // URL relative to the template directory.
			),
			'image-sandwich' => array(
				'post_title' => _x( 'Sandwich', 'Theme starter content', 'twentyseventeen' ),
				'file' => 'assets/images/sandwich.jpg',
			),
			'image-coffee' => array(
				'post_title' => _x( 'Coffee', 'Theme starter content', 'twentyseventeen' ),
				'file' => 'assets/images/coffee.jpg',
			),
		),

		// Default to a static front page and assign the front and posts pages.
		'options' => array(
			'show_on_front' => 'page',
			'page_on_front' => '{{home}}',
			'page_for_posts' => '{{blog}}',
		),

		// Set the front page section theme mods to the IDs of the core-registered pages.
		'theme_mods' => array(
			'panel_1' => '{{homepage-section}}',
			'panel_2' => '{{about}}',
			'panel_3' => '{{blog}}',
			'panel_4' => '{{contact}}',
		),

		// Set up nav menus for each of the two areas registered in the theme.
		'nav_menus' => array(
			// Assign a menu to the "top" location.
			'top' => array(
				'name' => __( 'Top Menu', 'twentyseventeen' ),
				'items' => array(
					'link_home', // Note that the core "home" page is actually a link in case a static front page is not used.
					'page_about',
					'page_blog',
					'page_contact',
				),
			),

			// Assign a menu to the "social" location.
			'social' => array(
				'name' => __( 'Social Links Menu', 'twentyseventeen' ),
				'items' => array(
					'link_yelp',
					'link_facebook',
					'link_twitter',
					'link_instagram',
					'link_email',
				),
			),
		),
	);

	/**
	 * Filters Twenty Seventeen array of starter content.
	 *
	 * @since Twenty Seventeen 1.1
	 *
	 * @param array $starter_content Array of starter content.
	 */
	$starter_content = apply_filters( 'twentyseventeen_starter_content', $starter_content );

	add_theme_support( 'starter-content', $starter_content );
}
add_action( 'after_setup_theme', 'twentyseventeen_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function twentyseventeen_content_width() {

	$content_width = $GLOBALS['content_width'];

	// Get layout.
	$page_layout = get_theme_mod( 'page_layout' );

	// Check if layout is one column.
	if ( 'one-column' === $page_layout ) {
		if ( twentyseventeen_is_frontpage() ) {
			$content_width = 644;
		} elseif ( is_page() ) {
			$content_width = 740;
		}
	}

	// Check if is single post and there is no sidebar.
	if ( is_single() && ! is_active_sidebar( 'sidebar-1' ) ) {
		$content_width = 740;
	}

	/**
	 * Filter Twenty Seventeen content width of the theme.
	 *
	 * @since Twenty Seventeen 1.0
	 *
	 * @param int $content_width Content width in pixels.
	 */
	$GLOBALS['content_width'] = apply_filters( 'twentyseventeen_content_width', $content_width );
}
add_action( 'template_redirect', 'twentyseventeen_content_width', 0 );

/**
 * Register custom fonts.
 */
function twentyseventeen_fonts_url() {
	$fonts_url = '';

	/*
	 * Translators: If there are characters in your language that are not
	 * supported by Libre Franklin, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$libre_franklin = _x( 'on', 'Libre Franklin font: on or off', 'twentyseventeen' );

	if ( 'off' !== $libre_franklin ) {
		$font_families = array();

		$font_families[] = 'Libre Franklin:300,300i,400,400i,600,600i,800,800i';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

/**
 * Add preconnect for Google Fonts.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function twentyseventeen_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'twentyseventeen-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'twentyseventeen_resource_hints', 10, 2 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function twentyseventeen_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Blog Sidebar', 'twentyseventeen' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'twentyseventeen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 1', 'twentyseventeen' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Add widgets here to appear in your footer.', 'twentyseventeen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 2', 'twentyseventeen' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Add widgets here to appear in your footer.', 'twentyseventeen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'twentyseventeen_widgets_init' );

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
 * a 'Continue reading' link.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $link Link to single post/page.
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
function twentyseventeen_excerpt_more( $link ) {
	if ( is_admin() ) {
		return $link;
	}

	$link = sprintf( '<p class="link-more"><a href="%1$s" class="more-link">%2$s</a></p>',
		esc_url( get_permalink( get_the_ID() ) ),
		/* translators: %s: Name of current post */
		sprintf( __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'twentyseventeen' ), get_the_title( get_the_ID() ) )
	);
	return ' &hellip; ' . $link;
}
add_filter( 'excerpt_more', 'twentyseventeen_excerpt_more' );

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Twenty Seventeen 1.0
 */
function twentyseventeen_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'twentyseventeen_javascript_detection', 0 );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function twentyseventeen_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", get_bloginfo( 'pingback_url' ) );
	}
}
add_action( 'wp_head', 'twentyseventeen_pingback_header' );

/**
 * Display custom color CSS.
 */
function twentyseventeen_colors_css_wrap() {
	if ( 'custom' !== get_theme_mod( 'colorscheme' ) && ! is_customize_preview() ) {
		return;
	}

	require_once( get_parent_theme_file_path( '/inc/color-patterns.php' ) );
	$hue = absint( get_theme_mod( 'colorscheme_hue', 250 ) );
?>
	<style type="text/css" id="custom-theme-colors" <?php if ( is_customize_preview() ) { echo 'data-hue="' . $hue . '"'; } ?>>
		<?php echo twentyseventeen_custom_colors_css(); ?>
	</style>
<?php }
add_action( 'wp_head', 'twentyseventeen_colors_css_wrap' );

/**
 * Enqueue scripts and styles.
 */
function twentyseventeen_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'twentyseventeen-fonts', twentyseventeen_fonts_url(), array(), null );

	// Theme stylesheet.
	wp_enqueue_style( 'twentyseventeen-style', get_stylesheet_uri() );

	// Load the dark colorscheme.
	if ( 'dark' === get_theme_mod( 'colorscheme', 'light' ) || is_customize_preview() ) {
		wp_enqueue_style( 'twentyseventeen-colors-dark', get_theme_file_uri( '/assets/css/colors-dark.css' ), array( 'twentyseventeen-style' ), '1.0' );
	}

	// Load the Internet Explorer 9 specific stylesheet, to fix display issues in the Customizer.
	if ( is_customize_preview() ) {
		wp_enqueue_style( 'twentyseventeen-ie9', get_theme_file_uri( '/assets/css/ie9.css' ), array( 'twentyseventeen-style' ), '1.0' );
		wp_style_add_data( 'twentyseventeen-ie9', 'conditional', 'IE 9' );
	}

	// Load the Internet Explorer 8 specific stylesheet.
	wp_enqueue_style( 'twentyseventeen-ie8', get_theme_file_uri( '/assets/css/ie8.css' ), array( 'twentyseventeen-style' ), '1.0' );
	wp_style_add_data( 'twentyseventeen-ie8', 'conditional', 'lt IE 9' );

	// Load the html5 shiv.
	wp_enqueue_script( 'html5', get_theme_file_uri( '/assets/js/html5.js' ), array(), '3.7.3' );
	wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );

	wp_enqueue_script( 'twentyseventeen-skip-link-focus-fix', get_theme_file_uri( '/assets/js/skip-link-focus-fix.js' ), array(), '1.0', true );

    wp_enqueue_script( 'main', get_theme_file_uri( '/assets/js/main.js' ), array(), '1.0', true );
	$twentyseventeen_l10n = array(
		'quote'          => twentyseventeen_get_svg( array( 'icon' => 'quote-right' ) ),
	);

	if ( has_nav_menu( 'top' ) ) {
		wp_enqueue_script( 'twentyseventeen-navigation', get_theme_file_uri( '/assets/js/navigation.js' ), array( 'jquery' ), '1.0', true );
		$twentyseventeen_l10n['expand']         = __( 'Expand child menu', 'twentyseventeen' );
		$twentyseventeen_l10n['collapse']       = __( 'Collapse child menu', 'twentyseventeen' );
		$twentyseventeen_l10n['icon']           = twentyseventeen_get_svg( array( 'icon' => 'angle-down', 'fallback' => true ) );
	}

	wp_enqueue_script( 'twentyseventeen-global', get_theme_file_uri( '/assets/js/global.js' ), array( 'jquery' ), '1.0', true );

	wp_enqueue_script( 'jquery-scrollto', get_theme_file_uri( '/assets/js/jquery.scrollTo.js' ), array( 'jquery' ), '2.1.2', true );

	wp_localize_script( 'twentyseventeen-skip-link-focus-fix', 'twentyseventeenScreenReaderText', $twentyseventeen_l10n );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'twentyseventeen_scripts' );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function twentyseventeen_content_image_sizes_attr( $sizes, $size ) {
	$width = $size[0];

	if ( 740 <= $width ) {
		$sizes = '(max-width: 706px) 89vw, (max-width: 767px) 82vw, 740px';
	}

	if ( is_active_sidebar( 'sidebar-1' ) || is_archive() || is_search() || is_home() || is_page() ) {
		if ( ! ( is_page() && 'one-column' === get_theme_mod( 'page_options' ) ) && 767 <= $width ) {
			 $sizes = '(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1071px) 543px, 580px';
		}
	}

	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'twentyseventeen_content_image_sizes_attr', 10, 2 );

/**
 * Filter the `sizes` value in the header image markup.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $html   The HTML image tag markup being filtered.
 * @param object $header The custom header object returned by 'get_custom_header()'.
 * @param array  $attr   Array of the attributes for the image tag.
 * @return string The filtered header image HTML.
 */
function twentyseventeen_header_image_tag( $html, $header, $attr ) {
	if ( isset( $attr['sizes'] ) ) {
		$html = str_replace( $attr['sizes'], '100vw', $html );
	}
	return $html;
}
add_filter( 'get_header_image_tag', 'twentyseventeen_header_image_tag', 10, 3 );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param array $attr       Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size       Registered image size or flat array of height and width dimensions.
 * @return array The filtered attributes for the image markup.
 */
function twentyseventeen_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
	if ( is_archive() || is_search() || is_home() ) {
		$attr['sizes'] = '(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1071px) 543px, 580px';
	} else {
		$attr['sizes'] = '100vw';
	}

	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'twentyseventeen_post_thumbnail_sizes_attr', 10, 3 );

/**
 * Use front-page.php when Front page displays is set to a static page.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $template front-page.php.
 *
 * @return string The template to be used: blank if is_home() is true (defaults to index.php), else $template.
 */
function twentyseventeen_front_page_template( $template ) {
	return is_home() ? '' : $template;
}
add_filter( 'frontpage_template',  'twentyseventeen_front_page_template' );

/**
 * Modifies tag cloud widget arguments to display all tags in the same font size
 * and use list format for better accessibility.
 *
 * @since Twenty Seventeen 1.4
 *
 * @param array $args Arguments for tag cloud widget.
 * @return array The filtered arguments for tag cloud widget.
 */
function twentyseventeen_widget_tag_cloud_args( $args ) {
	$args['largest']  = 1;
	$args['smallest'] = 1;
	$args['unit']     = 'em';
	$args['format']   = 'list';

	return $args;
}
add_filter( 'widget_tag_cloud_args', 'twentyseventeen_widget_tag_cloud_args' );

/**
 * Implement the Custom Header feature.
 */
require get_parent_theme_file_path( '/inc/custom-header.php' );

/**
 * Custom template tags for this theme.
 */
require get_parent_theme_file_path( '/inc/template-tags.php' );

/**
 * Additional features to allow styling of the templates.
 */
require get_parent_theme_file_path( '/inc/template-functions.php' );

/**
 * Customizer additions.
 */
require get_parent_theme_file_path( '/inc/customizer.php' );

/**
 * SVG icons functions and filters.
 */
require get_parent_theme_file_path( '/inc/icon-functions.php' );


function catch_the_image( $id ) {
    // global $post, $posts;
    $first_img = '';
    // 如果设置了缩略图

    $post_thumbnail_id = get_post_thumbnail_id( $id );

    if ( $post_thumbnail_id ) {
        $output = wp_get_attachment_image_src( $post_thumbnail_id, 'large' );
        $first_img = $output[0];
    }
    else { // 没有缩略图，查找文章中的第一幅图片
        ob_start();
        ob_end_clean();
        $post = get_post($id);
        $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
        $first_img = $matches [1] [0];

        if(empty($first_img)){ // 既没有缩略图，文中也没有图，设置一幅默认的图片
            $first_img = "http://yourdomain.tld/images/default.jpg";
        }
    }

    return $first_img;
}

function get_category_root_id($cat) {
    $this_category = get_category($cat); // 取得当前分类
    while($this_category->category_parent) // 若当前分类有上级分类时，循环
    {
        $this_category = get_category($this_category->category_parent); // 将当前分类设为上级分类（往上爬
    }
    return $this_category->term_id; // 返回根分类的id号
}

function get_pagenavi( $range = 4 ,$total ,$number) {
    global $paged,$wp_query;
    $max_page = ceil(count($total)/$number);
    if ( is_singular() ) return; // 文章与插页不用
    if ( !$max_page ) {
        $max_page = $wp_query->max_num_pages;
    }
//    $max_page = count($max_page);
//    var_dump($max_page);
    if ( $max_page == 1 ) return; // 只有一页不用
//                        if ( emptyempty( $paged ) ) $paged = 1;
//    echo '<span class="pages">Page: ' . $paged . ' of ' . $max_page . ' </span> '; // 显示页数
    if ( $paged > 1 ) p_link( $paged - 1, '上一页', '«' );/* 如果当前页大于1就显示上一页链接 */
    if ( $paged > $range + 1 ) p_link( 1, '最前页' );
    if ( $paged > $range + 2 ) echo '<span class="page-numbers-dian">...</span> ';
    for( $i = $paged - $range; $i <= $paged + $range; $i++ ) { // 中间页
        if ( $i > 0 && $i <= $max_page ) $i == $paged ? print "<span class='page-numbers current'>{$i}</span> " : p_link( $i );
    }
    if ( $paged < $max_page - $range - 1 ) echo '<span class="page-numbers-dian">...</span>';
    if ( $paged < $max_page - $range ) p_link( $max_page, '最后页' );
    if ( $paged < $max_page ) p_link( $paged + 1,'下一页', '»' );/* 如果当前页不是最后一页显示下一页链接 */
}


function p_link( $i, $title = '', $linktype = '' ) {
    if ( $title == '' ) $title = "第 {$i} 页";
    if ( $linktype == '' ) { $linktext = $i; } else { $linktext = $linktype; }
    echo "<a class='page-numbers' href='", esc_html( get_pagenum_link( $i ) ),"' title='{$title}'>{$linktext}</a> ";
//    echo "<a class='page-numbers' id='$i'  title='{$title}'>{$linktext}</a> ";
}

function get_pagenavis( $range = 4 ,$total ,$number,$paged) {
    global $wp_query;
    $max_page = ceil(count($total)/$number);
    if ( is_singular() ) return; // 文章与插页不用
    if ( !$max_page ) {
        $max_page = $wp_query->max_num_pages;
    }
//    $max_page = count($max_page);
//    var_dump($max_page);
    if ( $max_page == 1 ) return; // 只有一页不用
//                        if ( emptyempty( $paged ) ) $paged = 1;
//    echo '<span class="pages">Page: ' . $paged . ' of ' . $max_page . ' </span> '; // 显示页数
    if ( $paged > 1 ) p_links( $paged - 1, '上一页', '«' );/* 如果当前页大于1就显示上一页链接 */
    if ( $paged > $range + 1 ) p_links( 1, '最前页' );
    if ( $paged > $range + 2 ) echo '<span class="page-numbers-dian">...</span>';
    for( $i = $paged - $range; $i <= $paged + $range; $i++ ) { // 中间页
        if ( $i > 0 && $i <= $max_page ) $i == $paged ? print "<span id='$i' class='page-numbers current'>{$i}</span> " : p_links( $i );
    }
    if ( $paged < $max_page - $range - 1 ) echo '<span class="page-numbers-dian">...</span>';
    if ( $paged < $max_page - $range ) p_links( $max_page, '最后页' );
    if ( $paged < $max_page ) p_links( $paged + 1,'下一页', '»' );/* 如果当前页不是最后一页显示下一页链接 */
}


function p_links( $i, $title = '', $linktype = '' ) {
    if ( $title == '' ) $title = "第 {$i} 页";
    if ( $linktype == '' ) { $linktext = $i; } else { $linktext = $linktype; }
    echo "<a class='page-numbers' id='$i'  title='{$title}'>{$linktext}</a> ";
}

function get_text ($data) {
    if(preg_match('/<p>(.*)<\/p>/iU',trim(strip_tags($data->post_content,"<p>")),$result)){
        $post_content = $result['1'];
    } else {
        $post_content_r = explode("\n",trim(strip_tags($data->post_content)));
        $post_content = $post_content_r['0'];
    }
    $description = $post_content;
    echo $description;
}

function get_text_val ($data) {
    if(preg_match('/<p>(.*)<\/p>/iU',trim(strip_tags($data->post_content,"<p>")),$result)){
        $post_content = $result['1'];
    } else {
        $post_content_r = explode("\n",trim(strip_tags($data->post_content)));
        $post_content = $post_content_r['0'];
    }
    $description = $post_content;
    return $description;
}

require get_template_directory() . '/inc/bootstrapwp-functions.php';

global $wpdb;
define('MY_NEW_TABLE', $wpdb->prefix . 'configureId');

function the_table_install () {

    global $wpdb;

    $table_name = MY_NEW_TABLE;  //获取表前缀，并设置新表的名称

    if($wpdb->get_var("show tables like $table_name") != $table_name) {  //判断表是否已存在

        $sql = "CREATE TABLE " . $table_name . " (

          id mediumint(9) NOT NULL AUTO_INCREMENT,

          time timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,

          name tinytext NOT NULL,

          configure_id text NOT NULL,

          UNIQUE KEY id (id)

          );";

        require_once(ABSPATH . "wp-admin/includes/upgrade.php");  //引用wordpress的内置方法库

        dbDelta($sql);

    }

}
//the_table_install ();
function plugin_activation_insertdate() {
    global $wpdb;
    $data['name'] = 'ID';
    $data['configure_id'] = '1,,2,3,4,5,6,7,8,9,10,11,12';
    $wpdb->insert(MY_NEW_TABLE, $data);
}
//plugin_activation_insertdate();

function get_table_configureId () {
    global $wpdb;
    $table_name = $wpdb->prefix . "configureId";
    $myrows = $wpdb->get_results( "SELECT * FROM $table_name where name='ID'" );
    return $myrows;
}

function myajax_submit() {
    // 获取参数
    global $wpdb;
    $configure_val = $_POST['configure'];
    $id_val = $_POST['id'];
    $table_name = $wpdb->prefix . "configureId";
    $data['configure_id'] = $configure_val;
    $where_clause = array(
        'id'=> $id_val
    );
    $updated = $wpdb->update( $table_name, $data, $where_clause );
    // 生成响应
    $response = json_encode( array( 'success' => $updated, 'data' => $configure_val) );
    // 输出响应
    header( "Content-Type: application/json" );
    echo $response;
    exit;
}
add_action( 'wp_ajax_myajax_submit', 'myajax_submit' );



$data = get_table_configureId()[0]->configure_id;
$data_id = get_table_configureId()[0]->id;
$pieces = explode(",", $data);
// 分类ID
/* 新闻 */
//$newss = 1;
define( 'NEWSS', $pieces[0] );
/* DApps */
//$dapps = 2;
define( 'DAPPS', $pieces[1] );
/* 活动 */
//$activitys = 3;
define( 'ACTIVITYS', $pieces[2] );
/* 公链 */
//$chains = 4;
define( 'CHAINS', $pieces[3] );
/* 人物 */
//$characters = 5;
define( 'CHARACTERS', $pieces[4] );
/* 快讯 */
//$newsletters = 6;
define( 'NEWSLETTERS', $pieces[5] );
/* 小道 */
//$trails = 7;
define( 'TRAILS', $pieces[6] );
/* 明星 */
//$celebritys = 8;
define( 'CELEBRITYS', $pieces[7] );
/* 关于 */
//$on = 9;
define( 'ON', $pieces[8] );
/* 顾问 */
//$consultants = 10;
define( 'CONSULTANTS', $pieces[9] );
/* 合作 */
//$cooperations = 11;
define( 'COOPERATIONS', $pieces[10] );
/* 头条 */
//$tops = 12;
define( 'TOPS', $pieces[11] );

// 获取文章的第一个链接
//function get_content_link( $content = false, $echo = false )
//{
//    if ( $content === false )
//        $content = get_the_content();
//
//    $content = preg_match_all( '/hrefs*=s*["']([^"']+)/', $content, $links );
//    $content = $links[1][0];
//
//    if ( empty($content) ) {
//    	$content = false;
//    }
//
//    return $content;
//}

// 人物 子页面
function get_characterlink($id) {
    include 'index-character-details.php';
}


function get_table_title_posts ($title, $number, $offset) {
    global $wpdb;
    $CID = NEWSS;
    $sql="SELECT ID,post_title,post_content FROM wp_posts,
          wp_term_relationships,
          wp_term_taxonomy
           WHERE ID=object_id 
           and wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id 
           and post_title like '%$title%' 
           and post_type='post' and post_status = 'publish' 
           and wp_term_relationships.term_taxonomy_id = $CID 
           and taxonomy = 'category' limit $offset , $number";
    $title_post = $wpdb->get_results( $sql );
    return $title_post;
}

function get_table_count_posts ($title) {
    global $wpdb;
    $CID = NEWSS;
    $sql="SELECT ID,post_title,post_content FROM wp_posts,
          wp_term_relationships,
          wp_term_taxonomy
           WHERE ID=object_id 
           and wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id 
           and post_title like '%$title%' 
           and post_type='post' and post_status = 'publish' 
           and wp_term_relationships.term_taxonomy_id = $CID 
           and taxonomy = 'category'";
    $title_post = $wpdb->get_results( $sql );
    return $title_post;
}

function Month_E($Num) {
    $Month_E = array(
        "01" => "Jan",
        "02" => "Feb",
        "03" => "Mar",
        "04" => "Apr",
        "05" => "May",
        "06" => "Jun",
        "07" => "Jul",
        "08" => "Aug",
        "09" => "Sep",
        "10" => "Oct",
        "11" => "Nov",
        "12" => "Dec");
    return $Month_E[$Num];
}

function get_content_link( $content = false, $echo = false )
{
    if ( $content === false ){
        $content = get_the_content();
    }
    $content =  preg_match( '/<a[^>]*?href=\"([^>]+?)\"[^>]*?>.+?<\/a>/i',  $content, $links );
    $content = $links[0];
    if ( empty($links) ) {
    	$content = false;
    }
    return $content;
}

function get_content_strong( $content = false, $echo = false )
{
    if ( $content === false ){
        $content = get_the_content();
    }
    $content =  preg_match( '/<strong[^>]*?>.+?<\/strong>/i',  $content, $links );
    $content = $links[0];
    if ( empty($links) ) {
        $content = false;
    }
    return $content;
}

function get_content_score( $content = false, $echo = false )
{
    if ( $content === false ){
        $content = get_the_content();
    }
    $content =  preg_match( '/<strong[^>]*?>.+?<\/strong>/i',  $content, $links );
    $preg = '/<strong>.*?(\d+).*?<\/strong>/';
    $content = $links[0];
    preg_match( $preg,  $content, $result );
    $content = $result[1];
    if ( empty($result) ) {
        $content = false;
    }
    return intval($content);
}

function get_content_ol( $content = false, $echo = false )
{
    if ( $content === false ){
        $content = get_the_content();
    }
    $content =  preg_match( '/<ol>(.*?)<\/ol>/',  $content, $links );
    $content = $links[1];
    if ( empty($links) ) {
        $content = false;
    }
    return $content;
}

function get_ajax_newa() {
    $postID = $_POST['tape'];
    if (empty($postID)) {
        $postID = NEWSS;
    }
    $html = "<div id='collectionList' class='collection-list' style='margin-top: 0px;'>";
    $newss_data = get_posts("category=$postID&numberposts=9");
    if($newss_data) :
    foreach( $newss_data as $newa ):
        $html = "<div class='article-item article-item--list'>";
        $html .=     "<div class='article-image cover-image'>";
        $html .=         "<a href='?p=". $newa->ID."'";
        $html .=            "class='article-link cover-block'";
        $html .=           "style='background-image:url(". catch_the_image($newa->ID) .")'>";
        $html .=         "</a>";
        $html .=   " </div>";
        $html .=    "<div class='article-info js-transform'>";
        $html .=     "<h3><a class='js-title-transform' href='?p=". $newa->ID."'>". $newa->post_title."</a></h3>";
        $html .=      "<div class='article-summary'>".get_text_val($newa)."</div>";
        $html .=       "<div class='article-meta'>";
        $html .=        " <time> <span>". date('m-d', strtotime($newa->post_date_gmt))."</span>";
        $tt = wp_get_post_tags($newa->ID);
        foreach ($tt as $t):
        $html .=   "<span>". $t->name."</span>";
        endforeach;
        $html .=         "</time>";
        $html .=    " </div>";
        $html .=    "</div>";
        echo $html .=  "</div>";
    endforeach;
    else:
        echo "<div class='else-data'>无数据</div>";
    endif;
    echo  "</div>";
//    header( "Content-Type: application/json" );
    header("Content-Type: text/html; charset=utf-8");
//    echo htmlentities($str,ENT_QUOTES,"UTF-8");
    exit;//这个停止一定要写
}

//函数名对应添加上，第一个表示用户没有登录时，这里全部都一样处理
add_action( 'wp_ajax_nopriv_get_ajax_newa', 'get_ajax_newa' );
add_action( 'wp_ajax_get_ajax_newa', 'get_ajax_newa' );


function get_ajax_news() {
    $postID = $_POST['tape'];
    $paged = $_POST['page'];
    if($paged==null){
        $paged = 1;
    }
    $p = $paged - 1;
    // 总条数
    $total = get_posts("numberposts=-1&category=$postID");
    // 显示多少条
    $number = 10;
    $offset = $p * $number;

    if (empty($postID)) {
        $postID = NEWSS;
    }
    $html = "<div id='collectionList' class='collection-list' style='margin-top: 0px;'>";
    $tops = get_posts("category=$postID&numberposts=$number&offset=$offset");
    if($tops) :
    foreach( $tops as $top ):
        $html .= "<div class='article-item article-item--list'>";
        $html .=     "<div class='article-image cover-image'>";
        $html .=         "<a href='?p=". $top->ID."'";
        $html .=            "class='article-link cover-block'";
        $html .=           "style='background-image:url(". catch_the_image($top->ID) .")'>";
        $html .=         "</a>";
        $html .=   " </div>";
        $html .=    "<div class='article-info js-transform'>";
        $html .=     "<h3><a class='js-title-transform' href='?p=". $top->ID."'>". $top->post_title."</a></h3>";
        $html .=      "<div class='article-summary'>".get_text_val($top)."</div>";
        $html .=       "<div class='article-meta'>";
        $html .=        " <time> <span>". date('m-d', strtotime($top->post_date_gmt))."</span>";
        $tt = wp_get_post_tags($top->ID);
        foreach ($tt as $t):
            $html .=   "<span>". $t->name."</span>";
        endforeach;
        $html .=         "</time>";
        $html .=    " </div>";
        $html .=    "</div>";
        $html .=  "</div>";
    endforeach;
    echo $html .=  "</div>";
    else:
    echo "<div class='else-data'>无数据</div>";
    endif;
    echo  "<div class='pagena'>" ;
    get_pagenavis('4', $total, $number,$paged);
    echo  "</div>";
    header("Content-Type: text/html; charset=utf-8");
    exit;//这个停止一定要写
}
//函数名对应添加上，第一个表示用户没有登录时，这里全部都一样处理
add_action( 'wp_ajax_nopriv_get_ajax_news', 'get_ajax_news' );
add_action( 'wp_ajax_get_ajax_news', 'get_ajax_news' );



function get_ajax_dapps() {
    $postID = $_POST['tape'];
    $paged = $_POST['page'];
    if($paged==null){
        $paged = 1;
    }
    $p = $paged - 1;
    // 总条数
    $total = get_posts("numberposts=-1&category=$postID");
    // 显示多少条
    $number = 10;
    $offset = $p * $number;

    if (empty($postID)) {
        $postID = DAPPS;
    }
    $html = "<ul class='miniapp-list-content-ul clearfix js-miniapp-list'>";
    $tops = get_posts("category=$postID&numberposts=$number&offset=$offset");
    if($tops):
    $html .= "<div class='dApps-pc'>";
    foreach( $tops as $top ):
        $html .= "<li class='miniapp-item js-miniapp-item'>";
        $html .=     "<div class='article-image cover-image'>";
        $html .=         "<div class='miniapp-header'><div><img
                                            class='miniapp-header__app-icon js-app-link'
                                            src='".catch_the_image($top->ID)."'
                                            alt='app icon'></div>";
        $html .=            "<div class='app-header-corp'><a href='?p=". $top->ID."'
                                                                class='app-header-corp__app-name js-app-link'
                                                                target='_blank'>". $top->post_title."</a>
                                    <span class='app-header-corp__auth-name'>
                                        ". get_content_link($top->post_content) ."
                                    </span>
                                </div>";
        $html .=           "  <div class='miniapp-footer'>
                                ". get_text_val($top)."
                            </li>";
    endforeach;
    $html .= "</div>";
    $html .= "<div class='dApps-app'>";
    foreach( $tops as $top ):
        $html .=   "<li class='app-ranking-list__item'>
                        <div class='app-ranking-list__link clearfix' ><a
                                    href='?p=". $top->ID."' ga-bind='click'
                                    ga-category='widget' ga-label='newlist1'
                                    ga-action='NewList'><img class='app-ranking-list__image'
                                                             src='".catch_the_image($top->ID)."'
                                                             alt='app icon'></a>
                            <div class='app-ranking-list__content'><h5
                                        class='app-ranking-list__name'><a href='?p=". $top->ID."'>". $top->post_title."</a></h5>
                                <p class='app-ranking-list__name'>". get_text_val($top)."</p>
                                <div class='app-ranking-list__stars'></div>

                            </div>
                        </div>
                    </li>";
    endforeach;
    $html .= "</div>";
    else:
    echo "<div class='else-data'>无数据</div>";
    endif;
    echo $html .=  "<div class='clear'></div>
                </ul>";
    echo  "<div class='pagena'>" ;
    get_pagenavis('4', $total, $number,$paged);
    echo  "</div>";
    header("Content-Type: text/html; charset=utf-8");
    exit;//这个停止一定要写
}
//函数名对应添加上，第一个表示用户没有登录时，这里全部都一样处理
add_action( 'wp_ajax_nopriv_get_ajax_dapps', 'get_ajax_dapps' );
add_action( 'wp_ajax_get_ajax_dapps', 'get_ajax_dapps' );

function get_ajax_chains() {
    $postID = $_POST['tape'];
    $paged = $_POST['page'];
    if($paged==null){
        $paged = 1;
    }
    $p = $paged - 1;
    // 总条数
    $total = get_posts("numberposts=-1&category=$postID");
    // 显示多少条
    $number = 10;
    $offset = $p * $number;

    if (empty($postID)) {
        $postID = CHAINS;
    }
    $html = "<ul>";
    $tops = get_posts("category=$postID&numberposts=$number&offset=$offset");
    if($tops):
    foreach( $tops as $top ):
        $html .= "<li>";
        $html .=     "<a href='?p=". $top->ID."'>";
        $html .=         "<div class='left-font'><p class='p1'>". $top->post_title."</p>";
        $html .=            "<p class='p2'>". get_text_val($top)."</p>";
        $html .=           "<div class='p3'>
                            <div class='score'>项目评分 ：
                                <div class='cleanfloat'>";
        $score_data = get_content_score($top->post_content);
        if( $score_data <= 0) :
         $html .=  "<span>无</span>";
        else:
        for( $i=0; $i<$score_data; $i++ ):
          $html .=  "<div class='cleanfloat-li'>&#9733;</div>";
        endfor;
        endif;
        $html .= "</div></div></div></div>";
        $html .= "<div>
                    <div class='right-img'
                         style='background-image:url(". catch_the_image($top->ID) .")'></div>
                </div>
               </a>
            </li>";
    endforeach;
    else:
    echo "<div class='else-data'>无数据</div>";
    endif;
    echo $html .=  "<div class='clear'></div> </ul>";
    echo  "<div class='pagena'>" ;
    get_pagenavis('4', $total, $number,$paged);
    echo  "</div>";
    header("Content-Type: text/html; charset=utf-8");
    exit;//这个停止一定要写
}
//函数名对应添加上，第一个表示用户没有登录时，这里全部都一样处理
add_action( 'wp_ajax_nopriv_get_ajax_chains', 'get_ajax_chains' );
add_action( 'wp_ajax_get_ajax_chains', 'get_ajax_chains' );


function get_table_recommend_posts ($title) {
    global $wpdb;
    $CID = NEWSS;
    $sql="SELECT ID,post_title,post_content FROM wp_posts,
          wp_term_relationships,
          wp_term_taxonomy
           WHERE ID=object_id 
           and wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id 
           and post_title like '%$title%' 
           and post_type='post' and post_status = 'publish' 
           and wp_term_relationships.term_taxonomy_id = $CID 
           and taxonomy = 'category'";
    $title_post = $wpdb->get_results( $sql );
    return $title_post;
}

add_filter('jpeg_quality', function($arg){return 100;});

