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
 * @author Granit Nebiu
 * @since 1.0
 */


// rc for text block
function gn_map_block_rc($attributes, $content) {

    // get globals and scripts
    global  $theme_path;
    wp_register_style("gn_map_block",$theme_path."/gn-blocks/map-block/map_block.css",array("css-main"),"1");

    // vars
    $map_link           = $attributes['map_link'] ?? "";;
    $layout             = $attributes['layout'] ?? "";
    $layout_container   = $layout == "full-width" ? "container-fluid" : "container";
    $background_color   = $attributes['background_color'] ?? "";

    $wtCookieName = "gn-dv-settings";
    $current_language = "";
    if (defined('ICL_LANGUAGE_CODE'))
    {
        $current_language = ICL_LANGUAGE_CODE;
    }

    if (!isset($_COOKIE[$wtCookieName]) || strpos($_COOKIE[$wtCookieName], "005") === false) {
        if ($current_language == "sv") {
            return '<iframe  allowtransparency="true" width="100%" height="530" class="" id="ExternalWebContentExternalIFrame" frameborder="0" height="1000" width="100%" scrolling="no" src="/wp-content/themes/mucivi-group/template-parts/dv-box/gn-cookie-box/gmaps-se.html" style="overflow: hidden;"></iframe>';
        } else {
            // assuming any other language defaults to English
            return '<iframe  allowtransparency="true" width="100%" height="530" class="" id="ExternalWebContentExternalIFrame" frameborder="0" height="1000" width="100%" scrolling="no" src="/wp-content/themes/mucivi-group/template-parts/dv-box/gn-cookie-box/gmaps-en.html" style="overflow: hidden;"></iframe>';
        }
    }
    return '<section class="map-block mapArea  bg-color-'.$background_color.' py-5">                    
        <div class="'.$layout_container.'">
            <div class="row">
                 <iframe src="'.$map_link.'" width="100%" height="530" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                 </iframe>
            </div>
   
        </div>                                                                
    </section>
    <div class="mapArea">
    </div>';
}