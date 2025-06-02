<?php
///**
// * Copyright (c) 2025 by Granit Nebiu
// *
// * All rights are reserved. Reproduction or transmission in whole or in part, in
// * any form or by any means, electronic, mechanical or otherwise, is prohibited
// * without the prior written consent of the copyright owner.
// *
// * Functions and definitions
// *
// * @package WordPress
// * @subpackage mucivi
// * @author Granit Nebiu
// * @since 1.0
// */
//
//// rc for image block
//function gn_image_gallery_block_rc( $attributes, $content ) {
//
//    global  $theme_path;
//    wp_register_style("gn_image_gallery_block",$theme_path."/gn-blocks/image-gallery-block/image_gallery_block.css",array("css-main"),"1");
//    wp_enqueue_script("gn_image_gallery_block_js",$theme_path."/gn-blocks/image-gallery-block/image_gallery_block.min.js",array("js-main"),"1");
//    wp_enqueue_style("owl-carousel-style", $theme_path . "/assets/css/owl-carousel/owl.carousel.min.css");
//    wp_enqueue_style("owl-carousel-default", $theme_path . "/assets/css/owl-carousel/owl.theme.default.min.css");
//    wp_enqueue_script("owl-carousel-script", $theme_path . "/assets/js/owl-carousel/owl.carousel.min.js", array("jquery"), null, true);
//
//    // vars
//    $image_elements     = $attributes["images"] ?? "";
//    $layout_position    = $attributes["layout"] ?? "boxed";
//    $background_color   = $attributes["background_color"] ?? "white";
//    $gallery_type       = $attributes["gallery_type"] ?? "no-slider";
//
//    $image_gallery      = "";
//
//    foreach ($image_elements as $image_items) {
//        $image_url = $image_items['url'];
//        $image_gallery .= '<img src="'.$image_url.'" />';
//    }
//
//    $content_html       = "";
//    if($gallery_type === "no-slider"){
//        $content_html = '<div class="' . ( $layout_position == "boxed" ? "container" : "container-fluid" ) . '">
//                            <div class="row image-gallery-container">
//                                '.$image_gallery.'
//                            </div>
//                        </div>';
//    }else {
//        $content_html = '<div class="owl-carousel-slider ' . ( $layout_position == "boxed" ? "container" : "container-fluid" ) . ' py-5">
//                                        <div class="owl-nav-gn">
//                                            <button class="owl-prev-gn">
//                                                <div class="prev-btn gn-btn-left">
//                                                   <i class="bi bi-chevron-left"></i>
//                                                </div>
//                                            </button>
//                                            <button class="owl-next-gn">
//                                                <div class="next-btn gn-btn-right">
//                                                    <i class="bi bi-chevron-right"></i>
//                                                </div>
//                                            </button>
//                                        </div>
//                                        <div class="owl-carousel slider-carousel">
//                                         '.$image_gallery.'
//                                        </div>
//
//                         </div>';
//    }
//
//    return '<section class="image-gallery-block bg-color-'.$background_color.'">
//                '.$content_html.'
//            </section>';
//}