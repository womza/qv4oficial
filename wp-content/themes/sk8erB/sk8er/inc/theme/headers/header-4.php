<?php global $sk8er, $sk8er_header_style, $sk8er_theme_class, $sk8er_affect_class; ?>

<!-- HEADER 3 -->
<header class="header-3 <?php echo esc_attr($sk8er_affect_class); ?>">
    <a href="javascript:void(null);" class="open-menu-sidebar dark"><span class="line"></span></a>

    <div class="logo">
        <a href="<?php echo site_url(); ?>">
            <?php if (!empty($sk8er['sk8er_logo']['url'])): ?>
                    <img src="<?php echo esc_url($sk8er['sk8er_logo']['url']); ?>" alt="<?php echo bloginfo('title'); ?>">
                <?php else: ?>
                    <span class="txt-logo"><?php echo bloginfo('title'); ?></span>
            <?php endif ?>
        </a>
    </div>

    <a href="javascript:void(null);" class="open-widget-sidebar dark"><span class="cubes"></span><span class="cubes2"></span></a>
</header>
<!-- HEADER 3 -->