<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.8.0
 */

defined( 'ABSPATH' ) || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
    return;
}

global $product;

$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$post_thumbnail_id = $product->get_image_id();
$wrapper_classes   = apply_filters(
    'woocommerce_single_product_image_gallery_classes',
    array(
        'woocommerce-product-gallery',
        'woocommerce-product-gallery--' . ( $post_thumbnail_id ? 'with-images' : 'without-images' ),
        'woocommerce-product-gallery--columns-' . absint( $columns ),
        'images',
        // Remove zoom class
        'disable-zoom'
    )
);
?>

<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>" style="opacity: 0; transition: opacity .25s ease-in-out;">
    <div class="woocommerce-product-gallery__wrapper swipe-wrapper">
        <?php
        if ( $post_thumbnail_id ) {
            echo '<div class="swipe-slide">' . wc_get_gallery_image_html( $post_thumbnail_id, true ) . '</div>';
        }

        $attachment_ids = $product->get_gallery_image_ids();
        if ( $attachment_ids ) {
            foreach ( $attachment_ids as $attachment_id ) {
                echo '<div class="swipe-slide">' . wc_get_gallery_image_html( $attachment_id, true ) . '</div>';
            }
        }
        ?>
    </div>
    <button class="prev-button" aria-label="Previous">
        <div class="gallery-product-image-btn-left gn-btn-left">
            <span class="arrow">
                <span></span>
                <span></span>
            </span>
        </div>
    </button>
    <button class="next-button" aria-label="Next">
        <div class="gallery-product-image-btn-right gn-btn-right">
            <span class="arrow">
                <span></span>
                <span></span>
            </span>
        </div>
    </button>
</div>
