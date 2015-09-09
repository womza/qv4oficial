<?php
/**
 * Video Block Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_s7_video extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'title'             => '',
            'video_mp4_url'     => '',
            'video_webm_url'     => '',
            'video_poster'      => '',
        ), $atts));

        ob_start();

        wp_enqueue_style('sk8er-video-js');
        wp_enqueue_script('sk8er-video');
        wp_enqueue_script('sk8er-video-youtube');
        wp_enqueue_script('sk8er-video-vimeo');
        ?>

        <?php global $sk8er; ?>
        
        <?php if (!empty($video_poster)): ?>
            <?php
                $image_url = wp_get_attachment_image_src( $video_poster, 'full' );
                $poster_image = "poster=".$image_url[0]."";
            ?>
        <?php else: ?>
            <?php $poster_image = ""; ?>
        <?php endif ?>

        <section class="style-7 video" style="background: url(img/res/home-7-video-bg.png);">
            <div class="inner">
                <div class="container">
                    <?php if (!empty($title)): ?>
                        <div class="title-bar">
                            <h3><?php echo esc_html($title); ?></h3>
                        </div>
                    <?php endif ?>

                    <div class="video-wrapper">
                        <video id="actual-video" class="video-js vjs-default-skin vjs-big-play-centered"
                          controls preload="auto" <?php echo wp_kses($poster_image, ''); ?> width="auto" height="auto"
                          data-setup='{"example_option":true}'>

                            <?php if (!empty($video_mp4_url)): ?>
                                <source src="<?php echo esc_url($video_mp4_url); ?>" type='video/mp4' />    
                            <?php endif ?>
                            
                            <?php if (!empty($video_webm_url)): ?>
                                <source src="<?php echo esc_url($video_webm_url); ?>" type='video/webm' />
                            <?php endif ?>
                            

                         <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
                        </video>
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
    "name"      => __("Video Block", 'js_composer'),
    "description" => __('Insert Section with Video', 'js_composer'),
    "base"      => "vc_s7_video",
    "class"     => "vc_s7_video",
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
            "heading"     => __("Insert .MP4 Video Link", 'js_composer'),
            "param_name"  => "video_mp4_url",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("Insert .WEBM Video Link", 'js_composer'),
            "param_name"  => "video_webm_url",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
        array(
            "type"        => "attach_image",
            "heading"     => __("Video Poster (optional)", 'js_composer'),
            "param_name"  => "video_poster",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);