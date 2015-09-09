<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Sk8er
 */
global $sk8er;
$hover_color = sk8er_hex2rgba($sk8er['sk8er_hover_color']['color'], $sk8er['sk8er_hover_color']['alpha']);
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php if (!empty($sk8er['sk8er_favicon'])): ?>
    <link rel="shortcut icon" type="image/png" href="<?php echo esc_url($sk8er['sk8er_favicon']['url']); ?>"/>
<?php endif ?>
<?php if (!empty($sk8er['sk8er_google_analytics'])): ?>
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', '<?php echo esc_js($sk8er["sk8er_google_analytics"]); ?>', 'auto');
      ga('send', 'pageview');

    </script>
<?php endif ?>

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
<!--[if lt IE 8]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<?php global $sk8er_header_style, $sk8er_theme_class, $sk8er_affect_class; $widget_sidebar_bg = $sk8er['sk8er_widget_sidebar_bg']; ?>
<?php wp_enqueue_style('sk8er-animate'); ?>

<?php if (is_home() || is_front_page()): ?>
    <div class="preloader"></div>
<?php endif ?>



<?php if (isset($sk8er['sk8er_header'])): ?>
    <?php $header_style = $sk8er['sk8er_header']; ?>
<?php else: ?>
    <?php $header_style=1; ?>
<?php endif ?>

<?php $sk8er_header_style = $header_style; ?>

<?php
    if ($header_style==5) { $menualwaysclass = "class='menualways'"; } else { $menualwaysclass = ""; }
?>

