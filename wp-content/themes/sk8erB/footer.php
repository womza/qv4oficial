<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Sk8er
 */
?>
<?php wp_reset_query(); ?>

<?php
    global $sk8er;
    $copyright="";
    $copyright_url="";

    if (isset($sk8er['sk8er_footer_copyright'])) {
        $copyright = $sk8er['sk8er_footer_copyright'];
    }
    if (isset($sk8er['sk8er_footer_copyright_link'])) {
        $copyright_url = $sk8er['sk8er_footer_copyright_link'];
    }
    if (empty($copyright_url)) {
        $copyright_url = "javascript:void(null);";
    } else {
        $copyright_url = esc_url($copyright_url);
    }
    if (isset($sk8er['sk8er_footer_widget'])) {
        $footer_widget = $sk8er['sk8er_footer_widget'];
    } else {
        $footer_widget = 0;
    }

    $footer_style = $sk8er['sk8er_footer'];
?>

        <?php if (!is_page_template('templates/template-full-page.php') && !is_page_template('templates/template-shop-news.php') && $footer_widget==1 && $footer_style!=3): ?>
            <?php
                $instagram_user=$sk8er['sk8er_footer_instagram_feed'];
                $about_text=$sk8er['sk8er_footer_about_text'];
                $about_link=$sk8er['sk8er_footer_about_link'];
                $about_link_text=$sk8er['sk8er_footer_about_link_text'];
                if (empty($about_link_text)) {
                    $about_link_text = "Leer más";
                }
            ?>
            <div class="big-footer">
                <div class="container">
                    <?php if (!empty($about_text) || !empty($about_link)): ?>
                        <div class="col-md-4 site-info block">
                            <h3><?php bloginfo('title'); ?></h3>
                            <p><?php echo esc_html($about_text); ?></p>

                            <?php if (!empty($about_link)): ?>
                                <a href="<?php echo esc_url($about_link); ?>" class="ia" target="_blank"><?php echo esc_html($about_link_text); ?></a>
                            <?php endif ?>
                            
                        </div>
                    <?php endif ?>
                    

                    <?php wp_reset_query(); ?>
                    <?php
                        $args = array( 'post_type' => 'post', 'posts_per_page' => 3, 'post__not_in' => get_option('sticky_posts'),);
                        $wp_query = new WP_query($args);
                    ?>

                    <?php if ($wp_query->have_posts()): ?>
                        <div class="col-md-4 block">
                            <div class="name"><?php _e( 'Ultimas Noticias' , 'sk8er' ); ?></div>
                            <div class="posts-list">

                                <?php while($wp_query->have_posts()): $wp_query->the_post(); ?>

                                    <div class="single-post">
                                        <a href="<?php the_permalink(); ?>" class="ia">
                                            <span class="post-name"><?php the_title(); ?></span>
                                            <span class="post-date">
                                                <i class="fa fa-clock-o"></i> <?php the_time('F n, Y'); ?>
                                            </span>
                                        </a>
                                    </div>

                                <?php endwhile; ?>

                            </div>
                        </div>
                    <?php endif ?>

                    <?php if (!empty($instagram_user)): ?>
                        
                        <div class="col-md-4 block">
                            <div class="name">Instagram</div>
                            <div class="instagram-list" id="instafeed">

                            </div>
                        </div>

                        <script>
                            (function($) {
                                $(document).ready(function() {
                                    var feed = new Instafeed({
                                        get: 'user',
                                        userId: <?php echo esc_js($instagram_user); ?>,
                                        limit: 8,
                                        resolution: 'standard_resolution',
                                        accessToken: '30592662.e95b467.6f46ebe0a83e4301b9e1b0ce820dd87b',
                                        template : '<a href="{{link}}" target="_blank" class="single-instagram col-same-height"><span><img src="{{image}}" /></span></a>'
                                    });
                                    feed.run();
                                });
                            })(jQuery);
                        </script>

                    <?php endif ?>


                </div>
            </div>
        <?php endif ?>

        <?php if (!is_page_template('templates/template-full-page.php') && !is_404()): ?>
            <?php if ($footer_style==1): ?>
                <footer class="main">
                    <?php if (!is_page_template('templates/template-shop-news.php')): ?>
                        <a href="javascript:void(null);" class="go-to-top">
                            <i class="fa fa-chevron-up"></i>
                        </a>    
                    <?php endif ?>
                    
                    <div class="container">
                        <div class="left site-links">
                            <?php
                                if ( has_nav_menu( 'footer' ) ) {
                                    $menuParameters = array(
                                        'theme_location' => 'footer',
                                        'container'       => false,
                                        'echo'            => false,
                                        'items_wrap'      => '%3$s',
                                        'depth'           => 1,
                                    );

                                    echo strip_tags(wp_nav_menu( $menuParameters ), '<a>' );
                                } else {
                                    echo '<a href="'.admin_url().'nav-menus.php">'.__('Create your menu', 'sk8er').'</a>';
                                }
                            ?>
                        </div>

                        <div class="right copyright">
                            <a href="<?php echo esc_url($copyright_url); ?>" target="_blank"><?php echo esc_html($copyright); ?></a>
                        </div>
                    </div>
                </footer>
            <?php endif ?>

            <?php if ($footer_style==2): ?>
                <footer class="text">
                    <div class="inner">
                        <div class="container">
                            <p><a href="<?php echo esc_url($copyright_url); ?>" target="_blank"><?php echo esc_html($copyright); ?></a></p>
                        </div>
                    </div>
                </footer>
            <?php endif ?>

            <?php if ($footer_style==3): ?>
                <?php
                    $footer_info = $sk8er['sk8er_footer_info'];
                    $subscribe_form = $sk8er['sk8er_footer_subscribe'];
                ?>
                <div class="big-footer-2">
                    <div class="edge-cut"></div>

                    <div class="container">

                    <?php if (!empty($subscribe_form)): ?>
                        <div class="subscribe-form">
                            <?php echo do_shortcode($subscribe_form); ?>
                        </div>
                    <?php endif ?>


                        <div class="footer-info">
                            <?php foreach ($footer_info as $info): ?>
                                <?php if (!empty($info['title'])): ?>
                                    
                                    <div class="box">
                                        <div class="icon">
                                            <i class="fa <?php echo esc_attr($info['url']); ?>"></i>
                                        </div>
                                        <div class="content">
                                            <div class="name"><?php echo esc_html($info['title']); ?></div>
                                            <p><?php echo esc_html($info['description']); ?></p>
                                        </div>
                                    </div>

                                <?php endif ?>
                            <?php endforeach ?>
                        </div>

                        <div class="copyright-text">
                            <a href="<?php echo esc_url($copyright_url); ?>" target="_blank" class="ia"><?php echo esc_html($copyright); ?></a>
                        </div>

                    </div>
                </div>
            <?php endif ?>

        <?php else: ?>
            <footer class="main">
                <div class="container">
                    <div class="left site-links">
                        <?php
                            if ( has_nav_menu( 'footer' ) ) {
                                $menuParameters = array(
                                    'theme_location' => 'footer',
                                    'container'       => false,
                                    'echo'            => false,
                                    'items_wrap'      => '%3$s',
                                    'depth'           => 1,
                                );

                                echo strip_tags(wp_nav_menu( $menuParameters ), '<a>' );
                            } else {
                                echo '<a href="'.admin_url().'nav-menus.php">'.__('Create your menu', 'sk8er').'</a>';
                            }
                        ?>
                    </div>

                    <div class="right copyright">
                        <a href="<?php echo esc_url($copyright_url); ?>" target="_blank"><?php echo esc_html($copyright); ?></a>
                    </div>
                </div>
            </footer>
        <?php endif ?>
    </div>
</div>

<?php if (is_page_template('templates/template-full-page.php')): ?>
    <script>
        (function($) {
            $(document).ready(function() {
              if ($(window).width() > 1028 && Modernizr.csstransforms3d) {
                $(".fullscreen-holder").onepage_scroll({
                   sectionContainer: ".fullscreen-section",     // sectionContainer accepts any kind of selector in case you don't want to use section
                   easing: "ease",
                   updateURL: false,
                   direction: "vertical",
                   afterMove: function(index) {
                        $('.animate-el.el-' + index).addClass('animated fadeInUp');
                    }
                });
              }
            });
        })(jQuery);
    </script>
<?php endif ?>

<?php wp_footer(); ?>
</body>
</html>
