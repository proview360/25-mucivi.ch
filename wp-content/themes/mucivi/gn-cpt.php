<?php
	
	/* Add Custom Post Type - announcements */
	function add_custom_post_type_announcements() {
		$labels = array(
			'name' => _x( 'Announcements', 'Post Type General Name', "mucivi" ),
			'singular_name' => _x( 'Announcements', 'Post Type Singular Name', "mucivi" ),
			'menu_name' => __( 'Announcements', "mucivi" ),
			'name_admin_bar' => __( 'Announcements', "mucivi" ),
			'archives' => __( 'Announcements Archives', "mucivi" ),
			'attributes' => __( 'Announcements Attributes', "mucivi" ),
			'parent_item_colon' => __( 'Parent Announcements:', "mucivi" ),
			'all_items' => __( 'All Announcements', "mucivi" ),
			'add_new_item' => __( 'Add New Announcements', "mucivi" ),
			'add_new' => __( 'Add New', "mucivi" ),
			'new_item' => __( 'New Announcements', "mucivi" ),
			'edit_item' => __( 'Edit Announcements', "mucivi" ),
			'update_item' => __( 'Update Announcements', "mucivi" ),
			'view_item' => __( 'View Announcements', "mucivi" ),
			'view_items' => __( 'View Announcements', "mucivi" ),
			'search_items' => __( 'Search Announcements', "mucivi" ),
			'not_found' => __( 'Not found', "mucivi" ),
			'not_found_in_trash' => __( 'Not found in Trash', "mucivi" ),
			'insert_into_item' => __( 'Insert into Announcements', "mucivi" ),
			'uploaded_to_this_item' => __( 'Uploaded to this Announcements', "mucivi" ),
			'items_list' => __( 'Announcements list', "mucivi" ),
			'items_list_navigation' => __( 'Announcements list navigation', "mucivi" ),
			'filter_items_list' => __( 'Filter Announcements list', "mucivi" ),
		);
		
		$args = array(
			'label' => __( 'Announcements', "mucivi" ),
			'description' => __( 'Announcements', "mucivi" ),
			'labels' => $labels,
			'supports' => array( 'title' ),
			'public' => true,
			'show_in_rest' => true,
			'show_ui' => true,
			'menu_position' => 39,
			'menu_icon' => 'dashicons-megaphone',
			'has_archive' => true,
			'exclude_from_search' => true,
			'publicly_queryable' => false,
			'show_in_nav_menus' => false,
		);
		
		register_post_type( 'Announcements', $args );
	}
	add_action("init", "add_custom_post_type_announcements");
	
	// add HTML for announcements CPT
	function add_announcements_meta_box() {
		
		$text = __( 'Announcements information', "mucivi" );
		
		add_meta_box(
			'announcements_fields_meta_box',
			$text,
			'show_announcements_custom_fields',
			'Announcements'
		);
	}
	add_action( 'add_meta_boxes', 'add_announcements_meta_box' );
	
	// saves metas for CPT announcements
	function save_custom_post_announcements_metas( $post_id ) {
		
		$metaNonce    = "announcementsMetaNonce";
		$saveFields   = "announcementsFields";
		$fields       = "announcements_fields";
		
		return save_custom_post_metas($post_id, $metaNonce, $saveFields, $fields);
	}
	add_action( 'save_post', 'save_custom_post_announcements_metas' );
	/* END - Add Custom Post Type - announcements */

