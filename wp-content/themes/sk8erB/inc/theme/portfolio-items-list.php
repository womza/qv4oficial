<?php if (taxonomy_exists('portfolio-categories')): ?>

    <?php wp_enqueue_style('sk8er-swipebox'); wp_enqueue_script('sk8er-isotope'); ?>
    
    <?php
        global $post;
        global $sk8er_sidebar;
        $sk8er_sidebar = get_post_meta($post->ID, 'sk8er_portfolio_sidebar', true);
        $sk8er_portfolio_columns = get_post_meta($post->ID, 'sk8er_portfolio_columns', true);
        $sk8er_portfolio_layout = get_post_meta($post->ID, 'sk8er_portfolio_layout', true);

        $sk8er_portfolio_nospace = get_post_meta($post->ID, 'sk8er_portfolio_nospace', true);
        if ($sk8er_portfolio_nospace=="on") {
            $sk8er_nospace = "nospace";
        } else { $sk8er_nospace="";}

        if ($sk8er_portfolio_layout=='normal') {
            $sk8er_addclass = 'col-'.$sk8er_portfolio_columns.' '.$sk8er_nospace.'';
        } elseif ($sk8er_portfolio_layout=='grid') {
            $sk8er_addclass = 'grid';
        }


    ?>
    <section class="style-15 portfolio-items cols <?php echo esc_attr($sk8er_addclass); ?>">
        <div class="container">
            <div class="row">
                <?php if ($sk8er_sidebar=="on"): ?>
                    <div class="col-md-9">
                <?php else: ?>
                    <div class="col-md-12">
                <?php endif ?>

                    <ul class="portfolio-filter">
                        <li class="left">
                            <ul>
                                <?php
                                    $args = array(
                                        'child_of'                 => 0,
                                        'parent'                   => '',
                                        'order'                    => 'ASC',
                                        'taxonomy'                 => 'portfolio-categories',
                                    );

                                    $categories = get_categories($args);
                                    $category = get_queried_object();
                                    $cat_id = $category->ID;
                                    ?>

                                    <?php echo get_category_link($category->cat_ID); ?>

                                    <li class="portfolio-hide"><a href="javascript:void(null);" class="filter all" data-filter=".item">All</a></li>

                                    <?php
                                    foreach ($categories as $category) { ?>
                                        <li class="portfolio-hide"><a href="javascript:void(null);" data-filter=".<?php echo esc_attr($category->slug); ?>" class="filter"><?php echo esc_html($category->name); ?></a></li>
                                    <?php }

                                ?>
                            </ul>

                            <select id="filter-select">
                                <option value=".item" selected>All</option>
                                <?php foreach ($categories as $category): ?>
                                        <option value=".<?php echo esc_attr($category->slug); ?>"><?php echo esc_html($category->name); ?></option>
                                <?php endforeach ?>
                            </select>
                        </li>

                        <li class="right sort-layout">
                            <ul>
                                <li class="active"><a href="javascript:void(null);" data-sort="boxes"><i class="fa fa-th"></i></a></li>
                                <li><a href="javascript:void(null);" data-sort="lines"><i class="fa fa-align-justify"></i></a></li>
                            </ul>
                        </li>
                    </ul>

                    <div class="portfolio-items-wrapper boxes">

                        <?php
                            $args = array( 'post_type' => 'portfolio');
                            $wp_query = new WP_Query( $args );
                        ?>

                        <?php if ($wp_query->have_posts() ): while($wp_query->have_posts() ): $wp_query->the_post() ?>
                            <?php $current_category = wp_get_object_terms( $post->ID, 'portfolio-categories', array('orderby'=>'term_order')); ?>
                            <?php if (has_post_thumbnail( $post->ID ) ): ?>
                                <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
                                <?php $thumbnail = $image[0]; ?>
                            <?php else: ?>
                                <?php $thumbnail = "http://placehold.it/800x480"; ?>
                            <?php endif; ?>

                            <?php if (!empty($current_category)): ?>
                                <div <?php post_class("item ".$current_category[0]->slug); ?>>
                                <?php else: ?>
                                <div class="item">
                            <?php endif ?>

                            
                            
                                <div class="image">
                                    <div class="actual-image" style="background-image: url(<?php echo esc_url($thumbnail); ?>);"></div>
                                    <div class="hover">
                                        <div class="title"><?php the_title(); ?></div>
                                        <div class="actions">
                                            <a href="<?php the_permalink(); ?>"><i class="fa fa-chain"></i></a>
                                                <span class="sep"></span>
                                            <a href="<?php echo esc_url($thumbnail); ?>" class="swipebox"><i class="fa fa-search"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="info">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    <?php if (!empty($current_category)): ?>
                                        <span><?php echo esc_html($current_category[0]->name); ?></span>
                                    <?php endif ?>
                                    
                                    <?php if ($sk8er_portfolio_layout=='grid'): ?>
                                        <?php the_excerpt(); ?>
                                    <?php endif ?>
                                </div>
                            </div>

                        <?php endwhile; endif; ?>
                    </div>

                    <div class="load-more-wrapper">
                        <a href="javascript:void(null);" class="load-more load_more" data-nonce="<?php echo wp_create_nonce('load_posts') ?>"><span>Load More</span></a>
                    </div>
                </div>

                <?php if ($sk8er_sidebar=="on"): ?>
                    <div class="col-md-3">
                        <div class="sidebar">
                            <?php get_sidebar(); ?>
                        </div>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </section>
<?php else: ?>
    <?php echo "Sorry, You must to activate <b>Sk8er Post Types</b> plugin in order for this to work."; ?>
<?php endif ?>