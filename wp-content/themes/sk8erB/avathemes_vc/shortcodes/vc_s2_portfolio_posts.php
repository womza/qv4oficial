<?php
/**
 *  Latest Work Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_s2_portfolio_posts extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'title'         => '',
            'subtitle'      => '',
        ), $atts));

        ob_start();
        ?>

        <?php
            global $post;
            global $sk8er;
            $args = array( 'post_type' => 'portfolio', 'posts_per_page' => 5);
            $wp_query = new WP_Query( $args );
        ?>

        <?php if ( $wp_query->have_posts() ) : ?>

            <section class="style-2 latest-work">
                <div class="inner">
                    <div class="container">
                        <div class="title-bar">
                            <?php if (!empty($subtitle)): ?>
                                <span><?php echo esc_html($subtitle); ?></span>
                            <?php endif ?>
                            <?php if (!empty($title)): ?>
                                <h3><?php echo esc_html($title); ?></h3>
                            <?php endif ?>
                        </div>

                        <div class="row works">
                            <?php $x=1; ?>
                            <?php while($wp_query->have_posts()) : $wp_query->the_post(); ?>
                                <?php 
                                    $style = "";
                                    $sk8er_portfolio_images = get_post_meta($post->ID, 'sk8er_portfolio_images', true);
                                ?>
                                <?php if (has_post_thumbnail()): ?>
                                        <?php
                                            $thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
                                            $style = "style='background-image: url(".$thumb_url[0].");'";
                                        ?>
                                    <?php elseif(!empty($sk8er_portfolio_images)): ?>
                                        <?php
                                            $image_x=1;
                                            foreach ($sk8er_portfolio_images as $image) {
                                                if ($image_x==1) {
                                                    $style = "style='background-image: url(".$image.");'";
                                                }

                                                $image_x++;
                                            }
                                        ?>
                                <?php endif; ?>  

                                <?php if ($x==1 || $x==5): ?>
                                        <div class="col-md-7 work">
                                    <?php else: ?>
                                        <div class="col-md-5 work">
                                <?php endif ?>

                                            <div class="box">
                                                <div class="text">
                                                    <a href="<?php the_permalink(); ?>" class="name">
                                                        <?php the_title(); ?>
                                                    </a>
                                                    <span class="short-desc">
                                                        <?php
                                                            $category =  wp_get_object_terms( $post->ID, 'portfolio-categories', array('orderby'=>'term_order'));
                                                        ?>
                                                        <?php if (!empty($category)): ?>
                                                            <?php echo esc_html($category[0]->name); ?>
                                                        <?php endif ?>
                                                    </span>
                                                    <?php if ($x==1): ?>
                                                        <span class="short-content">
                                                            <?php echo sk8er_excerpt(30); ?>
                                                        </span>
                                                    <?php endif ?>
                                                </div>
                                                
                                                <div class="image" <?php echo wp_kses($style, ''); ?>>
                                                    <a href="<?php the_permalink(); ?>" class="full-link">
                                                        <span class="leftright-border"></span>
                                                        <span class="topbottom-border"></span>
                                                    </a>
                                                </div>
                                                
                                            </div>
                                        </div>
                            <?php $x++; endwhile; ?>
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
    "name"      => __("Portfolio Posts (layout 2)", 'js_composer'),
    "description" => __('Insert Section with Latest Portfolio Posts', 'js_composer'),
    "base"      => "vc_s2_portfolio_posts",
    "class"     => "vc_s2_portfolio_posts",
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