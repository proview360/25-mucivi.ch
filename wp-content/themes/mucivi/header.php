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
    <a class="logo-desktop" href="<?php echo esc_url(home_url('/')); ?>">
        <img width="200" height="auto" alt="logo mucivi" src="<?php echo $mucivi_logo ?>"/>
    </a>
    <nav class="desktop-nav">
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
	            
	            <?php get_template_part('template-parts/language-switch'); ?>
	            <?php get_template_part('template-parts/mega-menu'); ?>
                <?php get_template_part('template-parts/search-form'); ?>
         

            </div>

        </div>
    </nav>

</div>
