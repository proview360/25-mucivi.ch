<?php
	
	/* Add Custom Post Type - links */
	function add_custom_post_type_links() {
		$labels = array(
			'name' => _x( 'links', 'Post Type General Name', "mucivi" ),
			'singular_name' => _x( 'links', 'Post Type Singular Name', "mucivi" ),
			'menu_name' => __( 'links', "mucivi" ),
			'name_admin_bar' => __( 'links', "mucivi" ),
			'archives' => __( 'links Archives', "mucivi" ),
			'attributes' => __( 'links Attributes', "mucivi" ),
			'parent_item_colon' => __( 'Parent links:', "mucivi" ),
			'all_items' => __( 'All links', "mucivi" ),
			'add_new_item' => __( 'Add New links', "mucivi" ),
			'add_new' => __( 'Add New', "mucivi" ),
			'new_item' => __( 'New links', "mucivi" ),
			'edit_item' => __( 'Edit links', "mucivi" ),
			'update_item' => __( 'Update links', "mucivi" ),
			'view_item' => __( 'View links', "mucivi" ),
			'view_items' => __( 'View links', "mucivi" ),
			'search_items' => __( 'Search links', "mucivi" ),
			'not_found' => __( 'Not found', "mucivi" ),
			'not_found_in_trash' => __( 'Not found in Trash', "mucivi" ),
			'insert_into_item' => __( 'Insert into links', "mucivi" ),
			'uploaded_to_this_item' => __( 'Uploaded to this links', "mucivi" ),
			'items_list' => __( 'links list', "mucivi" ),
			'items_list_navigation' => __( 'links list navigation', "mucivi" ),
			'filter_items_list' => __( 'Filter links list', "mucivi" ),
		);
		
		$args = array(
			'label' => __( 'links', "mucivi" ),
			'description' => __( 'links', "mucivi" ),
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
		
		register_post_type( 'links', $args );
	}
	add_action("init", "add_custom_post_type_links");
	
	// add HTML for links CPT
	function add_links_meta_box() {
		
		$text = __( 'links information', "mucivi" );
		
		add_meta_box(
			'links_fields_meta_box',
			$text,
			'show_links_custom_fields',
			'links'
		);
	}
	add_action( 'add_meta_boxes', 'add_links_meta_box' );
	
	// saves metas for CPT links
	function save_custom_post_links_metas( $post_id ) {
		
		$metaNonce    = "linksMetaNonce";
		$saveFields   = "linksFields";
		$fields       = "links_fields";
		
		return save_custom_post_metas($post_id, $metaNonce, $saveFields, $fields);
	}
	add_action( 'save_post', 'save_custom_post_links_metas' );
	/* END - Add Custom Post Type - links */



