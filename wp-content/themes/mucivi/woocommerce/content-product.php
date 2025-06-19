<?php

defined('ABSPATH') || exit;

global $product;

if (empty($product) || !$product->is_visible()) {
    return;
}

$terms = get_the_terms($product->get_id(), 'product_cat');

$brand_name = !empty(get_post_meta($product->get_id(), 'brand_name', true)) ? get_post_meta($product->get_id(), 'brand_name', true) : 'Markenname';
$delivery_time = !empty(get_post_meta($product->get_id(), 'delivery_time', true)) ? get_post_meta($product->get_id(), 'delivery_time', true) : 'x';

$product_description = apply_filters('woocommerce_short_description', $product->get_short_description());
//
//if (mb_strlen($product_description) > 30) {
//    $product_description = mb_substr($product_description, 0, 30) . '...';
//}

?>

<li <?php wc_product_class('gn-product', $product); ?>>
    <?php do_action('woocommerce_before_shop_loop_item'); ?>
    <?php do_action('woocommerce_before_shop_loop_item_title'); ?>

    <?php
    echo '<div class="product-info-styles">';

    echo '<h2 class="product-title">' . get_the_title() . '</h2>'; // Product Title
    echo '<div class="product-description">' . $product_description . '</div>'; // Product short description

    if (is_user_logged_in()) {

        $price = $product->get_price();  // active price
        $price = (!empty($price)) ? wc_price($price) : '';  // format price if not empty

        $regular_price = $product->get_regular_price();
        $sale_price = $product->get_sale_price();

        // format prices only if they are not empty
        $regular_price = (!empty($regular_price)) ? wc_price($regular_price) : '';
        $sale_price = (!empty($sale_price)) ? wc_price($sale_price) : '';

        echo '<div class="product-price">';

        // Check if there is a sale price
        if (!empty($sale_price) && $sale_price != $regular_price) {
            echo '<span class="sale-price">' . $sale_price . '</span>';
            echo '<span class="regular-price"><del>' . $regular_price . '</del></span>';
        } else {
            echo '<span class="regular-price">' . $price . '</span>';
        }
        echo '</div>';

    }
    echo '</div';
    ?>

    <?php do_action('woocommerce_after_shop_loop_item'); ?>

</li>
