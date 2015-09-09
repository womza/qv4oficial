<?php global $sk8er, $sk8er_header_style, $sk8er_theme_class, $sk8er_affect_class; ?>

<div class="long-logo <?php echo esc_attr($sk8er_affect_class); ?>">
    <div class="container">
        <a href="<?php echo site_url(); ?>" class="logo">
            <?php if (!empty($sk8er['sk8er_logo']['url'])): ?>
                    <img src="<?php echo esc_url($sk8er['sk8er_logo']['url']); ?>" alt="<?php echo bloginfo('title'); ?>">
                <?php else: ?>
                    <span class="txt-logo"><?php echo bloginfo('title'); ?></span>
            <?php endif ?>
        </a>

        <div class="borders">
            <span class="left"></span>
            <span class="right"></span>
        </div>
    </div>

    <a href="javascript:void(null);" class="open-menu-sidebar"><span class="line"></span></a>

    <a href="javascript:void(null);" class="open-widget-sidebar"><span class="cubes"></span><span class="cubes2"></span></a>
</div>