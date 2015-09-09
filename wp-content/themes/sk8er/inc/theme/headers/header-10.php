<?php global $sk8er; ?>

<?php
    $args = array( 'post_type' => 'post', 'posts_per_page' => 1, 'post__in' => get_option( 'sticky_posts' ));
    $wp_query = new WP_Query( $args );
?>

<?php if ($wp_query->have_posts()): ?>
    <?php $x=1; while($wp_query->have_posts()): $wp_query->the_post(); ?>
        <?php $background = $sk8er['sk8er_header_weather_bg']['url']; ?>

        <?php if (has_post_thumbnail()): ?>
            <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
            <?php $thumbnail = $image[0]; ?>
        <?php else: ?>
            <?php $thumbnail = $background; // Fallback ?>
        <?php endif; ?>


       <?php if ($x==1): ?>

<section class="weather-header" style="background-image: url(<?php echo esc_url($thumbnail); ?>);">
    <div class="borders">

        <a href="<?php echo site_url(); ?>" class="logo">
            <?php if (!empty($sk8er['sk8er_logo']['url'])): ?>
                    <img src="<?php echo esc_url($sk8er['sk8er_logo']['url']); ?>" alt="<?php echo bloginfo('title'); ?>">
                <?php else: ?>
                    <span class="txt-logo"><?php echo bloginfo('title'); ?></span>
            <?php endif ?>
        </a>

        <a href="javascript:void(null);" class="open-menu-sidebar"><span class="line"></span></a>

        <a href="javascript:void(null);" class="open-widget-sidebar"><span class="cubes"></span><span class="cubes2"></span></a>

        <div class="leftright"></div>
        <div class="top">
            <span class="left"></span>
            <span class="right"></span>
        </div>
        <div class="bottom"></div>

        <div class="weather-info">
            <div class="line">
                <div class="box real-info">
                    <span class="date">
                        <b><?php _e( 'Today' , 'sk8er' ) ?></b>, <span class="date-fill"></span>
                    </span>
                    <span class="degrees">
                    </span>
                </div>
            </div>
            <div class="line">
                <div class="box title">
                    <?php the_title(); ?>
                </div>
            </div>
            <div class="line">
                <div class="box additional-info">
                    <?php echo sk8er_excerpt(15); ?>
                </div>
            </div>
            <div class="line">
                <a href="<?php the_permalink(); ?>" class="learn-more">
                    <span><?php _e( 'Learn More' , 'sk8er' ) ?></span>
                    <i class="fa fa-angle-right"></i>
                </a>
            </div>
        </div>
    </div>
</section>

        <?php endif ?>
    <?php $x++; endwhile; ?>
<?php endif ?>
<?php wp_reset_query(); ?>