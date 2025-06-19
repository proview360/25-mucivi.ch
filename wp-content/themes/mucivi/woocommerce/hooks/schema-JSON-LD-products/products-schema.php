<?php
/**
 * Copyright (c) 2024 by WebThinker GmbH
 *
 * All rights are reserved. Reproduction or transmission in whole or in part, in
 * any form or by any means, electronic, mechanical or otherwise, forbidden
 * without the prior written consent of the copyright owner.
 *
 * Functions and definitions
 *
 * @package WordPress
 * @subpackage mucivi
 * @author Granit Nebiu
 * @since 1.0
 */


//remove schema from yoast for products
add_filter('woocommerce_structured_data_product', '__return_false');
add_filter('woocommerce_structured_data', '__return_false');


//add custom schema product data.
add_action('wp_footer', 'add_custom_product_json_ld');

function add_custom_product_json_ld() {
    if (is_product()) { // Ensure this runs only on product pages
        global $product;

        if (!$product) {
            return;
        }


        // Get product categories
        $categories = wp_get_post_terms($product->get_id(), 'product_cat');
        $category_names = !empty($categories) ? $categories[0]->name : "";

        // Aggregate Rating and Reviews
        $rating_count = $product->get_rating_count();
        $review_count = $product->get_review_count();
        $average_rating = $product->get_average_rating();

        // Product dimensions and weight
        $dimensions = $product->has_dimensions() ? $product->get_dimensions() : null;
        $weight = $product->has_weight() ? $product->get_weight() : null;

        // Gather product data
        $product_data = array(
            "@context" => "https://schema.org/",
            "@type" => "Product",
            "@id" => get_permalink($product->get_id()) . "#product",
            "name" => $product->get_name(),
            "url" => get_permalink($product->get_id()),
            "description" => wp_strip_all_tags($product->get_short_description() ?: $product->get_description()),
            "image" => wp_get_attachment_url($product->get_image_id()),
            "sku" => $product->get_sku(),
            "brand" => array(
                "@type" => "Brand",
                "name" => "muciviec"
            ),
            "category" => $category_names,
            "gtin13" => get_post_meta($product->get_id(), '_custom_gtin', true), // GTIN if available
            "offers" => array(
                "@type" => "Offer",
                "price" => $product->get_price(),
                "priceCurrency" => get_woocommerce_currency(),
                "availability" => $product->is_in_stock() ? "https://schema.org/InStock" : "https://schema.org/OutOfStock",
                "itemCondition" => "https://schema.org/NewCondition",
                "url" => get_permalink($product->get_id()),
                "seller" => array(
                    "@type" => "Organization",
                    "name" => get_bloginfo('name'),
                    "url" => home_url()
                )
            )
        );

        // Include aggregateRating if reviews exist
        if ($rating_count > 0) {
            $product_data['aggregateRating'] = array(
                "@type" => "AggregateRating",
                "ratingValue" => $average_rating,
                "reviewCount" => $review_count
            );
        }

        // Include reviews if available
        if ($review_count > 0) {
            $reviews = array();
            $comments = get_comments(array('post_id' => $product->get_id(), 'status' => 'approve'));
            foreach ($comments as $comment) {
                $reviews[] = array(
                    "@type" => "Review",
                    "author" => $comment->comment_author,
                    "datePublished" => $comment->comment_date,
                    "reviewBody" => $comment->comment_content,
                    "reviewRating" => array(
                        "@type" => "Rating",
                        "ratingValue" => get_comment_meta($comment->comment_ID, 'rating', true)
                    )
                );
            }
            $product_data['review'] = $reviews;
        }

        // Include dimensions and weight if available
        if ($dimensions || $weight) {
            $product_data['additionalProperty'] = array();

            if ($dimensions) {
                $product_data['additionalProperty'][] = array(
                    "@type" => "PropertyValue",
                    "name" => "Dimensions",
                    "value" => $dimensions
                );
            }

            if ($weight) {
                $product_data['additionalProperty'][] = array(
                    "@type" => "PropertyValue",
                    "name" => "Weight",
                    "value" => $weight . " kg"
                );
            }
        }

        // Output JSON-LD script
        echo '<script type="application/ld+json">' . wp_json_encode($product_data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>';
    }

}


