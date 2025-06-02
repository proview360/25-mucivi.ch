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

function replace_symbol_acc($_content)
{

    $result = str_replace("#X#", '<div><span class="symbol-x"></span></div>', $_content);
    $result = str_replace("#-#", '<div><span class="symbol-minus"></span></div>', $result);
    $result = str_replace("#Haken#", '<div><span class="symbol-hook"></span></div>', $result);

    return $result;
}

function get_file_content($_id)
{
    $_id = str_replace("files-code-", '', $_id);
    $file_post_meta = get_post_meta($_id, 'file_fields', true);

    // Start output buffering to capture all the HTML output
    ob_start();

    // Check if the array is not empty
    if (!empty($file_post_meta) && is_array($file_post_meta)) {
        echo '<section class="icon-block">';
        echo '<div class="container">';
        echo '<div class="row">';

        foreach ($file_post_meta as $file) {
            // Variables extracted from each array element
            $add_icon = !empty($file['file_icon']) ? $file['file_icon'] : 'bi bi-file-earmark';
            $add_icon_color = !empty($file['file_icon_color']) ? $file['file_icon_color'] : 'black';
            $file_title = !empty($file['file_text']) ? $file['file_text'] : 'Untitled';
            $file_link = !empty($file['file_link']) ? $file['file_link'] : '#';
            $file_link_open         = !empty($file['file_link_open']) ? $file['file_link_open'] : '_self';

            // Output each file with its associated icon and link
            echo '<div class="icon-block-container col-12">';
            echo '<a href="' . $file_link . '" target="' . $file_link_open . '" class="icon-'.$add_icon_color.' text-color-black">';
            echo '<i class="' . $add_icon . '"></i>';
            echo '<span>' . $file_title . '</span>';
            echo '</a>';
            echo '</div>';
        }

        echo '</div>'; // End of row
        echo '</div>'; // End of container
        echo '</section>';
    } else {
        echo '<p>No files available.</p>';
    }

    // Get the content from the buffer and end buffering
    $content = ob_get_clean();

    return $content;
}

// rc for Accordion Block
function gn_accordion_block_rc($attributes, $content)
{
    // get globals and scripts
    global $theme_path;
    wp_register_style("gn_accordion_block", $theme_path . "/gn-blocks/accordion-block/accordion_block.css", array("css-main"), "1");
    wp_enqueue_script("gn_accordion_block_js", $theme_path . "/gn-blocks/accordion-block/accordion_block.min.js", array("js-main"), "1");

    // vars
    $class_name         = $attributes["className"] ?? "";

    $post_id_accordion  = $attributes["post_id"] ?? "";
    $uniqid             = uniqid();
    $accs_meta          = get_post_meta($post_id_accordion, 'accordion_fields', true);
    $accs               = $accs_meta['accordions'];

    $add_css_file           = "";
    $add_css_slider         = "";
    $html_acc               = "";
    $html_accordion_wrapper = "";

    $noscript = "<noscript>
                    <style>
                        
                        .acc-block .acc-box .content {
                            font-size: 18pt;
                            line-height: 26pt;
                            opacity: 1 !important;
                            visibility: visible !important;
                            max-height: inherit !important;
                        }
                        .acc-block .acc-box .content-area {
                            padding-bottom: 20px !important;
                            padding-top: 20px !important;
                        }
                        
                    </style>
                </noscript>";

    foreach ($accs as $acc) {


        $acc_headline       = $acc["headline"];
        $acc_headline_type  = $acc["headline_type"] ?? "p";

        $card_headline_type       = $item['card_headline_type'] ?? "p";
        $headline_html            = "";

        if($card_headline_type){
//            $headline_html = '<span class="title">' . $acc_headline . '</span>';
            $headline_html = '<' . $acc_headline_type . ' class="title">' . $acc_headline . '</' . $acc_headline_type . '>';
        }

        $accContent             = wpautop($acc["content"]);
        $add_content            = $acc["add_content"];
        $add_content_position   = $acc["add_content_position"];
        $add_content_class      = "";
        $add_content_html       = "";
        $add_content_type       = "";

        if ($add_content) {
            $add_content_class = "add-content";

            if (str_contains($add_content, 'file')) {
                $add_content = get_file_content($add_content);
                $add_css_file = "tab-file-block";

                $add_content_type = "add-content-type-file";
            }
            $add_content_html = '<div class="add-content-wrapper">
                                    ' . $add_content . '
                                </div>';
        }

        $html_acc .= '
            <div class="row">
                <div class="col-12">
                    <div class="acc-box">
                        
                        <div class="click-area">                            
                                '.$headline_html. ' <i class="icon-open-close"></i>
                        </div>
                        
                        <div class="content-area ' . $add_content_class . ' position-' . $add_content_position . ' ' . $add_content_type . '">
                            
                            <div class="content">
                                <div class="text-wrapper">' . $accContent . '</div>
                                ' . $add_content_html . '
                            </div>
                            
                        </div>
                        
                    </div> 
                </div>
            </div>';
    }

    $html_accordion_wrapper .= '
        <div class="accWrapper">                                                
            ' . $html_acc . '                                                
        </div>';


    return '
            <section id="' . $class_name . '" class="acc-block acc-block-id-' . $uniqid . ' ' . $add_css_file . ' ' . $add_css_slider . ' ' . $class_name . '">
                
                <div class="container">    
                    ' . $html_accordion_wrapper . '                        
                </div>                                            
                                      
            </section>
            ' . $noscript;
}