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
function gn_before_after_block_rc($attributes, $content) {

    global $theme_path;
    wp_register_style("gn_before_after_block",$theme_path. "/gn-blocks/before-after-block/before_after_block.css", array("css-main"), "1");

    wp_enqueue_style('twentytwenty-css', $theme_path . '/assets/css/before-after/before-after.css', array("css-main"));
    wp_enqueue_script('jquery-event-move', $theme_path . '/assets/js/before-after/jquery.event.move.js', array('jquery'), null, true);
    wp_enqueue_script('twentytwenty', $theme_path . '/assets/js/before-after/jquery.twentytwenty.js', array('jquery', 'jquery-event-move'), null, true);

    wp_add_inline_script('twentytwenty', '
        jQuery(function($) {
            $(".before-after-slider").twentytwenty();
        });
    ');
    // vars
    $uniq_id                    = uniqid();
    $con                        = "";
    $conHTML                    = "";
    $headline                   = $attributes["headline"];


    $class_name             = $attributes["class_name"] ?? "";
    $background_color       = $attributes["background_color"] ?? 'white';
    $text_color             = $attributes["text_color"] ?? 'black';
    $text_style             = $attributes["text_style"] ?? 'sRichText';
    $image_before           = $attributes["image_before"]["url"] ?? '';
    $image_after            = $attributes["image_after"]["url"] ?? '';
    $space_bottom           = $attributes["space_bottom"] ?? 'yes';
    $space_top              = $attributes["space_top"] ?? 'yes';
    $headline_style         = $attributes["select_headline_style"] ?? 'style-1';



    $headline       = str_replace("[*", "<br/><span class='text-bold'>", $headline);
    $headline        = str_replace("*]", "</span>", $headline);

    if($headline_style == "style_2")
    {
        $headline_style_class = "style-2";
    }
    else
    {
        $headline_style_class = "style-1";
    }

    if ( isset($attributes["select_headline_type"]) && $attributes["select_headline_type"] !== "" )
    {
        $headline_type = $attributes["select_headline_type"];
    }
    else
    {
        $headline_type = "h1";
    }

    if ($text_style === "sRichText")
    {
        $con = wpautop($content);
    }
    elseif ($text_style=== "sHtml")
    {
        $con = $attributes["text_html"];
    }

    if( !empty($con) )
    {
        $conHTML = '<div class="row text">
                        <div class="col">
                            <div class="textBlock-text mt-4 text-block-'.$text_style.'">
                                '.$con.'
                            </div>
                        </div>                                        
                    </div>';
    }

    if ( isset($attributes["headline"]) && $attributes["headline"] !== "" )
    {

        $headline = '<'.$headline_type.' class="textBlock-headline '.$headline_style_class.' pb-4 '.$class_name.'">'.$headline.'</'.$headline_type.'>';
    }

    if($image_before !== "" && $image_after !== ""){
        $image_before_after_html = '  <div class="before-after-slider">
                                        <img src="'.$image_before.'" alt="Before">
                                        <img src="'.$image_after.'" alt="After">
                                      </div>      ';
    }

    if($headline !== "" && $conHTML !== ""){
            $content_html = '
                 <div class="text-content">
                     '.$headline.'    
                     '.$conHTML.'   
                </div>
            ';
    }
    return '
    <div class="before-after-block container '.$class_name.' space-bottom-'.$space_bottom.' space-top-'.$space_top.' text-block-id-'.$uniq_id.' bg-color-'.$background_color.' text-color-'.$text_color.'"> 
            <div class="before-after-wrapper grid">
                <div class="before-after-slider-container">
                     '.$image_before_after_html.'
                </div>
                <div class="text-content">
                     '.$content_html.'
                </div>
            </div>
     </div>

     
            ';
}