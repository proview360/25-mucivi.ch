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

// rc for image block
function gn_image_gallery_block_rc( $attributes, $content ) {

    global  $theme_path;
    wp_register_style("gn_image_gallery_block",$theme_path."/gn-blocks/image-gallery-block/image_gallery_block.css",array("css-main"),"1");
    wp_enqueue_script("gn_image_gallery_block_js",$theme_path."/gn-blocks/image-gallery-block/image_gallery_block.min.js",array("js-main"),"1");

    // vars
    $image_elements     = $attributes["images"] ?? "";
    $layout_position    = $attributes["layout"] ?? "boxed";
    $background_color   = $attributes["background_color"] ?? "white";
    $gallery_type       = "no-slider";

    $image_gallery      = "";
	
	foreach ($image_elements as $image_items) {
		$image_id = $image_items['id'] ?? null;
		$url_partner = $image_items['url_partner'] ?? "";
		
		if ($image_id) {
			$thumb = wp_get_attachment_image_src($image_id, 'medium');
			
			if ($thumb) {
				$image_url = $thumb[0];
				$width = $thumb[1];
				$height = $thumb[2];
				
				$image_gallery .= '<li><a href="'.$url_partner.'" target="_blank">
											<img src="' . esc_url($image_url) . '" width="' . esc_attr($width) . '" height="' . esc_attr($height) . '" />
										</a>
									</li>';
			}
		}
	}

    $content_html       = "";
    if($gallery_type === "no-slider"){
        $content_html = '<div class="' . ( $layout_position == "boxed" ? "container" : "container-fluid" ) . '">
                            <ul class="image-gallery-inline">
                                '.$image_gallery.'
                            </ul>
                        </div>';
    }

    return '<section class="image-gallery-block bg-color-'.$background_color.'">
                '.$content_html.'
            </section>';
}