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

function gn_showcase_block_rc($attributes, $content) {

    // get globals and scripts
    global  $theme_path;
    wp_register_style("gn_showcase_block",$theme_path."/gn-blocks/showcase-block/showcase_block.css",array("css-main"),"1");


    $showcase_background_image      = $attributes["showcase_background_image"]["url"] ?? '';
    $showcase_headline              = $attributes["showcase_headline"] ?? '';
    $showcase_description           = $attributes["showcase_description"] ?? '';
    $showcase_button_text           = $attributes["showcase_button_text"] ?? '';
    $showcase_button_link           = $attributes["showcase_button_link"] ?? '';
    $showcase_btn_html              = '';
    $showcase_section_image_position = $attributes["showcase_section_image_position"] ?? 'scroll';
    $showcase_align_content         = $attributes["showcase_section_align_content"] ?? 'start';
    $banner_text_color              = $attributes["banner_text_color"] ?? '--mucivi-white';
	$overlay                        = $attributes["overlay"] ?? '';
	$overlay_picture                = $attributes["overlay_picture"] ?? '';
	$headline_type                  = $attributes["select_headline_type"] ?? 'h1';
	
    $show_case_button           = $attributes["show_case_button"] ?? 'btn-full-blue';
    $unique_class               = 'showcase-section-block-' . uniqid();

    // check if button exists
    if($showcase_button_link) {
        $showcase_btn_html = '<a class="btn-full '.$show_case_button.'" href="'.$showcase_button_link.'">
                            '.$showcase_button_text.'
                        </a>';
    }
	
	$overlay_html ="";
	if ($overlay === "yez") {
		$overlay_html = '<div class="showcase-overlay"></div>';
	}
	
	$overlay_picture_html ="";
	if ($overlay_picture === "yez") {
		$overlay_picture_html = '<div class="showcase-overlay-picture"></div>';
	}
	
	
	$showcase_section_style = '
        <style>
             .' . $unique_class . ' {
                background-image: url('. $showcase_background_image .');
                background-attachment: '. $showcase_section_image_position.';
                background-size: cover;  
                background-repeat: no-repeat; 
                background-position: center center;
                overflow: hidden;
                color:  var('. $banner_text_color.');
            }

            @media (max-width: 1024px) {
                 .' . $unique_class . ' {
                    background-attachment: scroll;
                }
            }
        </style>';

    $showcase_section_html = '<div class="showcase-section d-flex flex-column align-items-'.$showcase_align_content.' justify-content-evenly text-'.$showcase_align_content.'">
            <div class="showcase-content">
				<'.$headline_type.' class="showcase-title">'.$showcase_headline.'</'.$headline_type.'>
                <p class="showcase-description">'.$showcase_description.'</p>
                  <div class="showcase-section-button">
                    '.$showcase_btn_html.'
                  </div>
            </div>
        </div>';

    return $showcase_section_style.'<section class="showcase-section-block ' . $unique_class . '">   
        <div class="container showcase-section-container showcase-section-banner">
                 '. $overlay_picture_html .'
                    '. $overlay_html .'
                '.$showcase_section_html.'
        </div>
    </section>';
}