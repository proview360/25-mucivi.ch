<?php
function gn_threed_and_lists_block_rc( $attributes, $content ) {


    global  $theme_path;
    wp_register_style("gn_threed_and_lists_block",$theme_path."/gn-blocks/threed-and-lists-block/threed_and_lists_block.css",array("css-main"),"1");

    // vars
    $layout             = $attributes["layout"] ?? '';
    $theed_link         = $attributes["theed_link"] ?? '';
    $row_headline       = $attributes["row_headline"] ?? '';
    $rows               = $attributes["rows"] ?? [];
    $change_row_order   = $attributes["change_row_order"] ?? 'no';
    $rows_html          = '';
    $threed_link_html   = '';
    $background_color    = $attributes["background_color"] ?? '';
    $row_headline_html = '';
//            echo '<pre>';
//        echo print_r($attributes);
//        echo '</pre>';
    $row_headline       = str_replace("[*", "<br/><span class='text-bold'>", $row_headline);
    $row_headline        = str_replace("*]", "</span>", $row_headline);


    if($theed_link!==""){
        $threed_link_html = '<div class="three-d-config col-12 col-lg-6 col-xl-5">
                                <iframe src="'.$theed_link.'" width="100%" height="600" style="border:0;" loading="lazy"></iframe>
                                <img class="three-d-config-bg" src="/wp-content/themes/mucivi/assets/img/vectors/sun-background.svg" alt="3d rotation" />
                            </div>';
    }

    if($row_headline!==""){
        $row_headline_html = '<h2 class="">'.$row_headline.'</h2>';
    }

    if($change_row_order === "yes") {
        $change_row_order_class = 'flex-lg-row-reverse';
    }else{
        $change_row_order_class = 'flex-lg-row';
    }

    $rows_html .= '<div class="col-12 col-lg-6 col-xl-7">';
    $rows_html .= $row_headline_html;
    foreach($rows as $row) {

        $row_headline_title     =  $row['headline'] ?? "";
        $row_description        =  $row['description'] ?? "";
        $row_image              =  $row['image']['url'] ?? "";
        $row_image_title        =  $row['headline'] ?? "";

        $row_headline_title       = str_replace("[*", "<br/><span class='text-bold'>", $row_headline_title);
        $row_headline_title        = str_replace("*]", "</span>", $row_headline_title);


        $rows_html .= '<div class="list-container d-flex flex-column flex-lg-row  justify-content-center text-center text-md-start justify-content-md-start gap-3 align-items-start mt-5">
               <img src="' . $row_image . '" alt="' . $row_image_title . '"/>
               <div class="">
                   <h2 class="gn-h3 mb-3 mt-4">' . $row_headline_title . '</h2>
                   <p>' . $row_description . '</p>
               </div>
            </div>';

    }

    $rows_html .= '</div>';
    return '<section class="threed-and-lists-block bg-'.$background_color.'">  
              <div class="' . ( $layout == "full-width" ? "container-fluid" : "container" ) . '">  
              <div class="d-flex flex-column ' . $change_row_order_class . ' gap-5">
                   '.$threed_link_html.'  
                    '.$rows_html.'
              </div>
              </div>
            </section>';
}
