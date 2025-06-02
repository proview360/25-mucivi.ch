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

// rc for hexagons block
function gn_hexagon_block_rc($attributes, $content) {
    global $theme_path;
    wp_register_style("gn_hexagon_block", $theme_path."/gn-blocks/hexagon-block/hexagon_block.css", array("css-main"), "1");
    wp_enqueue_script("gn_hexagon_block_js", $theme_path."/gn-blocks/hexagon-block/hexagon_block.min.js", array("js-main"), "1");

    $unique_id             = uniqid('hexagons_');
    $post_ID               = $attributes["post_id"] ?? "";
    $hexagons_data_row_1   = get_post_meta($post_ID, 'hexagons_fields', true);
    $hexagons_row_1        = is_array($hexagons_data_row_1) ? $hexagons_data_row_1 : [];
    $hexagons_data_row_2   = get_post_meta($post_ID, 'hexagons_fields_row2', true);
    $hexagons_row_2        = is_array($hexagons_data_row_2) ? $hexagons_data_row_2 : [];
    $design_type           = $attributes["design_type"] ?? "";
    $break_text            = $attributes["break_text"] ?? 'yes';
    $hexagon_html          = "";
    $hexagon_html_tan_mob  = "";
    $hexagon_row_1_html    = "";
    $hexagon_row_2_html    = "";
    $hexagon_post_html     = "";
    $hexagon_combined_html = "";
    $hexagons_combined     = array_merge($hexagons_row_1, $hexagons_row_2);
    $counter     = 1;
    $counter_2   = 1;
    $hexagon_small_class = "";

    $break_text_class = ($break_text == 'yes') ? 'break-text' : '';

    foreach ($hexagons_row_1 as $item) {

        $hexagon_image       = $item['image'] ?? "";
        $hexagon_headline    = $item['headline'] ?? "";
        $hexagon_headline       = str_replace("[*", "<br/><span class='text-bold'>", $hexagon_headline);
        $hexagon_headline        = str_replace("*]", "</span>", $hexagon_headline);
        $hexagon_description = $item['description'] ?? "";
        $hexagon_color       = $item['hexagon_color'] ?? "";
        $hexagon_link        = $item['image_link'] ?? "";


        if ($design_type === 'hexagon_big') {
            $hexagon_small_class = "hexagon-big";
            $hexagon_row_1_html .= '<div class="d-flex flex-column hexagon hexagon-row-1-'.$counter.'" style="background-color:'.$hexagon_color.'">
                                        <img alt="'.$hexagon_headline.'" src="'.$hexagon_image.'" />
                                        <h2 class="hexagon-title gn-h3 '.$break_text_class.'">'.$hexagon_headline.'</h2>
                                        <p class="hexagon-description">'.$hexagon_description.'</p>
                                    </div>';
        } elseif ($design_type === 'hexagon_small') {
            $hexagon_small_class = "hexagon-small-class";
            $hexagon_row_1_html .= '<a href="'.$hexagon_link.'" target="_blank">
                                        <div class="d-flex flex-column hexagon-small hexagon-row-1-small-'.$counter.'" style="background-color:'.$hexagon_color.'">
                                            <img alt="'.$hexagon_headline.'" src="'.$hexagon_image.'" />
                                        </div>
                                    </a>';
        }
        elseif ($design_type === 'hexagon_post') {
            $hexagon_row_1_html .= '
         <li class="hex">
                <div class="hexIn" href="#">
                  <img src="'.$hexagon_image.'" alt="" />
                  <h2 class="gn-h3">'.$hexagon_headline.'</h2>
                  <p class="hex-in-description">'.wp_trim_words($hexagon_description, 18, '...').'</p>
                  <a class="hex-btn" href="'.$hexagon_link.'">'.__('Voir plus d\'images', 'mucivi').'</a>
                </div>
         </li>';
        }
        else {
            $hexagon_row_1_html .= '<p>Please select design type</p>';
        }
        $counter++;
    }

    foreach ($hexagons_row_2 as $item) {
        $hexagon_image       = $item['image'] ?? "";
        $hexagon_headline    = $item['headline'] ?? "";
        $hexagon_description = $item['description'] ?? "";
        $hexagon_color       = $item['hexagon_color'] ?? "";
        $hexagon_link        = $item['image_link'] ?? "";

        if ($design_type === 'hexagon_big') {
            $hexagon_small_class = "hexagon-big";
            $hexagon_row_2_html .= '<div class="d-flex flex-column hexagon hexagon-row-2-'.$counter_2.'" style="background-color:'.$hexagon_color.'">
                                        <img alt="'.$hexagon_headline.'" src="'.$hexagon_image.'" />
                                        <h2 class="hexagon-title gn-h3 '.$break_text_class.'">'.$hexagon_headline.'</h2>
                                        <p class="hexagon-description">'.$hexagon_description.'</p>
                                    </div>';
        } elseif ($design_type === 'hexagon_small') {
            $hexagon_small_class = "hexagon-small-class";
            $hexagon_row_2_html .= '<a href="'.$hexagon_link.'" target="_blank">
                                        <div class="d-flex flex-column hexagon-small hexagon-row-2-small-'.$counter_2.'" style="background-color:'.$hexagon_color.'">
                                            <img alt="'.$hexagon_headline.'" src="'.$hexagon_image.'" />
                                        </div>
                                    </a>';
        }

        else {
            $hexagon_row_2_html .= '<p>Please select design type</p>';
        }
        $counter_2++;
    }

    foreach ($hexagons_combined as $item) {
        $hexagon_image       = $item['image'] ?? "";
        $hexagon_headline    = $item['headline'] ?? "";
        $hexagon_description = $item['description'] ?? "";
        $hexagon_color       = $item['hexagon_color'] ?? "";

        if ($hexagon_image && $hexagon_headline && $hexagon_description) {
            $hexagon_combined_html .= '<div class="d-flex flex-column hexagon" style="background-color:'.$hexagon_color.'">
                                            <img alt="'.$hexagon_headline.'" src="'.$hexagon_image.'" />
                                            <h2 class="hexagon-title gn-h3 '.$break_text_class.'">'.$hexagon_headline.'</h2>
                                            <p class="hexagon-description">'.$hexagon_description.'</p>
                                        </div>';
        }
    }

    if ($design_type === 'hexagon_big') {
        $hexagon_html .= '
            <section class="honeycomb-section d-none d-lg-block">
                <div class="honeycomb">
                    <div class="gn-row">
                        '.$hexagon_row_1_html.'
                    </div>
                    <div class="gn-row">
                        '.$hexagon_row_2_html.'
                    </div>
                </div>
            </section>';
        $hexagon_html_tan_mob .= '
            <section class="honeycomb-section honeycomb-section-mobile d-block d-lg-none">
                <div class="honeycomb-mobile-column">
                    '.$hexagon_combined_html.'
                </div>
            </section>';
    } elseif ($design_type === 'hexagon_small') {
        $hexagon_html .= '
            <section class="honeycomb-section-small">
                <div class="honeycomb-small">
                    <div class="gn-row-small">
                        '.$hexagon_row_1_html.'
                    </div>
                    <div class="gn-row-small">
                        '.$hexagon_row_2_html.'
                    </div>
                </div>
            </section>';
    }elseif ($design_type === 'hexagon_post') {
        $hexagon_html .= '
                           <ul id="hexGrid">
                                        '.$hexagon_row_1_html.'
                                      </ul>';
    }
    else {
        $hexagon_html .= '
            <section class="honeycomb-section">
                <div class="honeycomb">
                    <div class="gn-row">
                        <div class="hexagon">01</div>
                        <div class="hexagon">02</div>
                        <div class="hexagon">03</div>
                        <div class="hexagon">04</div>
                        <div class="hexagon">05</div>
                        <div class="hexagon">06</div>
                        <div class="hexagon">07</div>
                        <div class="hexagon">08</div>
                    </div>
                    <div class="gn-row">
                        <div class="hexagon">09</div>
                        <div class="hexagon">10</div>
                        <div class="hexagon">11</div>
                        <div class="hexagon">12</div>
                        <div class="hexagon">13</div>
                        <div class="hexagon">14</div>
                        <div class="hexagon">15</div>
                        <div class="hexagon">16</div>
                    </div>
                </div>
            </section>';
    }



    return '<div class="section-hexagons '.$hexagon_small_class.' sections-hexagons-'.$unique_id.' .">
                '.$hexagon_html.'
                '.$hexagon_html_tan_mob.'
            </div>'
        ;
}
