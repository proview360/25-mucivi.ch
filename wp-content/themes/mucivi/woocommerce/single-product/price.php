<?php
/**
 * Single Product Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

global $product;

$price = '';

if($product->is_type('variable')) {
    // Get minimum and maximum prices for the variable product
    $prices = array($product->get_variation_price('max', true), $product->get_variation_price('min', true));

    // Check if prices are not empty
    if (!empty($prices)) {
        $price = wc_price(max($prices));
        if (end($prices) != reset($prices)) {
            $price .= '<span class="mx-2"> - </span>' . wc_price(end($prices));
        }
    }
} else {
    $price = $product->get_price_html();
}

?>
<p class="<?php echo esc_attr(apply_filters('woocommerce_product_price_class', 'price')); ?>">
    <?php echo $price; ?>
</p>