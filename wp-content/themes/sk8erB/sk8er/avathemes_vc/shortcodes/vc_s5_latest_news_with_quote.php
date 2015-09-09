<?php
/**
 *  Latest News Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_s5_latest_news_with_quote extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'category'         => '',
            'quote'            => '',
            'page_slug'        => '',
            'quote_by'         => '',
            'quote_position'   => '',
            'quote_quote'      => '',
            'quote_image'      => '',
        ), $atts));

        ob_start();
        ?>


        <?php
            global $post;
            global $sk8er;
            if ($quote=="yes") {
                $ppp = 4;
            } else {
                $ppp = 6;
            }
            $args = array( 'post_type' => 'post', 'posts_per_page' => $ppp, 'category_name' => ''.$category.'');
            $wp_query = new WP_Query( $args );
        ?>

        <section class="style-5 news">
            <div class="inner">
                <div class="container">
                    <div class="row equalize_this">
                        <?php if ( $wp_query->have_posts() ) : ?>

                        <?php if ($quote=="yes"): ?>
                            <div class="col-md-8">
                                <?php else: ?>
                            <div class="col-md-12">
                        <?php endif ?>

                            <div class="row list">

                                <?php while ($wp_query->have_posts() ) : $wp_query->the_post(); ?>
                                <?php if (has_post_thumbnail( $post->ID ) ): ?>
                                    <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
                                    <?php $thumbnail = $image[0]; ?>
                                <?php else: ?>
                                    <?php $thumbnail = ""; ?>
                                <?php endif; ?>

                                <?php if ($quote=="yes"): ?>
                                    <div class="col-md-6">
                                        <?php else: ?>
                                    <div class="col-md-4">
                                <?php endif ?>
                                
                                    <div class="box" style="background-image: url(<?php echo esc_url($thumbnail); ?>);">
                                        <a href="<?php the_permalink(); ?>">
                                            <span class="main-info">
                                                <span class="name"><?php the_title(); ?></span>
                                                <span class="date"><?php the_time('d.n.Y'); ?></span>
                                            </span>

                                            <div class="content">
                                                <p class="text"><?php echo sk8er_excerpt(20); ?></p>
                                            </div>
                                        </a>
                                    </div>
                                </div>

                                <?php endwhile; ?>

                            </div>
                            <div class="row more">
                                <div class="col-xs-12">
                                    <div class="get-more">
                                        <a href="<?php echo site_url(); ?>/<?php echo esc_attr($page_slug); ?>"><i class="fa fa-newspaper-o"></i><?php _e('More News', 'sk8er'); ?></a>
                                    </div> 
                                </div>
                            </div>
                        </div>

                        <?php endif; ?>

                        <?php if ($quote=="yes"): ?>
                            <?php $image_url = wp_get_attachment_image_src( $quote_image, 'full' ); ?>

                            <div class="col-md-4">
                                <div class="quote">
                                    <div class="top">
                                        <img src="<?php echo esc_url($image_url[0]); ?>" alt="">
                                        <div class="info">
                                            <span class="name"><?php echo esc_html($quote_by); ?></span>
                                            <span class="position"><?php echo esc_html($quote_position); ?></span>
                                        </div>
                                        <div class="cut"></div>
                                        <div class="cut2"></div>
                                    </div>
                                    <div class="bottom">
                                        <p><?php echo esc_html($quote_quote); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endif ?>
                        

                    </div>
                </div>
            </div>
        </section>

        <?php
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}



$opts = array(
    "name"      => __("Latest Posts with Quote", 'js_composer'),
    "description" => __('Insert Section with Latest Posts', 'js_composer'),
    "base"      => "vc_s5_latest_news_with_quote",
    "class"     => "vc_s5_latest_news_with_quote",
    "icon"      => "icon-class",
    "controls"  => "full",
    "category"  => __('AvaThemes', 'js_composer'),
    "params"    => array(
        array(
            "type"        => "textfield",
            "heading"     => __("Loop from Category (category slug) or leave empty to loop from all categories", 'js_composer'),
            "param_name"  => "category",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("Page slug with posts (for <i>view more</i> link)", 'js_composer'),
            "param_name"  => "page_slug",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
        array(
            'type' => 'checkbox',
            'heading' => __( 'Show Quote?', 'js_composer' ),
            'param_name' => 'quote',
            'description' => __( '', 'js_composer' ),
            'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
            'std' => ''
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("[Quote] By", 'js_composer'),
            "param_name"  => "quote_by",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("[Quote] Position", 'js_composer'),
            "param_name"  => "quote_position",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
        array(
            "type"        => "textarea",
            "heading"     => __("[Quote] Quote", 'js_composer'),
            "param_name"  => "quote_quote",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
        array(
            "type"        => "attach_image",
            "heading"     => __("[Quote] Image", 'js_composer'),
            "param_name"  => "quote_image",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);