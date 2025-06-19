<?php
	
	// Disable comments support in post types
	add_action('admin_init', function () {
		foreach (get_post_types() as $post_type) {
			if (post_type_supports($post_type, 'comments')) {
				remove_post_type_support($post_type, 'comments');
				remove_post_type_support($post_type, 'trackbacks');
			}
		}
	});
	
	// Close comments on the front-end
	add_filter('comments_open', '__return_false', 20, 2);
	add_filter('pings_open', '__return_false', 20, 2);
	
	// Hide existing comments
	add_filter('comments_array', '__return_empty_array', 10, 2);
	
	// Remove "Comments" from admin menu
	add_action('admin_menu', function () {
		remove_menu_page('edit-comments.php');
	});

	
	/* woocomerce */
	// add theme support woocommerce
	function mucivi_add_woocommerce_support() {
		add_theme_support( 'woocommerce' );
	}
	add_action( 'after_setup_theme', 'mucivi_add_woocommerce_support' );
	
	// remove woocommerce_results_count
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
	
	function update_cart_count() {
		echo WC()->cart->get_cart_contents_count();
		wp_die(); // this is required to terminate immediately and return a proper response
	}
	add_action('wp_ajax_nopriv_update_cart_count', 'update_cart_count');
	add_action('wp_ajax_update_cart_count', 'update_cart_count');

	require get_template_directory() . '/woocommerce/hooks/custom-header-search/custom-header-search.php';
	require get_template_directory() . '/woocommerce/hooks/custom-header-search/custom-header-search-mobile.php';
	require get_template_directory() . '/woocommerce/hooks/select-filter-custom.php';
	
	// Add ID column to product admin page.
	add_filter( 'manage_edit-product_columns', 'show_product_id', 15 );
	function show_product_id($columns){
		// Add column
		$columns['product_id'] = __( 'Product ID', 'woocommerce' );
		
		return $columns;
	}
	
	// Add the data to the ID column.
	add_action( 'manage_product_posts_custom_column' , 'product_custom_columns_content', 10, 2 );
	function product_custom_columns_content( $column, $post_id ) {
		global $post;
		
		switch ( $column ) {
			case 'product_id' :
				echo $post->ID;
				break;
		}
	}
	
	
	add_filter( 'woocommerce_show_page_title', 'remove_shop_page_title' );
	
	function remove_shop_page_title( $show ) {
		if ( is_shop() ) {
			return false;
		}
		return $show;
	}
	
	function encode_mail($email) {
		$encoded = '';
		for ($i = 0; $i < strlen($email); $i++) {
			$encoded .= '&#' . ord($email[$i]) . ';';
		}
		return $encoded;
	}
