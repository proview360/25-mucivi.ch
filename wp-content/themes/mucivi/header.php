<?php
/**
 * Copyright (c) 2025 by Granit Nebiu
 *
 * All rights are reserved. Reproduction or transmission in whole or in part, in
 * any form or by any means, electronic, mechanical or otherwise, is prohibited
 * without the prior written consent of the copyright owner.
 *
 * Functions and definitions
 *
 * @package WordPress
 * @subpackage mucivi
 * @author Granit Nebiu, Granit Nebiu
 * @since 1.0
 */

$currentLangCode = "";
if (defined('ICL_LANGUAGE_CODE'))
{
    $currentLangCode = ICL_LANGUAGE_CODE;
}

$theme_options            = get_option('mucivi_theme_options_' . $currentLangCode);
$theme_options_all        = get_option('mucivi_theme_options_all');

$mucivi_logo                 = $theme_options_all['mucivi_logo'];

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>


<div class="header-mucivi">
    <a class="logo-desktop d-none d-sm-block" href="<?php echo esc_url(home_url('/')); ?>">
        <img width="200" height="auto" alt="logo mucivi" src="<?php echo $mucivi_logo ?>"/>
    </a>
    <nav class="desktop-nav container">
        <div class="d-block d-sm-none">
            <a class="logo-mobile" href="<?php echo esc_url(home_url('/')); ?>">
                <img width="50" height="auto" alt="logo mucivi" src="<?php echo $mucivi_logo ?>"/>
            </a>
        </div>
        <div class="">
            <div class="header-wrapper">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary-menu',
                    'container' => 'nav',
                    'container_class' => 'main-menu',
                    'menu_class' => 'nav-menu',
                    'walker' => new Desktop_Walker_Nav_Menu(),
                    'fallback_cb' => false
                ));
                ?>
                
                <div class="d-flex align-items-center gap-2 mobile-space">
                    <?php get_template_part('template-parts/language-switch'); ?>
                    <?php get_template_part('template-parts/mega-menu'); ?>
                    <div class="menu-shop">
                        <div class=" d-flex align-items-end justify-content-end ">
                            <a class="menu-item account-contents me-3"
                               href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>"
                               title="<?php _e('View your account'); ?>">
                                <div class="icon-container menu-basket-icon-account"></div>
                            </a>
                            <a class="menu-item cart-contents" href="<?php echo wc_get_cart_url(); ?>"
                               title="<?php _e('View your shopping cart'); ?>">
                                <div class="menu-basket">
                                    <div class="icon-container-basket menu-basket-icon-basket"></div>
                                    <span class="menu-basket-items-total"></span>
                                </div>
                            </a>
                        </div>
                    </div>
                    <?php get_template_part('template-parts/search-form'); ?>
                </div>
         

            </div>

        </div>
    </nav>

</div>
