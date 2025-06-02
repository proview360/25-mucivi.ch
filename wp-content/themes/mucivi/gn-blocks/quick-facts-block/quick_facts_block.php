<?php
function gn_quick_facts_block_rc( $attributes, $content ) {

    // get globals and scripts
    global  $theme_path;
    wp_register_style("gn_quick_facts_block_rc",$theme_path."/gn-blocks/quick-facts-block/quick_facts_block.css",array("css-main"),"1");

    // vars
    $layout                     = $attributes["layout"] ?? '';
    $quick_facts                = $attributes["quick_facts"] ?? [];
    $background_color           =  $attributes['background_color'] ?? "gray";
    $horizontal_line_color      =  $attributes['horizontal_line_color'] ?? "green";
    $quick_fact_html            = '';

    foreach($quick_facts as $quick_fact) {

        $text_1 = $quick_fact['text'] ?? "";
        $text_2 = $quick_fact['text_2'] ?? "";
        $text_3 = $quick_fact['text_3'] ?? "";
        $show_icon = $quick_fact['show_icon'] ?? false;
        $show_icon_sv = $quick_fact['show_icon_sv'] ?? false;

        $sign_html = $show_icon ? '<span class="sign">~</span>' : '';
        $sign_html_sv = $show_icon_sv ? '<span class="sign-sv">≈</span>' : '';

        $text_1_html = !empty($text_1) ? ("<p class='quick-fact-number'>". $sign_html_sv . $sign_html . $text_1 . "</p>") : "";
        $text_2_html = !empty($text_2) ? ('<p class="quick-fact-text-2">'.$text_2.'</p>') : "";
        $text_3_html = !empty($text_3) ? ('<p class="quick-fact-text-3">'.$text_3.'</p>') : "";

        $quick_fact_html .= '<div class="col-lg-4 col-md-6 mt-4 mb-4 text-center">
                                '.$text_1_html.'
                                '.$text_2_html.'
                                <hr class="horizontal-line '.$horizontal_line_color.'" />
                                '.$text_3_html.'
                            </div>';
    }

    return '<section class="quick-facts-block bg-color-'.$background_color.'">  
              <div class="' . ( $layout == "full-width" ? "container-fluid" : "container" ) . '">              
                <div class="row d-flex justify-content-center align-items-center">
                    '.$quick_fact_html.'
                </div>                                                                
              </div>
            </section>';
}
