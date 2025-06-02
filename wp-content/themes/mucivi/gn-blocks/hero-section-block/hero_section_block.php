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
function gn_hero_section_block_rc($attributes, $content) {

    global  $theme_path;
    wp_register_style("gn_hero_section_block",$theme_path."/gn-blocks/hero-section-block/hero_section_block.css",array("css-main"),"1");

    $hero_background_image      = $attributes["hero_background_image"]["url"] ?? '';
    $hero_image                 = $attributes["hero_image"]["url"] ?? '';
    $hero_headline              = $attributes["hero_headline"] ?? '';
    $hero_description           = $attributes["hero_description"] ?? '';
    $hero_button_text           = $attributes["hero_button_text"] ?? '';
    $hero_button_link           = $attributes["hero_button_link"] ?? '';

    $hero_image_html      = '';
    $hero_btn_html              = '';
    $hero_section_style             = '';
    $hero_section_layout_type       = $attributes["hero_section_layout_type"] ?? '';
    $hero_section_image_position    = $attributes["hero_section_image_position"] ?? 'scroll';
    $hero_align_content             = $attributes["hero_section_align_content"] ?? 'start';
    $unique_class = 'hero-section-block-' . uniqid();

    $banner_text_color          =  $attributes["banner_text_color"] ?? '--mucivi-white';
    $banner_background_color    = $attributes["banner_background_color"] ?? '';

    $unique_id = 'padding-block-' . uniqid();

    $hero_image_extra_class = "";


    if($hero_image !== "") {
        $hero_image_html = '<img src="'.$hero_image.'" class="hero-image-icons" alt="'.$hero_image.'">';
        $hero_image_extra_class = 'hero-image-extra-class';
    }

    // check if btn exist
    if( $hero_button_link )
    {
        $hero_btn_html = '   <div class="hero-section-button">
                                <a class="btn-full btn-full-red" href="'.$hero_button_link.'">
                                    '.$hero_button_text.'
                                </a>
                              </div>';
    }


    if($hero_section_layout_type == 'hero-section-banner-2'){
        $hero_section_style = '
            <style>
            
                 .' . $unique_class . ' {
                        background-color: var('. $banner_background_color.');
                        color:  var('. $banner_text_color.');
                }
        </style>';

        $hero_section_html = '<div class="hero-section d-flex flex-column align-items-'.$hero_align_content.' justify-content-center text-'.$hero_align_content.'">
                        <h1 class="hero-title">'.$hero_headline.'</h1>
                        <p  id="'.$unique_id.'" class="hero-description">'.$hero_description.'</p>
                            '.$hero_btn_html.'
                        '.$hero_image_html.'
                </div>';

    }
    elseif($hero_section_layout_type == 'hero-section-banner-1'){
        $hero_section_style = '
            <style>
                 .' . $unique_class . ' {
                    background-image: url('. $hero_background_image .');
                    background-attachment: '. $hero_section_image_position.';
                    background-size: cover;  
                    background-repeat: no-repeat; 
                    background-position: center center;
                    color:  var('. $banner_text_color.');
                }
        
                @media (max-width: 1024px) {
                     .' . $unique_class . ' {
                        background-attachment: scroll;
                    }
                }
        </style>';

        $hero_section_html = '<div class="hero-section d-flex flex-column align-items-'.$hero_align_content.' justify-content-center text-'.$hero_align_content.'">
                
                        <h1 class="hero-title">'.$hero_headline.'</h1>
                        <p  id="'.$unique_id.'" class="hero-description">'.$hero_description.'</p>
                            '.$hero_btn_html.'
                    '.$hero_image_html.'
                </div>';

    }


    return $hero_section_style.'<section class="hero-section-block ' . $unique_class . '">   
            <div class="container hero-section-container '.$hero_section_layout_type.' '.$hero_image_extra_class.'">
                    '.$hero_section_html.'
            </div>
        </section>';
}