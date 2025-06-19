<?php

// change options filter title
function custom_woocommerce_catalog_orderby($orderby)
{
    $orderby['menu_order'] = __('Standard sorting', 'mucivi');
    $orderby['popularity'] = __('Sort by Popularity', 'mucivi');
    $orderby['date'] = __('Sort by Newest', 'mucivi');
    $orderby['price'] = __('Sort by price: low to high', 'mucivi');
    $orderby['price-desc'] = __('Sort by price: high to low', 'mucivi');
    $orderby['sku'] = __('Sort by SKU', 'mucivi');

    unset($orderby['rating']); // Remove Sort by average rating option
    return $orderby;
}

add_filter('woocommerce_catalog_orderby', 'custom_woocommerce_catalog_orderby');

// unset option filters if the user is not logged in
function remove_menu_filter_for_guests($orderby)
{
    // Check if the user is not logged in
    if (!is_user_logged_in()) {
        unset($orderby['price']);
        unset($orderby['price-desc']);
    }
    return $orderby;
}

add_filter('woocommerce_default_catalog_orderby_options', 'remove_menu_filter_for_guests');
add_filter('woocommerce_catalog_orderby', 'remove_menu_filter_for_guests');

