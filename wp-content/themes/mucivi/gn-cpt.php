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

/* Add Custom Post Type - Sliders */
function add_custom_post_type_sliders() {
    $labels = array(
        'name' => _x( 'Sliders', 'Post Type General Name', "mucivi" ),
        'singular_name' => _x( 'Sliders', 'Post Type Singular Name', "mucivi" ),
        'menu_name' => __( 'Sliders', "mucivi" ),
        'name_admin_bar' => __( 'Sliders', "mucivi" ),
        'archives' => __( 'Sliders Archives', "mucivi" ),
        'attributes' => __( 'Sliders Attributes', "mucivi" ),
        'parent_item_colon' => __( 'Parent Sliders:', "mucivi" ),
        'all_items' => __( 'All Sliders', "mucivi" ),
        'add_new_item' => __( 'Add New Sliders', "mucivi" ),
        'add_new' => __( 'Add New', "mucivi" ),
        'new_item' => __( 'New Sliders', "mucivi" ),
        'edit_item' => __( 'Edit Sliders', "mucivi" ),
        'update_item' => __( 'Update Sliders', "mucivi" ),
        'view_item' => __( 'View Sliders', "mucivi" ),
        'view_items' => __( 'View Sliders', "mucivi" ),
        'search_items' => __( 'Search Sliders', "mucivi" ),
        'not_found' => __( 'Not found', "mucivi" ),
        'not_found_in_trash' => __( 'Not found in Trash', "mucivi" ),
        'insert_into_item' => __( 'Insert into Sliders', "mucivi" ),
        'uploaded_to_this_item' => __( 'Uploaded to this Sliders', "mucivi" ),
        'items_list' => __( 'Sliders list', "mucivi" ),
        'items_list_navigation' => __( 'Sliders list navigation', "mucivi" ),
        'filter_items_list' => __( 'Filter Sliders list', "mucivi" ),
    );

    $args = array(
        'label' => __( 'Sliders', "mucivi" ),
        'description' => __( 'Sliders', "mucivi" ),
        'labels' => $labels,
        'supports' => array( 'title' ),
        'public' => true,
        'show_in_rest' => true,
        'show_ui' => true,
        'menu_position' => 39,
        'menu_icon' => 'dashicons-images-alt2',
        'has_archive' => true,
        'exclude_from_search' => true,
        'publicly_queryable' => false,
        'show_in_nav_menus' => false,
    );

    register_post_type( 'Sliders', $args );
}
add_action("init", "add_custom_post_type_sliders");

// add HTML for Sliders CPT
function add_sliders_meta_box() {

    $text = __( 'Sliders information', "mucivi" );

    add_meta_box(
        'sliders_fields_meta_box',
        $text,
        'show_sliders_custom_fields',
        'Sliders'
    );
}
add_action( 'add_meta_boxes', 'add_sliders_meta_box' );

// saves metas for CPT Sliders
function save_custom_post_sliders_metas( $post_id ) {

    $metaNonce    = "slidersMetaNonce";
    $saveFields   = "slidersFields";
    $fields       = "sliders_fields";

    return save_custom_post_metas($post_id, $metaNonce, $saveFields, $fields);
}
add_action( 'save_post', 'save_custom_post_sliders_metas' );
/* END - Add Custom Post Type - Sliders */


