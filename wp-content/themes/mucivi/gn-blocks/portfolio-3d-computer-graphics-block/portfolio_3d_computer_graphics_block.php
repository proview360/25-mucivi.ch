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
 * @author Granit Nebiu, Granit Nebiu
 * @since 1.0
 */
function gn_portfolio_3d_computer_graphics_block_rc($attributes, $content = '')
{
    ob_start();
    global $theme_path;

    // Enqueue Styles
    wp_register_style(
        "gn_portfolio_3d_computer_graphics_block",
        $theme_path . "/gn-blocks/portfolio-3d-computer-graphics-block/portfolio_3d_computer_graphics_block.css",
        array("css-main"),
        "1"
    );

    // Localize Script for AJAX calls
    wp_enqueue_script('gn_portfolio_3d_computer_graphics_block_js', $theme_path . '/gn-blocks/portfolio-3d-computer-graphics-block/portfolio_3d_computer_graphics_block.min.js', array('jquery'), '1.0', true);
    wp_localize_script('gn_portfolio_3d_computer_graphics_block_js', 'gn_portfolio3dcg_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('gn_portfolio3dcg_nonce')
    ));

    // Determine layout class
    $layout                 = $attributes["layout"] ?? '';
    $portfolio_headline     = $attributes["portfolio_headline"] ?? '';
    $filter_name            = $attributes["filter_name"] ?? '';
    $button_load_more       = $attributes["button_load_more"] ?? '';
    $button_reset           = $attributes["button_reset"] ?? '';
    $mobile_filter_name     = $attributes["mobile_filter_name"] ?? '';
    $select_headline_type   = $attributes["select_headline_type"] ?? 'h1';
//            echo '<pre>';
//        echo print_r($attributes);
//        echo '</pre>';
    $portfolio_headline       = str_replace("[*", "<br/><span class='text-bold'>", $portfolio_headline);
    $portfolio_headline       = str_replace("*]", "</span>", $portfolio_headline);

    if ( $select_headline_type )
    {
        $headline_type = $select_headline_type;
    }
    else
    {
        $headline_type = "h1";
    }


    $layout_class = ($layout == "full-width") ? "" : "container";

    // Get unique post titles for filtering
    $posts = get_posts([
        'post_type' => 'portfolio3dcg',
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'ASC'
    ]);

    $titles = [];
    foreach ($posts as $post) {
        if (!in_array($post->post_title, $titles)) {
            $titles[] = $post->post_title;
        }
    }
    ?>

    <!-- Portfolio Block Container -->
    <div class="<?php echo $layout_class; ?> hex-container">

        <!-- Filter Bar -->
        <div class="portfolio-filter d-flex  justify-content-between align-items-center p-3">

            <div class="container d-flex align-items-center justify-content-between">
                <!-- Title (left-aligned) -->
                <div class="d-block">
                <?php echo "<$headline_type class='textBlock-headline'>$portfolio_headline</$headline_type>"; ?>
            </div>
                <!-- Mobile Toggler (right-aligned on small screens) -->
                <div class="d-flex d-lg-none justify-content-end w-100">
                    <button class="navbar-toggler ms-auto" type="button" id="toggleButton" aria-controls="portfolioFilterMenu" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="portfolio-filters-mob"><?php echo $mobile_filter_name ?> <i class="bi bi-filter-right"></i></span>
                    </button>
                </div>

                <!-- Filter Menu (right-aligned on large screens) -->
                <div class="portfolio-filter-collapse collapse d-lg-block ms-lg-auto" id="portfolioFilterMenu">
                    <nav class="filter-nav">
                        <ul class="nav flex-column flex-lg-row gap-2">
                            <li class="nav-item">
                                <a class="nav-link-gn active" href="#" data-filter="all"><?php echo $filter_name ?></a>
                            </li>
                            <?php foreach ($titles as $title) : ?>
                                <li class="nav-item">
                                    <a class="nav-link-gn" href="#" data-filter="<?php echo esc_attr($title); ?>">
                                        <?php echo esc_html($title); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Portfolio Grid -->
        <div class="gn-portfolio-block">
            <div class="row gy-3 portfolio-grid ">

                <!-- Spinner (Hidden initially) -->
                <div class="col-12 text-center" style="display: none;" id="portfolio-spinner">
                    <div class="spinner-border text-danger" role="status"></div>
                </div>

                <?php
                // Load default items for portfolio display
                $items = gn_portfolio_3d_computer_graphics_get_items();
                echo $items['html'];
                ?>
            </div>

            <!-- Load More / Show Less Buttons -->
            <div class="d-flex flex-column flex-sm-row justify-content-center align-items-center gap-1 text-center pb-1" id="button-container">
                <a class="load-more-button text-uppercase btn-full btn-full-red">
                    <?php echo $button_load_more  ?>
                </a>
                <a class="show-less-button text-uppercase btn-full btn-full-red">
                    <?php echo $button_reset ?>
                </a>

            </div>
        </div>

    </div>

    <!-- Lightbox Modal -->
    <div class="modal fade" id="lightboxModal" tabindex="-1" aria-labelledby="lightboxModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" style="background: transparent; border: 0; overflow: hidden">

                <div class="modal-body" >
