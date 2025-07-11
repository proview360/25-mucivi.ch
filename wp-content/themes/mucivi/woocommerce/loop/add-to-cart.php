<?php
/**
 * Loop Add to Cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/add-to-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.3.0
 */

if (!defined('ABSPATH')) {
    exit;
}

global $product;



if ($product->is_type('variable')) {
    $icon_html = '';
}

echo apply_filters(
    'woocommerce_loop_add_to_cart_link',
    sprintf(
        '<div class="gn-btn-add-to-cart-container">
                <a href="%1$s" data-quantity="%2$s" class="gn-btn-add-to-cart %3$s" %4$s>
                    <span>%6$s<span>
                </a>
                </div>',
        esc_url($product->add_to_cart_url()),
        esc_attr(isset($args['quantity']) ? $args['quantity'] : 1),
        esc_attr(isset($args['class']) ? $args['class'] : 'button'),
        isset($args['attributes']) ? wc_implode_html_attributes($args['attributes']) : '',
        get_template_directory_uri(),
        esc_html($product->add_to_cart_text())
    ),
    $product,
    $args
);