/* Add Custom Post Type - Hexagons */
function add_custom_post_type_hexagons() {
    $labels = array(
        'name' => _x( 'Hexagons', 'Post Type General Name', "mucivi" ),
        'singular_name' => _x( 'Hexagons', 'Post Type Singular Name', "mucivi" ),
        'menu_name' => __( 'Hexagons', "mucivi" ),
        'name_admin_bar' => __( 'Hexagons', "mucivi" ),
        'archives' => __( 'Hexagons Archives', "mucivi" ),
        'attributes' => __( 'Hexagons Attributes', "mucivi" ),
        'parent_item_colon' => __( 'Parent Hexagons:', "mucivi" ),
        'all_items' => __( 'All Hexagons', "mucivi" ),
        'add_new_item' => __( 'Add New Hexagons', "mucivi" ),
        'add_new' => __( 'Add New', "mucivi" ),
        'new_item' => __( 'New Hexagons', "mucivi" ),
        'edit_item' => __( 'Edit Hexagons', "mucivi" ),
        'update_item' => __( 'Update Hexagons', "mucivi" ),
        'view_item' => __( 'View Hexagons', "mucivi" ),
        'view_items' => __( 'View Hexagons', "mucivi" ),
        'search_items' => __( 'Search Hexagons', "mucivi" ),
        'not_found' => __( 'Not found', "mucivi" ),
        'not_found_in_trash' => __( 'Not found in Trash', "mucivi" ),
        'insert_into_item' => __( 'Insert into Hexagons', "mucivi" ),
        'uploaded_to_this_item' => __( 'Uploaded to this Hexagons', "mucivi" ),
        'items_list' => __( 'Hexagons list', "mucivi" ),
        'items_list_navigation' => __( 'Hexagons list navigation', "mucivi" ),
        'filter_items_list' => __( 'Filter Hexagons list', "mucivi" ),
    );

    $args = array(
        'label' => __( 'Hexagons', "mucivi" ),
        'description' => __( 'Hexagons', "mucivi" ),
        'labels' => $labels,
        'supports' => array( 'title' ),
        'public' => true,
        'show_in_rest' => true,
        'show_ui' => true,
        'menu_position' => 39,
        'menu_icon' => 'dashicons-images-alt2',
        'has_archive' => true,
        'exclude_from_search' => true,
        'publicly_queryable' => false,
        'show_in_nav_menus' => false,
    );

    register_post_type( 'Hexagons', $args );
}
add_action("init", "add_custom_post_type_Hexagons");

// add HTML for Hexagons CPT
function add_hexagons_meta_box() {

    $text = __( 'Hexagons information', "mucivi" );

    add_meta_box(
        'hexagons_fields_meta_box',
        $text,
        'show_hexagons_custom_fields',
        'Hexagons'
    );
}
add_action( 'add_meta_boxes', 'add_hexagons_meta_box' );

// saves metas for CPT Hexagons
function save_custom_post_hexagons_metas( $post_id ) {

    $metaNonce    = "hexagonsMetaNonce";
    $saveFields   = "hexagonsFields";
    $fields       = "hexagons_fields";

    return save_custom_post_metas($post_id, $metaNonce, $saveFields, $fields);
}
add_action( 'save_post', 'save_custom_post_hexagons_metas' );

function save_custom_post_hexagons_row_2_metas( $post_id ) {

    $metaNonce    = "hexagonsMetaNonceRow2";
    $saveFields   = "hexagonsFieldsRow2";
    $fields       = "hexagons_fields_row2";

    return save_custom_post_metas($post_id, $metaNonce, $saveFields, $fields);
}
add_action( 'save_post', 'save_custom_post_hexagons_row_2_metas' );
/* END - Add Custom Post Type - hexagons */


