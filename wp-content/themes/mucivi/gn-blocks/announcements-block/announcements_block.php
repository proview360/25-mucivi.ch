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

// rc for announcements block
	function gn_announcements_block_rc($attributes, $content)
	{
		global $theme_path;
		
		wp_register_style("gn_announcements_block", $theme_path . "/gn-blocks/announcements-block/announcements_block.css", ["css-main"], "1");
		wp_enqueue_script("gn_announcements_block_js", $theme_path . "/gn-blocks/announcements-block/announcements_block.min.js", ["js-main"], "1");
		
		$post_ID               = $attributes["post_id"] ?? "";
		$post_ID_2               = $attributes["post_id_2"] ?? "";
		$background_color      = $attributes["background_color"] ?? "white";
		$sidebar_enable        = $attributes['side_bar_enable'] ?? 'no';
		$sidebar_title         = $attributes["side_bar_title"] ?? '';
		$announcements_data    = get_post_meta($post_ID, 'announcements_fields', true);
		$unique_id             = uniqid('announcements_');
		$content_html          = '';
		$sidebar_html          = '';
		
		$links_data            = get_post_meta($post_ID_2, 'links_fields', true);
//		echo '<pre>';
//		echo print_r($links_data);
//		echo '</pre>';
//
		
		
		// Build content
		if (is_array($announcements_data) && count($announcements_data)) {
			foreach ($announcements_data as $item) {
				$headline         = $item["headline"] ?? "";
				$headline_color   = $item["headline_color"] ?? "black";
				$description      = $item["description"] ?? "";
				$description_html = $description ? '<div class="my-3">' . wpautop($description) . '</div>' : '';
				$button_text      = $item["button_text"] ?? "";
				$button_link      = $item["button_link"] ?? "";
				$link_type        = $item["link_type"] ?? "";
				$image_url        = $item["image"] ?? "";
				$date             = $item["date"] ?? "";

				$date_html          = $date ? '<p class="announcements-date gn-h3">' . $date . '<p>' : '';
				
				$headline_html      = $headline ? '<h2 class="text-color-'.$headline_color.'">' . $headline . '</h2>' : '';
				
				$image_html         = $image_url ? '<div>
														<img class="img-fluid py-3" src="' . $image_url . '" alt="' . $headline . '">
													</div>' : '';
				
				$button_html        = $button_text ? '<div class="mt-4">
															<a href="' . $button_link . '" target="' . $link_type . '" class="btn-full btn-full-primary">' . esc_html($button_text) . '</a>
													 </div>' : '';
				
				$content_html       .= '
						                <div class="announcement-item py-5">
						                    '.$date_html.'
						                    '.$headline_html.'
						                    ' . $image_html . '
						                    ' . $description_html . '
						                    ' . $button_html . '
						                </div>';
			}
		}
		
		// Build sidebar
		if ($sidebar_enable === 'yes')
		{
			$sidebar_html .= '

		<div class="sidebar-title">
		   '.$sidebar_title.'
		</div>
		<div class="sidebar-buttons mt-4">';
			
			if (is_array($links_data) && count($links_data)) {
				foreach ($links_data as $item) {
					
					$icon = $item["icon"] ?? "";
					$button_text = $item["button_text"] ?? "";
					
					$button_link = $item["button_link"] ?? "";
					$link_type = $item["link_type"] ?? "";
					$icon_html = $icon !== "none" ? '<span class="me-2"><i class="'.$icon.'"></i></span>' : '';
					
					if ($button_text !== "" ) {
						$sidebar_html .= '<div class="sidebar-button mb-2"><a target="'.$link_type.'" href="' . $button_link . '" class="sidebar-link">' . $icon_html . '' . $button_text . '</a></div>';
					}
				}
			}
			$sidebar_html .= '</div>';
		}
		
		// Build full layout
		if ($sidebar_enable === 'yes')
		{
			return '
		            <section class="announcements-block bg-color-' . esc_attr($background_color) . '" id="' . esc_attr($unique_id) . '">
		                <div class="container d-flex flex-column flex-lg-row">
		                    <div class="col-12 col-lg-9">
		                        ' . $content_html . '
		                    </div>
		                    <div class="sidebar-container col-12 col-lg-3 ps-lg-5 py-5">
		                        ' . $sidebar_html . '
		                    </div>
		                </div>
		            </section>';
		}
		else
		{
			return '
		            <section class="announcements-block bg-color-' . esc_attr($background_color) . '" id="' . esc_attr($unique_id) . '">
		                <div class="container">
		                    <div class="row">
		                        ' . $content_html . '
		                    </div>
		                </div>
		            </section>';
		}
	}

