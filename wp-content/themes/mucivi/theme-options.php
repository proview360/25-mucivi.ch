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
 * @author Granit Nebiu
 * @since 1.0
 */

/* Theme options page */
add_action( "admin_init", "theme_options_init" );
add_action( "admin_menu", "add_theme_menu_item" );

function add_theme_menu_item() {
    add_menu_page( "Theme-Optionen", "Theme Options", "manage_options", "theme-panel", "add_theme_options", null, 99 );
}

// register settings
function theme_options_init() {

    $currentLangCode = "";
    if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
        $currentLangCode = ICL_LANGUAGE_CODE;
    }

    register_setting( 'theme_options', 'mucivi_theme_options_' . $currentLangCode, 'itg_validate_options' );
    register_setting( 'theme_options', 'mucivi_theme_options_all', 'itg_validate_options' );

    $js_src = includes_url('js/tinymce/') . 'tinymce.min.js';
    $css_src = includes_url('css/') . 'editor.css';

    wp_register_style('tinymce_css', $css_src);
    wp_enqueue_style('tinymce_css');
}



// create option site
function add_theme_options() {



    if ( ! isset( $_REQUEST['settings-updated'] ) ) {
        $_REQUEST['settings-updated'] = false;
    } ?>

    <div class="wrap gn-theme-options-wrapper">
        <h2><?php _e( 'Theme options for ', "mucivi" ); ?><?php bloginfo( 'name' ); ?></h2>

        <?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
            <div class="updated fade">
                <p><strong><?php _e( 'Settings saved', "mucivi" ); ?></strong></p>
            </div>
        <?php endif; ?>

        <form method="post" action="options.php">

            <?php

            $currentLangCode = "";
            if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
                $currentLangCode = ICL_LANGUAGE_CODE;
            }

            settings_fields( 'theme_options' );
            $options     = get_option( 'mucivi_theme_options_' . $currentLangCode );
            $options_all = get_option( 'mucivi_theme_options_all' );

            $mucivi_logo           = $options_all['mucivi_logo'] ?? "";

            // footer
            $footer_copyright_text          = $options['footer_copyright_text'] ?? "";
            $footer_copyright_text_2        = $options['footer_copyright_text_2'] ?? "";

            $footer_phone_number_title      = $options['footer_phone_number_title'] ?? "";
            $footer_phone_number            = $options['footer_phone_number'] ?? "";
            $footer_phone_number_link       = $options['footer_phone_number_link'] ?? "";

            // social link
            $social_title       = $options['social_title'] ?? "";
            $twitter_link       = $options_all['twitter_link'] ?? "";
            $vimeo_link         = $options_all['vimeo_link'] ?? "";
            $linked_in_link     = $options_all['linkedin_link'] ?? "";
            $instagram_link     = $options_all['instagram_link'] ?? "";
            $youtube_link       = $options_all['youtube_link'] ?? "";
            $facebook_link      = $options_all['facebook_link'] ?? "";

            ?>
            <br>
            <script src="https://unpkg.com/phosphor-icons"></script>

            <div class="body-options">
                <div class="container-options">
                    <div class="wrapper-options">
                        <ul class="indicator-options">
                            <p class="theme-options-logo"></p>
                            <p class="theme-options-logo-text">Theme Options</p>
                            <li class="active" data-target="#general"><i class="ph-house"></i>General</li>
                            <li data-target="#social-media"><i class="ph ph-twitch-logo"></i> Social Media</li>
                            <li data-target="#footer"><i class="ph ph-tree-structure"></i>Footer</li>
                            <li data-target="#settings"><i class="ph-gear-six"></i>Settings</li>
                        </ul>
                        <ul class="content-options">
                            <li class="active" id="general">
                                <h1><?php _e( 'General Settings', "mucivi" ); ?></h1>
                                <div>

                                    <!-- Logo -->
                                    <p><?php _e( 'Logo', "mucivi" ); ?></p>
                                    <input id="image_url_mucivi_logo" type="text" name="mucivi_theme_options_all[mucivi_logo]" size="60" value="<?php esc_attr_e( $mucivi_logo ); ?>" />
                                    <input id="upload_button_mucivi_logo" type="button" class="button" value="Upload Logo" />
                                    <input id="remove_button_mucivi_logo" type="button" class="button" value="Remove Image" />
                                    <br>
                                    <?php
                                    if ($mucivi_logo !== null && $mucivi_logo != '') {
                                        echo '<p>'. _e('Image Preview',"mucivi") . '</p>';
                                        echo '<img id="preview_image_mucivi_logo" style="width:50%; background: #F5F5F5; padding:20px;" src="'. $mucivi_logo. '">';
                                    } else {
                                        echo '<p>'. _e('Image Preview',"mucivi") . '</p>';
                                        echo '<img id="preview_image_mucivi_logo" style="width:50%; background: #F5F5F5; padding:20px;" src="" >';
                                    }
                                    ?>

                                </div>
                            </li>
                            <li id="social-media">

                                <h1>Social Media Settings</h1>

                                <p>Social Title</p>
                                <div>
                                    <input class="gn-option-fields"
                                           type="text"
                                           name="mucivi_theme_options_<?php echo $currentLangCode; ?>[social_title]"
                                           value="<?php esc_attr_e( $social_title ); ?>"/>
                                </div>
                                <hr>
                                <p>Twitter - Link</p>
                                <div>
                                    <input class="gn-option-fields"
                                           type="text"
                                           name="mucivi_theme_options_all[twitter_link]"
                                           value="<?php esc_attr_e( $twitter_link ); ?>"/>
                                </div>
                                <hr>
                                <p>LinkedIn - Link</p>
                                <div>
                                    <input class="gn-option-fields"
                                           type="text"
                                           name="mucivi_theme_options_all[linkedin_link]"
                                           value="<?php esc_attr_e( $linked_in_link ); ?>"/>
                                </div>
                                <hr>
                                <p>Instagram - Link</p>
                                <div>
                                    <input class="gn-option-fields"
                                           type="text"
                                           name="mucivi_theme_options_all[instagram_link]"
                                           value="<?php esc_attr_e( $instagram_link ); ?>"/>
                                </div>
                                <hr>
                                <p>Youtube - Link</p>
                                <div>
                                    <input class="gn-option-fields"
                                           type="text"
                                           name="mucivi_theme_options_all[youtube_link]"
                                           value="<?php esc_attr_e( $youtube_link ); ?>"/>
                                </div>
                                <hr>
                                <p>Facebook - Link</p>
                                <div>
                                    <input class="gn-option-fields"
                                           type="text"
                                           name="mucivi_theme_options_all[facebook_link]"
                                           value="<?php esc_attr_e( $facebook_link ); ?>"/>
                                </div>
                                <p>Vimeo - Link</p>
                                <div>
                                    <input class="gn-option-fields"
                                           type="text"
                                           name="mucivi_theme_options_all[vimeo_link]"
                                           value="<?php esc_attr_e( $vimeo_link ); ?>"/>
                                </div>
                                <hr>

                            </li>
                            <li id="footer">
                                <h1>Footer Settings</h1>
                                <hr/>
                                <p><?php _e( 'Copyright Text', "mucivi" ); ?></p>
                                <div>
                                    <input class="gn-option-fields"
                                           type="text"
                                           name="mucivi_theme_options_<?php echo $currentLangCode; ?>[footer_copyright_text]"
                                           value="<?php esc_attr_e( $footer_copyright_text); ?>"
                                    />
                                </div>

                                <p><?php _e( 'Copyright Text 2', "mucivi" ); ?></p>
                                <div>
                                    <input class="gn-option-fields"
                                           type="text"
                                           name="mucivi_theme_options_<?php echo $currentLangCode; ?>[footer_copyright_text_2]"
                                           value="<?php esc_attr_e( $footer_copyright_text_2); ?>"
                                    />
                                </div>
                                <hr/>

                                <p><?php _e( 'Phone number title', "mucivi" ); ?></p>
                                <div>
                                    <input class="gn-option-fields"
                                           type="text"
                                           name="mucivi_theme_options_<?php echo $currentLangCode; ?>[footer_phone_number_title]"
                                           value="<?php esc_attr_e( $footer_phone_number_title ); ?>"
                                    />
                                </div>

                                <p><?php _e( 'Phone Number', "mucivi" ); ?></p>
                                <div>
                                    <input class="gn-option-fields"
                                           type="text"
                                           name="mucivi_theme_options_<?php echo $currentLangCode; ?>[footer_phone_number]"
                                           value="<?php esc_attr_e( $footer_phone_number ); ?>"
                                    />
                                </div>

                                <p><?php _e( 'Phone Number Link', "mucivi" ); ?></p>
                                <div>
                                    <input class="gn-option-fields"
                                           type="text"
                                           name="mucivi_theme_options_<?php echo $currentLangCode; ?>[footer_phone_number_link]"
                                           value="<?php esc_attr_e( $footer_phone_number_link ); ?>"
                                    />
                                </div>

