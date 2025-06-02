<?php
function gn_honeycomb_block_rc( $attributes, $content ) {


    global  $theme_path;
    wp_register_style("gn_honeycomb_block",$theme_path."/gn-blocks/honeycomb-block/honeycomb_block.css",array("css-main"),"1");
    wp_enqueue_script("gn_honeycomb_block_js",$theme_path."/gn-blocks/honeycomb-block/honeycomb_block.min.js",array("js-main"),"1");

    // vars
    $layout       = $attributes["layout"] ?? '';
    $button_link  =  $attributes['button_link'] ?? "";
    $button_name  =  $attributes['button_text'] ?? "";


    $headline                   = $attributes["headline"] ?? "";
    $sub_headline               = $attributes["sub_headline"] ?? "";

    $headline       = str_replace("[*", "<br/><span class='text-bold'>", $headline);
    $headline        = str_replace("*]", "</span>", $headline);

    $sub_headline       = str_replace("[*", "<br/><span class='text-bold'>", $sub_headline);
    $sub_headline        = str_replace("*]", "</span>", $sub_headline);

    $button_html                = '';
    $headline_html              = "";
    $sub_headline_html          = "";

    if($button_link && $button_name !== "")
    {
        $button_html .= '<a class="btn-full btn-full-red" href="' . $button_link . '">' . $button_name . '</a>';
    }

    if($headline !== ""){
        $headline_html = '<h2 class="honeycomb-block-headline">' . $headline . '</h2>';
    }

    if($sub_headline !== ""){
        $sub_headline_html = '<h2 class="honeycomb-block-sub-headline">' . $sub_headline . '</h2>';
    }




    ob_start();
    ?>
    <section class="honeycomb-block-main">
    <div class="bginfo" id="bginfo">
        <script>
            const rows = 10;
            const cols = 25;
            let html = '';

            for (let i = 0; i < rows; i++) {
                html += '<div class="rowHexagon">';
                for (let j = 0; j < cols; j++) {
                    html += '<div class="bgHexagon"></div>';
                }
                html += '</div>';
            }

            document.write(html);
        </script>
    </div>
        <div class="honeycomb-block bg-color-transparent">
            <div class="honeycomb-block-container d-flex flex-column flex-lg-row justify-content-between align-items-lg-center <?php echo $layout === 'full-width' ? 'container-fluid' : 'container'; ?>">
                <div class="left-side">
                    <?php echo $headline_html; ?>
                    <?php echo $sub_headline_html; ?>
                </div>
                <div class="right-side">
                    <?php echo $button_html; ?>
                </div>
            </div>
        </div>
    </section>
    <?php
    return ob_get_clean();
}