/* Add Custom Post Type - Employee  */
function add_custom_post_type_employee() {

    $labels = array(
        'name' => _x( 'Employee', 'Post Type General Name', 'mucivi' ),
        'singular_name' => _x( 'Employee', 'Post Type Singular Name', 'mucivi' ),
        'menu_name' => __( 'Employee', 'mucivi' ),
        'name_admin_bar' => __( 'Employee', 'mucivi' ),
        'archives' => __( 'Employee Archives', 'mucivi' ),
        'attributes' => __( 'Employee Attributes', 'mucivi' ),
        'parent_item_colon' => __( 'Parent Employee:', 'mucivi' ),
        'all_items' => __( 'All Employees', 'mucivi' ),
        'add_new_item' => __( 'Add New Employee', 'mucivi' ),
        'add_new' => __( 'Add New', 'mucivi' ),
        'new_item' => __( 'New Employee', 'mucivi' ),
        'edit_item' => __( 'Edit Employee', 'mucivi' ),
        'update_item' => __( 'Update Employee', 'mucivi' ),
        'view_item' => __( 'View Employee', 'mucivi' ),
        'view_items' => __( 'View Employees', 'mucivi' ),
        'search_items' => __( 'Search Employee', 'mucivi' ),
        'not_found' => __( 'Not found', 'mucivi' ),
        'not_found_in_trash' => __( 'Not found in Trash', 'mucivi' ),
        'featured_image' => __( 'Employee Image', 'mucivi' ),
        'set_featured_image' => __( 'Set Employee image', 'mucivi' ),
        'remove_featured_image' => __( 'Remove Employee ', 'mucivi' ),
        'use_featured_image' => __( 'Use as Employee ', 'mucivi' ),
        'insert_into_item' => __( 'Insert into Employee', 'mucivi' ),
        'uploaded_to_this_item' => __( 'Uploaded to this Employee', 'mucivi' ),
        'items_list' => __( 'Employee list', 'mucivi' ),
        'items_list_navigation' => __( 'Employee list navigation', 'mucivi' ),
        'filter_items_list' => __( 'Filter Employee list', 'mucivi' ),
    );

    $args = array(
        'label' => __( 'Employee', 'mucivi' ),
        'description' => __( 'Employee', 'mucivi' ),
        'labels' => $labels,
        'supports' => array( 'title'),
        'public' => true,
        'show_in_rest' => true,
        'show_ui' => true,
        'menu_position' => 38,
        'menu_icon' => 'dashicons-businessperson',
        'has_archive' => true,
        'exclude_from_search' => true,
        'publicly_queryable' => false,
        'show_in_nav_menus' => false,
    );

    register_post_type( 'Employee', $args );
}
add_action("init", "add_custom_post_type_employee");

// add HTML for Reference CPT
function add_employee_meta_box() {

    $text = __( 'Employee information', 'mucivi' );

    add_meta_box(
        'employee_fields_meta_box',
        $text,
        'show_employee_custom_fields',
        'Employee'
    );
}
add_action( 'add_meta_boxes', 'add_employee_meta_box' );

// saves metas for CPT Reference
function save_custom_post_employee_metas( $post_id ) {

    $metaNonce    = "employeeMetaNonce";
    $saveFields   = "saveEmployeeFields";
    $fields       = "employee_fields";

    return save_custom_post_metas($post_id, $metaNonce, $saveFields, $fields);
}
add_action( 'save_post', 'save_custom_post_employee_metas' );
/* END - Add Custom Post Type - Employee */


/* Add Custom Post Type - Testimonial */
function add_custom_post_type_testimonial() {

    $labels = array(
        'name' => _x( 'Testimonial', 'Post Type General Name', "mucivi" ),
        'singular_name' => _x( 'Testimonial', 'Post Type Singular Name', "mucivi" ),
        'menu_name' => __( 'Testimonials', "mucivi" ),
        'name_admin_bar' => __( 'Testimonials', "mucivi" ),
        'archives' => __( 'Testimonial Archives', "mucivi" ),
        'attributes' => __( 'Testimonial Attributes', "mucivi" ),
        'parent_item_colon' => __( 'Parent Testimonial:', "mucivi" ),
        'all_items' => __( 'All Testimonials', "mucivi" ),
        'add_new_item' => __( 'Add New Testimonial', "mucivi" ),
        'add_new' => __( 'Add New', "mucivi" ),
        'new_item' => __( 'New Testimonial', "mucivi" ),
        'edit_item' => __( 'Edit Testimonial', "mucivi" ),
        'update_item' => __( 'Update Testimonial', "mucivi" ),
        'view_item' => __( 'View Testimonial', "mucivi" ),
        'view_items' => __( 'View Testimonials', "mucivi" ),
        'search_items' => __( 'Search Testimonial', "mucivi" ),
        'not_found' => __( 'Not found', "mucivi" ),
        'not_found_in_trash' => __( 'Not found in Trash', "mucivi" ),
        'featured_image' => __( 'Testimonial Image', "mucivi" ),
        'set_featured_image' => __( 'Set Testimonial image', "mucivi" ),
        'remove_featured_image' => __( 'Remove Testimonial image', "mucivi" ),
        'use_featured_image' => __( 'Use as Testimonial image', "mucivi" ),
        'insert_into_item' => __( 'Insert into Testimonial', "mucivi" ),
        'uploaded_to_this_item' => __( 'Uploaded to this Testimonial', "mucivi" ),
        'items_list' => __( 'Testimonials list', "mucivi" ),
        'items_list_navigation' => __( 'Testimonials list navigation', "mucivi" ),
        'filter_items_list' => __( 'Filter Testimonial list', "mucivi" ),
    );

    $args = array(
        'label' => __( 'Testimonial', "mucivi" ),
        'description' => __( 'Testimonial', "mucivi" ),
        'labels' => $labels,
        'supports' => array( 'title'),
        'public' => true,
        'show_in_rest' => true,
        'show_ui' => true,
        'menu_position' => 40,
        'menu_icon' => 'dashicons-admin-comments',
        'exclude_from_search' => true,
        'publicly_queryable' => false,
        'show_in_nav_menus' => false,
    );

    register_post_type( 'Testimonial', $args );
}
add_action("init", "add_custom_post_type_testimonial");

