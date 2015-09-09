<?php global $sk8er, $sk8er_header_style, $sk8er_theme_class, $sk8er_affect_class; ?>

<?php if ($sk8er_header_style=="8" || $sk8er_header_style=="11"): ?>
    <?php $add_class="bg-white"; ?>
<?php else: ?>
    <?php $add_class=""; ?>
<?php endif ?>

<!-- HEADER 1 -->
<header class="header-1 <?php echo esc_attr($sk8er_theme_class) .' '. esc_attr($sk8er_affect_class) .' '. esc_attr($add_class); ?>">
<div class="container">
    <div class="inside">
        <?php if ($sk8er_header_style=="8"): ?>
            <a href="javascript:void(null);" class="open-menu-sidebar dark"><span class="line"></span></a>
        <?php else: ?>
            <a href="javascript:void(null);" class="open-menu-sidebar"><span class="line"></span></a>
        <?php endif ?>

        <div class="logo">
            <a href="<?php echo site_url(); ?>">
                <?php if (!empty($sk8er['sk8er_logo']['url'])): ?>
                        <img src="<?php echo esc_url($sk8er['sk8er_logo']['url']); ?>" alt="<?php echo bloginfo('title'); ?>">
                    <?php else: ?>
                        <span class="txt-logo"><?php echo bloginfo('title'); ?></span>
                <?php endif ?>

            </a>
        </div>

        <nav>
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
                                    <span data-second="<?php echo _e('Ver Todo', 'sk8er'); ?>">...</span>
                                </a>
                            </li>
		                </ul>
		            </li>

		        <?php endif ?>

                <li class="emptyli">
                    <?php if ($sk8er_header_style=="8"): ?>
                        <a href="javascript:void(null);" class="open-widget-sidebar dark"><span class="cubes"></span><span class="cubes2"></span></a>
                    <?php elseif($sk8er_header_style=="11"): ?>
                        <a href="javascript:void(null);" class="open-widget-sidebar dark incircle"><span class="cubes"></span><span class="cubes2"></span></a>
                    <?php else: ?>
                        <a href="javascript:void(null);" class="open-widget-sidebar"><span class="cubes"></span><span class="cubes2"></span></a>
                    <?php endif ?>
                </li>
                
            </ul>
        </nav>
    </div>
</div>
</header>
<!-- HEADER 1 -->