<!--                                <p>--><?php //_e( 'Copyright', "mucivi" ); ?><!--</p>-->
<!--                                <div>-->
<!--                                    --><?php //echo getWpEditor($copyright, "mucivi_theme_options_lang_copyright", "mucivi_theme_options_" . $currentLangCode . "[copyright]") ?>
<!--                                </div>-->

                                <hr>
                            </li>

                            <li id="settings">
                                <h1>Other Settings</h1>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Reiciendis, sapiente.</p>

                            </li>
                        </ul>

                        <p class="submit-options">
                            <input type="submit" class="button-primary" value="<?php _e( 'Save settings', "mucivi" ); ?>"/>
                        </p>
                    </div>
                </div>
            </div>


        </form>
    </div>
    <script>
        jQuery(document).ready(function($) {

            // Upload
            $('#upload_button_mucivi_logo, #upload_button_mucivi_logo_active, #upload_button_mucivi_logo_mobile, #upload_button_mucivi_footer_logo, #upload_button_mucivi_footer_logo_2, #upload_button_mucivi_slider_background').on('click', function(e) {
                e.preventDefault();

                // get the name of the current clicked button id (without 'upload_button_' prefix)
                var option_name = this.id.replace('upload_button_', '');

                var image = wp.media({
                    title: 'Upload Image',
                    multiple: false
                }).open().on('select', function(e) {
                    var uploaded_image = image.state().get('selection').first();
                    var full_image_url = uploaded_image.toJSON().url;

                    // Create a URL object
                    var url_path = new URL(full_image_url);

                    // Get the pathname (the part of the URL after the domain)
                    var image_url = url_path.pathname;

                    $('#image_url_' + option_name).val(image_url);
                    $('#preview_image_' + option_name).attr('src', full_image_url);
                });
            });

            // Remove
            $('#remove_button_mucivi_logo, #remove_button_mucivi_logo_active, #remove_button_mucivi_logo_mobile, #remove_button_mucivi_footer_logo, #remove_button_mucivi_footer_logo_2, #remove_button_mucivi_slider_background').on('click', function(e) {
                e.preventDefault();

                // get the name of the current clicked button id (without 'remove_button_' prefix)
                var option_name = this.id.replace('remove_button_', '');

                $('#image_url_' + option_name).val(''); // Empty the input field
                $('#preview_image_' + option_name).attr('src', ''); // Remove the image preview

                // Add Ajax call to update the database
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    async: true,
                    cache: false,
                    global: false,
                    dataType: 'json',
                    data:{
                        action: 'remove_option', // Tell WordPress how to handle this AJAX request
                        option_name: 'mucivi_theme_options_all', // provide the correct option_name here
                        clicked_option: option_name // Pass the option name related to the clicked button
                    }
                });
            });
        });
    </script>

    <?php
}