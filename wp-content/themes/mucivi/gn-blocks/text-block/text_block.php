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

// rc for text block
function gn_text_block_rc($attributes, $content) {

    // get globals and scripts
    global  $theme_path;
    wp_register_style("gn_text_block",$theme_path."/gn-blocks/text-block/text_block.css",array("css-main"),"1");

    // vars
    $uniq_id                    = uniqid();
    $con                        = "";
    $conHTML                    = "";


    $headline                   = $attributes["headline"] ?? "";
    $sub_headline               = $attributes["sub_headline"] ?? "";

    $headline       = str_replace("[*", "<br/><span class='text-bold'>", $headline);
    $headline        = str_replace("*]", "</span>", $headline);

    $sub_headline       = str_replace("[*", "<br/><span class='text-bold'>", $sub_headline);
    $sub_headline        = str_replace("*]", "</span>", $sub_headline);

    $headline_html              = "";
    $sub_headline_html          = "";
	
    $class_name                 = $attributes["class_name"] ?? "";
    $content_position           = $attributes["two_columns"] ?? "0";
	$align_items                = $attributes["select_field"] ?? 'left';
    $background_color           = $attributes["background_color"] ?? 'white';
    $text_color                 = $attributes["text_color"] ?? 'black';
    $text_style                 = $attributes["text_style"] ?? 'sRichText';
    $space_bottom               = $attributes["space_bottom"] ?? 'yes';
    $space_top                  = $attributes["space_top"] ?? 'yes';

    $margin_top                 = $attributes["margin_top"] ?? '20';
    $headline_style             = $attributes["select_headline_style"] ?? 'style-1';
    $select_sub_headline_type   = $attributes["select_sub_headline_type"] ?? '';
    $select_headline_type       = $attributes["select_headline_type"] ?? '';
	$sidebar_enable             = $attributes['side_bar_enable'] ?? '';
	$sidebar_title              = $attributes["side_bar_title"] ?? '';

    if($headline_style == "style_2")
    {
        $headline_style_class = "style-2";
    }
    else
    {
        $headline_style_class = "style-1";
    }

    if ($select_headline_type  !== "" )
    {
        $headline_type = $select_headline_type ;
    }
    else
    {
        $headline_type = "h1";
    }

    if ( $select_sub_headline_type!== "" )
    {
        $headline_sub_type = $select_sub_headline_type;
    }
    else
    {
        $headline_sub_type = "h1";
    }




    if ($text_style === "sRichText")
    {
        $con = wpautop($content);
    }
    elseif ($text_style=== "sHtml")
    {
        $con = $attributes["text_html"];
    }

    if (!empty($con)) {
        $conHTML = '<div class="row text">
                    <div class="col">
                        <div class="textBlock-text text-block-html ' . ($content_position == "1" ? "content-two-columns" : "") . '" style="margin-top: '.$margin_top.'px; ">
                            ' . $con . '
                        </div>
                    </div>                                        
                </div>';
    }

    if ($headline !== "")
    {
        $headline_html = '<div class="row">                                        
                        <div class="col">
                            <'.$headline_type.' class="textBlock-headline '.$headline_style_class.' '.$align_items.' '.$class_name.'">'.$headline.'</'.$headline_type.'>
                        </div>       
                                                          
                    </div>';
    }

    if ($sub_headline !== "" )
    {
        $sub_headline_html = '<div class="row">                                        
                        <div class="col">
                            <'.$headline_sub_type.' class="textBlock-sub-headline '.$align_items.' '.$class_name.'">'.$sub_headline.'</'.$headline_sub_type.'>
                        </div>       
                                                          
                    </div>';
    }
	$sidebar_html = '';
	
	if ($sidebar_enable === 'yes') {
		$sidebar_html .= '

		<div class="sidebar-title">
		   '.$sidebar_title.'
		</div>
		<div class="sidebar-buttons mt-4">';
		// Loop up to a reasonable number, e.g., 10
			for ($i = 1; $i <= 10; $i++) {
				$name_key = "button_{$i}_name";
				$link_key = "button_{$i}_link";
				$icon_key = "button_{$i}_icon";
				$icon_html = !empty($attributes[$icon_key]) ? '<span class="me-2">' . wp_kses_post($attributes[$icon_key]) . '</span>' : '';
				
				
				if (!empty($attributes[$name_key]) && !empty($attributes[$link_key])) {
					$sidebar_html .= '<div class="sidebar-button mb-2"><a href="' . esc_url($attributes[$link_key]) . '" class="sidebar-link">' . $icon_html . '' . esc_html($attributes[$name_key]) . '</a></div>';
				}
			}
		$sidebar_html .= '</div>';
	}
	
	$full_content_html = '';
	if($sidebar_enable === 'yes')
	{
		$full_content_html = '
		
		<section id="'.$class_name.'" class="text-block '.$class_name.' space-bottom-'.$space_bottom.' space-top-'.$space_top.' text-block-id-'.$uniq_id.' bg-color-'.$background_color.' text-color-'.$text_color.'">
                    <div class="container d-flex flex-column flex-lg-row ">
                        <div class="col-12 col-lg-9">
	                        '.$headline_html.'
	                        '.$sub_headline_html.'
	                        '.$conHTML.'
                        </div>
                       <div class="sidebar-container col-12 col-lg-3 ps-lg-5">
                        	'.$sidebar_html.'
                        </div>
                        
            </section>';
	}
	else
	{
		$full_content_html = '<section id="'.$class_name.'" class="text-block '.$class_name.' space-bottom-'.$space_bottom.' space-top-'.$space_top.' text-block-id-'.$uniq_id.' bg-color-'.$background_color.' text-color-'.$text_color.'">
                    <div class="container">
                        '.$headline_html.'
                        '.$sub_headline_html.'
                        '.$conHTML.'
                    </div>
            </section>';
	}
    return $full_content_html;
}