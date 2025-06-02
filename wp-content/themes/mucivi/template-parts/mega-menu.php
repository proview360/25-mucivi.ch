<?php
$currentLangCode = "";
if (defined('ICL_LANGUAGE_CODE'))
{
    $currentLangCode = ICL_LANGUAGE_CODE;
}

$theme_options            = get_option('mucivi_theme_options_' . $currentLangCode);
$theme_options_all        = get_option('mucivi_theme_options_all');

$mega_menu_headline = $theme_options['mega_menu_title'] ?? "";

$mega_menu_headline        = str_replace("[*", "<br/><span class='text-bold'>", $mega_menu_headline);
$mega_menu_headline        = str_replace("*]", "</span>", $mega_menu_headline);

$footer_address         = $theme_options['footer_address'] ?? "";
$footer_address_2       = $theme_options['footer_address_2'] ?? "";
$footer_address_2_link  = $theme_options['footer_address_2_link'] ?? "";

$footer_phone_number_title      = $theme_options['footer_phone_number_title'] ?? "";
$footer_phone_number            = $theme_options['footer_phone_number'] ?? "";
$footer_phone_number_link       = $theme_options['footer_phone_number_link'] ?? "";

$social_title                   = $theme_options['social_title'] ?? "";

$social_title        = str_replace("[*", "<br/><span>", $social_title);
$social_title        = str_replace("*]", "</span>", $social_title);

$linked_in_link                 = $theme_options_all['linkedin_link'] ?? "";
$instagram_link                 = $theme_options_all['instagram_link'] ?? "";
$facebook_link                  = $theme_options_all['facebook_link'] ?? "";
?>

<div class="open-mega-menu d-flex d-lg-none" id="openMegaMenu">
    <!-- Open Hamburger SVG -->
    <div class="svg-icon open-icon">
        <img src="/wp-content/themes/mucivi/assets/img/vectors/openMenu.svg" width="30" height="27.23" alt="Close">
    </div>

    <!-- Close (X) SVG -->
    <div class="svg-icon close-icon">
        <img src="/wp-content/themes/mucivi/assets/img/vectors/closeMenu.svg" width="30" height="27.23" alt="Close">
    </div>
</div>
<div class="overflow-hidden">
    <div class="split-panel panel-left" id="panelLeft">
  
    </div>
    <div class="split-panel panel-right" id="panelRight">


        <div class="mega-socials">
            <div>
                <a href="<?php echo $facebook_link ?>">
                    <img src="/wp-content/themes/mucivi/assets/img/vectors/fb.svg" alt="social facebook">
                </a>
            </div>
            <div>
                <a href="<?php echo $linked_in_link ?>">
                    <img src="/wp-content/themes/mucivi/assets/img/vectors/linkedin.svg" alt="social facebook">
                </a>
            </div>
            <div>
                <a href="<?php echo $instagram_link ?>">
                    <img src="/wp-content/themes/mucivi/assets/img/vectors/ig.svg" alt="social facebook">
                </a>
            </div>
            <div class="mega-social-description">
                <p><?php echo $social_title ?></p>
            </div>
        </div>
        <div class="panel-content container">
            <div class="mega-menu-main d-flex flex-column justify-content-between">
                <div class="mega-menu-right-top">
                    <p class="gn-h1"><?php echo $mega_menu_headline ?></p>
                    <nav class="mega-menu-content ">
                                        <?php
                                        wp_nav_menu(array(
                                            'theme_location' => 'mobile-menu',
                                            'container' => 'nav',
                                            'container_class' => 'mega-menu',
                                            'menu_class' => 'nav-menu-mobile',
                                            'walker' => new Mobile_Walker_Nav_Menu(),
                                            'fallback_cb' => false
                                        ));
                                        ?>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>