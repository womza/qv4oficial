<?php
/**
 *  Clients List Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_clients extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
        ), $atts));

        ob_start();
        ?>

        <?php
          global $sk8er;

          $title = $sk8er['sk8er_clients_title'];
          $desc = $sk8er['sk8er_clients_description'];
          $clients = $sk8er['sk8er_clients'];
        ?>

        <section class="style-misc our-clients">
            <div class="inner">
                <div class="container">
                    <div class="row">

                      <?php if (!empty($clients[0]['image'])): ?>
                        <div class="col-md-7">
                            <div class="clients-list">
                                <div class="row">

                                  <?php foreach ($clients as $client): ?>
                                    <?php
                                      if (!empty($client['url'])) {
                                        $url = $client['url'];
                                      } else {
                                        $url = "javascript:void(null);";
                                      }
                                    ?>
                                    <?php if (!empty($client['image'])): ?>
                                      <div class="col-md-6">
                                          <div class="single">
                                              <span class="tb-borders"></span>
                                              <span class="lr-borders"></span>

                                                <a href="<?php echo esc_url($url); ?>" target="_blank">
                                                    <span class="valign">
                                                        <img src="<?php echo esc_url($client['image']); ?>" alt="">
                                                    </span>
                                                </a>

                                          </div>
                                      </div>
                                    <?php endif ?>

                                  <?php endforeach ?>

                                </div>
                            </div>
                        </div>
                      <?php endif ?>

                      <?php if (!empty($clients[0]['image'])): ?>
                        <div class="col-md-4 col-md-offset-1">
                          <?php else: ?>
                        <div class="col-md-4">
                      <?php endif; ?>
                        
                            <div class="clients-about">
                                <?php if (!empty($title)): ?>
                                  <div class="title-bar">
                                    <h3><?php echo esc_html($title); ?></h3>
                                </div>
                                <?php endif ?>

                                <p class="desc">
                                    <?php echo esc_html($desc); ?>
                                </p>
                            </div>
                        </div>

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
    "name"      => __("List of Clients", 'js_composer'),
    "description" => __('Insert Section with Clients list', 'js_composer'),
    "base"      => "vc_clients",
    "class"     => "vc_clients",
    "icon"      => "icon-class",
    "controls"  => "full",
    "category"  => __('AvaThemes', 'js_composer'),
    "params"    => array(
        array(
            "type"        => "nothing",
            "heading"     => __("You should go to <b>Theme Options</b> -> <b>Clients List</b> and from there add clients.", 'js_composer'),
            "param_name"  => "nothing",
            "value"       => "",
            "description" => __("<b>BUT</b> you still need to have this block inserted on page!", 'js_composer')
        ),
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);