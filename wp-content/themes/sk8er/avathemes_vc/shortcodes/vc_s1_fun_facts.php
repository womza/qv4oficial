<?php
/**
 * Fun Facts Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_s1_fun_facts extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'title'    => '',
            'subtitle'    => '',
            'layout'    => '',
        ), $atts));

        ob_start();
        ?>

        <?php
            global $post;
            global $sk8er;
            $args = array( 'post_type' => 'fun_facts', 'posts_per_page' => -1, 'order' => 'ASC');
            $wp_query = new WP_Query( $args );
        ?>

        <?php if ($layout=="layout_1"): ?>
            <section class="style-1 fun-facts">
                <!-- max limit 4 -->
                <div class="row">
                    <div class="col-md-5 bgtitle">
                        <?php if (!empty($title) || !empty($subtitle)): ?>
                            <div class="title-bar">
                                <?php if (!empty($title)): ?>
                                    <h3><?php echo esc_html($title); ?></h3>
                                <?php endif ?>
                                <?php if (!empty($subtitle)): ?>
                                    <span><?php echo esc_html($subtitle); ?></span>
                                <?php endif ?>
                            </div>
                        <?php endif ?>
                    </div>

                    <?php if ($wp_query->have_posts()): ?>
                        <div class="col-md-7 fun-fact-block-holder">
                            <?php while($wp_query->have_posts()): $wp_query->the_post(); ?>
                                <?php $number = get_post_meta($post->ID, 'sk8er_funfacts_number', true); ?>
                                <div class="fun-fact-block">
                                    <div class="inside" data-number="<?php echo esc_attr($number); ?>">
                                        <h3><?php the_title(); ?></h3>
                                        <span><?php echo get_the_content(); ?></span>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php endif ?>
                </div>
            </section>
        <?php endif ?>

        <?php if ($layout=="layout_2"): ?>
            <section class="style-13 fun-facts">
                <div class="container">
                    <?php if ($wp_query->have_posts()): ?>
                        <?php while($wp_query->have_posts()): $wp_query->the_post(); ?>
                            <?php $number = get_post_meta($post->ID, 'sk8er_funfacts_number', true); ?>

                            <div class="fact">
                                <div class="count">
                                    <span><?php echo esc_html($number); ?></span>
                                </div>
                                <div class="name">
                                    <?php the_title(); ?> <?php echo get_the_content(); ?>
                                </div>
                            </div>

                        <?php endwhile; ?>
                    <?php endif; ?>

                </div>
            </section>
        <?php endif ?>


        <?php if ($layout=="layout_3"): ?>
            <?php if ($wp_query->have_posts()): ?>
                
                <section class="style-18 stats">
                    <div class="container">
                        <div class="list">

                            <?php while($wp_query->have_posts()): $wp_query->the_post(); ?>
                                <?php $number = get_post_meta($post->ID, 'sk8er_funfacts_number', true); ?>
                                <div class="item">
                                    <h3><?php echo esc_html($number); ?></h3>
                                    <span><?php the_title(); ?> <?php echo get_the_content(); ?></span>
                                </div>
                            <?php endwhile; ?>

                        </div>
                    </div>
                </section>
            <?php endif; ?>
        <?php endif ?>


        <?php
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}



$opts = array(
    "name"      => __("Fun Facts", 'js_composer'),
    "description" => __('Insert Section with Fun Facts', 'js_composer'),
    "base"      => "vc_s1_fun_facts",
    "class"     => "vc_s1_fun_facts",
    "icon"      => "icon-class",
    "controls"  => "full",
    "category"  => __('AvaThemes', 'js_composer'),
    "params"    => array(
        array(
            "type"        => "nothing",
            "heading"     => __("On the left side choose <b>Fun Facts</b> and from there add facts you want.", 'js_composer'),
            "param_name"  => "nothing",
            "value"       => "",
            "description" => __("<b>BUT</b> you still need to have this block inserted on page!", 'js_composer')
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("Title (Layout 1 only)", 'js_composer'),
            "param_name"  => "title",
            "value"       => "",
            "description" => __("Add title for your section", 'js_composer')
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("Subtitle (Layout 1 only)", 'js_composer'),
            "param_name"  => "subtitle",
            "value"       => "",
            "description" => __("Add subtitle for your section", 'js_composer')
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Layout', 'js_composer' ),
            'param_name' => 'layout',
            'description' => __( '', 'js_composer' ),
            'value' => array( __( 'Layout 1', 'js_composer' ) => 'layout_1', __( 'Layout 2', 'js_composer' ) => 'layout_2', __( 'Layout 3', 'js_composer' ) => 'layout_3'),
            'std' => 'layout_1'
        ),
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);