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

// rc for squares block
function gn_slider_block_rc($attributes, $content) {

    global  $theme_path;

    wp_register_style("gn_slider_block",$theme_path."/gn-blocks/slider-block/slider_block.css",array("css-main"),"1");
    wp_enqueue_script("gn_slider_block_js",$theme_path."/gn-blocks/slider-block/slider_block.min.js",array("js-main"),"1");
    wp_enqueue_script("slick-js", $theme_path . "/assets/js/slick-slider/slick.min.js", array("jquery"), "5.2.2", true); // Fixed script handle
    wp_enqueue_style("slick-css", $theme_path . "/assets/css/slick-slider/slick.min.css", array(), "5.2.2");


    $post_ID        = $attributes["post_id"] ?? "";
    $slider_data    = get_post_meta($post_ID, 'sliders_fields', true);

    $slides              = $slider_data["slides"] ?? [];
    $slider_count        = count($slides);
    $slider_loop         = ($slider_count > 1) ? "true" : "false";
    $class_name          = $attributes["className"] ?? "default-aci-id";

    wp_localize_script( 'sliderBlockJs', 'wtSliderSettings', array(
        'loop' => $slider_loop
    ));

    $html = '
        <section id="slider-section-'.$class_name.'" class="slider-section slider-section-count-'.$slider_count.' '.$class_name.'">
            <div class="slider-content-wrapper">
                <div class="main-slider">';

    //iterate slides of slider
    foreach($slides as $slide)
    {
//        echo '<pre>';
//        echo print_r($slide);
//        echo '</pre>';

        //get required vars
        $image = wp_get_attachment_image($slide["imageId"], "full", false, array(
            'loading' => 'eager', // critical images should be loaded eagerly
            'fetchpriority' => 'high'
        ));

        $text                   = $slide["text"] ?? "";
        $headline               = $slide["headline"] ?? "";
        $h                      = $slide["headlineType"] ?? "";
        $text_headline_color    = $slide["text_headline_color"] ?? "white";
        $text_font_weight       = $slide["text_font_weight"] ?? "regular";
        $button_text             = $slide["button1text"] ?? "";
        $button_link             = $slide["button1link"] ?? "";
        $button_linktype         = $slide["button1linktype"] ?? "";
        $link_type               = "";

        $button2text        = $slide["button2text"] ?? "";
        $button2link        = $slide["button2link"] ?? "";
        $button2linktype    = $slide["button2linktype"] ?? "";
        $link_type2          = "";


        $text_css   = "no-text";
        $text_html  = "";
        if($text !== "")
        {
            $text_css = "";

            $text_html = '<p class="text">'.$text.'</p>';
        }

        //build special html elements
        $primary_btn_html = "";
        $sec_btn_html     = "";

        $headline_class = "";

        // btn primary
        $btn_css = "no-btn";
        if($button_link != "" && $button_text != "")
        {
            $btn_css = "";

            if( $button_linktype === "blank" )
            {
                $link_type = 'target="_blank" rel="noopener"';
            }

            $primary_btn_html = '
                        <a class="btn-full btn-full-red" href="'.$button_link.'" title="'.$button_text.'" '.$link_type.'>
                                '.$button_text.'
                        </a>';
        }

        // btn sec
        if($button2link != "" && $button2text != "")
        {
            $btn_css = "";

            if( $button2linktype === "blank" )
            {
                $link_type2 = 'target="_blank" rel="noopener"';
            }

            $sec_btn_html = '<a  class="btn-full btn-full-red"  href="'.$button2link.'" title="'.$button2text.'" '.$link_type2.'>
                                   '.$button2text.'
                             </a>';
        }

        $full_cls = '';
        if( $sec_btn_html == "" )
        {
            $full_cls = 'full-btn';
        }


        //build default slide code
        $headline_code = ($headline != "") ? '<'.$h.' class="headline text-'.$text_font_weight.'">'.$headline.'</'.$h.'>' : '';


        $html .= '
            <div class="slide">
                <div class="image-area">
                    '.$image.'
                    <div class="slider-text container">
                        <div class="text-area '.$text_css.' '.$btn_css.'">
                            <div class="text-right-are text-color-'.$text_headline_color.' ">
                                '.$headline_code .'
                                '.$text_html.'
                                    <div class="'.$full_cls.' text-btn-area-styles">
                                        '.$primary_btn_html.'                                
                                        '.$sec_btn_html.'                                
                                    </div>
                            </div>
                            
                     
                            
                        </div>
                     </div>   
                    </div>                     
            </div>';
    }

    //finish html
    $html .= '</div> 
                                              
            </div>
            
        </section>';

    return $html;
}