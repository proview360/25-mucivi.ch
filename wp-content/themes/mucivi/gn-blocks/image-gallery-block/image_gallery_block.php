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
		
		global $theme_path;
		
		// Register and enqueue styles and scripts
		wp_register_style("gn_image_gallery_block", $theme_path . "/gn-blocks/image-gallery-block/image_gallery_block.css", array("css-main"), "1");
		wp_enqueue_script("gn_image_gallery_block_js", $theme_path . "/gn-blocks/image-gallery-block/image_gallery_block.min.js", array("js-main"), "1");
		
		// Owl Carousel
		wp_enqueue_style('owl-carousel-style', $theme_path . '/assets/css/owl-carousel/owl.carousel.min.css', array(), '2.3.4');
		wp_enqueue_style('owl-carousel-default', $theme_path . '/assets/css/owl-carousel/owl.theme.default.min.css', array(), '2.3.4');
		wp_enqueue_script('owl-carousel-script', get_template_directory_uri() . '/assets/js/owl-carousel/owl.carousel.min.js', array('jquery'), '2.3.4', true);
		
		
		wp_enqueue_style('fancybox-style', $theme_path . '/assets/css/fancybox/fancybox.css', array(), '2.3.4');
		wp_enqueue_script('fancybox-script', get_template_directory_uri() . '/assets/js/fancybox/fancybox.js', array('jquery'), '2.3.4', true);
		
		// Get attributes
		$image_elements   = $attributes["images"] ?? "";
		$layout_position  = $attributes["layout"] ?? "boxed";
		$background_color = $attributes["background_color"] ?? "white";
		$gallery_type     = $attributes["gallery_type"] ?? "no-slider";
		$gallery_title    = $attributes["gallery_title"] ?? '';
		
//		            echo '<pre>';
//		        echo print_r($gallery_title);
//		        echo '</pre>';
		$image_gallery = "";
		
		if ($gallery_type === "no-slider") {
		
			foreach ($image_elements as $image_items) {
				$image_id    = $image_items['id'] ?? null;
				$url_partner = $image_items['url_partner'] ?? "";
				
				if ($image_id) {
					$thumb = wp_get_attachment_image_src($image_id, 'medium');
					
					if ($thumb) {
						$image_url = $thumb[0];
						$width     = $thumb[1];
						$height    = $thumb[2];
						
						$image_gallery .= '<li>
                    <a href="' . esc_url($url_partner) . '" target="_blank">
                        <img src="' . esc_url($image_url) . '" width="' . esc_attr($width) . '" height="' . esc_attr($height) . '" />
                    </a>
                </li>';
					}
				}
			}
		} else {
			
			foreach ($image_elements as $image_items) {
		
				$image_id   = $image_items['id'] ?? null;
				$thumb_url  = $image_items['url'] ?? '';
				$full_url   = $image_id ? wp_get_attachment_image_url($image_id, 'full') : $thumb_url;
	
	
				if ($thumb_url && $full_url) {
					$image_gallery .= '<div>
			            <a href="' . esc_url($full_url) . '" data-fancybox="gallery" data-caption="' . $gallery_title . '">
			                <img src="' . esc_url($thumb_url) . '" alt="' . $gallery_title . '" />
			            </a>
			        </div>';
				}
			}
			
		}
		
		
		$content_html = "";
		
		if ($gallery_type === "no-slider") {
			$content_html = '<div class="' . ($layout_position == "boxed" ? "container" : "container-fluid") . '">
            <ul class="image-gallery-inline">
                ' . $image_gallery . '
            </ul>
        </div>';
		} else {
			$content_html = '<div class="owl-carousel-slider ' . ($layout_position == "boxed" ? "container" : "") . '">
            <div class="owl-carousel slider-carousel">
                ' . $image_gallery . '
            </div>
        </div>';
		}
		
		return '<section class="image-gallery-block bg-color-' . $background_color . '">
        ' . $content_html . '
    </section>';
	}
