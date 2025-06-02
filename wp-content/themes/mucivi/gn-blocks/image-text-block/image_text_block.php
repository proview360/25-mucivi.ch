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
function gn_image_text_block_rc($attributes, $content) {

    global $theme_path;
    wp_register_style("gn_image_text_block",$theme_path. "/gn-blocks/image-text-block/image_text_block.css", array("css-main"), "1");

    // vars
    $uniq_id                    = uniqid();
    $con                        = "";
    $conHTML                    = "";
    $headline                   = $attributes["headline"];

    $content_image_html         = "";

    $class_name             = $attributes["class_name"] ?? "";
    $background_color       = $attributes["background_color"] ?? 'white';
    $text_color             = $attributes["text_color"] ?? 'black';
    $text_style             = $attributes["text_style"] ?? 'sRichText';
    $image                  = $attributes["image_text_block"]["url"] ?? '';

    $space_bottom           = $attributes["space_bottom"] ?? 'yes';
    $space_top              = $attributes["space_top"] ?? 'yes';
    $align_items            = $attributes["align_items"] ?? 'end';



    $headline       = str_replace("[*", "<br/><span class='text-bold'>", $headline);
    $headline        = str_replace("*]", "</span>", $headline);

//            echo '<pre>';
//        echo print_r($attributes);
//        echo '</pre>';


    if ( isset($attributes["select_headline_type"]) && $attributes["select_headline_type"] !== "" )
    {
        $headline_type = $attributes["select_headline_type"];
    }
    else
    {
        $headline_type = "h1";
    }


    if($image !== '')
    {
        $content_image_html = "<img class='img-fluid mt-2' src='$image' />";
    }

    if ($text_style === "sRichText")
    {
        $con = wpautop($content);
    }
    elseif ($text_style=== "sHtml")
    {
        $con = $attributes["text_html"];
    }

// Check for <code> tags and convert them to <ul><li>
    if (preg_match_all('/<code>(.*?)<\/code>/s', $con, $matches)) {
        foreach ($matches[1] as $rawCode) {
            // Normalize line breaks (<br>, <br/>, <br />)
            $items = preg_split('/<br\s*\/?>/i', $rawCode);

            // Wrap each line in <li>
            $listItems = array_map(function ($item) {
                $clean = trim(strip_tags($item));
                return $clean !== '' ? '<li>' . $clean . '</li>' : '';
            }, $items);

            // Remove empty items and combine
            $listItems = array_filter($listItems);
            $ul = '<ul class="gn-list-style">' . implode('', $listItems) . '</ul>';

            // Rebuild full <code> block safely and replace
            $pattern = '/<code>' . preg_quote($rawCode, '/') . '<\/code>/s';
            $con = preg_replace($pattern, $ul, $con, 1);
        }
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

        $headline = '<div class="row order-1">                                        
                        <div class="col pb-4">
                            <'.$headline_type.' class="textBlock-headline '.$class_name.'">'.$headline.'</'.$headline_type.'>
                        </div>       
                    </div>';
    }

    return '<section id="'.$class_name.'" class="text-block '.$class_name.' space-bottom-'.$space_bottom.' space-top-'.$space_top.' text-block-id-'.$uniq_id.' bg-color-'.$background_color.' text-color-'.$text_color.'">                
                    <div class="d-none container d-lg-flex justify-content-between align-items-center align-items-xl-'.$align_items.' gap-5">  
                       <div class=" col-lg-6 col-xl-7">
                            '.$headline.'    
                            '.$conHTML.'    
                        </div>
                         <div class="col-lg-6 col-xl-5 d-flex justify-content-center">
                            '.$content_image_html.'      
                        </div>                 
                                                          
                    </div> 
                    
                    <div class="d-flex container d-lg-none justify-content-between align-items-center align-items-xl-'.$align_items.' gap-5">  
                       <div class="col-12">
                            '.$headline.'    
                            <div class="d-flex justify-content-center py-3">
                                '.$content_image_html.'    
                            </div>
                            '.$conHTML.'    
                        </div>
                    </div>                                      
            </section>
            ';
}