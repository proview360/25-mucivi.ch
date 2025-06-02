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

// rc for video-block
function gn_iframe_block_rc($attributes, $content) {

    // get globals and scripts
    global $theme_path;
    wp_register_style("gn_iframe_block",$theme_path."/gn-blocks/iframe-block/iframe_block.css",array("css-main"),"1");

    // vars
    $uniqid               = uniqid();
    $video_layout         = $attributes["video_layout"] ?? "youtube";
    $iframe_link          = $attributes["iframe_link"] ?? "";
    $headline             = $attributes["headline"] ?? "";
    $select_headline_type = $attributes["select_headline_type"] ?? "h2";
    $bg_color             = $attributes["background_color"] ?? "black";
    $text_color           = $attributes["text_color"] ?? "black";
    $headline_html        = "";


    $headline       = str_replace("[*", "<br/><span class='text-bold'>", $headline);
    $headline        = str_replace("*]", "</span>", $headline);

    if($headline)
    {
        $headline_html = '<div class="row pb-4">                                        
                        <div class="col">
                            <'.$select_headline_type.' class="textBlock-headline text-'.$text_color.' ">'.$headline.'</'.$select_headline_type.'>
                        </div>       
                    </div>';
    }


    if ($video_layout == 'virtual_tour')
    {
        $content_html = '  <div class="virtual-tour-iframe ratio ratio-16x9">
                  <iframe
                      width="100%"
                      height="600"
                      src="'.$iframe_link.'"
                      frameborder="0"
                      allowfullscreen
                      allow="xr-spatial-tracking; gyroscope; accelerometer"
                ></iframe>
        </div>';
    }
    elseif ($video_layout == 'youtube')
    {
        $youtube_id = '';
        if(preg_match("/v=([^&]+)/i", $iframe_link, $match))
        {
            $youtube_id = $match[1];
        }
        $content_html = '
        <div class="youtube-iframe ratio ratio-16x9">
            <iframe class="" src="https://www.youtube.com/embed/'.$youtube_id.'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>';
    }
    elseif ($video_layout == 'gallery')
    {
        $content_html = '  <div class="gallery-iframe ratio ratio-16x9">
                  <iframe
                      width="100%"
                      height="600"
                      src="'.$iframe_link.'"
                      frameborder="0"
                      allowfullscreen
                      allow="xr-spatial-tracking; gyroscope; accelerometer"
                ></iframe>
        </div>';
    }
    else
    {
        $content_html = '
        <video autoplay loop muted>
            <source src="' . $iframe_link . '" type="video/mp4">
             Your browser does not support the video tag.
        </video>';
    }


    return '<section id="" class="iframe-block iframe-block-id-'.$uniqid.'  bg-color-'.$bg_color.'">
                <div class="container">
                    <div class="iframe-wrapper">
                        <div class="row">
                            '.$headline_html.'
                            <div class="col-12 image-video-layout my-4">
                                '.$content_html.'
                            </div>
                        </div>
                    </div>                            
                </div>
            </section>';

}