<div id="site-wrapper" <?php echo wp_kses($menualwaysclass, ''); ?>>
    <?php if (!is_page_template('templates/template-coming-soon.php')): ?>

        <?php
            global $sk8er, $sk8er_theme_class, $sk8er_affect_class;
            $header_submenu_theme = $sk8er['sk8er_header_submenu_theme'];
            if ($header_submenu_theme=='theme_light') {
                $sk8er_theme_class = 'theme-light';
            } else {
                $sk8er_theme_class = 'theme-dark';
            }

            $sk8er_theme_class = $sk8er_theme_class;

            if (isset($sk8er['header_over_next'])) {
                $header_affect = $sk8er['header_over_next'];
            } else {
                $header_affect = 0;
            }

            if ($header_affect==1) {
                $affect_class = 'noaffect';
            } else {
                $affect_class = 'bg-black';
            }

            $sk8er_affect_class = $affect_class;
        ?>

        <?php if ($header_style==9 || $header_style==10): ?>
            <div id="site-content">
        <?php endif ?>

        <?php
            switch ($header_style) {
                case 1:
                    get_template_part('inc/theme/headers/header-1');
                    break;
                case 2:
                    get_template_part('inc/theme/headers/header-2');
                    break;
                case 3:
                    get_template_part('inc/theme/headers/header-2');
                    break;
                case 4:
                    get_template_part('inc/theme/headers/header-4');
                    break;
                case 5:
                    get_template_part('inc/theme/headers/header-5');
                    break;
                case 6:
                    get_template_part('inc/theme/headers/header-6');
                    break;
                case 7:
                    get_template_part('inc/theme/headers/header-7');
                    break;
                case 8:
                    get_template_part('inc/theme/headers/header-1');
                    break;
                case 9:
                    get_template_part('inc/theme/headers/header-9');
                    break;
                case 10:
                    get_template_part('inc/theme/headers/header-10');
                    break;
                case 11:
                    get_template_part('inc/theme/headers/header-1');
                    break;
                case 12:
                    get_template_part('inc/theme/headers/header-12');
                    break;
                default:
                    get_template_part('inc/theme/headers/header-1');
                    break;
            }
        ?>

    <?php endif ?>

    <a href="javascript:void(null);" class="back-to-top"><?php _e('Back to top', 'sk8er') ?></a>

    <?php if ($header_style!=9 && $header_style!=10): ?>
        <div id="site-content">
    <?php endif ?>

        <!-- WIDGET/MENU SIDEBAR BLACKOUT -->
        <div class="blackout"></div>
        <!-- WIDGET/MENU SIDEBAR BLACKOUT -->

        <!-- MENU SIDEBAR -->
        <div id="menu-sidebar">
            <div class="inner">
            <?php if ($header_style==5): ?>
            	<div class="logo">
            	    <a href="<?php echo site_url(); ?>">
            	        <?php if (!empty($sk8er['sk8er_logo']['url'])): ?>
            	                <img src="<?php echo esc_url($sk8er['sk8er_logo']['url']); ?>" alt="<?php echo bloginfo('title'); ?>">
            	            <?php else: ?>
            	                <span class="txt-logo"><?php echo bloginfo('title'); ?></span>
            	        <?php endif ?>
            	    </a>
            	</div>
            <?php endif ?>


                <nav>
                    <ul>
                        <?php
                            if ( has_nav_menu( 'primary' ) ) {
                                // User has assigned menu to this location;
                                // output it
                                wp_nav_menu( array(
                                    'theme_location' => 'primary',
                                    'menu_class' => 'nav',
                                    'container' => '',
                                    'items_wrap'      => '%3$s',
                                ) );
                            } else {
                                echo '<li><a href="'.admin_url().'nav-menus.php">'.__('Create your menu', 'sk8er').'</a></li>';
                            }
                        ?>
                        <?php if (class_exists('woocommerce')): ?>
                        	<?php $cart = WC()->cart->get_cart(); global $woocommerce; ?>

                       		<li class="cart"><a href="<?php echo esc_url($woocommerce->cart->get_cart_url()); ?>"><i class="fa fa-shopping-cart"></i><?php echo esc_attr($woocommerce->cart->cart_contents_count); ?></a></li>
                    	<?php endif; ?>
                    </ul>
                </nav>

                <?php if (isset($sk8er['sk8er_social'])): ?>
                    <?php $sk8er_social = $sk8er['sk8er_social']; ?>

                    <?php if (!empty($sk8er_social[0]['url'])): ?>
                        <footer>
                            <ul>
                                <?php foreach ($sk8er_social as $social): ?>
                                    <li><a href="<?php echo esc_url($social['url']); ?>" title="<?php echo esc_attr($social['title']); ?>" target="_blank"><i class="fa <?php echo esc_attr($social['description']); ?>"></i></a></li>
                                <?php endforeach ?>
                            </ul>
                        </footer>
                    <?php endif ?>
                <?php endif ?>
            </div>
        </div>
        <!-- MENU SIDEBAR -->


        <!-- WIDGET SIDEBAR -->
        <div id="widget-sidebar" style="background-color: <?php echo esc_attr($widget_sidebar_bg); ?>;">
            <div class="inner">
                <?php if (is_active_sidebar('sidebar-menu')): ?>
                    <?php dynamic_sidebar( 'sidebar-menu' ); ?>
                <?php else: ?>
                    <div class="box">
                        <h5><a href="<?php echo admin_url(); ?>widgets.php" class="ia">+ <?php _e( 'Add Widgets here to Menu Sidebar' , 'sk8er' ); ?></a></h5>
                    </div>
                <?php endif ?>
            </div>
        </div>
        <!-- WIDGET SIDEBAR -->
        <?php if (class_exists('woocommerce') && is_woocommerce()): ?>


        <?php elseif(!is_404() && !is_page_template('templates/template-custom-page.php') && !is_page_template('templates/template-full-page.php') && !is_page_template('templates/template-posts-page.php') && !is_page_template('templates/template-shop-news.php') && !is_page_template('templates/template-full-members.php') && !is_page_template('templates/template-coming-soon.php') && $header_style!=10): ?>

                <?php if (is_single() && has_post_thumbnail() || is_page() && has_post_thumbnail()): ?>
                        <?php $thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
                        <div class="big-page-title s-2" style="background-image: url(<?php echo esc_url($thumb_url[0]); ?>);">
                    <?php elseif(is_single() && !has_post_thumbnail() || is_page() && !has_post_thumbnail()): ?>
                        <div class="big-page-title s-2" style="background-image: url();">
                    <?php elseif(is_category()): ?>
                        <?php $categoryID = $cat; ?>
                        <?php $cat_bg = Taxonomy_MetaData::get( 'category', $categoryID, 'sk8er_category_image' ); ?>
                        <?php
                            if (!empty($cat_bg)) {
                                $cat_background = $cat_bg;
                            } else if(!empty($sk8er["sk8er_bigpagetitle_background"]["url"])) {
                                $cat_background = $sk8er["sk8er_bigpagetitle_background"]["url"];
                            } else {
                                $cat_background = '';
                            }
                        ?>

                        <div class="big-page-title s-2" style="background-image: url(<?php echo esc_url($cat_background); ?>);">
                    <?php else: ?>
                        <?php
                            if (!empty($sk8er['sk8er_bigpagetitle_background']['url'])) {
                                $bigpagebg = 'style="background-image: url('.$sk8er["sk8er_bigpagetitle_background"]["url"].');"';
                            } else {
                                $bigpagebg = '';
                            }
                        ?>
                        <div class="big-page-title s-2" <?php echo wp_kses($bigpagebg, ''); ?>>
                <?php endif; ?>

                    <div class="container">
                        <div class="valign animate-el fadeIn">
                        <?php if (is_archive()): ?>
                                <?php
                                    the_archive_title( '<h3>', '</h3>' );
                                    the_archive_description( '<span>', '</span>' );
                                ?>
                            <?php elseif(is_search()): ?>

                                <h3><?php printf( __( 'Search Results for: %s', 'sk8er' ), '<span>' . get_search_query() . '</span>' ); ?></h3>
                            <?php elseif('shop_news' == get_post_type()): ?>
                                <?php
                                    $smaller_title      = get_post_meta($post->ID, 'sk8er_shop_news_title_smaller', true);
                                    $bigger_title       = get_post_meta($post->ID, 'sk8er_shop_news_title_bigger', true);
                                ?>

                                <?php if (get_the_title()): ?>
                                        <h3><?php the_title(); ?></h3>
                                    <?php else: ?>
                                        <h3><?php echo esc_html($smaller_title).' '.esc_html($bigger_title); ?></h3>
                                <?php endif ?>
                            <?php elseif(is_single()): ?>
                                <?php while ( have_posts() ) : the_post(); ?>
                                    <?php if ( 'services' == get_post_type() ): ?>
                                        <?php $icon = get_post_meta($post->ID, 'sk8er_services_icon', true); ?>
                                        <span style="margin-top: 0;padding-bottom: 15px;font-size: 50px;line-height: 1;"><i class="fa <?php echo esc_attr($icon); ?>"></i></span>
                                    <?php endif; ?>
                                    <h3><?php the_title(); ?></h3>
                                    <?php if ('services' != get_post_type()): ?>
                                        <span><?php sk8er_posted_on(); ?></span>
                                    <?php endif ?>

                                <?php endwhile; // end of the loop. ?>
                            <?php elseif(is_page()): ?>
                                    <h3><?php the_title(); ?></h3>
                            <?php else: ?>

                                <h3><?php bloginfo('title'); ?></h3>
                                <span><?php bloginfo('description'); ?></span>
                        <?php endif ?>
                        </div>
                    </div>
                </div>

        <?php endif; ?>



        <?php if (is_page()): ?>
            <?php $rev = get_post_meta( $post->ID, 'sk8er_page_revolution_slider', true ); ?>
            <?php if (isset($rev) && !empty($rev)): ?>
                <?php echo do_shortcode($rev); ?>
            <?php endif ?>
        <?php endif ?>