// add HTML for Testimonial CPT
function add_testimonial_meta_box() {

    $text = __( 'Testimonial information', "mucivi" );

    add_meta_box(
        'testimonial_fields_meta_box',
        $text,
        'show_testimonial_custom_fields',
        'Testimonial'
    );
}
add_action( 'add_meta_boxes', 'add_testimonial_meta_box' );

// saves metas for CPT Testimonial
function save_custom_post_testimonial_metas( $post_id ) {

    $metaNonce    = "testimonial_meta_nonce";
    $saveFields   = "save_testimonial_fields";
    $fields       = "testimonial_fields";

    return save_custom_post_metas($post_id, $metaNonce, $saveFields, $fields);
}
add_action( 'save_post', 'save_custom_post_testimonial_metas' );
/* END - Add Custom Post Type - Testimonial */



/* Add Custom Post Type - Teasers */
function add_custom_post_type_teasers() {
    $labels = array(
        'name' => _x( 'Teasers', 'Post Type General Name', "mucivi" ),
        'singular_name' => _x( 'Teasers', 'Post Type Singular Name', "mucivi" ),
        'menu_name' => __( 'Teasers', "mucivi" ),
        'name_admin_bar' => __( 'Teasers', "mucivi" ),
        'archives' => __( 'Teasers Archives', "mucivi" ),
        'attributes' => __( 'Teasers Attributes', "mucivi" ),
        'parent_item_colon' => __( 'Parent Teasers:', "mucivi" ),
        'all_items' => __( 'All Teasers', "mucivi" ),
        'add_new_item' => __( 'Add New Teasers', "mucivi" ),
        'add_new' => __( 'Add New', "mucivi" ),
        'new_item' => __( 'New Teasers', "mucivi" ),
        'edit_item' => __( 'Edit Teasers', "mucivi" ),
        'update_item' => __( 'Update Teasers', "mucivi" ),
        'view_item' => __( 'View Teasers', "mucivi" ),
        'view_items' => __( 'View Teasers', "mucivi" ),
        'search_items' => __( 'Search Teasers', "mucivi" ),
        'not_found' => __( 'Not found', "mucivi" ),
        'not_found_in_trash' => __( 'Not found in Trash', "mucivi" ),
        'insert_into_item' => __( 'Insert into Teasers', "mucivi" ),
        'uploaded_to_this_item' => __( 'Uploaded to this Teasers', "mucivi" ),
        'items_list' => __( 'Teasers list', "mucivi" ),
        'items_list_navigation' => __( 'Teasers list navigation', "mucivi" ),
        'filter_items_list' => __( 'Filter Teasers list', "mucivi" ),
    );

    $args = array(
        'label' => __( 'Teasers', "mucivi" ),
        'description' => __( 'Teasers', "mucivi" ),
        'labels' => $labels,
        'supports' => array( 'title' ),
        'public' => true,
        'show_in_rest' => true,
        'show_ui' => true,
        'menu_position' => 39,
        'menu_icon' => 'dashicons-images-alt2',
        'has_archive' => true,
        'exclude_from_search' => true,
        'publicly_queryable' => false,
        'show_in_nav_menus' => false,
    );

    register_post_type( 'Teasers', $args );
}
add_action("init", "add_custom_post_type_teasers");

