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

get_header('shop');

// Make sure we're on a shop page
if ( is_shop() || is_product_category() || is_product_tag() ) {

    // Get the content of the current page
    $content = apply_filters( 'the_content', get_post_field('post_content', get_option('woocommerce_shop_page_id')) );

    echo '<div class="content-wrapper shop-container pt-4 pb-5">
            <h1 class="shop-title">' . __('Shop', 'mucivi') . '</h1>'
                . $content .
        '</div>';

} else {

    // Include the WooCommmerce content if it isn't a shop page
    wc_get_template_part( 'content', 'product' );

}

get_footer('shop');
?>