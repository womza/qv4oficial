<?php
/**
 *  Latest Work Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_s4_portfolio_posts extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'title'         => '',
            'subtitle'      => '',
        ), $atts));

        ob_start();

        wp_enqueue_style('sk8er-slick');
        wp_enqueue_style('sk8er-swipebox');
        ?>

        <?php
            global $post;
            global $sk8er;
            $args = array( 'post_type' => 'portfolio', 'posts_per_page' => -1);
            $wp_query = new WP_Query( $args );
        ?>

        <?php if ( $wp_query->have_posts() ) : ?>

            <section class="style-4 gallery">
                <div class="inner">
                    <div class="container">
                        <?php if (!empty($title) || !empty($subtitle)): ?>
                            <div class="title-bar">
                                <?php if (!empty($subtitle)): ?>
                                    <span><?php echo esc_html($subtitle); ?></span>
                                <?php endif ?>
                                <?php if (!empty($title)): ?>
                                    <h3><?php echo esc_html($title); ?></h3>
                                <?php endif ?>
                            </div>
                        <?php endif ?>

                        <div class="row gallery-wrapper">
                            <div class="gallery-slick">

                                <?php $x=1;$y=1;$total=0; ?>
                                <?php while($wp_query->have_posts()) : $wp_query->the_post(); ?> <?php $total++; ?> <?php endwhile; ?>
                                <?php while($wp_query->have_posts()) : $wp_query->the_post(); ?>
                                        <?php if (has_post_thumbnail( $post->ID ) ): ?>
                                            <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
                                            <?php $thumbnail = $image[0]; ?>
                                        <?php else: ?>
                                            <?php $thumbnail = "http://placehold.it/800x480"; ?>
                                        <?php endif; ?>

                                        <?php if ($x==1): ?>
                                            <div class="one">
                                        <?php endif ?>

                                        <div class="image col-same-height" style="background-image: url(<?php echo esc_url($thumbnail); ?>);">
                                            <div class="hover">
                                                <span class="leftright-border"></span>
                                                <span class="topbottom-border"></span>

                                                <div class="inside">
                                                    <div class="name"><?php the_title(); ?></div>
                                                    <hr>
                                                    <div class="links">
                                                        <a href="<?php echo esc_url($thumbnail); ?>" class="open-image swipebox" rel="gallery-portfolio"><i class="fa fa-search-plus"></i></a>

                                                        <a href="<?php the_permalink(); ?>"><i class="fa fa-chain"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <?php if ($x==2 || $y==$total): ?>
                                            </div>

                                            <?php $x=0; ?>
                                        <?php endif ?>

                                <?php $x++; $y++; endwhile; ?>

                            </div>

                            <div class="gallery-slick-arrows"></div>
                        </div>

                    </div>
                </div>
            </section>

            <section class="style-2 latest-work" style="display: none;">
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
                                                        <?php echo esc_html($category[0]->name); ?>
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
    "name"      => __("Portfolio Posts (layout 3)", 'js_composer'),
    "description" => __('Insert Section with Latest Portfolio Posts', 'js_composer'),
    "base"      => "vc_s4_portfolio_posts",
    "class"     => "vc_s4_portfolio_posts",
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