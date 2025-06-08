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
	
	// rc for Split-Block
	function gn_split_block_rc($attributes, $content) {
		
		// get globals and scripts
		global $theme_path;
		wp_register_style("gn_split_block",$theme_path."/gn-blocks/split-block/split_block.css",array("css-main"),"1");
		
		// vars
		$uniqid             = uniqid();
		$class_name         = $attributes["className"] ?? "default-mucivi";
		$post_id            = $attributes["post_id"] ?? "";
		$headline           = $attributes["headline"] ?? "";
		$subheadline        = $attributes["subheadline"] ?? "";
		$layout             = $attributes["layout"] ?? "";
		$selectLayout       = $attributes["selectLayout"] ?? "";
		$selectLayoutMobile = $attributes["selectLayoutMobile"] ?? "";
		$color              = $attributes["color"] ?? "";
		$headline_color     = $attributes["headline_color"] ?? "";
		$con                = "";
		$button_html        = "";
		$button_2_html      = "";
		$button_3_html      = "";
		$headline_html      = "";
		$subheadline_html   = "";
		
		// buttons var
		$btn_1_link             = $attributes["link"] ?? "";
		$btn_1_text             = $attributes["text"] ?? "";
		$btn_1_link_type        = $attributes["linktype"] ?? "";
		$btn_1_link_type_html   = "";
		$btn_1_style            = $attributes["btn_1_style"] ?? "";
	
		
		$btn_2_link             = $attributes["btn_2_link"] ?? "";
		$btn_2_text             = $attributes["btn_2_text"] ?? "";
		$btn_2_link_type        = $attributes["btn_2_link_type"] ?? "";
		$btn_2_link_type_html   = "";
		$btn_2_style            = $attributes["btn_2_style"] ?? "";

		
		$btn_3_link             = $attributes["btn_3_link"] ?? "";
		$btn_3_text             = $attributes["btn_3_text"] ?? "";
		$btn_3_link_type        = $attributes["btn_3_link_type"] ?? "";
		$btn_3_link_type_html   = "";
		$btn_3_style            = $attributes["btn_3_style"] ?? "";

		
		$sub_headline_type          = $attributes["selectHeadlineType"] ?? "";
		$headline_type          = $attributes["selectHeadlineType2"] ?? "";
		
		if ( isset($sub_headline_type) && $sub_headline_type !== "" )
		{
			$sub_headline_type = $sub_headline_type;
		}
		else
		{
			$sub_headline_type = "span";
		}
		
		if ( isset($headline_type) && $headline_type !== "" )
		{
			$main_headline_type = $headline_type;
		}
		else
		{
			$main_headline_type = "h2";
		}
		
		if( $btn_1_link_type === "_blank" )
		{
			$btn_1_link_type_html = 'target="_blank" rel="noopener"';
		}
		if( $btn_2_link_type === "_blank" )
		{
			$btn_2_link_type_html = 'target="_blank" rel="noopener"';
		}
		if( $btn_3_link_type === "_blank" )
		{
			$btn_3_link_type_html = 'target="_blank" rel="noopener"';
		}
		

		
		if( $btn_1_link && $btn_1_text )
		{
			$button_html = '<a href="'.$btn_1_link.'" '.$btn_1_link_type_html.' class="'.$btn_1_style.'">
                               <span>'.$btn_1_text.'</span>
                        </a>';
		}
		
		if( $btn_2_link && $btn_2_text )
		{
			$button_2_html = '<a href="'.$btn_2_link.'" '.$btn_2_link_type_html.' class="'.$btn_2_style.'">
                                  <span>'.$btn_2_text.'</span>
                            </a>';
		}
		
		if( $btn_3_link && $btn_3_text )
		{
			$button_3_html = '<a href="'.$btn_3_link.'" '.$btn_3_link_type_html.' class="'.$btn_3_style.'">
                                  <span>'.$btn_3_text.'</span>
                            </a>';
		}
		
		if($layout == "fullWidth")
		{
			$layoutPre  = '<div class="container-fluid">';
			$layoutSuff = '</div>';
		}
		else
		{
			$layoutPre  = '<div class="container">';
			$layoutSuff = '</div>';
		}
		
		if ($attributes["textStyle"] === "sRichText")
		{
			$con = $content;
		}
		elseif ($attributes["textStyle"] === "sHtml")
		{
			$con = $attributes["textHtml"];
		}
		
		if($headline)
		{
			$headline_html = "<$main_headline_type class='headline gn-h3 $headline_color'>$headline</$main_headline_type>";
		}
		if($subheadline)
		{
			$subheadline_html = "<$sub_headline_type class='subheadline $headline_color'>$subheadline</$sub_headline_type>";
		}
		
		if( $selectLayout === "0" || $selectLayout === "1" )
		{
			if ( isset($attributes["img"]["id"]) && !empty($attributes["img"]["id"]) ) {
				$contentHTML = wp_get_attachment_image($attributes["img"]["id"], "full", false, array('class' => 'img-fluid'));
			} else {
				$contentHTML = ''; // or show a placeholder or warning if needed
			}
		}

		
		
		// $layout === 0 - text / content
		if( $selectLayout === "0" || $selectLayout === "2" )
		{
			// vars for style
			$orderCSS   = "";
			
			if ($selectLayoutMobile === "1")
			{
				$orderCSS .= "order-last order-lg-first";
			}
			
			return '<section id="'.$class_name.'" class="split-block split-block-id-'.$uniqid.' split-block-layout-'.$layout.' split-block-select-layout-'.$selectLayout.' '.$class_name.'">
                
                '.$layoutPre.'
                    
                    <div class="split-wrapper row">
                            <div class="col-12 col-lg-6 pe-lg-0 mob '.$orderCSS.'">
                                <div class="content bg-'.$color.'">
                                    <div class="content-wrapper">
                                        '.$subheadline_html.'
                                        '.$headline_html.'
                                        <div class="con-wrapper">'.$con.'</div>
                                        <div class="btn-wrapper">
                                            '.$button_html.'
                                            '.$button_2_html.'
                                            '.$button_3_html.'
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12 col-lg-6 ps-lg-0 mob d-flex align-items-center image-split-block">
                                '.$contentHTML.'
                            </div>
                    </div>
                '.$layoutSuff.'
                
            </section>';
		}
		else // $layout === 1 - content / text
		{
			return '
            <section id="'.$class_name.'" class="split-block split-block-id-'.$uniqid.' split-block-layout-'.$layout.' split-block-select-layout-'.$selectLayout.' '.$class_name.'">
                    
                    '.$layoutPre.'
                        
                        <div class="split-wrapper row">
                                <div class="content-image col-12 col-lg-6 pe-lg-0 mob d-flex align-items-center">
                                    '.$contentHTML.'
                                </div>
                                
                                <div class="col-12 col-lg-6 mob ps-lg-0">
                                    <div class="content bg-'.$color.'">
                                       
                                       <div class="content-wrapper">
                                            '.$subheadline_html.'
                                            '.$headline_html.'
                                            <div class="con-wrapper">'.$con.'</div>
                                            <div class="btn-wrapper">
                                                '.$button_html.'
                                                '.$button_2_html.'
                                                '.$button_3_html.'
                                            </div>
                                       </div>
                                    </div>
                                </div>
                        </div>
                    '.$layoutSuff.'
                    
            </section>';
		}
	}