<?php
/**
 *  Member List Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_s2_members extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'title'         => '',
            'subtitle'      => '',
            'text'          => '',
            'layout'        => '',
        ), $atts));

        ob_start();
        ?>

        <?php
            global $post;
            global $sk8er;
            $args = array( 'post_type' => 'members', 'posts_per_page' => -1);
            $wp_query = new WP_Query( $args );
        ?>

        <?php if ($layout=="layout_1"): ?>
            <section class="style-2 our-team">
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

                        <?php if ( $wp_query->have_posts() ) : ?>

                        <div class="row members">

                            <?php while($wp_query->have_posts()) : $wp_query->the_post(); ?>
                                <?php
                                    $social = get_post_meta($post->ID, 'sk8er_member_social', true);
                                    $position = get_post_meta($post->ID, 'sk8er_member_position', true);
                                ?>
                                
                                <div class="member">
                                    <?php if (has_post_thumbnail()): ?>
                                        <?php $thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
                                        <div class="image" style="background-image: url(<?php echo esc_url($thumb_url[0]); ?>);">
                                            <a href="javascript:void(null);"></a>
                                        </div>
                                    <?php endif ?>
                                    <div class="text">
                                        <span class="name"><?php the_title(); ?></span>
                                        <?php if (!empty($position)): ?>
                                            <span class="position"><?php echo esc_html($position); ?></span>
                                        <?php endif ?>
                                        <?php the_content(); ?>

                                        <?php if (!empty($social[0]['icon'])): ?>
                                            <div class="social">
                                                <?php foreach ($social as $link): ?>
                                                    <a href="<?php echo esc_url($link['url']); ?>" class="ia" target="_blank">
                                                        <i class="fa <?php echo esc_attr($link['icon']); ?>"></i>
                                                    </a>
                                                <?php endforeach ?>
                                            </div>
                                        <?php endif ?>
                                    </div>
                                </div>
                            <?php endwhile; ?>

                        </div>

                        <?php endif; ?>
                    </div>
                </div>
            </section>
        <?php endif ?>

        <?php if ($layout=="layout_2"): ?>
            <section class="style-3 ourteam">
                <div class="inner">
                    <?php if (!empty($title) || !empty($subtitle)): ?>
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
                    <?php endif ?>

                    <?php if ( $wp_query->have_posts() ) : ?>

                        <div class="row members">
                            <div class="container">
                                <?php while($wp_query->have_posts()) : $wp_query->the_post(); ?>
                                    <?php
                                        $social = get_post_meta($post->ID, 'sk8er_member_social', true);
                                        $position = get_post_meta($post->ID, 'sk8er_member_position', true);
                                        $transparent_image = get_post_meta($post->ID, 'sk8er_member_transparent_image', true);
                                    ?>
                                    <div class="col-md-6">
                                        <div class="member">
                                            <div class="inside">
                                                <div class="info">
                                                    <h3><?php the_title(); ?></h3>
                                                    <span><?php echo esc_html($position); ?></span>
                                                    <p><?php echo get_the_content(); ?></p>
                                                </div>

                                                <?php if (!empty($transparent_image)): ?>
                                                        <div class="image">
                                                            <img src="<?php echo esc_url($transparent_image); ?>" alt="">
                                                        </div>
                                                    <?php else: ?>

                                                    <?php if (has_post_thumbnail()): ?>
                                                        <?php $thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
                                                        <div class="image">
                                                            <img src="<?php echo esc_url($thumb_url[0]); ?>" alt="">
                                                        </div>
                                                    <?php endif ?>

                                                <?php endif ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        </div>

                    <?php endif; ?>
                </div>
            </section>
        <?php endif ?>

        <?php if ($layout=="layout_3"): ?>
            <section class="style-5 our-team">
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

                        <?php if ( $wp_query->have_posts() ) : ?>

                            <div class="row members">

                                <?php while($wp_query->have_posts()) : $wp_query->the_post(); ?>
                                    <?php
                                        $social = get_post_meta($post->ID, 'sk8er_member_social', true);
                                        $position = get_post_meta($post->ID, 'sk8er_member_position', true);
                                        $transparent_image = get_post_meta($post->ID, 'sk8er_member_transparent_image', true);
                                    ?>

                                    <div class="row">
                                        <div class="member">
                                            <?php if (has_post_thumbnail()): ?>
                                                <?php $thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
                                                <div class="image">
                                                    <img src="img/res/style-5-members-bg.png" alt="" class="bg-image" style="top: -75px; display: none;">
                                                    <a href="javascript:void(null);" style="background-image: url(<?php echo esc_url($thumb_url[0]); ?>);"></a>
                                                </div>
                                            <?php endif ?>
                                            <div class="text">
                                                <span class="name"><?php the_title(); ?></span>
                                                <span class="position"><?php echo esc_html($position); ?></span>
                                                <?php the_content(); ?>

                                                <div class="social">
                                                    <?php foreach ($social as $single): ?>
                                                        <a href="<?php echo esc_url($single['url']); ?>" target="_blank">
                                                            <i class="fa <?php echo esc_attr($single['icon']); ?>"></i>
                                                        </a>
                                                    <?php endforeach ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php endwhile; ?>

                            </div>

                        <?php endif; ?>

                    </div>
                </div>
            </section>
        <?php endif ?>

        <?php if ($layout=="layout_4"): ?>
            <section class="style-10 our-team">
                <div class="inner">
                    <div class="container">
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

                        <?php if ( $wp_query->have_posts() ) : ?>

                            <div class="row members">

                            <?php while($wp_query->have_posts()) : $wp_query->the_post(); ?>

                                <?php
                                    $social = get_post_meta($post->ID, 'sk8er_member_social', true);
                                    $position = get_post_meta($post->ID, 'sk8er_member_position', true);
                                    $transparent_image = get_post_meta($post->ID, 'sk8er_member_transparent_image', true);
                                ?>

                                <div class="col-md-4">
                                    <div class="member">
                                        <?php if (!empty($transparent_image)): ?>
                                            <div class="image">
                                                <div class="valign"><img src="<?php echo esc_url($transparent_image); ?>" alt=""></div>
                                            </div>
                                            <div class="content">

                                            <?php else: ?>

                                            <div class="content" style="width: 100%;padding:30px;">
                                        <?php endif ?>
                                            <div class="name"><?php the_title(); ?></div>
                                            <div class="position"><?php echo esc_html($position); ?></div>
                                            <hr>
                                            <div class="social">
                                                <?php foreach ($social as $single): ?>
                                                    <a href="<?php echo esc_url($single['url']); ?>" target="_blank">
                                                        <i class="fa <?php echo esc_attr($single['icon']); ?>"></i>
                                                    </a>
                                                <?php endforeach ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php endwhile; ?>

                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
        <?php endif ?>

        <?php if ($layout=="layout_5"): ?>
            <section class="style-13 our-team" style="background-image: url(img/res/home-13-team-bg.png);">
                <div class="inner">
                    <div class="container">
                        <div class="title-bar">
                            <h3><span><?php echo esc_html($title); ?></span></h3>
                            <span><?php echo esc_html($subtitle); ?></span>
                        </div>

                        <?php if ( $wp_query->have_posts() ) : ?>

                        <div class="row members">

                            <?php while($wp_query->have_posts()) : $wp_query->the_post(); ?>

                                <?php
                                    $thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
                                    $social = get_post_meta($post->ID, 'sk8er_member_social', true);
                                    $position = get_post_meta($post->ID, 'sk8er_member_position', true);
                                    $transparent_image = get_post_meta($post->ID, 'sk8er_member_transparent_image', true);
                                ?>

                                <div class="col-md-4">
                                    <div class="member">
                                        <div class="image" style="background-image: url(<?php echo esc_url($thumb_url[0]); ?>);">
                                            <div class="hover">
                                                <div class="social">
                                                    <?php foreach ($social as $single): ?>
                                                        <a href="<?php echo esc_url($single['url']); ?>" class="ia" target="_blank">
                                                            <i class="fa <?php echo esc_attr($single['icon']); ?>"></i>
                                                        </a>
                                                    <?php endforeach ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="info">
                                            <span class="name"><?php the_title(); ?></span>
                                            <span class="position"><?php echo esc_html($position); ?></span>
                                        </div>
                                    </div>
                                </div>

                            <?php endwhile; ?>

                        </div>
                        
                        <?php endif; ?>

                    </div>
                </div>
            </section>
        <?php endif ?>

        <?php if ($layout=="layout_6"): ?>
            <section class="style-17 our-team">
                <div class="inner">
                    <div class="container">
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

                        <?php if ( $wp_query->have_posts() ) : ?>

                            <div class="row members">

                                <?php while($wp_query->have_posts()) : $wp_query->the_post(); ?>

                                    <?php
                                        $thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
                                        $social = get_post_meta($post->ID, 'sk8er_member_social', true);
                                        $position = get_post_meta($post->ID, 'sk8er_member_position', true);
                                    ?>

                                    <div class="col-sm-6 col-md-4">
                                        <div class="box">
                                            <div class="image" style="background-image: url(<?php echo esc_url($thumb_url[0]); ?>);"></div>
                                            <div class="content">
                                                <span class="name"><?php the_title(); ?></span>
                                                <span class="position"><?php echo esc_html($position); ?></span>
                                                <div class="social">
                                                    <?php foreach ($social as $single): ?>
                                                        <a href="<?php echo esc_url($single['url']); ?>" target="_blank" class="ia"><i class="fa <?php echo esc_attr($single['icon']); ?>"></i></a>
                                                    <?php endforeach ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php endwhile; ?>

                            </div>

                        <?php endif; ?>
                    </div>
                </div>
            </section>
        <?php endif ?>

        <?php if ($layout=="layout_7"): ?>
            <section class="style-18 style-element our-team">
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

                        <?php if ( $wp_query->have_posts() ) : ?>

                            <div class="row members">
                            <!-- .ispoppingout klasa za izrezane slike -->

                            <?php while($wp_query->have_posts()) : $wp_query->the_post(); ?>
                                <?php
                                    $thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
                                    $social = get_post_meta($post->ID, 'sk8er_member_social', true);
                                    $position = get_post_meta($post->ID, 'sk8er_member_position', true);
                                    $transparent_image = get_post_meta($post->ID, 'sk8er_member_transparent_image', true);
                                ?>

                                <div class="col-md-4">
                                    <div class="member">
                                        <?php if (!empty($transparent_image)): ?>
                                            <div class="image ispoppingout">
                                                <img src="<?php echo esc_url($transparent_image); ?>" alt="">
                                            </div>
                                        <?php else: ?>
                                            <div class="image" style="background-image: url(<?php echo esc_url($thumb_url[0]); ?>);">
                                            </div>
                                        <?php endif ?>
                                        <div class="content">
                                            <span class="name"><?php the_title(); ?></span>
                                            <span class="position"><?php echo esc_html($position); ?></span>
                                            <p><?php echo get_the_content(); ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>

                            </div>

                        <?php endif; ?>
                    </div>
                </div>
            </section>
        <?php endif ?>

        <?php if ($layout=="layout_8"): ?>
            <section class="style-misc style-element our-team">
                <div class="inner">
                    <div class="container">
                        <?php if (!empty($title)): ?>
                            <div class="title-bar">
                                <h3><?php echo esc_html($title); ?></h3>
                            </div>
                        <?php endif ?>

                        <?php if (!empty($text)): ?>
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <p class="desc">
                                        <?php echo esc_html($text); ?>
                                    </p>
                                </div>
                            </div>
                        <?php endif ?>

                        <?php if ( $wp_query->have_posts() ) : ?>

                            <div class="row members">

                                <?php while($wp_query->have_posts()): $wp_query->the_post(); ?>
                                    <?php
                                        $thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
                                        $social = get_post_meta($post->ID, 'sk8er_member_social', true);
                                        $position = get_post_meta($post->ID, 'sk8er_member_position', true);
                                        $transparent_image = get_post_meta($post->ID, 'sk8er_member_transparent_image', true);
                                    ?>


                                    <div class="col-md-4">
                                        <div class="member">
                                        <?php if (!empty($transparent_image)): ?>
                                            <div class="image ispoppingout">
                                                <img src="<?php echo esc_url($transparent_image); ?>" alt="">
                                            </div>
                                        <?php else: ?>
                                            <div class="image ispoppingout">
                                                <img src="<?php echo esc_url($thumb_url[0]); ?>" alt="">
                                            </div>
                                        <?php endif ?>


                                            <div class="content">
                                                <span class="name"><?php the_title(); ?></span>
                                                <span class="position"><?php echo esc_html($position); ?></span>
                                                <p><?php echo get_the_content(); ?></p>
                                            </div>
                                        </div>
                                    </div>

                                <?php endwhile; ?>

                            </div>

                        <?php endif; ?>

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
    "name"      => __("Member List", 'js_composer'),
    "description" => __('Insert Section with list of members', 'js_composer'),
    "base"      => "vc_s2_members",
    "class"     => "vc_s2_members",
    "icon"      => "icon-class",
    "controls"  => "full",
    "category"  => __('AvaThemes', 'js_composer'),
    "params"    => array(
        array(
            "type"        => "nothing",
            "heading"     => __("From the left side menu, choose Members and then from there add members.", 'js_composer'),
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
        array(
            "type"        => "textfield",
            "heading"     => __("Subtitle", 'js_composer'),
            "param_name"  => "subtitle",
            "value"       => "",
            "description" => __("Add subtitle for your section", 'js_composer')
        ),
        array(
            "type"        => "textarea",
            "heading"     => __("Text (Layout 8)", 'js_composer'),
            "param_name"  => "text",
            "value"       => "",
            "description" => __("Add text for your section", 'js_composer')
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Layout', 'js_composer' ),
            'param_name' => 'layout',
            'description' => __( '', 'js_composer' ),
            'value' => array( __( 'Layout 1', 'js_composer' ) => 'layout_1', __( 'Layout 2', 'js_composer' ) => 'layout_2', __( 'Layout 3', 'js_composer' ) => 'layout_3', __( 'Layout 4', 'js_composer' ) => 'layout_4', __( 'Layout 5', 'js_composer' ) => 'layout_5', __( 'Layout 6', 'js_composer' ) => 'layout_6', __( 'Layout 7', 'js_composer' ) => 'layout_7', __( 'Layout 8', 'js_composer' ) => 'layout_8'   ),
            'std' => 'layout_1'
        ),
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);