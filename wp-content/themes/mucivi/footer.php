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

$footer_title_1 = $theme_options['footer_title_1'] ?? "";
$footer_title_2 = $theme_options['footer_title_2'] ?? "";

$footer_address         = $theme_options['footer_address'] ?? "";
$footer_address_2       = $theme_options['footer_address_2'] ?? "";
$footer_address_2_link  = $theme_options['footer_address_2_link'] ?? "";

$footer_copyright_text          = $theme_options['footer_copyright_text'] ?? "";
$footer_copyright_text_2        = $theme_options['footer_copyright_text_2'] ?? "";

$footer_phone_number_title      = $theme_options['footer_phone_number_title'] ?? "";
$footer_phone_number            = $theme_options['footer_phone_number'] ?? "";
$footer_phone_number_link       = $theme_options['footer_phone_number_link'] ?? "";

$footer_title_1       = str_replace("[*", "<br/><span class='text-bold'>", $footer_title_1);
$footer_title_1        = str_replace("*]", "</span>", $footer_title_1);

$footer_title_2       = str_replace("[*", "<br/><span class='text-bold'>", $footer_title_2);
$footer_title_2        = str_replace("*]", "</span>", $footer_title_2);


$nav_footer_1 = array(
    'theme_location' => 'footer-menu-1',
    'menu_class' => 'footer-menu',
    'items_wrap' => '%3$s',
);

$nav_footer_2 = array(
    'theme_location' => 'footer-menu-2',
    'menu_class' => 'footer-menu',
    'items_wrap' => '%3$s',
);

$nav_footer_3 = array(
    'theme_location' => 'footer-menu-3',
    'menu_class' => 'footer-menu',
    'items_wrap' => '%3$s',
);

$nav_footer_4 = array(
    'theme_location' => 'footer-menu-4',
    'menu_class' => 'footer-menu',
    'items_wrap' => '%3$s',
);


?>

<footer class="footer-container">
<!--    <div class="container ">-->
<!--        <div class="footer-top d-flex flex-column flex-xl-row justify-content-between">-->
<!--            <div class="px-3 px-md-0">-->
<!--                <p class="gn-h1 py-5 text-color-white"> --><?php //echo $footer_title_1 ?><!--</p>-->
<!--                <div class="d-flex flex-column flex-md-row  gap-md-5">-->
<!--                    --><?php //wp_nav_menu($nav_footer_1); ?>
<!--                    --><?php //wp_nav_menu($nav_footer_2); ?>
<!--                </div>-->
<!--            </div>-->
<!---->
<!--            <div class="px-3 px-md-0">-->
<!--                <p class="gn-h1 py-5 text-color-white"> --><?php //echo $footer_title_2 ?><!--</p>-->
<!--                <div class="d-flex flex-column flex-md-row  gap-md-5 ">-->
<!--                    --><?php //wp_nav_menu($nav_footer_3); ?>
<!--                    --><?php //wp_nav_menu($nav_footer_4); ?>
<!--                </div>-->
<!--            </div>-->
<!---->
<!---->
<!--        </div>-->
<!--    </div>-->

    <div class="footer-bottom py-4">
        <div class="container d-flex justify-content-center align-content-center px-3 px-md-0">
                    <p class="first-copyright"><?php echo $footer_copyright_text ?></p>
        </div>

    </div>

</footer>

<?php wp_footer(); ?>

</body>
</html>