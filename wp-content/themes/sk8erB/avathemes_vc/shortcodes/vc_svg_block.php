<?php
/**
 * SVG Block Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_svg_block extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            
        ), $atts));

        ob_start();
        ?>

        <?php
            global $sk8er;
            $bg = $sk8er['sk8er_svg_head_background_image'];
            $title = $sk8er['sk8er_svg_head_title'];
            $subtitle = $sk8er['sk8er_svg_head_subtitle'];
            $svg = $sk8er['sk8er_svg_head_code'];
            $image = $sk8er['sk8er_svg_head_image'];
            $buttons = $sk8er['sk8er_svg_head_buttons'];
        ?>


         <section class="style-10 app-big-image" style="background-image: url(<?php echo esc_url($bg['url']); ?>);">

                <?php if (!empty($title) || !empty($subtitle)): ?>
                    <div class="big-title">
                        <?php if (!empty($title)): ?>
                            <h3><?php echo esc_html($title); ?></h3>
                        <?php endif ?>
                        <?php if (!empty($subtitle)): ?>
                            <span><?php echo esc_html($subtitle); ?></span>
                        <?php endif ?>
                    </div>
                <?php endif ?>

                <div class="phone-mockup" id="svg-animate">
                    <div class="real-image" style="top: 90px; left:10px;" data-animation="pulse">
                        <?php if (!empty($image['url'])): ?>
                            <img src="<?php echo esc_url($image['url']); ?>" class="real-image" alt="">
                        <?php endif ?>
                    </div>

                    <?php
                        $allowed_tags = "<animate>, <animateColor>, <animateMotion>, <animateTransform>, <mpath>, <set>, <circle>, <ellipse>, <line>, <polygon>, <polyline>, <rect>, <a>, <defs>, <glyph>, <g>, <marker>, <mask>, <missing-glyph>, <pattern>, <svg>, <switch>, <symbol>, <desc>, <metadata>, <title>, <feBlend>, <feColorMatrix>, <feComponentTransfer>, <feComposite>, <feConvolveMatrix>, <feDiffuseLighting>, <feDisplacementMap>, <feFlood>,<feFuncA>, <feFuncB>, <feFuncG>, <feFuncR>,<feGaussianBlur>, <feImage>, <feMerge>, <feMergeNode>, <feMorphology>, <feOffset>, <feSpecularLighting>, <feTile>, <feTurbulence>,  <font>, <font-face>, <font-face-format>, <font-face-name>, <font-face-src>, <font-face-uri>, <hkern>, <vkern>, <linearGradient>, <radialGradient>, <stop>, <circle>, <ellipse>, <image>, <line>, <path>, <polygon>, <polyline>, <rect>, <text>, <use>, <feDistantLight>, <fePointLight>, <feSpotLight>, <circle>, <ellipse>, <line>, <path>, <polygon>, <polyline>, <rect>, <defs>, <g>, <svg>, <symbol>, <use>, <altGlyph>, <altGlyphDef>, <altGlyphItem>, <glyph>, <glyphRef>, <textPath>, <text>, <tref>, <tspan>, <altGlyph>, <textPath>, <tref>, <tspan>,<clipPath>, <color-profile>, <cursor>, <filter>, <foreignObject>, <script>, <style>, <view>";

                        echo strip_tags($svg, $allowed_tags);
                    ?>


                </div>

                <?php if (!empty($buttons[0]['title'])): ?>
                    <div class="app-buttons">
                        <?php foreach ($buttons as $button): ?>
                            <a href="<?php echo esc_url($button['url']); ?>">
                                <?php if (!empty($button['image'])): ?>
                                    <span class="icon">
                                        <img src="<?php echo esc_url($button['image']); ?>" alt="">
                                    </span>
                                <?php endif ?>

                                <span class="content">
                                    <?php if (!empty($button['title'])): ?>
                                        <span class="title"><?php echo esc_html($button['title']); ?></span>
                                    <?php endif ?>
                                    <?php if (!empty($button['description'])): ?>
                                        <span class="desc"><?php echo esc_html($button['description']); ?></span>
                                    <?php endif ?>
                                </span>
                            </a>
                        <?php endforeach ?>
                    </div>
                <?php endif ?>

                <div class="big-cut"></div>
        </section>

        <?php
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}



$opts = array(
    "name"      => __("SVG Head Block", 'js_composer'),
    "description" => __('Insert Section with SVG Animation', 'js_composer'),
    "base"      => "vc_svg_block",
    "class"     => "vc_svg_block",
    "icon"      => "icon-class",
    "controls"  => "full",
    "category"  => __('AvaThemes', 'js_composer'),
    "params"    => array(
        array(
            "type"        => "nothing",
            "heading"     => __("You should go to <b>Theme Options</b> -> <b>SVG Head Block</b> and from there fill fields.", 'js_composer'),
            "param_name"  => "nothing",
            "value"       => "",
            "description" => __("<b>BUT</b> you still need to have this block inserted on page!", 'js_composer')
        ),
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);