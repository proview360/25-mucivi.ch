<?php
	get_header();
?>

<?php if ( is_shop() ) : ?>
    <main class="">
		
		<?php
			// Manually fetch the content of the Shop page
			$shop_page_id = get_option( 'woocommerce_shop_page_id' );
			$shop_page = get_post( $shop_page_id );
			if ( $shop_page ) {
				echo apply_filters( 'the_content', $shop_page->post_content );
			}
		?>

    </main>
<?php else : ?>
    <main class="container">
		<?php woocommerce_content(); ?>
    </main>
<?php endif; ?>

<?php
	get_footer();
