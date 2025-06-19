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
	
	$linked_in_link                 = $theme_options_all['linkedin_link'] ?? "";
	$instagram_link                 = $theme_options_all['instagram_link'] ?? "";
	$facebook_link                  = $theme_options_all['facebook_link'] ?? "";
	$youtube_link                   = $theme_options_all['youtube_link'] ?? "";
	$twitter_link                   = $theme_options_all['twitter_link'] ?? "";
$nav_footer_1 = array(
		'theme_location' => 'footer-menu-1',
		'menu_class' => 'footer-menu',
		'items_wrap' => '%3$s',
	);

?>

<footer class="footer-container">
    <div class="footer-bottom py-4">
        <div class="container d-flex flex-column flex-lg-row justify-content-between align-content-start align-items-lg-center gap-2">
            <div>
                <p class="first-copyright"><?php echo $footer_copyright_text ?></p>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div>
                    <a target="_blank" href="<?php echo $facebook_link ?>">
                        <img src="/wp-content/themes/mucivi/assets/img/vectors/fb.svg" alt="social facebook">
                    </a>
                </div>
                <div>
                    <a target="_blank" href="<?php echo $twitter_link ?>">
                        <img src="/wp-content/themes/mucivi/assets/img/vectors/x.svg" alt="social facebook">
                    </a>
                </div>
                <div>
                    <a target="_blank" href="<?php echo $instagram_link ?>">
                        <img src="/wp-content/themes/mucivi/assets/img/vectors/ig.svg" alt="social facebook">
                    </a>
                </div>
                <div>
                    <a target="_blank" href="<?php echo $youtube_link ?>">
                        <img src="/wp-content/themes/mucivi/assets/img/vectors/yt.svg" alt="social facebook">
                    </a>
                </div>
                <div>
                    <a target="_blank" href="<?php echo $linked_in_link ?>">
                        <img src="/wp-content/themes/mucivi/assets/img/vectors/linkedin.svg" alt="social facebook">
                    </a>
                </div>
            </div>
        </div>

        <div class="container d-flex flex-column flex-lg-row justify-content-between align-content-start align-items-lg-center mt-3 gap-2">
            <div class="d-flex align-items-center gap-3">
		        <?php echo $footer_copyright_text_2?>
            </div>
            <div>
                <div class="d-flex flex-column flex-md-row  gap-md-5">
				    <?php wp_nav_menu($nav_footer_1); ?>
                </div>
            </div>
          
        </div>
    </div>

</footer>

<?php wp_footer(); ?>

</body>
</html>