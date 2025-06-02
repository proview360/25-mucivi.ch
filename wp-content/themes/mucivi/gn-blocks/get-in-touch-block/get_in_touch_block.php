<?php
function gn_get_in_touch_block_rc( $attributes, $content ) {


    global  $theme_path;
    wp_register_style("gn_get_in_touch_block",$theme_path."/gn-blocks/get-in-touch-block/get_in_touch_block.css",array("css-main"),"1");

    // vars
    $layout       = $attributes["layout"] ?? '';
    $button_link  =  $attributes['button_link'] ?? "";
    $button_name  =  $attributes['button_text'] ?? "";
    $image_url    =  $attributes["img_1"]["url"] ?? "";
    $image_alt    =  $attributes["img_1"]["title"] ?? "";
    $bg_color     =  $attributes["background_color"] ?? "";
    $button_html  = '';

    if($button_link && $button_name !== "")
    {
        $button_html .= '<a class="btn-full btn-full-red" href="' . $button_link . '">' . $button_name . '</a>';
    }

    return '<section class="get-in-touch-block bg-color-'.$bg_color.'">  
              <div class="d-flex flex-column-reverse flex-lg-row justify-content-between align-items-lg-center ' . ( $layout == "full-width" ? "container-fluid" : "container" ) . '">              
                    <div class="col-12 col-lg-9">
                        ' . $button_html . '
                    </div>     
                    <div class="right-side col-12 col-lg-3">
                        <img class="get-in-touch-img" src="' . $image_url . '" alt="' . $image_alt . '">
                    </div>  
                </div>                                                         
            </section>';
}