<!--                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>-->
                    <div id="lightboxCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner" id="lightboxCarouselContent">
                            <!-- Populated dynamically -->
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#lightboxCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#lightboxCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    return ob_get_clean();
}

// ===============================
// Helper: Get Portfolio Items with Filter + Pagination
// ===============================

function gn_portfolio_3d_computer_graphics_get_items($filter = 'all', $page = 1)
{
    $posts_per_page = 7;
    $offset = ($page - 1) * $posts_per_page;

    // Setup base query for portfolio posts
    $args = [
        'post_type' => 'portfolio3dcg',
        'posts_per_page' => -1, // Manual slicing later
        'orderby' => 'date',
        'order' => 'DESC',
    ];

    // If filter is not 'all', apply search filter
    if ($filter !== 'all') {
        $args['suppress_filters'] = false;

        // Store filter in a variable so we can remove it later
        $title_filter = function ($where) use ($filter) {
            global $wpdb;
            $where .= $wpdb->prepare(" AND {$wpdb->posts}.post_title = %s", $filter);
            return $where;
        };

        // Add the filter
        add_filter('posts_where', $title_filter);
    }



    $query = new WP_Query($args);
    // Remove the filter after the query
    if (isset($title_filter)) {
        remove_filter('posts_where', $title_filter);
    }

    $all_items = [];

    // Check if there are any posts matching the query
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            // Retrieve portfolio fields
            $portfolio_data = get_post_meta(get_the_ID(), 'portfolios_fields_3d_computer_graphics', true) ?? [];

            // Loop through the portfolio items and add them to the list
            if (isset($portfolio_data['portfolio']) && is_array($portfolio_data['portfolio'])) {
                foreach ($portfolio_data['portfolio'] as $portfolio) {
                    if (!empty($portfolio['image'])) {
                        $all_items[] = [
                            'image' => $portfolio['image'],
                            'title' => $portfolio['headline'] ?? get_the_title(),
                            'description' => $portfolio['text'] ?? '',
                            'post_title' => get_the_title(),
                            'link' => $portfolio['button2link'] ?? '',
                            'link_type' => $portfolio['button2linktype'] ?? 'same'
                        ];
                    }
                }
            }
        }
        wp_reset_postdata();
    }

    // Pagination logic for portfolio items
    $total_items = count($all_items);
    $has_more = ($total_items > $page * $posts_per_page);
    $paged_items = array_slice($all_items, $offset, $posts_per_page);

    // Build HTML for portfolio items
    $html = '<ul id="hexGrid">';
    foreach ($paged_items as $item) {
        $title = esc_html($item['title']);
        $description = esc_html($item['description']);
        $image = esc_url($item['image']);
        $link = !empty($item['link']) ? esc_url($item['link']) : '#';
        $target = (!empty($item['link']) && $item['link_type'] === 'blank') ? ' target="_blank"' : '';

        $html .= '<li class="hex">';
        $html .= '  <a class="hexIn portfolio-image" href="' . $link . '"' . $target;

        // Enable lightbox if no external link
        if (empty($item['link'])) {
            $html .= ' data-bs-toggle="modal" data-bs-target="#lightboxModal"';
            $html .= ' data-image="' . $image . '"';
            $html .= ' data-title="' . esc_attr($item['title']) . '"';
            $html .= ' data-description="' . esc_attr($item['description']) . '"';
        }

        $html .= '>';
        $html .= '    <img src="' . $image . '" alt="' . esc_attr($item['title']) . '" />';
        $html .= '    <h2 class="gn-h3">' . $title . '</h2>';
        $html .= '    <p class="hex-in-description">' . $description . '</p>';
        $html .= '  </a>';
        $html .= '</li>';
    }
    $html .= '</ul>';

    return [
        'html' => $html,
        'has_more' => $has_more
    ];
}