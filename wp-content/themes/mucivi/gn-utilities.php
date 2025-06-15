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