// add HTML for Teasers CPT
function add_teasers_meta_box() {

    $text = __( 'Teasers information', "mucivi" );

    add_meta_box(
        'teasers_fields_meta_box',
        $text,
        'show_teasers_custom_fields',
        'Teasers'
    );
}
add_action( 'add_meta_boxes', 'add_teasers_meta_box' );

// saves metas for CPT Teasers
function save_custom_post_teasers_metas( $post_id ) {

    $metaNonce    = "teasersMetaNonce";
    $saveFields   = "teasersFields";
    $fields       = "teasers_fields";

    return save_custom_post_metas($post_id, $metaNonce, $saveFields, $fields);
}
add_action( 'save_post', 'save_custom_post_teasers_metas' );
/* END - Add Custom Post Type - Teasers */




/* Add Custom Post Type - Portfolios */
function add_custom_post_type_portfolios() {
    $labels = array(
        'name' => _x( 'Portfolios', 'Post Type General Name', "mucivi" ),
        'singular_name' => _x( 'Portfolios', 'Post Type Singular Name', "mucivi" ),
        'menu_name' => __( 'Portfolios', "mucivi" ),
        'name_admin_bar' => __( 'Portfolios', "mucivi" ),
        'archives' => __( 'Portfolios Archives', "mucivi" ),
        'attributes' => __( 'Portfolios Attributes', "mucivi" ),
        'parent_item_colon' => __( 'Parent Portfolios:', "mucivi" ),
        'all_items' => __( 'All Portfolios', "mucivi" ),
        'add_new_item' => __( 'Add New Portfolios', "mucivi" ),
        'add_new' => __( 'Add New', "mucivi" ),
        'new_item' => __( 'New Portfolios', "mucivi" ),
        'edit_item' => __( 'Edit Portfolios', "mucivi" ),
        'update_item' => __( 'Update Portfolios', "mucivi" ),
        'view_item' => __( 'View Portfolios', "mucivi" ),
        'view_items' => __( 'View Portfolios', "mucivi" ),
        'search_items' => __( 'Search Portfolios', "mucivi" ),
        'not_found' => __( 'Not found', "mucivi" ),
        'not_found_in_trash' => __( 'Not found in Trash', "mucivi" ),
        'insert_into_item' => __( 'Insert into Portfolios', "mucivi" ),
        'uploaded_to_this_item' => __( 'Uploaded to this Portfolios', "mucivi" ),
        'items_list' => __( 'Portfolios list', "mucivi" ),
        'items_list_navigation' => __( 'Portfolios list navigation', "mucivi" ),
        'filter_items_list' => __( 'Filter Portfolios list', "mucivi" ),
    );

    $args = array(
        'label' => __( 'Portfolios', "mucivi" ),
        'description' => __( 'Portfolios', "mucivi" ),
        'labels' => $labels,
        'supports' => array( 'title' ),
        'public' => true,
        'show_ui' => true,
        'show_in_rest' => true,
        'show_in_menu' => false, // hide from sidebar menu
        'has_archive' => true,
        'exclude_from_search' => true,
        'publicly_queryable' => false,
        'show_in_nav_menus' => false,

        // ✅ Capability setup
        'capability_type' => 'post',
        'map_meta_cap' => true,
    );

    register_post_type( 'Portfolios', $args );
}
add_action("init", "add_custom_post_type_portfolios");

// add HTML for Portfolios CPT
function add_portfolios_meta_box() {

    $text = __( 'Portfolios information', "mucivi" );

    add_meta_box(
        'portfolios_fields_meta_box',
        $text,
        'show_portfolios_custom_fields',
        'Portfolios'
    );
}
add_action( 'add_meta_boxes', 'add_portfolios_meta_box' );

