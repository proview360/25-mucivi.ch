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

// rc for hero section block
function gn_website_block_rc($attributes, $content) {

    global  $theme_path;
    wp_register_style("gn_website_block",$theme_path."/gn-blocks/website-block/website_block.css",array("css-main"),"1");

    $layout                 = $attributes['layout'] ?? "container";
    $image_desktop         = $attributes["desktop_image"]["url"] ?? '';
    $image_mobile          = $attributes["mobile_image"]["url"] ?? '';

    $button_text           = $attributes["button_text"] ?? '';
    $button_link           = $attributes["button_link"] ?? '';

    $image_desktop_html      = '';
    $image_mobile_html      = '';
    $btn_html              = '';

    $unique_class = 'website-section-block-' . uniqid();

    $text_color          =  $attributes["text_color"] ?? '';
    $background_color    = $attributes["background_color"] ?? '';


//        echo '<pre>';
//        echo print_r($attributes);
//        echo '</pre>';

    if($image_desktop !== "") {
        $image_desktop_html = '<img src="'.$image_desktop.'" class="website-images" alt="'.$image_desktop.'">';
    }
    if($image_mobile !== "") {
        $image_mobile_html = '<img src="'.$image_mobile.'" class="website-images-2" alt="'.$image_mobile.'">';
    }


    // check if btn exist
    if( $button_link )
    {
        $btn_html = '   <div class="website-section-button mt-5 ">
                                <a class="btn-outline btn-outline-red" href="'.$button_link.'">
                                    '.$button_text.'
                                </a>
                              </div>';
    }




    return '<section class="website-section-block ' . $unique_class . ' bg-'.$background_color.' text-'.$text_color.'">   
            <div class="website-section-container ' . ( $layout == "full-width" ? "container-fluid" : "container" ) . ' ">
                <div class="d-flex flex-column flex-lg-row align-items-center gap-5">
                    <div class="col-12 col-lg-8">
                        '.$image_desktop_html.'
                    </div>
                    <div class="col-12 col-lg-4">
                         '.$image_mobile_html.'
                     </div>
          
                </div>
                     '.$btn_html.'
            </div>
                
        </section>';
}