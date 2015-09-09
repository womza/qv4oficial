<?php
/**
 *  Portfolio Posts Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_s17_portfolio_posts extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'title'     => '',
            'subtitle'  => '',
        ), $atts));

        ob_start();
        ?>

        <?php
            global $post;
            global $sk8er;
            $args = array( 'post_type' => 'portfolio', 'posts_per_page' => 10);
            $wp_query = new WP_Query( $args );
        ?>

        <?php if ( $wp_query->have_posts() ) : ?>

            <section class="style-17 portfolio">
                    <?php if (!empty($title) || !empty($subtitle)): ?>
                    <div class="inner">
                        <div class="container">
                            <div class="title-bar">
                                <?php if (!empty($title)): ?>
                                    <h3><?php echo esc_html($title); ?></h3>
                                <?php endif ?>
                                <?php if (!empty($subtitle)): ?>
                                    <span><?php echo esc_html($subtitle); ?></span>
                                <?php endif ?>
                            </div>
                        </div>

                    <?php else: ?>

                    <div class="inner" style="padding-top: 0;">
                    <?php endif ?>
                    

                    <?php if (!empty($title) || !empty($subtitle)): ?>
                        <div class="row portfolio-gallery-wrapper">

                        <?php else: ?>

                        <div class="row portfolio-gallery-wrapper" style="margin-top: 0;">
                    <?php endif ?>

                        <div class="portfolio-gallery">
                            <?php $x=1;$y=1;$total=1; ?>

                            <?php while($wp_query->have_posts()) : $wp_query->the_post(); ?><?php $total++ ?><?php endwhile; ?>

                            <?php while($wp_query->have_posts()) : $wp_query->the_post(); ?>
                                <?php if (has_post_thumbnail() ): ?>
                                    <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
                                    <?php $thumbnail = $image[0]; ?>
                                <?php else: ?>
                                    <?php $thumbnail = "http://placehold.it/800x480"; ?>
                                <?php endif; ?>

                                <?php if ($x==1): ?>
                                    <!-- one column -->
                                        <div class="column">
                                <?php endif ?>

                                <div class="single">
                                    <div class="image" style="background-image: url(<?php echo esc_url($thumbnail); ?>);">
                                        <a href="<?php the_permalink(); ?>">
                                            <i class="fa fa-external-link"></i>
                                        </a>
                                    </div>
                                    <div class="content">
                                        <div class="inside">
                                            <span class="name"><?php the_title(); ?></span>
                                            <p><?php echo sk8er_excerpt(15); ?></p>
                                        </div>
                                    </div>
                                </div>

                                <?php if ($x==2 || $y==$total-1): ?>
                                        </div>
                                    <!-- end of one column -->
                                    <?php $x=0; ?>
                                <?php endif ?>
                            <?php $x++; $y++; endwhile; ?>

                        </div>
                    </div>
                </div>
            </section>

        <?php endif; ?>

        <?php
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}



$opts = array(
    "name"      => __("Portfolio Posts (layout 5)", 'js_composer'),
    "description" => __('Insert Section with Latest Portfolio Posts', 'js_composer'),
    "base"      => "vc_s17_portfolio_posts",
    "class"     => "vc_s17_portfolio_posts",
    "icon"      => "icon-class",
    "controls"  => "full",
    "category"  => __('AvaThemes', 'js_composer'),
    "params"    => array(
        array(
            "type"        => "textfield",
            "heading"     => __("Title", 'js_composer'),
            "param_name"  => "title",
            "value"       => "",
            "description" => __("Add title for your section", 'js_composer')
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("Subtitle", 'js_composer'),
            "param_name"  => "subtitle",
            "value"       => "",
            "description" => __("Add subtitle for your section", 'js_composer')
        ),
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);