<?php

function custom_woocommerce_product_search_callback_mobile() {
    $keyword = sanitize_text_field($_GET['search_term_mobile']);
    $search_by = sanitize_text_field($_GET['search_type_mobile']);
    $results = custom_woocommerce_product_search_mobile($keyword, $search_by);
    if (!empty($results)) {

        echo '<div class="mucivi-custom-search-results-mobile">';
        foreach ($results as $product) {
            echo '<div class="mucivi-custom-search-results-container-mobile">';
            echo '<div class="mucivi-custom-search-results-items-mobile">';
            echo '<img src="' . esc_url($product['image']) . '" alt="' . esc_attr($product['title']) . '" />';
            echo '<div class="mucivi-custom-search-results-items-2-mobile">';
            echo '<a href="' . esc_url($product['permalink']) . '">' . esc_html($product['title']) . '</a>';
            echo '<span class="price-mobile">' . wc_price($product['price'], array('currency' => get_woocommerce_currency())) . '</span>';
            echo '<span class="sku-mobile"><span class="sku-mobile-title">' . __('SKU:', 'mucivi') . ' </span><span class="sku-mobile-number">' . esc_html($product['sku']) . '</span></span>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';
    } else {
        echo '<div class="mucivi-custom-search-results-mobile">';
        echo '<div class="p-3">' . __('No products found.', 'mucivi') . '</div>';
        echo '</div>';
    }

    wp_die();
}

function custom_woocommerce_product_search_mobile($keyword) {
    if (!class_exists('WooCommerce')) {
        return [];
    }

    $args = [
        'post_type'      => 'product',
        'posts_per_page' => -1,
        's'              => $keyword,
    ];


    add_filter('posts_where', function($where) use ($keyword){
        global $wpdb;
        $where .= sprintf(
            " OR ({$wpdb->posts}.ID IN (
                SELECT post_id FROM {$wpdb->postmeta}
                WHERE meta_key='_sku' AND meta_value = '%s'
            ))", $wpdb->esc_like($keyword)
        );

        return $where;
    });
    $query = new WP_Query($args);

    remove_all_filters('posts_where');

    $products = [];
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $products[] = [
                'ID'        => get_the_ID(),
                'title'     => get_the_title(),
                'permalink' => get_permalink(),
                'price'     => get_post_meta(get_the_ID(), '_price', true),
                'sku'       => get_post_meta(get_the_ID(), '_sku', true),
                'image'     => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail')
            ];
        }
        wp_reset_postdata();
    }

    return $products;
}

add_action('wp_ajax_custom_woocommerce_product_search_mobile', 'custom_woocommerce_product_search_callback_mobile');
add_action('wp_ajax_nopriv_custom_woocommerce_product_search_mobile', 'custom_woocommerce_product_search_callback_mobile');
