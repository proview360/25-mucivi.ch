<?php
function gn_news_block_rc( $attributes, $content ) {

    // get globals and scripts
    global  $theme_path;
    wp_register_style("gn_news_block",$theme_path."/gn-blocks/news-block/news_block.css",array("css-main"),"1");


    $layout             = $attributes['layout'] ?? "container";
    $background_color   = $attributes['background_color'] ?? "white";
    $category_1         = $attributes['category_1'] ?? "";
    $category_2         = $attributes['category_2'] ?? "";
    $category_1_title         = $attributes['category_1_title'] ?? "";
    $category_2_title         = $attributes['category_2_title'] ?? "";
    $button_text        = $attributes['button_text'] ?? "";
    $button_link        = $attributes['button_link'] ?? "";

    $button_html = "";
    if(  $button_text !== ""){
        $button_html = '<a href="'.$button_link.'" class="btn-full btn-full-blue mt-3">'.$button_text.'</a>';
    }
    $output = '<section class="news-block bg-color-' . $background_color . '">
                  <div class="' . ($layout == "full-width" ? "container-fluid" : "container") . '">';

    if ($category_1 !== "") {
        $args_1 = array(
            'category' => $category_1,
            'numberposts' => 3,
            'orderby' => 'date',
            'order' => 'DESC'
        );


        $posts_1 = get_posts($args_1);
        $cat_1 = get_category($category_1);

        $post_counter = 1;
        $category_show_cat_1_title = "";
        if($category_1_title !== ""){
            $category_show_cat_1_title = $category_1_title;
        }else{
            $category_show_cat_1_title = $cat_1->name;
        }

        $output .= '<h2 class="category-title">'.$category_show_cat_1_title.'</h2> <hr class="horizontal-line" />';
        $output .= '<div class="row d-flex">';
        foreach ($posts_1 as $post) {



            setup_postdata($post);
            $permalink = get_permalink($post); // Get the post's permalink

            $output .= '<div class="post col-lg-4 col-md-6 mt-4 mb-4 post-' . $post_counter . '">
            <h2 class="category-post-title"><a href="' . $permalink . '">' . $post->post_title . '</a></h2>
            <br>
            <span class="category-date">' . get_the_date('F j, Y', $post) . ' </span>
        </div>';

            // Increment the counter at the end of the loop
            $post_counter++;
        }
        $output .= '</div>';
    }

    if ($category_2 !== "") {
        // News
        $args_2 = array(
            'category' => $category_2,
            'numberposts' => 3,
            'orderby' => 'date',
            'order' => 'DESC'
        );
        $posts_2 = get_posts($args_2);
        $cat_2 = get_category($category_2);

        $category_show_cat_2_title = "";
        if($category_2_title !== ""){
            $category_show_cat_2_title = $category_2_title;
        }else{
            $category_show_cat_2_title = $cat_2->name;
        }

        $post_counter_cat_2 = 1;
        $output .= '<h2 class="category-title mt-3 mt-lg-5">' . $category_show_cat_2_title . '</h2> <hr class="horizontal-line" />';
        $output .= '<div class="row d-flex ">';
        foreach ($posts_2 as $post) {
            setup_postdata($post);
            $permalink = get_permalink($post); // Get the post's permalink



            $output .= '<div class="post col-lg-4 col-md-6 mt-4 mb-2 post-' . $post_counter_cat_2 . '">
                   <h2 class="category-post-title"><a href="' . $permalink . '">' . $post->post_title . '</a></h2>
                   <br>
                   <span class="category-date">' . get_the_date('F j, Y', $post) . ' </span>
            </div>';

            // Increment the counter at the end of the loop
            $post_counter_cat_2++;
        }
        $output .= '</div>';
    }

    $output .= $button_html . '</div></section>';

    // Reset the global $the_post as this query will have stomped on it
    wp_reset_postdata();

    return $output;
}