// saves metas for CPT Portfolios
function save_custom_post_portfolios_metas( $post_id ) {

    $metaNonce    = "portfoliosMetaNonce";
    $saveFields   = "portfoliosFields";
    $fields       = "portfolios_fields";

    return save_custom_post_metas($post_id, $metaNonce, $saveFields, $fields);
}
add_action( 'save_post', 'save_custom_post_portfolios_metas' );
/* END - Add Custom Post Type - Portfolios */


/* Add Custom Post Type - Portfolio 3d Computer Graphics */
function add_custom_post_type_portfolio_3d_computer_graphics() {
    $labels = array(
        'name' => _x( 'Portfolio 3d Computer Graphics', 'Post Type General Name', "mucivi" ),
        'singular_name' => _x( 'Portfolio 3d Computer Graphics', 'Post Type Singular Name', "mucivi" ),
        'menu_name' => __( 'Portfolio 3d Computer Graphics', "mucivi" ),
        'name_admin_bar' => __( 'Portfolio 3d Computer Graphics', "mucivi" ),
        'archives' => __( 'Portfolio 3d Computer Graphics Archives', "mucivi" ),
        'attributes' => __( 'Portfolio 3d Computer Graphics Attributes', "mucivi" ),
        'parent_item_colon' => __( 'Parent Portfolio 3d Computer Graphics:', "mucivi" ),
        'all_items' => __( 'All Portfolio 3d Computer Graphics', "mucivi" ),
        'add_new_item' => __( 'Add New Portfolio 3d Computer Graphics', "mucivi" ),
        'add_new' => __( 'Add New', "mucivi" ),
        'new_item' => __( 'New Portfolio 3d Computer Graphics', "mucivi" ),
        'edit_item' => __( 'Edit Portfolio 3d Computer Graphics', "mucivi" ),
        'update_item' => __( 'Update Portfolio 3d Computer Graphics', "mucivi" ),
        'view_item' => __( 'View Portfolio 3d Computer Graphics', "mucivi" ),
        'view_items' => __( 'View Portfolio 3d Computer Graphics', "mucivi" ),
        'search_items' => __( 'Search Portfolio 3d Computer Graphics', "mucivi" ),
        'not_found' => __( 'Not found', "mucivi" ),
        'not_found_in_trash' => __( 'Not found in Trash', "mucivi" ),
        'insert_into_item' => __( 'Insert into Portfolio 3d Computer Graphics', "mucivi" ),
        'uploaded_to_this_item' => __( 'Uploaded to this Portfolio 3d Computer Graphics', "mucivi" ),
        'items_list' => __( 'Portfolio 3d Computer Graphics list', "mucivi" ),
        'items_list_navigation' => __( 'Portfolio 3d Computer Graphics list navigation', "mucivi" ),
        'filter_items_list' => __( 'Filter Portfolio 3d Computer Graphics list', "mucivi" ),
    );

    $args = array(
        'label' => __( 'Portfolio 3d Computer Graphics', "mucivi" ),
        'description' => __( 'Portfolio 3d Computer Graphics', "mucivi" ),
        'labels' => $labels,
        'supports' => array( 'title' ),
        'public' => true,
        'show_ui' => true,
        'show_in_rest' => true,
        'show_in_menu' => false, // hide from sidebar menu
        'has_archive' => true,
        'exclude_from_search' => true,
        'publicly_queryable' => false,
        'show_in_nav_menus' => false,

        // ✅ Capability setup
        'capability_type' => 'post',
        'map_meta_cap' => true,
    );

    register_post_type( 'portfolio3dcg', $args );
}
add_action("init", "add_custom_post_type_portfolio_3d_computer_graphics");

// add HTML for Portfolio 3d Computer Graphics CPT
function add_portfolio_3d_computer_graphics_meta_box() {

    $text = __( 'Portfolio 3d Computer Graphics information', "mucivi" );

    add_meta_box(
        'portfolios_fields_meta_box',
        $text,
        'show_portfolios_fields_3d_computer_graphics_custom_fields',
        'portfolio3dcg'
    );
}
add_action( 'add_meta_boxes', 'add_portfolio_3d_computer_graphics_meta_box' );

