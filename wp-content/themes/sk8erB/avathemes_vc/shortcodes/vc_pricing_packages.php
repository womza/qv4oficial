<?php
/**
 * Pricing Packages for Visual Composer
 */

class WPBakeryShortCode_vc_pricing_packages extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'title' => '',
        ), $atts));

        ob_start();
        ?>

        <?php
            global $post;
            global $sk8er;
            $args = array( 'post_type' => 'pricing_packages', 'posts_per_page' => -1, 'order' => 'ASC');
            $wp_query = new WP_Query( $args );
        ?>

        <section class="style-misc pricing-tables">
            <div class="inner">
                <div class="container">
                    <?php if (!empty($title)): ?>
                        <div class="title-bar">
                            <h3><?php echo esc_html($title); ?></h3>
                        </div>
                    <?php endif ?>

                    <?php if ($wp_query->have_posts()): ?>
                        <div class="row tables">
                            
                            <?php while($wp_query->have_posts()): $wp_query->the_post(); ?>
                                <?php
                                    $desc = get_post_meta($post->ID, 'sk8er_pricing_package_description', true);
                                    $price_currency = get_post_meta($post->ID, 'sk8er_pricing_package_price_currency', true);
                                    $price = get_post_meta($post->ID, 'sk8er_pricing_package_price', true);
                                    $paying_period = get_post_meta($post->ID, 'sk8er_pricing_package_paying_period', true);
                                    $best = get_post_meta($post->ID, 'sk8er_pricing_package_best', true);
                                ?>

                                <div class="col-md-4">
                                    <?php if ($best=="on"): ?>
                                        <div class="box best">
                                    <?php else: ?>
                                        <div class="box">
                                    <?php endif ?>

                                        <div class="column">
                                            <a href="javascript:void(null);"></a>
                                            <div class="name">
                                                <h3><?php the_title(); ?></h3>
                                                <span><?php echo esc_html($desc); ?></span>
                                            </div>
                                            <div class="info">
                                                <p>60 GB Space</p>
                                                <p>Unlimited downloads</p>
                                                <p>No ads, ever.</p>
                                            </div>
                                            <div class="price">
                                                <span class="currency"><?php echo esc_html($price_currency); ?></span>
                                                <span class="cost"><?php echo esc_html($price); ?><span>
                                                    <?php if ($paying_period=="month"): ?>
                                                        /mo
                                                    <?php elseif($paying_period=="year"): ?>
                                                        /y
                                                    <?php endif ?>
                                                </span></span>
                                            </div>
                                        </div>

                                        <p class="addinfo"><?php the_content(); ?></p>
                                    </div>
                                </div>

                            <?php endwhile; ?>

                        </div>
                    <?php endif ?>
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
    "name"      => __("Pricing Packages", 'js_composer'),
    "description" => __('Insert Section with Pricing Packages', 'js_composer'),
    "base"      => "vc_pricing_packages",
    "class"     => "vc_pricing_packages",
    "icon"      => "icon-class",
    "controls"  => "full",
    "category"  => __('AvaThemes', 'js_composer'),
    "params"    => array(
        array(
            "type"        => "nothing",
            "heading"     => __("From the left side menu, choose Pricing Packages and then from there add packages.", 'js_composer'),
            "param_name"  => "nothing",
            "value"       => "",
            "description" => __("<b>BUT</b> you still need to have this block inserted on page!", 'js_composer')
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("Title", 'js_composer'),
            "param_name"  => "title",
            "value"       => "",
            "description" => __("Add title for your section", 'js_composer')
        ),
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);