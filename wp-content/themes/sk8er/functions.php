<?php
/**
 * Sk8er functions and definitions
 *
 * @package Sk8er
 */

/**
 * Add Redux Framework & extras
 */
require get_template_directory() . '/admin/admin-init.php';
require get_template_directory() . '/cmb/example-functions.php';

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'sk8er_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function sk8er_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Sk8er, use a find and replace
	 * to change 'sk8er' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'sk8er', get_template_directory() . '/languages' );

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
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'sk8er' ),
		'footer' => __( 'Footer Menu', 'sk8er' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'video', 'quote', 'link', 'audio'
	) );

	/**
	 * Add PostTypes
	 */
	require get_template_directory() . '/inc/theme/shortcodes.php';

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'sk8er_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	add_theme_support('woocommerce');
}
endif; // sk8er_setup
add_action( 'after_setup_theme', 'sk8er_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function sk8er_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'sk8er' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="box %2$s">',
		'after_widget'  => '</div></aside>',
		'before_title'  => '<div class="title">',
		'after_title'   => '</div><div class="content">',
	) );
	register_sidebar( array(
		'name'          => __( 'Menu Sidebar', 'sk8er' ),
		'id'            => 'sidebar-menu',
		'description'   => '',
		'before_widget' => '<div id="%1$s" class="box %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'sk8er_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function sk8er_scripts() {
	global $sk8er;

	// Stylesheet
	wp_enqueue_style( 'sk8er-bootstrap', get_template_directory_uri() .'/css/font-awesome.min.css' );
	wp_enqueue_style( 'sk8er-opensans', 'http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' );
	wp_enqueue_style( 'sk8er-indie', 'http://fonts.googleapis.com/css?family=Indie+Flower' );
	wp_enqueue_style( 'sk8er-roboto', 'http://fonts.googleapis.com/css?family=Roboto:100' );
	if (is_page_template('templates/template-full-page.php')) {
		wp_enqueue_style( 'sk8er-fs', get_template_directory_uri() . '/css/onepage-scroll.css' );
	}
	if (is_page_template('templates/template-coming-soon.php')) {
		wp_enqueue_style( 'sk8er-countdown', get_template_directory_uri() . '/css/jquery.countdown.css' );
	}
	wp_enqueue_style( 'sk8er-normalize', get_template_directory_uri() . '/css/normalize.css' );
	wp_enqueue_style( 'sk8er-main', get_template_directory_uri() . '/css/main.css' );
	wp_enqueue_style( 'sk8er-style', get_stylesheet_uri() );

	// Javascript
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'shortcode-bootstrap', get_template_directory_uri() . '/js/min/bootstrap.min.js', array(), '1.0', true );
	wp_enqueue_script( 'sk8er-modernizr', get_template_directory_uri() . '/js/vendor/modernizr-2.8.3.min.js');
	wp_enqueue_script( 'sk8er-waypoints', get_template_directory_uri() . '/js/min/waypoints.min.js', array(), '1', true );
	wp_enqueue_script( 'sk8er-jqplugin', get_template_directory_uri() . '/js/jquery.plugin.js', array(), '1', true );
	wp_enqueue_script( 'sk8er-plugins', get_template_directory_uri() . '/js/plugins.js', array(), '1', true );
	wp_enqueue_script( 'sk8er-easing', get_template_directory_uri() . '/js/jquery.easing.1.3.js', array(), '1', true );
	wp_enqueue_script( 'sk8er-main', get_template_directory_uri() . '/js/main.js', array(), '1', true );

	wp_enqueue_script( 'sk8er-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );
	wp_enqueue_script( 'sk8er-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Register Styles and JS
		wp_register_style('sk8er-slick', get_template_directory_uri() . '/css/slick.css');
		wp_register_style('sk8er-swipebox', get_template_directory_uri() . '/css/swipebox.css');
		wp_register_style('sk8er-smoothDivScroll', get_template_directory_uri() . '/css/smoothDivScroll.css'  );
		wp_register_style('sk8er-postlikes', get_template_directory_uri() . '/css/like-styles.min.css' );
		wp_register_style('sk8er-video-js', get_template_directory_uri() . '/css/video-js.css' );
		wp_register_style('sk8er-animate', get_template_directory_uri() . '/css/animate.css');

		wp_register_script('sk8er-google-maps', 'https://maps.googleapis.com/maps/api/js', array(), '1', true );
		wp_register_script('sk8er-video', get_template_directory_uri() . '/js/video.js', array(), '1', true);
		wp_register_script('sk8er-video-youtube', get_template_directory_uri() . '/js/min/vjs.youtube.js', array(), '1', true);
		wp_register_script('sk8er-video-vimeo', get_template_directory_uri() . '/js/min/vjs.vimeo.js', array(), '1', true);
		wp_register_script('sk8er-smoothDivScroll', get_template_directory_uri() . '/js/jquery.smoothdivscroll-1.3-min.js', array(), '1', true);
		wp_register_script('sk8er-kinetic', get_template_directory_uri() . '/js/jquery.kinetic.min.js', array(), '1', true);
		wp_register_script('sk8er-jquery-ui', get_template_directory_uri() . '/js/jquery-ui-1.8.23.custom.min.js', array(), '1', true);
		wp_register_script('sk8er-mousewheel', get_template_directory_uri() . '/js/jquery.mousewheel.min.js', array(), '1', true);

		wp_register_script('sk8er-isotope', get_template_directory_uri() . '/js/isotope.pkgd.min.js', array(), '1', true );
		wp_register_script('sk8er-tabs', get_template_directory_uri() . '/js/bootstrap/tab.js', array(), '1', true );
}
add_action( 'wp_enqueue_scripts', 'sk8er_scripts' );

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load Post Like
 */
//require get_template_directory() . '/inc/post-like.php';

////////////////////////////////////////
// Embed VC Config if VC is installed //
////////////////////////////////////////
if(in_array('js_composer/js_composer.php', apply_filters('active_plugins', get_option('active_plugins'))))
{
	require 'avathemes_vc/config.php';
	require 'avathemes_vc/vc-modify.php';
}


function sk8er_excerpt($limit) {
	$excerpt = explode(' ', get_the_excerpt(), $limit);
	if (count($excerpt)>=$limit) {
		array_pop($excerpt);
		$excerpt = implode(" ",$excerpt).'...';
	} else {
		$excerpt = implode(" ",$excerpt);
	}
		$excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
		return $excerpt;
}

function sk8er_metabox_script() {
 wp_register_script('sk8er-meta', get_template_directory_uri() . '/cmb/meta.js', array('jquery'), '1.0.0');
 wp_enqueue_script('sk8er-meta');
}
add_action('admin_enqueue_scripts', 'sk8er_metabox_script');

function sk8er_custom_admin_css() {
    wp_enqueue_style( 'sk8er-custom-admin-css', get_template_directory_uri() . '/css/admin-style.css' );
}
add_action( 'admin_enqueue_scripts', 'sk8er_custom_admin_css' );

function sk8er_pagination() {
    global $wp_query;
    $big = 999999999; // need an unlikely integer
    $pages = paginate_links( array(
            'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'format' => '?paged=%#%',
            'current' => max( 1, get_query_var('paged') ),
            'total' => $wp_query->max_num_pages,
            'prev_next' => false,
            'type'  => 'array',
            'prev_next'   => TRUE,
			'prev_text'    => __('«', 'sk8er'),
			'next_text'    => __('»', 'sk8er'),
        ) );
        if( is_array( $pages ) ) {
            $paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
            echo '<ul class="pagination">';
            foreach ( $pages as $page ) {
                    echo "<li>$page</li>";
            }
           echo '</ul>';
        }
}

function sk8er_hex2rgba($color, $opacity = false) {

    $default = 'rgb(0,0,0)';

    //Return default if no color provided
    if(empty($color))
          return $default;

    //Sanitize $color if "#" is provided
        if ($color[0] == '#' ) {
            $color = substr( $color, 1 );
        }

        //Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
                $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        } elseif ( strlen( $color ) == 3 ) {
                $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        } else {
                return $default;
        }

        //Convert hexadec to rgb
        $rgb =  array_map('hexdec', $hex);

        //Check if opacity is set(rgba or rgb)
        if($opacity){
            if(abs($opacity) > 1)
                $opacity = 1.0;
            $output = 'rgba('.implode(",",$rgb).','.$opacity.')';
        } else {
            $output = 'rgb('.implode(",",$rgb).')';
        }

        //Return rgb(a) color string
        return $output;
}

add_filter( 'woocommerce_product_add_to_cart_url', 'sk8er_woocommerce_product_add_to_cart_url', 10, 2 );
function sk8er_woocommerce_product_add_to_cart_url($url, $obj){
	if(isset($obj->id) && $obj->id > 0){
		$url = add_query_arg(array(
			'add-to-cart'=>$obj->id,
		),get_permalink($obj->id));
	}
	return $url;
}

function sk8er_custom_head_style()
{
	global $sk8er;
	$main_color = $sk8er['sk8er_main_color'];
	$hover_color = sk8er_hex2rgba($sk8er['sk8er_hover_color']['color'], $sk8er['sk8er_hover_color']['alpha']);
    echo "<style>
    	/*Bgs*/
    	.servicelist .box-holder .box:hover, .servicelist .box-holder:nth-of-type(4n+2) .box:hover, .servicelist .box-holder:nth-of-type(4n+3) .box:hover, .servicelist .box-holder:nth-of-type(4n) .box:hover, section.style-2.page-links .one-link-wrapper .one-link, section.style-2.page-links .one-link-wrapper .one-link:before, section.style-2.page-links .one-link-wrapper .one-link:after, section.style-2.our-team .members .member .text .social a:hover, section.style-2.image-details .image-holder .detail, section.style-5.whatwedo .list .box:hover .main .name:before, section.style-5.our-team .members .member .text .social a:hover, section.style-9.latest-wines .wines-slick .one .content .learn-more, section.style-9.textwithimage .image .price, section.style-10.portfolio .image .hover, section.style-10.latest-news .news-slick-controls .slick-prev, section.style-10.latest-news .news-slick-controls .slick-next, section.style-11.textwithquote .images .text, section.style-11.single-product .product-wrapper .product-info,section.style-12.services .list .box .name:after, section.style-12.featured-post .post-info, section.style-13.fun-facts, section.style-17.our-team .box .content .social a:hover, section.style-18 .buttons a span:before, section.style-18.about .slider .slider-wrapper .slider-controls a:hover, section.style-18.about .slider .slider-wrapper .slider-controls a.active, .style-element.our-team .members .member:hover .content:after, section.style-18.latest-news .news .box .image a:hover, .fullscreen-holder .fullscreen-section .valign .post-wrapper.normal.full .post-icon, .fullscreen-holder .fullscreen-section .valign .post-wrapper.quote .post-icon, .fullscreen-holder .fullscreen-section .valign .post-wrapper.video .post-icon, .fullscreen-holder .fullscreen-section .valign .post-wrapper .post-icon, .social-links-bar, section.style-misc.contact-form .form form label.submit input, section.style-misc.our-clients .clients-list .single .tb-borders:before, section.style-misc.our-clients .clients-list .single .tb-borders:after, section.style-misc.our-clients .clients-list .single .lr-borders:before, section.style-misc.our-clients .clients-list .single .lr-borders:after, section.style-misc.blog-items .blog-items-wrapper .item .image-slider .slick-prev, section.style-misc.blog-items .blog-items-wrapper .item .image-slider .slick-next, ul.pagination li span.current, section.style-misc.blog-items .blog-items-wrapper .item .text .post-content .read-more:hover, section.style-misc.blog-items .blog-items-wrapper .item.sticky .text .post-content .title::before, #respond form input[type='submit'], #respond form textarea[type='submit'], .sidebar .box .content input[type='submit'], .woocommerce button.button, ul.products .product .onsale, .wc-content .product .onsale, .shop-items .item .onsale, .woocommerce-page .cart input.checkout-button, .sidebar .search-form .search-submit {background-color: ".$main_color." !important; }
    	.social-links-bar:after { border-color: ".$main_color." transparent transparent; }
    	.woocommerce-page input#place_order {background: ".$main_color." !important;}
    	section.style-misc.blog-items .sidebar .box .content input:focus, section.style-misc.blog-items .sidebar .box .content select:focus {
    	    border-color: ".$main_color.";
    	    color: ".$main_color.";
    	    @include box-shadow(inset 0 0 5px ".$hover_color.");
    	}
    	section.style-misc.blog-items .blog-items-wrapper .item.sticky { border-bottom: 3px solid ".$main_color."  ;}
    	section.style-2.page-links .one-link-wrapper .one-link:after { box-shadow: 0 0 35px 55px ".$main_color." !important; -webkit-box-shadow: 0 0 35px 55px ".$main_color." !important; }
    	section.style-5.whatwedo .list .box:hover { box-shadow: inset 0 0 0 3px ".$main_color." !important; -webkit-box-shadow: inset 0 0 0 3px ".$main_color." !important; }
    	section.style-9.latest-wines .wines-slick .one .content .learn-more { box-shadow: inset 0 0 0 1px ".$main_color.",inset 0 0 0 3px #fff; -webkit-box-shadow: inset 0 0 0 1px ".$main_color.",inset 0 0 0 3px #fff; }
    	section.style-9.latest-wines .wines-slick .one .content .learn-more:hover { box-shadow: inset 0 0 0 4px ".$main_color.", inset 0 0 0 5px #fff; -webkit-box-shadow: inset 0 0 0 4px".$main_color.",inset 0 0 0 5px #fff; }
    	section.style-9.latest-wines .wines-slick .one .image .image-inside { box-shadow: inset 0 0 0 5px #fff,0 0 0 3px ".$main_color."; -webkit-box-shadow: inset 0 0 0 5px #fff,0 0 0 3px ".$main_color."; }
    	section.style-9.textwithimage .image .price { box-shadow: inset 0 0 0 1px ".$main_color.", inset 0 0 0 4px #fff; -webkit-box-shadow: inset 0 0 0 1px ".$main_color.",inset 0 0 0 4px #fff; }
    	section.style-9.textwithimage .image .minitext { box-shadow: inset 0 0 0 4px #fff,inset 0 0 0 5px ".$main_color."; -webkit-box-shadow: inset 0 0 0 4px #fff,inset 0 0 0 5px ".$main_color."; }
    	section.style-11.textwithquote .quote .quote-head .image { box-shadow: inset 0 0 0 2px ".$main_color.",inset 0 0 0 6px #fff; -webkit-box-shadow: inset 0 0 0 2px ".$main_color.",inset 0 0 0 6px #fff; }
    	section.style-12 .title-bar h3, section.style-17.services .box:hover, section.style-18.services .list .box .icon, section.style-18.stats .list, .style-element.our-team .members .member .image:before, section.style-18.latest-news .news .box .content .title:hover, section.style-18.contact-info .row .box:hover .icon { border-color: ".$main_color."; }
    	section.style-12.featured-post .post-info:before { border-color: transparent ".$main_color." transparent transparent; }
    	section.style-13.our-team .members .member .image .hover, section.style-17.portfolio .single .image a, section.style-misc.blog-items .blog-items-wrapper .item .image a { background-color: ".$hover_color."!important; }
    	section.style-13.our-team .members .member .image:before { box-shadow: inset 0 0 0 3px ".$main_color.",inset 0 0 0 6px #fff; -webkit-box-shadow: inset 0 0 0 3px ".$main_color.",inset 0 0 0 6px #fff; }
    	section.style-17.our-team .box .image { box-shadow: inset 0 0 0 2px ".$main_color.",inset 0 0 0 4px #fff; -webkit-box-shadow: inset 0 0 0 2px ".$main_color.",inset 0 0 0 4px #fff; }
    	.style-element.our-team .members .member:hover .image { box-shadow: inset 0 0 0 2px ".$main_color."; -webkit-box-shadow: inset 0 0 0 2px ".$main_color."; }
    	/*Colors*/
    	.servicelist .box .icon, section.style-1.latest-news .news-block .block .content a:not(.jm-post-like):hover, section.style-2 .works .work a:hover, section.style-2.latest-news .news-block .block .content .inside .name a:hover, section.style-2.latest-news .news-block .block .content .inside .author-info a:hover, section.style-4.happening .list .happening-slick .one .event-post .inside .content .name a:hover, section.style-4.happening .list .happening-slick .one .event-post .inside .content .author-info a:hover, section.style-5.whatwedo .list .box:hover .main .icon, section.style-5.whatwedo .list .box:hover .main .name, section.style-5.products .list .box:hover .icon, section.style-5.products .list .box:hover .content .name, section.style-5.products .list .box:hover .content p, section.style-5.news .get-more a:hover, section.style-11 .title-bar span, section.style-12.services .list .box .icon, section.style-12.services .list .box .name, section.style-12.mini-services .list .service .icon i, section.style-12.mini-services .list .service .content .name,section.style-17.services .box .icon i, section.style-17.services .box .content .name, section.style-18.services .list .box:hover .icon, section.style-18.services .list .box:hover .content .name, .style-element.our-team .members .member:hover .content .name, section.style-18.latest-news .news .box .content .title:hover, section.style-18.contact-info .row .box:hover .icon i, .social-links-bar .links a,ul.pagination li span, ul.pagination li a, section.style-15.portfolio-items ul.portfolio-filter li a:hover, section.style-misc.blog-items ul.portfolio-filter li a:hover, section.style-misc.blog-items-grid ul.portfolio-filter li a:hover, section.style-15.portfolio-items-wrapper .sidebar .box .content ul li a:hover, section.style-misc.blog-items .sidebar .box .content ul li a:hover, section.style-misc.blog-single .sidebar .box .content ul li a:hover, section.style-15.portfolio-items .sidebar .box .content ul li a:hover, section.single-post .sidebar .box .content ul li a:hover, section.single-page .sidebar .box .content ul li a:hover, section.style-misc.blog-items-grid .sidebar .box .content ul li a:hover, section.style-misc.blog-items .blog-items-wrapper .item .text .info a:hover, section.style-misc.blog-items .blog-items-wrapper .item.sticky .text .post-content .title, .tagcloud a, section.style-15.portfolio-items-wrapper .sidebar .box .content #calendar_wrap #wp-calendar tfoot a, section.style-misc.blog-items .sidebar .box .content #calendar_wrap #wp-calendar tfoot a, section.style-misc.blog-single .sidebar .box .content #calendar_wrap #wp-calendar tfoot a, section.style-15.portfolio-items .sidebar .box .content #calendar_wrap #wp-calendar tfoot a, section.single-post .sidebar .box .content #calendar_wrap #wp-calendar tfoot a, section.single-page .sidebar .box .content #calendar_wrap #wp-calendar tfoot a, section.style-misc.blog-items-grid .sidebar .box .content #calendar_wrap #wp-calendar tfoot a,section.style-15.portfolio-items-wrapper .sidebar .box.widget_rss .title a:hover, section.style-misc.blog-items .sidebar .box.widget_rss .title a:hover, section.style-misc.blog-single .sidebar .box.widget_rss .title a:hover, section.style-15.portfolio-items .sidebar .box.widget_rss .title a:hover, section.single-post .sidebar .box.widget_rss .title a:hover, section.single-page .sidebar .box.widget_rss .title a:hover, section.style-misc.blog-items-grid .sidebar .box.widget_rss .title a:hover,section.style-15.portfolio-items ul.portfolio-filter li.active a, section.style-misc.blog-items ul.portfolio-filter li.active a, section.style-misc.blog-items-grid ul.portfolio-filter li.active a, section.style-misc.blog-single .post-content .post-navigation a:hover, section.style-misc.single-post .post-content .post-navigation a:hover, section.style-misc.blog-single .post-content .text .info a:hover, section.style-misc.single-post .post-content .text .info a:hover, .woocommerce .star-rating span:before, .woocommerce-page .star-rating span:before, p.stars a:after, #site-content a:hover:not(.ia), .wp-caption-text, .wp-caption-text a  {color: ".$main_color." !important;}
    	    .tagcloud a:hover { color: #888 !important; }
    	ul.pagination li span.current { color: #fff !important; }
    	#respond form input:focus, #respond form textarea:focus {border-color:".$main_color.";color:".$main_color.";}
    </style>
    ";
}
add_action('wp_head', 'sk8er_custom_head_style');

function sk8er_custom_css()
{
	global $sk8er;
    echo "<style>". $sk8er['sk8er_custom_css'] ."</style>";
}
add_action('wp_head', 'sk8er_custom_css');

function sk8er_custom_comments($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>

   <div <?php comment_class('single-comment'); ?> id="li-comment-<?php comment_ID() ?>">
	   <?php if ($comment->comment_approved == '0') : ?>
	      <span class="awaiting-moderator"><?php _e('Your comment is awaiting moderation.', 'sk8er') ?></span>
	   <?php endif; ?>
	   <span class="avatar"><?php echo get_avatar( $comment->comment_ID, 120 ); ?></span>

	   <div class="comment-content">
	   		<div class="inside">
	   			<span class="text"><?php comment_text(); ?></span>
	   			<span class="info">
	   				<span><i class="fa fa-user"></i> <?php comment_author_link(); ?></span>
	   				<span><i class="fa fa-clock-o"></i> <?php comment_date(); ?></span>
	   				<span class="reply">
	   					<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth'])))?>
	   				</span>
	   				<span class="reply">
	   					<?php edit_comment_link(); ?>
	   				</span>
	   			</span>
	   		</div>
	   </div>
   </div>

<?php }

/**
 * Ajax Load More
 */
require get_template_directory() . '/inc/theme/loadmore.php';

// Creating the widget
	class sk8er_widget_posts extends WP_Widget {

			function __construct() {
			parent::__construct(
			// Base ID of your widget
			'sk8er_widget_posts',

			// Widget name will appear in UI
			__('Sk8er - Latest Posts', 'sk8er'),

			// Widget description
			array( 'description' => __( '', 'sk8er' ), )
			);
			}

			// Creating widget front-end
			// This is where the action happens
			public function widget( $args, $instance ) {
			$title = apply_filters( 'widget_title', $instance['title'] );
			// before and after widget arguments are defined by themes
			echo $args['before_widget'];
			if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];

			$args = array(
			    'post_type' => 'post',
			    'posts_per_page' => 4,
			);
			$wp_query = new WP_Query( $args );
			?>

				<?php if ($wp_query->have_posts()): ?>
					<div class="latest-post-widget">
						<?php while($wp_query->have_posts()): $wp_query->the_post(); ?>
							<a href="<?php the_permalink(); ?>">
								<span class="image"><?php echo get_the_post_thumbnail( $post->ID, 'full' ); ?></span>
								<span class="details">
									<span class="name"><?php the_title(); ?></span>
									<span class="date"><?php the_time('F d, Y'); ?></span>
								</span>
							</a>
						<?php endwhile; ?>
					</div>
				<?php endif ?>

			</div><!--end of content-->
			</aside><!--end of aside-->
			<?php
			echo $args['after_widget'];
			}
			// Widget Backend
			public function form( $instance ) {
			if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
			}
			else {
			$title = __( 'New title', 'sk8er' );
			}
			// Widget admin form
			?>
			<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'sk8er' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			<?php
			}

			// Updating widget replacing old instances with new
			public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			return $instance;
			}
	} // Class sk8er_widget_posts ends here

// Register and load the widget
	function sk8er_load_widgets() {
		register_widget( 'sk8er_widget_posts' );
	}
	add_action( 'widgets_init', 'sk8er_load_widgets' );




// Creating the widget
	class sk8er_tweets_widget extends WP_Widget {

			function __construct() {
			parent::__construct(
			// Base ID of your widget
			'sk8er_tweets_widget',

			// Widget name will appear in UI
			__('Sk8er - Tweets', 'sk8er'),

			// Widget description
			array( 'description' => __( '', 'sk8er' ), )
			);
			}

			// Creating widget front-end
			// This is where the action happens
			public function widget( $args, $instance ) {
			$title = apply_filters( 'widget_title', $instance['title'] );
			// before and after widget arguments are defined by themes
			echo $args['before_widget'];
			if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];
			?>

			<?php wp_enqueue_script( 'sk8er-tweetie', get_template_directory_uri() . '/tweetie/tweetie.min.js', array(), '1', true ); ?>

			<?php $twitter_username = $instance['twitter_username']; ?>

			<?php if (!empty($twitter_username)): ?>

					<div class="twitter-feed">

						<div class="tweets"></div>

					</div>

					<script>
					(function($) {
						$(window).on('load', function() {
							$('.tweets').twittie({
								username: '<?php echo $twitter_username; ?>',
								count: 3,
								apiPath: '<?php echo get_template_directory_uri() . "/tweetie/api/tweet.php" ?>',
								template: '<p>{{tweet}}<span>{{date}}</span></p>',
							});
						});
					})(jQuery);
					</script>

			<?php endif ?>


			</div><!--end of content-->
			</aside><!--end of aside-->
			<?php
			echo $args['after_widget'];
			}
			// Widget Backend
			public function form( $instance ) {
				if ( isset( $instance[ 'title' ] ) ) {
					$title = $instance[ 'title' ];
				}
				else {
					$title = __( 'New title', 'sk8er' );
				}

				if ( isset( $instance[ 'twitter_username' ] ) ) {
					$twitter_username = $instance[ 'twitter_username' ];
				}
				else {
					$twitter_username = __( 'gordonramsay', 'sk8er' );
				}


			// Widget admin form
			?>
			<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'sk8er' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />

				<br><br>

			<label for="<?php echo $this->get_field_id( 'twitter_username' ); ?>"><?php _e( 'Twitter Username:', 'sk8er' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'twitter_username' ); ?>" name="<?php echo $this->get_field_name( 'twitter_username' ); ?>" type="text" value="<?php echo esc_attr( $twitter_username ); ?>" />
			</p>
			<?php
			}

			// Updating widget replacing old instances with new
			public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['twitter_username'] = ( ! empty( $new_instance['twitter_username'] ) ) ? strip_tags( $new_instance['twitter_username'] ) : '';
			return $instance;
	}
	} // Class sk8er_tweets_widget ends here

	// Register and load the widget
		function sk8er_load_widgets_two() {
			register_widget( 'sk8er_tweets_widget' );
		}
		add_action( 'widgets_init', 'sk8er_load_widgets_two' );
