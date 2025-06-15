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
		$background_color      = $attributes["background_color"] ?? "white";
		$sidebar_enable        = $attributes['side_bar_enable'] ?? 'no';
		$sidebar_title         = $attributes["side_bar_title"] ?? '';
		$announcements_data    = get_post_meta($post_ID, 'announcements_fields', true);
		$unique_id             = uniqid('announcements_');
		$content_html          = '';
		$sidebar_html          = '';
		
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
			$sidebar_html .= '<div class="sidebar-title">' . esc_html($sidebar_title) . '</div><div class="sidebar-buttons mt-4">';
			
			for ($i = 1; $i <= 10; $i++) {
				$name_key = "button_{$i}_name";
				$link_key = "button_{$i}_link";
				$icon_key = "button_{$i}_icon";
				
				$icon_html = !empty($attributes[$icon_key]) ? '<span class="me-2">' . wp_kses_post($attributes[$icon_key]) . '</span>' : '';
				
				if (!empty($attributes[$name_key]) && !empty($attributes[$link_key]))
				{
					$sidebar_html .= '<div class="sidebar-button mb-2"><a href="' . esc_url($attributes[$link_key]) . '" class="sidebar-link">' . $icon_html . '' . esc_html($attributes[$name_key]) . '</a></div>';
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

