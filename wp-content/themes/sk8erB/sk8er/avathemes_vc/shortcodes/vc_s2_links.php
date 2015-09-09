<?php
/**
 * Links Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_s2_links extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            
        ), $atts));

        ob_start();
        ?>

        <?php global $sk8er; global $post; ?>

        <?php
            $args = array( 'post_type' => 'page_links', 'posts_per_page' => -1);
            $wp_query = new WP_Query( $args );
        ?>

        <?php if ($wp_query->have_posts()): ?>
            <section class="style-2 page-links">
                <div class="container">
                    <div class="row">

                        <?php while($wp_query->have_posts()): $wp_query->the_post(); ?>
                            <?php $url = get_post_meta($post->ID, 'sk8er_pagelink_url', true); ?>
                            <?php $url = esc_url($url); ?>
                            <?php if (empty($url)): ?>
                                <?php $url = "javascript:void(null);" ?>
                            <?php endif ?>

                            <?php if (has_post_thumbnail( $post->ID ) ): ?>
                                <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
                            <?php else: ?>
                                <?php $image = ""; ?>
                            <?php endif; ?>

                            <div class="one-link-wrapper">
                                <div class="one-link" style="background-image: url(<?php echo esc_url($image[0]); ?>);">
                                    <a href="<?php echo esc_url($url); ?>" target="_blank">
                                        <span class="inside">
                                            <span class="leftright-border"></span>
                                            <span class="topbottom-border"></span>

                                            <span class="name"><?php the_title(); ?></span>
                                            <span class="desc"><?php echo get_the_content(); ?></span>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        <?php endwhile; ?>

                    </div>
                </div>
            </section>

        <?php endif ?>

        <?php
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}



$opts = array(
    "name"      => __("Links Block", 'js_composer'),
    "description" => __('Insert Section with Links', 'js_composer'),
    "base"      => "vc_s2_links",
    "class"     => "vc_s2_links",
    "icon"      => "icon-class",
    "controls"  => "full",
    "category"  => __('AvaThemes', 'js_composer'),
    "params"    => array(
        array(
            "type"        => "nothing",
            "heading"     => __("You should go to <b>Page Links</b> from the left menu and from there add links you want.", 'js_composer'),
            "param_name"  => "nothing",
            "value"       => "",
            "description" => __("<b>BUT</b> you still need to have this block inserted on page!", 'js_composer')
        ),
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);