// saves metas for CPT Portfolio 3d Computer Graphics CPT
function save_custom_post_portfolio_3d_computer_graphics_metas( $post_id ) {

    $metaNonce    = "portfolio3dComputerGraphicsMetaNonce";
    $saveFields   = "portfolio3dComputerGraphicsFields";
    $fields       = "portfolios_fields_3d_computer_graphics";

    return save_custom_post_metas($post_id, $metaNonce, $saveFields, $fields);
}
add_action( 'save_post', 'save_custom_post_portfolio_3d_computer_graphics_metas' );
/* END - Add Custom Post Type - portfolios_fields_3d_computer_graphics */


/* Add Custom Post Type - Accordion */
function add_custom_post_type_accordion() {

    $labels = array(
        'name' => _x( 'Accordion', 'Post Type General Name', 'mucivi' ),
        'singular_name' => _x( 'Accordion', 'Post Type Singular Name', 'mucivi' ),
        'menu_name' => __( 'Accordion', 'mucivi' ),
        'name_admin_bar' => __( 'Accordion', 'mucivi' ),
        'archives' => __( 'Accordion Archives', 'mucivi' ),
        'attributes' => __( 'Accordion Attributes', 'mucivi' ),
        'parent_item_colon' => __( 'Parent Accordion:', 'mucivi' ),
        'all_items' => __( 'All Accordions ', 'mucivi' ),
        'add_new_item' => __( 'Add New Accordion', 'mucivi' ),
        'add_new' => __( 'Add New', 'mucivi' ),
        'new_item' => __( 'New Accordion', 'mucivi' ),
        'edit_item' => __( 'Edit Accordion', 'mucivi' ),
        'update_item' => __( 'Update Accordion', 'mucivi' ),
        'view_item' => __( 'View Accordion', 'mucivi' ),
        'view_items' => __( 'View Accordions', 'mucivi' ),
        'search_items' => __( 'Search Accordion', 'mucivi' ),
        'not_found' => __( 'Not found', 'mucivi' ),
        'not_found_in_trash' => __( 'Not found in Trash', 'mucivi' ),
        'featured_image' => __( 'Accordion Image', 'mucivi' ),
        'set_featured_image' => __( 'Set Accordion image', 'mucivi' ),
        'remove_featured_image' => __( 'Remove Accordion image', 'mucivi' ),
        'use_featured_image' => __( 'Use as Accordion image', 'mucivi' ),
        'insert_into_item' => __( 'Insert into Accordion', 'mucivi' ),
        'uploaded_to_this_item' => __( 'Uploaded to this Accordion', 'mucivi' ),
        'items_list' => __( 'Accordions list', 'mucivi' ),
        'items_list_navigation' => __( 'Accordions list navigation', 'mucivi' ),
        'filter_items_list' => __( 'Filter Accordion list', 'mucivi' ),
    );

    $args = array(
        'label' => __( 'Accordion', 'mucivi' ),
        'description' => __( 'Accordion', 'mucivi' ),
        'labels' => $labels,
        'supports' => array( 'title' ),
        'public' => true,
        'show_in_rest' => true,
        'show_ui' => true,
        'menu_position' => 21,
        'menu_icon' => 'dashicons-menu',
        'has_archive' => true,
        'exclude_from_search' => true,
        'publicly_queryable' => false,
        'show_in_nav_menus' => false,
    );

    register_post_type( 'Accordion', $args );
}
add_action("init", "add_custom_post_type_accordion");

// add HTML for Accordion CPT
function add_accordion_meta_box() {

    $text = __( 'Accordion information', 'mucivi' );

    add_meta_box(
        'accordion_fields_meta_box',
        $text,
        'show_accordion_custom_fields',
        'Accordion'
    );
}
add_action( 'add_meta_boxes', 'add_accordion_meta_box' );

function save_custom_post_accordion_metas( $post_id ) {

    $metaNonce    = "accordionMetaNonce";
    $saveFields   = "saveAccordionFields";
    $fields       = "accordion_fields";

    return save_custom_post_metas($post_id, $metaNonce, $saveFields, $fields);
}
add_action( 'save_post', 'save_custom_post_accordion_metas' );
/* END - Add Custom Post Type - Accordion */
