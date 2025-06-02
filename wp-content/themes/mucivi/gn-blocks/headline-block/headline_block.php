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
function gn_headline_block_rc($attributes, $content) {

    // get globals and scripts
    global  $theme_path;
    wp_register_style("gn_headline_block",$theme_path."/gn-blocks/headline-block/headline_block.css",array("css-main"),"1");

    // vars
    $uniq_id                    = uniqid();
    $headline                   = $attributes["headline"] ?? "";
    $sub_headline               = $attributes["sub_headline"] ?? "";

    $headline_hml                   = "";
    $sub_headline_hml               = "";
    $content_image_html         = "";
    $bg_headline_html           = "";

    $class_name                 = $attributes["class_name"] ?? "";
    $selectFieldValue           = $attributes["select_field"] ?? 'left';
    $background_color           = $attributes["background_color"] ?? 'white';
    $text_color                 = $attributes["text_color"] ?? 'black';
    $space_bottom               = $attributes["space_bottom"] ?? 'yes';
    $space_top                  = $attributes["space_top"] ?? 'yes';
    $bg_headline                = $attributes["bg_headline"] ?? '';

    $headline       = str_replace("[*", "<br/><span class='text-bold'>", $headline);
    $headline        = str_replace("*]", "</span>", $headline);

    $sub_headline       = str_replace("[*", "<br/><span class='text-bold'>", $sub_headline);
    $sub_headline        = str_replace("*]", "</span>", $sub_headline);

    if ( isset($attributes["select_headline_type"]) && $attributes["select_headline_type"] !== "" )
    {
        $headline_type = $attributes["select_headline_type"];
    }
    else
    {
        $headline_type = "h1";
    }

    if ( isset($attributes["select_headline_type"]) && $attributes["select_headline_type"] !== "" )
    {
        $headline_sub_type = $attributes["select_sub_headline_type"];
    }
    else
    {
        $headline_sub_type = "h1";
    }

    if($bg_headline !== ""){
        $bg_headline_html ="<p class='background-text'> $bg_headline </p>";
    }

    if ($headline !== "")
    {
        $headline_hml = '<div class="row">                                        
                        <div class="col">
                            <'.$headline_type.' class="textBlock-headline '.$selectFieldValue.' '.$class_name.'">'.$headline.'</'.$headline_type.'>
                        </div>       
                                                          
                    </div>';
    }

    if ($sub_headline !== "" )
    {
        $sub_headline_hml = '<div class="row">                                        
                        <div class="col">
                            <'.$headline_sub_type.' class="textBlock-sub-headline '.$selectFieldValue.' '.$class_name.'">'.$sub_headline.'</'.$headline_sub_type.'>
                        </div>       
                                                          
                    </div>';
    }

    return '<section id="'.$class_name.'" class="headline-block '.$class_name.' space-bottom-'.$space_bottom.' space-top-'.$space_top.' text-block-id-'.$uniq_id.' bg-color-'.$background_color.' text-color-'.$text_color.'">                
                
                    <div class="container">     
                        '.$bg_headline_html.'         
                        '.$headline_hml.'
                        '.$sub_headline_hml.'       
                        '.$content_image_html.'                       
                    </div>                                
            </section>';
}