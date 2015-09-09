<?php global $sk8er, $sk8er_header_style, $sk8er_theme_class, $sk8er_affect_class; ?>

<!-- HEADER 5 -->
<header class="header-6 theme-dark">
    <div class="top-bar">
        <div class="container">
            <div class="left">
                <?php if (!isset($sk8er_header_info)): ?>
                    <?php echo esc_html($sk8er['sk8er_header_info']); ?>
                <?php endif ?>
            </div>

            <div class="right">

                <nav>
                    <ul>
                        <?php if (class_exists('woocommerce')): ?>
		                	<?php $cart = WC()->cart->get_cart(); global $woocommerce; ?>

				                                <li class="cart">

                                                    <a href="<?php echo esc_url($woocommerce->cart->get_cart_url()); ?>"><i class="fa fa-shopping-cart"></i><?php echo esc_html($woocommerce->cart->cart_contents_count); ?></a>

                                                    <ul>
                                                        <li class="h-title">
                                                            <a href="<?php echo esc_url($woocommerce->cart->get_cart_url()); ?>"><?php _e('Your Cart','sk8er'); ?> (<?php echo esc_html($woocommerce->cart->cart_contents_count); ?>)</a>
                                                        </li>

                                                        <li class="items">
                                                            <?php if (!count($cart)): ?>
                                                                <div class="no-item"><?php _e('Your Cart is empty', 'sk8er'); ?></div>

                                                            <?php else: ?>

                                                                <?php $counter=1; foreach ($cart as $cart_item_key => $cart_item): ?>
                                                                    <?php
                                                                        $product_id = $cart_item['product_id'];
                                                                        $product = new WC_Product($product_id);
                                                                        $_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                                                                        $permalink = get_permalink($product->post);
                                                                        $quantity = $cart_item['quantity'];
                                                                    ?>

                                                                    <?php if ($counter<=3): ?>
                                                                        <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), 'full' ); ?>
                                                                        <div class="item">
                                                                            <a href="<?php echo esc_url($permalink); ?>">
                                                                                <div class="image" style="background-image: url(<?php echo esc_url($image[0]); ?>);">

                                                                                </div>
                                                                                <div class="info">
                                                                                    <div class="name">
                                                                                        <?php echo get_the_title($product->post); ?>
                                                                                    </div>
                                                                                    <div class="price">
                                                                                        <?php echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); ?>
                                                                                    </div>
                                                                                </div>
                                                                            </a>
                                                                        </div>

                                                                    <?php endif ?>

                                                                <?php $counter++; endforeach ?>

                                                            <?php endif ?>
                                                        </li>

                                                        <li class="h-more">
                                                            <a href="<?php echo esc_url($woocommerce->cart->get_cart_url()); ?>" class="h-more">
                                                                <span data-second="<?php echo _e('View All', 'sk8er'); ?>">...</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </li>

		        		<?php endif ?>
                    </ul>
                </nav>

                <a href="javascript:void(null);" class="open-widget-sidebar dark"><span class="cubes"></span><span class="cubes2"></span></a>
            </div>
        </div>
    </div>

    <div class="container-2">
        <div class="align">
            <a href="javascript:void(null);" class="open-menu-sidebar dark"><span class="line"></span></a>

            <nav class="split-in-half">
                <ul>
                    <?php
                        if ( has_nav_menu( 'primary' ) ) {
                            // User has assigned menu to this location;
                            // output it
                            wp_nav_menu( array(
                                'theme_location' => 'primary',
                                'menu_class' => 'nav',
                                'container' => '',
                                'items_wrap'      => '%3$s',
                            ) );
                        } else {
                            echo '<li><a href="'.admin_url().'nav-menus.php">'.__('Create your menu', 'sk8er').'</a></li>';
                        }
                    ?>
                </ul>
            </nav>

            <div class="logo" style="display: none;">
                <a href="<?php echo site_url(); ?>">
                    <?php if (!empty($sk8er['sk8er_logo']['url'])): ?>
                            <img src="<?php echo esc_url($sk8er['sk8er_logo']['url']); ?>" alt="<?php echo bloginfo('title'); ?>">
                        <?php else: ?>
                            <span class="txt-logo"><?php echo bloginfo('title'); ?></span>
                    <?php endif ?>
                </a>
            </div>

            <div class="mobile-logo" style="display: none;">
                <a href="<?php echo site_url(); ?>">
                    <?php if (!empty($sk8er['sk8er_logo']['url'])): ?>
                            <img src="<?php echo esc_url($sk8er['sk8er_logo']['url']); ?>" alt="<?php echo bloginfo('title'); ?>">
                        <?php else: ?>
                            <span class="txt-logo"><?php echo bloginfo('title'); ?></span>
                    <?php endif ?>
                </a>
            </div>

        </div>
    </div>
</header>
<!-- HEADER 5 -->


<script>
    (function($) {
        var li_count = $("nav.split-in-half ul > li:not(ul li ul li)").length;
        li_count = Math.round(li_count / 2);
        console.log(li_count);
        $("nav.split-in-half ul > li:nth-of-type("+li_count+"):not(ul li ul li)").addClass("appendLogo");
        var logo = $("header .logo");
        var logo_clone = logo.clone();
        logo.remove();
        logo_clone.insertAfter( ".appendLogo" ).show();
    })(jQuery);
</script>