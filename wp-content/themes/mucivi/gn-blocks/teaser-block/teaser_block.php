<?php
/**
 * Copyright (c) 2024 by Granit Nebiu
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

// rc for teaser block
function gn_teaser_block_rc($attributes, $content)
{
    // get globals and scripts
    global $theme_path;
    wp_register_style("gn_teaser_block", $theme_path . "/gn-blocks/teaser-block/teaser_block.css", array("css-main"), "1");
    wp_enqueue_script("gn_teaser_block_js",$theme_path."/gn-blocks/teaser-block/teaser_block.min.js",array("js-main"),"1");

    $post_ID            = $attributes["post_id"] ?? "";
    $teaser_data        = get_post_meta($post_ID, 'teasers_fields', true);
    $design_type        = $attributes["design_type"] ?? "flex";
    $background_color   = $attributes["background_color"] ?? "white";
    $cards              = $teaser_data ?? [];
    $headline           = $attributes["headline"] ?? "";


    // Generate a unique ID for this instance
    $unique_id          = uniqid('teaser_');
    $modal_content      = "";
    $card               = "";
    $i                  = 1;
    $headline_section   = "";
    if($cards)
    {
        $cards_count = count($cards);
    }

    if($headline){
        $headline_section = '<h2 class="headline">'.$headline.'</h2>';
    }

    foreach ($cards as $item) {

        $card_image       = $item['image'];
        $card_headline    = $item['headline'];
        $card_description = mb_strimwidth($item['description'], 0, 100, "...");
        $card_btn_text    = $item['button_text'];
        $card_btn_link    = $item['button_link'];
        $card_link_type   = $item['link_type'];
        $card_btn_html    = "";
        $card_btn_css     = "no-btn";
        $cards_count_length      = count($cards);

        if ($design_type === 'flex')
        {
            if( $card_btn_link && $card_btn_text )
            {
                $card_btn_css  = "";
                $card_btn_html = '<div class="btn-wrapper mt-5"><a href="' . $card_btn_link . '" target="' . $card_link_type . '" class="button-1 btn-outline-full-gold">' . $card_btn_text . '</a></div>';
            }

            $card .= '
                <div class="teaser-item mb-3 me-md-3 '.$card_btn_css.'">
                    <img src="'.$card_image.'" />
                    <h3 class="teaser-headline mt-3">' . $card_headline . '</span></h3>
                    <p class="teaser-description mt-3">' . $card_description . '</p>                    
                    '.$card_btn_html.'                    
                </div>
       ';
        }
        else if ($design_type === 'grid')
        {
            if( $card_btn_link && $card_btn_text )
            {
                $card_btn_css  = "";
                $card_btn_html = '<div class="btn-wrapper pt-4 pb-5"><a href="' . $card_btn_link . '" target="' . $card_link_type . '" class="button-1 btn-outline-full-gold">' . $card_btn_text . '</a></div>';
            }

            $card .= '
            <div class="teaser-item-grid mb-3 me-md-3 d-flex flex-column flex-sm-row '.$card_btn_css.'">
                <div class="col-12 col-sm-6">
                     <img src="' . $card_image . '" />
                </div>
                <div class="col-12 col-sm-6">
                    <h3 class="teaser-headline mt-3">' . $card_headline . '</span></h3>
                    <p class="teaser-description mt-4">' . $card_description . '</p>                    
                    '.$card_btn_html.'                    
                </div>
            </div>
       ';
        }
        else if ($design_type === 'image-link')
        {
            $card_title = "";
            if($card_headline){
                $card_title = '<p class="partner-title">'.$card_headline.'</p>';
            }
            if($cards_count_length === 2) {
                $card .= '   
                  <div class="teaser-item-two-items mb-3 me-md-3 d-flex slide  ' . $i . '">    
                        '.$card_title.'
                        <div class="image-area"">
                           <a href="' . $card_btn_link . '" target="' . $card_link_type . '">
                               <img src="' . $card_image . '" />
                           </a> 
                        </div>    
                  </div>
    
               ';
            }
            else if($cards_count_length === 3) {
                $card .= '
                    <div class="teaser-item-three-items mb-3 me-md-3 d-flex slide  '.$i.'">
                        '.$card_title.'
                        <div class="image-area"">
                            <a href="' . $card_btn_link . '" target="' . $card_link_type . '">
                                <img src="' . $card_image . '" />
                            </a>
                        </div>                
                    </div>
               ';
            }
            else{
                $card .= '
                    <div class="teaser-item-multiple-items mb-3 me-md-3 d-flex slide  '.$i.'">
                        '.$card_title.'
                        <div class="image-area"">
                            <a href="' . $card_btn_link . '" target="' . $card_link_type . '">
                                <img src="' . $card_image . '" />
                            </a>
                        </div>                
                    </div>
               ';
            }
        }
        else
        {
            $card .= '
                <div class="teaser-item-image-only mb-3 me-md-3 d-flex slide img-only '.$i.'">
                <div class="image-area" onclick="open_modal(\'' . $unique_id . '\');current_slide(\'' . $unique_id . '\',' . $i . ')">
                    <img src="' . $card_image . '" />
                </div>                
            </div>';

            $modal_content .= '<div class="mySlides">
                   <div class="numbertext">'.$i.' / '.$cards_count.'</div>
                   <img class="images-slider" src="' . $card_image . '" />
                   </div>
       ';
            $i++;
        }

        $modal = "";
        if( $design_type == "image-only" )
        {
            $modal .= '
            <div id="my-modal-' . $unique_id . '" class="modal my-modal-teaser">
                <span class="modal-close cursor" onclick="close_modal(\'' . $unique_id . '\')">&times;</span>
                <div class="modal-content">
                    '.$modal_content.'
                    <a class="prev" onclick="plus_slides(\'' . $unique_id . '\', -1)">&#10094;</a>
                    <a class="next" onclick="plus_slides(\'' . $unique_id . '\', 1)">&#10095;</a>
                </div>    
            </div>';
        }
    }
    return '<section class="teaser-block gn-space-top bg-color-' . $background_color . '" id="' . $unique_id . '">
                <div class="container">
                 <div class="row">
                            '.$headline_section.'
                           <div class="teaser-container d-flex flex-column flex-md-row flex-wrap justify-content-center">
                               ' . $card . '
                            </div>
                 </div>
                </div>   
            </section>
            '.$modal.'
            ';
}
