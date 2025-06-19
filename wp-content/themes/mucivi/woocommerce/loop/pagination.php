<?php
/**
 * Pagination - Show numbered pagination for catalog pages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/pagination.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.3.1
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$total   = isset( $total ) ? $total : wc_get_loop_prop( 'total_pages' );
$current = isset( $current ) ? $current : wc_get_loop_prop( 'current_page' );
$base    = isset( $base ) ? $base : esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
$format  = isset( $format ) ? $format : '';

// SVG for left arrow
$prev_arrow = '<div class="pagination-icon-left"> </div>';

// SVG for right arrow
$next_arrow = '<div class="pagination-icon-right"> </div>';

// Your disabled SVG or HTML for left arrow, do replace as needed
$prev_arrow_disabled = '';

// Your disabled SVG or HTML for right arrow, do replace as needed
$next_arrow_disabled = '';

?>
<nav class="woocommerce-pagination">

    <?php

    if ( $total <= 1 ) {
        $prev_arrow = $current <= 1 ? $prev_arrow_disabled : $prev_arrow;
        $next_arrow = $current >= $total ? $next_arrow_disabled : $next_arrow;

        echo '<div class="woocommerce-pagination">';
        echo '<ul class="page-numbers">';
        echo '<li><span class="page-numbers prev">' . $prev_arrow . '</span></li>';
        echo '<li><span class="page-numbers next">' . $next_arrow . '</span></li>';
        echo '</ul>';
        echo '</div>';

        return;
    }

    echo paginate_links(
        apply_filters(
            'woocommerce_pagination_args',
            array( // WPCS: XSS ok.
                'base'      => $base,
                'format'    => $format,
                'add_args'  => false,
                'current'   => max( 1, $current ),
                'total'     => $total,
                'prev_text' => $prev_arrow,
                'next_text' => $next_arrow,
                'type'      => 'list',
                'end_size'  => 3,
                'mid_size'  => 3,
            )
        )
    );

    ?>

</nav>