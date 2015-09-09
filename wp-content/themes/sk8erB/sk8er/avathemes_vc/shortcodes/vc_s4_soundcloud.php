<?php
/**
 * Soundcloud Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_s4_soundcloud extends  WPBakeryShortCode
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
            global $sk8er;
            $tracks     = $sk8er['sk8er_soundcloud'];
            $url        = $sk8er['sk8er_soundcloud_url'];
            $button     = $sk8er['sk8er_soundcloud_button'];
        ?>

        <section class="style-4 music whitebg">
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

                    <div class="row list">

                        <?php foreach ($tracks as $track): ?>
                            <?php 
                                $id = $track['description'];
                                $color = $track['url'];
                                $main_color = trim($sk8er['sk8er_main_color'], '#');
                                if ($color=="") { $color=$main_color; }
                            ?>
                            <div class="col-md-6">
                                <iframe width="100%" height="166" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/<?php echo esc_attr($id); ?>&amp;color=<?php echo esc_attr($color); ?>"></iframe>
                            </div>
                        <?php endforeach ?>

                    </div>

                    <?php if (!empty($url)): ?>
                        <div class="buttons">
                            <a href="<?php echo esc_url($url); ?>" class="big-button" target="_blank"><?php echo esc_html($button); ?></a>
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
    "name"      => __("Soundcloud Songs", 'js_composer'),
    "description" => __('Insert Section with Soundcloud songs', 'js_composer'),
    "base"      => "vc_s4_soundcloud",
    "class"     => "vc_s4_soundcloud",
    "icon"      => "icon-class",
    "controls"  => "full",
    "category"  => __('AvaThemes', 'js_composer'),
    "params"    => array(
        array(
            "type"        => "nothing",
            "heading"     => __("You should go to <b>Theme Options</b> -> <b>Soundcloud Section</b> and from there add links you want.", 'js_composer'),
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
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);