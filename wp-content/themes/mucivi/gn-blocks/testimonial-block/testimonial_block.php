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

// rc for text testimonials block

function gn_testimonial_block_rc($attributes, $content) {

    // get globals and scripts
    global $theme_path;
    wp_register_style("gn_testimonial_block", $theme_path . "/gn-blocks/testimonial-block/testimonial_block.css", array("css-main"), "1");
    wp_enqueue_script("gn_testimonials_block_js",$theme_path."/gn-blocks/testimonial-block/testimonial_block.min.js",array("js-main"),"1");

    wp_enqueue_style("owl-carousel-style", $theme_path . "/assets/css/owl-carousel/owl.carousel.min.css", array("css-main"), "1");
    wp_enqueue_style("owl-carousel-default", $theme_path . "/assets/css/owl-carousel/owl.theme.default.min.css", array("css-main"), "1");
//
    wp_enqueue_script("owl-js",$theme_path."/assets/js/owl-carousel/owl.carousel.min.js",array("js-main"),"1");

    $layout             = $attributes["layout"];
    $quote_style        = $attributes['quote_style'] ?? "style_1";
    $show_stars         = $attributes['show_stars'] ?? "1";


    $testimonials_data  = get_post_meta( $attributes["postID"], 'testimonial_fields', true );
    $testimonials       = $testimonials_data['testimonial'];



    $testimonial_html   = "";
    $html               = "";
    $stars_html         = "";
    $testimonial_count  = 0;
    $uniqid             = uniqid($layout);

    if($testimonials)
    {
        $testimonial_count = count($testimonials);
    }

    $arrowHTML = "";
    $active_owl = "";


    if( $testimonial_count > 1 )
    {
        $arrowHTML = '<div class="arrow arrow-right owl-nav-button" data-action="next" data-context="testimonials-'.$uniqid.'">
                            <img src="/wp-content/themes/mucivi/assets/img/vectors/nextButton.svg" alt="arrow-next-testimonial" />
                       </div>
                      <div class="arrow arrow-left owl-nav-button" data-action="prev" data-context="testimonials-'.$uniqid.'">
                            <img src="/wp-content/themes/mucivi/assets/img/vectors/prevButton.svg" alt="arrow-prev-testimonial" />
                      </div>';

        $active_owl = 'owl-carousel';
    }


    $layout_classes     = "";
    if($layout === "boxed")
    {
        $layout_classes = "container boxed";
    }else {
        $layout_classes = "container-fluid fluid-boxed";
    }


    foreach ($testimonials as $testimonial) {

        //get required vars
        $testimonial_star = $testimonial['stars'] ?? "5";
        $testimonial_quote = wpautop($testimonial['quote']) ?? "";
        $testimonial_full_name = $testimonial['full_name'] ?? "";
        $testimonial_full_job = $testimonial['job'] ?? "";
//        echo '<pre>';
//        echo print_r( $testimonial_full_job);
//        echo '</pre>';

        if($show_stars === "1") {
            // create star string based on $testimonial_star
            $stars_html = '<div id="star-review">';
            for ($i = 1; $i <= 5; $i++) {
                if ($i <= $testimonial_star) {
                    $stars_html .= '<span class="star filled">&#9733;</span>';
                } else {
                    $stars_html .= '<span class="star">&#9734;</span>';
                }
            }
            $stars_html .= '</div>';
        }


        if($quote_style === "style_1")
        {
            $testimonial_html .= '
            <div class="testimonial">
                <div class="content-area">
             
                        <div class="quote-icon">
                            <i class="bi bi-quote"></i>
                        </div>
                        <div class="quote-area">
                            <span>' . $testimonial_quote . '</span>
                        </div>
                        <div class="author-area">
                             <p>- ' . $testimonial_full_name . ' -</p>
                        </div>
                        <div class="author-job">
                             <p>' . $testimonial_full_job . '</p>
                        </div>
                        <div class="stars-area">
                                   ' . $stars_html . '
                        </div>
                                <div class=" content-area-1"></div>
                                    <div class=" content-area-2"></div>
                </div>
            </div>';
        }else {
            $testimonial_html .= '
            <div class="testimonial testimonial-style-two">
                 <div class=" content-area-1"></div>
                <div class="content-area-2"></div>
                <div class="content-area">
                <div class="testimonial-style-info">
                        <div class="quote-icon">
                            <i class="bi bi-quote"></i>
                        </div>
                        <div>
                            <div class="quote-area">
                                <span>' . $testimonial_quote . '</span>
                            </div>
                            <div class="author-area">
                                 <p>- ' . $testimonial_full_name . ' -</p>
                            </div>
                            <div class="author-job">
                               <p>' . $testimonial_full_job . '</p>
                            </div>
                            <div class="stars-area">
                                   ' . $stars_html . '
                            </div>
                        </div>
                   </div>
                </div>
            </div>';
        }


    }



// finish html
    $html .= '<!-- testimonials -->
        <section class="testimonials-section">
            <div class="'.$layout_classes.'">
                <div class="testimonials-content-wrapper">
                    <div class="'.$active_owl.' owl-carousel-style owl-theme" data-id="'.$uniqid.'">
                        '.$testimonial_html.'
                    </div>
                    '.$arrowHTML.'
                </div>
            </div>
        </section>
        <!-- END - Testimonials -->';

    return $html;

//    return '<h1> TEst</h1>';
}