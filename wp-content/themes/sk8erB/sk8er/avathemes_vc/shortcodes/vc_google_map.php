<?php
/**
 *  Google Map Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_google_map extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
        ), $atts));

        ob_start();

        wp_enqueue_script('sk8er-google-maps');
        ?>

        <?php 
            global $sk8er;
            $map_loc        = $sk8er['sk8er_google_map_location'];
            $marker_locs    = $sk8er['sk8er_google_map_markers'];
        ?>

        <div class="contact-map-header">
            <div id="map-canvas">
            </div>
        </div>

        <script>
          (function($) {
            $(document).ready(function() {
                function initialize() {
                                  var mapCanvas = document.getElementById('map-canvas');
                                  var mapOptions = {
                                    center: new google.maps.LatLng(<?php echo esc_attr($map_loc); ?>),
                                    zoom: 12,
                                    scrollwheel: false,
                                    navigationControl: false,
                                    mapTypeControl: false,
                                    scaleControl: false,
                                    draggable: false,
                                    mapTypeId: google.maps.MapTypeId.ROADMAP
                                  }
                                  var map = new google.maps.Map(mapCanvas, mapOptions);

                                  var locations = [
                                        <?php 
                                            foreach ($marker_locs as $marker) {
                                                $title      = $marker['title'];
                                                $loc        = $marker['description'];
                                                if (!empty($marker['image'])) {
                                                    $image = $marker['image'];
                                                } else {
                                                    $image = $marker['url'];
                                                }

                                                ?>
                                                ['<?php echo esc_html($title); ?>', <?php echo esc_attr($loc); ?>, '<?php echo esc_url($image); ?>'],
                                            <?php }
                                        ?>
                                      ];

                                  var infowindow = new google.maps.InfoWindow();

                                  var marker, i;

                                      function drop(map, myLatLng, icon, timeout) {
                                          setTimeout(function() {
                                            var marker = new google.maps.Marker({
                                              position: myLatLng,
                                              map: map,
                                              icon: icon,
                                              animation: google.maps.Animation.DROP
                                            });
                                          }, timeout);
                                      }

                                      function setMarkers(map, locations) {
                                          for (var i = 0; i < locations.length; i++) {
                                            var klant = locations[i];
                                            var myLatLng = new google.maps.LatLng(klant[1], klant[2]);
                                            var icon = locations[i][3];
                                            var timeout = (i+1) * 600;

                                            drop(map, myLatLng, icon, timeout);
                                          }
                                      }

                                      setMarkers(map, locations);

                                  var styles = [{"featureType":"water","stylers":[{"color":"#021019"}]},{"featureType":"landscape","stylers":[{"color":"#08304b"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#0c4152"},{"lightness":5}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#000000"}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#0b434f"},{"lightness":25}]},{"featureType":"road.arterial","elementType":"geometry.fill","stylers":[{"color":"#000000"}]},{"featureType":"road.arterial","elementType":"geometry.stroke","stylers":[{"color":"#0b3d51"},{"lightness":16}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#000000"}]},{"elementType":"labels.text.fill","stylers":[{"color":"#ffffff"}]},{"elementType":"labels.text.stroke","stylers":[{"color":"#000000"},{"lightness":13}]},{"featureType":"transit","stylers":[{"color":"#146474"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#000000"}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#144b53"},{"lightness":14},{"weight":1.4}]}];

                                  map.setOptions({styles: styles});
                        }

                 google.maps.event.addDomListener(window, 'load', initialize);
            });

          })(jQuery);
        </script>

        
        <?php
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}



$opts = array(
    "name"      => __("Google Map Section", 'js_composer'),
    "description" => __('Insert Section with Google Map', 'js_composer'),
    "base"      => "vc_google_map",
    "class"     => "vc_google_map",
    "icon"      => "icon-class",
    "controls"  => "full",
    "category"  => __('AvaThemes', 'js_composer'),
    "params"    => array(
        array(
            "type"        => "nothing",
            "heading"     => __("You should go to <b>Theme Options</b> -> <b>Google Map</b> and from there fill info this section need.", 'js_composer'),
            "param_name"  => "nothing",
            "value"       => "",
            "description" => __("<b>BUT</b> you still need to have this block inserted on page!", 'js_composer')
        ),
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);