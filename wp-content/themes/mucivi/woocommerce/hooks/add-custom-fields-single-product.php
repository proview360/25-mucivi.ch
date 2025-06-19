<?php
// Add extra custom fields
function woo_add_custom_general_fields() {

    global $woocommerce, $post;

    echo '<div class="options_group">';

    // Custom fields will go here...
    woocommerce_wp_text_input(
        array(
            'id'          => 'brand_name',
            'label'       => __( 'Brand Name', 'woocommerce' ),
            'placeholder' => 'Enter brand name',
            'desc_tip'    => 'true',
            'description' => __( 'Enter the product brand name here.', 'woocommerce' )
        )
    );

    // Add Delivery Time field
    woocommerce_wp_text_input(
        array(
            'id'          => 'delivery_time',
            'label'       => __( 'Delivery Time', 'woocommerce' ),
            'placeholder' => 'Enter Delivery Time',
            'desc_tip'    => 'true',
            'description' => __( 'Enter the delivery time here.', 'woocommerce' )
        )
    );

    echo '</div>';
}

add_action( 'woocommerce_process_product_meta', 'woo_add_custom_general_fields_save' );

function woo_add_custom_general_fields_save( $post_id ){

    // Save Brand Name
    $woocommerce_brand_name = $_POST['brand_name'];
    if( !empty( $woocommerce_brand_name ) ) {
        update_post_meta( $post_id, 'brand_name', sanitize_text_field( $woocommerce_brand_name ) );
    } else {
        delete_post_meta( $post_id, 'brand_name' );
    }

    // Save Delivery Time
    $woocommerce_delivery_time = $_POST['delivery_time'];
    if( !empty( $woocommerce_delivery_time ) ) {
        update_post_meta( $post_id, 'delivery_time', sanitize_text_field( $woocommerce_delivery_time ) );
    } else {
        delete_post_meta( $post_id, 'delivery_time' );
    }
}