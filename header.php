<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="<?php bloginfo('name'); ?> - <?php bloginfo('description'); ?>">
    <link rel="shortcut icon" href="<?php echo esc_url(get_template_directory_uri() . '/assets/img/favicon.ico'); ?>"
          type="image/x-icon">
    <link rel="icon" href="<?php echo esc_url(get_template_directory_uri() . '/assets/img/favicon.ico'); ?>"
          type="image/x-icon">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?> id="top">

<?php wp_body(); ?>

<div class="wrapper">
    <header class="header">
        <div class="header-before">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 header-work">
                        <i class="fa fa-clock" aria-hidden="true"></i>
                        <?php echo get_theme_mod('bw_additional_address') ?>
                    </div>
                    <div class="col-lg-7 text-right">
                        <div class="row">
                            <?php if (has_social()) { ?>
                                <div class="col-sm-3 col-md-4 header-social">
                                    <ul class="social">
                                        <?php foreach (get_social() as $social) { ?>
                                            <li class="social-item">
                                                <a href="<?php echo esc_attr(esc_url($social['url'])); ?>"
                                                   class="social-link"
                                                   target="_blank">
                                                    <i class="<?php echo esc_attr($social['icon']); ?>"
                                                       aria-hidden="true"
                                                       aria-label="<?php echo esc_attr($social['text']); ?>"></i>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            <?php } ?>
                            <?php if (has_phones()) { ?>
                                <div class="col-xs-6 col-sm-5 col-md-4 header-phone">
                                    <ul class="phone">
                                        <?php
                                        $phones = get_phones();
                                        $sizeof_phones = sizeof($phones);
                                        foreach ($phones as $index => $phone) { ?>
                                            <?php if ($index === 0): ?>
                                                <li class="phone-item">
                                                    <a href="tel:<?php echo esc_attr(get_phone_number($phone)); ?>"
                                                       class="phone-number">
                                                        <i class="fa fa-phone" aria-hidden="true"></i>
                                                        <?php echo esc_html($phone); ?>
                                                    </a>
                                                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                                                    <ul class="sub-phone">
                                            <?php endif; ?>
                                                <?php if ($index !== 0): ?>
                                                    <li class="phone-item">
                                                        <a href="tel:<?php echo esc_attr(get_phone_number($phone)); ?>"
                                                           class="phone-number">
                                                            <i class="fa fa-phone" aria-hidden="true"></i>
                                                            <?php echo esc_html($phone); ?>
                                                        </a>
                                                    </li>
                                                <?php endif; ?>
                                            <?php if ($index === $sizeof_phones): ?>
                                                    </ul>
                                                </li>
                                            <?php endif; ?>

                                        <?php } ?>
                                    </ul>
                                </div>
                            <?php } ?>
                            <div class="col-xs-6 col-sm-4 header-callback">
                                <button type="button"
                                        class="button-medium button-block text-uppercase <?php the_lang_class('js-callback'); ?>">
                                    <?php _e('Call back', 'brainworks'); ?>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-main">
            <div class="container">
                <div class="row">
                    <div class="col-xs-6 col-sm-12 col-lg-2 header-logo">
                        <div class="logo"><?php fk_logo(true); ?></div>
                    </div>
                    <?php if (has_nav_menu('main-nav')) { ?>
                        <div class="col-md-11 col-lg-9 header-nav">
                            <nav class="nav js-menu">
                                <button type="button" tabindex="0"
                                        class="menu-item-close menu-close js-menu-close"></button>
                                <?php wp_nav_menu(array(
                                    'theme_location' => 'main-nav',
                                    'container' => false,
                                    'menu_class' => 'menu-container',
                                    'menu_id' => '',
                                    'fallback_cb' => 'wp_page_menu',
                                    'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                                    'depth' => 3
                                )); ?>
                            </nav>
                        </div>
                    <?php } ?>
                    <div class="col-xs-6 col-sm-12 col-md-1 col-lg-1 header-basket">
                        <a class="basket" href="/cart">
                            <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                            <span class="basket-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-after">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-lg-3 header-catalog text-uppercase">
                        <a href="<?php echo esc_url(home_url() . '/shop'); ?>">
                        <svg class="svg-icon" width="21" height="14" fill="#fff">
                            <use xlink:href="#bars"></use>
                        </svg>
                        Категории товаров
                        </a>
                    </div>
                    <div class="col-md-8 col-lg-9 header-search"><?php get_search_form(); ?></div>
                </div>
            </div>
        </div>
    </header>
    <div class="page-wrapper container">
        <div class="nav-mobile-header">
            <button class="hamburger js-hamburger" type="button" tabindex="0">
            <span class="hamburger-box">
                <span class="hamburger-inner"></span>
            </span>
            </button>
            <div class="logo"><?php fk_logo(true, '#fff'); ?></div>
        </div>