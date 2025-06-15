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
	

	$hero_button_text_2 = $attributes["hero_button_text_2"] ?? '';
	$hero_button_link_2 = $attributes["hero_button_link_2"] ?? '';
	
	$hero_button_text_3 = $attributes["hero_button_text_3"] ?? '';
	$hero_button_link_3 = $attributes["hero_button_link_3"] ?? '';
	
	$hero_button_text_4 = $attributes["hero_button_text_4"] ?? '';
	$hero_button_link_4 = $attributes["hero_button_link_4"] ?? '';
	
	$hero_button_text_5 = $attributes["hero_button_text_5"] ?? '';
	$hero_button_link_5 = $attributes["hero_button_link_5"] ?? '';
	
	$hero_button_text_6 = $attributes["hero_button_text_6"] ?? '';
	$hero_button_link_6 = $attributes["hero_button_link_6"] ?? '';

    $hero_image_html                = '';
	$overlay                        = $attributes["overlay"] ?? '';
	$overlay_picture                = $attributes["overlay_picture"] ?? '';
    $hero_section_style             = '';
    $hero_section_layout_type       = $attributes["hero_section_layout_type"] ?? '';
    $hero_section_image_position    = $attributes["hero_section_image_position"] ?? 'scroll';
    $hero_align_content             = $attributes["hero_section_align_content"] ?? 'start';
	$unique_class = 'hero-section-block-' . ( $attributes['clientId'] ?? uniqid() );

    $banner_text_color          =  $attributes["banner_text_color"] ?? '--mucivi-white';
    $banner_background_color    = $attributes["banner_background_color"] ?? '';

    $unique_id = 'padding-block-' . uniqid();

    $hero_image_extra_class = "";


    if($hero_image !== "") {
        $hero_image_html = '<img src="'.$hero_image.'" class="hero-image-icons" alt="'.$hero_image.'">';
        $hero_image_extra_class = 'hero-image-extra-class';
    }

    // check if btn exist
	$hero_btn_html = '';
	
	$buttons = [];
	
	if ($hero_button_link)
	{
		$buttons[] = '<span class="hero-section-button">
                    <a href="' . esc_url($hero_button_link) . '">
                        ' . esc_html($hero_button_text) . '
                    </a>
                  </span>';
	}
	
	if ($hero_button_link_2)
	{
		$buttons[] = '<span class="hero-section-button">
                    <a href="' . esc_url($hero_button_link_2) . '">
                        ' . esc_html($hero_button_text_2) . '
                    </a>
                  </span>';
	}
	
	if ($hero_button_link_3)
	{
		$buttons[] = '<span class="hero-section-button">
                    <a href="' . esc_url($hero_button_link_3) . '">
                        ' . esc_html($hero_button_text_3) . '
                    </a>
                  </span>';
	}
	
	if ($hero_button_link_4)
	{
		$buttons[] = '<span class="hero-section-button">
                    <a href="' . esc_url($hero_button_link_4) . '">
                        ' . esc_html($hero_button_text_4) . '
                    </a>
                  </span>';
	}
	
	if ($hero_button_link_5)
	{
		$buttons[] = '<span class="hero-section-button">
                    <a href="' . esc_url($hero_button_link_5) . '">
                        ' . esc_html($hero_button_text_5) . '
                    </a>
                  </span>';
	}
	
	if ($hero_button_link_6)
	{
		$buttons[] = '<span class="hero-section-button">
                    <a href="' . esc_url($hero_button_link_6) . '">
                        ' . esc_html($hero_button_text_6) . '
                    </a>
                  </span>';
	}
	
	// Combine with white line separator and wrap in flex container
	if (!empty($buttons))
	{
		$hero_btn_html = '<div class="hero-button-section-mob d-flex align-items-center justify-content-center flex-wrap">'
			. implode('<span style="color: white;" class="seperator-herosection">-</span>', $buttons)
			. '</div>';
	}
	
	$overlay_html ="";
	if ($overlay === "yez")
	{
		$overlay_html = '<div class="hero-section-overlay"></div>';
	}
	
	$overlay_picture_html ="";
	if ($overlay_picture === "yez")
	{
		$overlay_picture_html = '<div class="hero-section-overlay-picture"></div>';
	}
	
	
	if($hero_section_layout_type == 'hero-section-banner-2')
	{
        $hero_section_style = '
					            <style>
					                 .' . $unique_class . ' {
					                        background-color: var('. $banner_background_color.');
					                        color:  var('. $banner_text_color.');
					                }
					        	</style>';

        $hero_section_html = '<div class=" container hero-section d-flex flex-column align-items-'.$hero_align_content.' justify-content-center text-'.$hero_align_content.'">
				                        <h1 class="hero-title">'.$hero_headline.'</h1>
				                        <p  id="'.$unique_id.'" class="hero-description">'.$hero_description.'</p>
				                            '.$hero_btn_html.'
				                        '.$hero_image_html.'
				                </div>';

    }
    elseif($hero_section_layout_type == 'hero-section-banner-1')
    {
        $hero_section_style = '
					            <style>
					                 .' . $unique_class . ' {
					                    background-image: url('. $hero_background_image .');
					                    background-attachment: '. $hero_section_image_position.';
					                    background-size: cover;
					                    background-repeat: no-repeat;
					                    background-position: left center;
					                    color:  var('. $banner_text_color.');
					                }
					        
					                @media (max-width: 1024px) {
					                     .' . $unique_class . ' {
					                        background-attachment: scroll;
					                    }
					                }
					        </style>';

        $hero_section_html = '<div class=" container hero-section d-flex flex-column align-items-'.$hero_align_content.' justify-content-center text-'.$hero_align_content.'">
				                        <h1 class="hero-title">'.$hero_headline.'</h1>
				                        <p  id="'.$unique_id.'" class="hero-description">'.$hero_description.'</p>
				                            '.$hero_btn_html.'
				                    '.$hero_image_html.'
				                </div>';

    }


    return $hero_section_style.'<section class="hero-section-block ' . $unique_class . '">
						            <div class=" hero-section-container '.$hero_section_layout_type.' '.$hero_image_extra_class.'">
						                    '. $overlay_picture_html .'
						                    '. $overlay_html .'
						                    '.$hero_section_html.'
						            </div>
						        </section>';
}