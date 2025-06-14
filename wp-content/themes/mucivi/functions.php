<?php

if ( ! defined( '_S_VERSION' ) ) {
    // Replace the version number of the theme on each release.
    define( '_S_VERSION', '1.0.0' );
}

// Define global variable correctly
global $theme_path;
$theme_path = get_template_directory_uri();

function add_frontend_resources() {
    global $theme_path; // Correct global variable usage

    // CSS
    wp_enqueue_style("boo-icons", $theme_path . "/assets/bootstrap-icons/font/bootstrap-icons.min.css", array("bootstrap-css"), _S_VERSION);
    wp_enqueue_style("bootstrap-css", $theme_path . "/assets/css/bootstrap/bootstrap.min.css", array(), "5.2.2");
	
	wp_enqueue_style("css-main", $theme_path . "/assets/css/main.css", array("bootstrap-css"), _S_VERSION);
 
	// JS
    wp_deregister_script("wp-embed");
    wp_enqueue_script("bootstrap-js", $theme_path . "/assets/js/bootstrap.min.js", array("jquery"), "5.2.2", true);

    wp_enqueue_script("js-main", $theme_path . "/assets/js/functions.min.js", array("jquery"), "1.0", true);

    wp_localize_script("js-main", "wtAjax", array(
        "ajaxurl" => admin_url("admin-ajax.php"),
    ));

}

add_action("wp_enqueue_scripts", "add_frontend_resources");



// load backend CSS and JS
function add_backend_resources() {

    global $theme_path;

    // CSS
    wp_enqueue_style("admin-styles", $theme_path . "/assets/css/backend.css");

    // JS
    wp_enqueue_script("admin-js", $theme_path . "/assets/js/backend.min.js");

    wp_localize_script('admin-js', 'wtAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
    ));

    // Enqueue WordPress color picker styles and scripts
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wp-color-picker');
    wp_enqueue_script('custom-color-picker', get_template_directory_uri() . '/js/custom-color-picker.js', array('wp-color-picker'), false, true);

}
add_action('admin_enqueue_scripts', 'add_backend_resources');


function register_my_menus()
{
    register_nav_menus(
        array(
            'primary-menu' => __('Primary Menu'),
            'secondary-menu' => __('Secondary Menu'),
            'mobile-menu' => __('Mobile Menu'),
            'footer-menu-1' => __('Footer Menu 1'),
            'footer-menu-2' => __('Footer Menu 2'),
            'footer-menu-3' => __('Footer Menu 3'),
            'footer-menu-4' => __('Footer Menu 4'),
            'footer-menu-5' => __('Footer Menu 5'),
            'footer-menu-6' => __('Footer Menu 6'),
            'footer-menu-7' => __('Footer Menu 7'),
            'footer-menu-8' => __('Footer Menu 8'),
        )
    );
}

add_action('init', 'register_my_menus');

// theme support options
add_theme_support('menus');
add_theme_support('post-thumbnails');
add_theme_support('widgets');
add_theme_support('custom-header', array('flex-height' => true, 'flex-width' => true));
add_theme_support( 'title-tag' );

// add backend script media
function load_media_files() {

    wp_enqueue_media();
}
add_action('admin_enqueue_scripts', 'load_media_files');

// allow svg upload
function allow_svg_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'allow_svg_types');


// Editor Type WYSIWYG
// Editor Type WYSIWYG
function getWpEditor($content, $editor_id, string $name, bool $withoutOB = false, $wpautop = true ) {
    $settings = array(
        'media_buttons' => false,
        'teeny' => false,
        'textarea_rows' => 4,
        'textarea_name' => $name,
        'tinymce' => array(
            'toolbar1' => 'formatselect,bold,italic,bullist,numlist,blockquote,alignleft,aligncenter,alignright,link,unlink,wp_more,spellchecker,fullscreen,wp_adv',
            'toolbar2' => 'strikethrough,hr,forecolor,pastetext,removeformat,charmap,outdent,indent,undo,redo,wp_help'
        ),
        'wpautop' => $wpautop,
    );

    if($withoutOB)
    {
        wp_editor( $content, $editor_id, $settings );
    }
    else
    {
        ob_start();

        wp_editor( $content, $editor_id, $settings );

        return ob_get_clean();
    }
}

// AJAX call wp_editor
add_action('wp_ajax_gn_get_text_editor', 'gn_get_text_editor');



function gn_get_text_editor() {
    // Check if the required parameters are set
    if(isset($_POST['text_editor_id']) && isset($_POST['textarea_name'])) {
        // Sanitize the received parameters
        $editor_id = sanitize_text_field($_POST['text_editor_id']);
        $textarea_name = sanitize_text_field($_POST['textarea_name']);

        // Set settings for the editor
        $settings = array(
            'media_buttons' => false,  // Show the media buttons
            'textarea_name' => $textarea_name,  // Set the name
            'textarea_rows' => 8, // Set text area rows
            'teeny' => false,
            'tinymce' => array(
                'toolbar1' => 'formatselect,bold,italic,bullist,numlist,blockquote,alignleft,aligncenter,alignright,link,unlink,wp_more,spellchecker,fullscreen,wp_adv',
                'toolbar2' => 'strikethrough,hr,forecolor,pastetext,removeformat,charmap,outdent,indent,undo,redo,wp_help'
            ),
        );

        // Generate the editor
        wp_editor('', $editor_id, $settings);
    }
    wp_die(); // this is required to terminate immediately and return a proper response
}
	
	add_action('admin_enqueue_scripts', function () {
		wp_enqueue_editor(); // ✅ loads all necessary TinyMCE + Quicktags assets
	});

// END of ajax call for wp_editor

// register custom-block category
function add_block_category( $categories, $post ) {

    return array_merge(
        array(
            array(
                'slug' => 'mucivi-blocks',
                'title' => __( 'mucivi', 'mucivi' ),
            ),
        ),
        $categories
    );
}
add_filter( 'block_categories_all', 'add_block_category', 10, 2);


// Desktop Walker
class Desktop_Walker_Nav_Menu extends Walker_Nav_Menu
{
    function start_lvl(&$output, $depth = 0, $args = array()) {
        $indent = str_repeat("\t", $depth);
        if ($depth === 0) {
            $submenu_class = 'sub-menu';
        } elseif ($depth === 1) {
            $submenu_class = 'sub-sub-menu';
        } else {
            $submenu_class = 'sub-sub-sub-menu';
        }
        $output .= "\n$indent<ul class=\"dropdown-menu $submenu_class depth_$depth\">\n";
    }

    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        $li_attributes = '';
        $class_names = $value = '';

        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = ($args->walker->has_children) ? 'dropdown' : '';

        if ($item->current) {
            $classes[] = 'active';
        }

        $classes[] = 'menu-item-' . $item->ID;
        if ($depth && $args->walker->has_children) {
            $classes[] = 'dropdown-submenu';
        }

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = ' class="' . esc_attr($class_names) . '"';

        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
        $id = strlen($id) ? ' id="' . esc_attr($id) . '"' : '';

        $output .= $indent . '<li' . $id . $value . $class_names . $li_attributes . '>';

        $atts = array();
        $atts['title'] = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = !empty($item->target) ? $item->target : '';
        $atts['rel'] = !empty($item->xfn) ? $item->xfn : '';
        $atts['href'] = !empty($item->url) ? $item->url : '';

        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args);

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= '<span class="link-drop-down">';  // Add a span tag to wrap the link text
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        $item_output .= '</span>';  // Close the span tag
        $item_output .= ($args->walker->has_children) ? ' <span class="arrow-mucivi-desktop"></span></a>' : '</a>';
        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}



class Mobile_Walker_Nav_Menu extends Walker_Nav_Menu
{
    function start_lvl(&$output, $depth = 0, $args = array()) {
        $indent = str_repeat("\t", $depth);
        if ($depth === 0) {
            $submenu_class = 'sub-menu';
        } elseif ($depth === 1) {
            $submenu_class = 'sub-sub-menu';
        } else {
            $submenu_class = 'sub-sub-sub-menu';
        }
        $output .= "\n$indent<ul class=\"dropdown-menu $submenu_class depth_$depth\">\n";
    }

    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        $li_attributes = '';
        $class_names = $value = '';

        $classes = empty($item->classes) ? array() : (array)$item->classes;
        $classes[] = ($args->walker->has_children) ? 'dropdown' : '';

        if ($item->current) {
            $classes[] = 'active';
        }

        $classes[] = 'menu-item-' . $item->ID;
        if ($depth && $args->walker->has_children) {
            $classes[] = 'dropdown-submenu';
        }

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = ' class="' . esc_attr($class_names) . '"';

        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
        $id = strlen($id) ? ' id="' . esc_attr($id) . '"' : '';

        $output .= $indent . '<li' . $id . $value . $class_names . $li_attributes . '>';

        $atts = array();
        $atts['title'] = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = !empty($item->target) ? $item->target : '';
        $atts['rel'] = !empty($item->xfn) ? $item->xfn : '';

        $atts['href'] = !empty($item->url) ? $item->url : '';

        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args);

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        // Define different arrow classes based on depth
        $arrow_class = '';
        if ($args->walker->has_children) {
            if ($depth == 0) {
                $arrow_class = 'mega-menu-mobile-arrow';
            } elseif ($depth == 1) {
                $arrow_class = 'sub-mega-menu-mobile-arrowe';
            } else {
                $arrow_class = 'sub-sub-mega-menu-mobile-arrow';
            }
        }

        $item_output = $args->before;

        if ($args->walker->has_children) {
            $item_output .= '<span class="menu-item-wrap">';
        }

        $item_output .= '<a class="nav-link-mob"' . $attributes . '>';
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        $item_output .= '</a>';

        if ($args->walker->has_children) {
            $item_output .= '<div class="' . $arrow_class . '">
                    <img alt="menu-open" src="/wp-content/themes/mucivi/assets/img/vectors/dropDownMenuClose.svg" class="arrow-menu-open" /> 
                    <img alt="menu-close" src="/wp-content/themes/mucivi/assets/img/vectors/dropDownMenu.svg" class="d-none arrow-menu-close" /> 
            </div>';
            $item_output .= '</span>';
        }

        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}


// register granit custom-blocks
function register_granit_blocks() {

    // abort if gutenberg is not active
    if(!function_exists( 'register_block_type'))
    {
        return;
    }

    // init vars
    global $theme_path;
    $blocks = array(
	    array("name" => "hero_section_block", "block-name" => "hero-section-block", "deps" => array("wp-block-editor","wp-blocks","wp-element","wp-data")),
	    array("name" => "split_block", "block-name" => "split-block", "deps" => array("wp-block-editor","wp-blocks","wp-element","wp-data")),
	    array("name" => "image_gallery_block", "block-name" => "image-gallery-block", "deps" => array("wp-block-editor","wp-blocks","wp-element","wp-data")),
	    array("name" => "headline_block", "block-name" => "headline-block", "deps" => array("wp-block-editor","wp-blocks","wp-element","wp-data")),
	    array("name" => "showcase_block", "block-name" => "showcase-block", "deps" => array("wp-block-editor","wp-blocks","wp-element","wp-data")),
	    array("name" => "iframe_block", "block-name" => "iframe-block", "deps" => array("wp-block-editor","wp-blocks","wp-element","wp-data")),
	    array("name" => "image_block", "block-name" => "image-block", "deps" => array("wp-block-editor","wp-blocks","wp-element","wp-data")),
	    array("name" => "text_block", "block-name" => "text-block", "deps" => array("wp-block-editor","wp-blocks","wp-element","wp-data")),
	    array("name" => "image_text_block", "block-name" => "image-text-block", "deps" => array("wp-block-editor","wp-blocks","wp-element","wp-data")),
	    array("name" => "announcements_block", "block-name" => "announcements-block", "deps" => array("wp-block-editor","wp-blocks","wp-element","wp-data")),
		
		
        array("name" => "hexagon_block", "block-name" => "hexagon-block", "deps" => array("wp-block-editor","wp-blocks","wp-element","wp-data")),
        array("name" => "threed_and_lists_block", "block-name" => "threed-and-lists-block", "deps" => array("wp-block-editor","wp-blocks","wp-element","wp-data")),
        array("name" => "website_block", "block-name" => "website-block", "deps" => array("wp-block-editor","wp-blocks","wp-element","wp-data")),
        array("name" => "accordion_block", "block-name" => "accordion-block", "deps" => array("wp-block-editor","wp-blocks","wp-element","wp-data")),
        array("name" => "map_block", "block-name" => "map-block", "deps" => array("wp-block-editor","wp-blocks","wp-element","wp-data")),
        array("name" => "quick_facts_block", "block-name" => "quick-facts-block", "deps" => array("wp-block-editor","wp-blocks","wp-element","wp-data")),
        array("name" => "news_block", "block-name" => "news-block", "deps" => array("wp-block-editor","wp-blocks","wp-element","wp-data")),
        array("name" => "employee_block", "block-name" => "employee-block", "deps" => array("wp-block-editor","wp-blocks","wp-element","wp-data")),
        array("name" => "slider_block", "block-name" => "slider-block", "deps" => array("wp-block-editor","wp-blocks","wp-element","wp-data")),
        array("name" => "honeycomb_block", "block-name" => "honeycomb-block", "deps" => array("wp-block-editor","wp-blocks","wp-element","wp-data")),
        array("name" => "teaser_block", "block-name" => "teaser-block", "deps" => array("wp-block-editor","wp-blocks","wp-element","wp-data")),
        array("name" => "before_after_block", "block-name" => "before-after-block", "deps" => array("wp-block-editor","wp-blocks","wp-element","wp-data")),
        array("name" => "testimonial_block", "block-name" => "testimonial-block", "deps" => array("wp-block-editor","wp-blocks","wp-element","wp-data")),
        array("name" => "portfolio_block", "block-name" => "portfolio-block", "deps" => array("wp-block-editor","wp-blocks","wp-element","wp-data")),
        array("name" => "portfolio_3d_computer_graphics_block", "block-name" => "portfolio-3d-computer-graphics-block", "deps" => array("wp-block-editor","wp-blocks","wp-element","wp-data")),
        array("name" => "get_in_touch_block", "block-name" => "get-in-touch-block", "deps" => array("wp-block-editor","wp-blocks","wp-element","wp-data")),   );

    // iterate blocks
    foreach($blocks as $block) {

        // register script
        wp_register_script(
            "gn_".$block["name"],
            $theme_path."/gn-blocks/".$block["block-name"]."/".$block["name"]."_editor.min.js",
            $block["deps"]
        );

        // register editor style
        wp_register_style(
            "gn_".$block["name"]."_editor",
            $theme_path."/gn-blocks/".$block["block-name"]."/".$block["name"]."_editor.css",
            array("wp-edit-blocks")
        );

        // register block
        $check = register_block_type(
            "gn/".$block["block-name"], array(
            "style" => "gn_".$block["name"],
            "editor_style" => "gn_".$block["name"]."_editor",
            "editor_script" => "gn_".$block["name"],
            "render_callback" => "gn_".$block["name"]."_rc"
        ));

        // include php return call function
        include_once(dirname(__FILE__)."/gn-blocks/".$block["block-name"]."/".$block["name"].".php");
    }
}
add_action('init', 'register_granit_blocks');




// manage columns for cpt files
function manage_columns_for_file($columns) {
    //remove columns
    unset($columns['title']);
    unset($columns['categories']);
    unset($columns['tags']);
    unset($columns['date']);
    unset($columns['comments']);
    unset($columns['author']);

    //add new columns
    $columns['title'] = 'Title';
    $columns['tab_shortcode'] = 'Shortcode';
    $columns['date'] = 'Date';

    return $columns;
}

add_action('manage_file_posts_columns', 'manage_columns_for_file');

function cpt_file_column_content_tab_shortcode($column, $post_id)
{

    //post content column
    if ($column == 'tab_shortcode') {
        $post = get_post($post_id);

        if ($post) {
            $value = "<div>" . "files-code-" . $post->ID . "</div>";

            echo $value;
        }
    }
}

add_action('manage_file_posts_custom_column', 'cpt_file_column_content_tab_shortcode', 10, 2);

/* end of columns for cpt files */

/* use archive.php for posts */
function use_archive_for_posts_page( $template ) {
    if ( is_home() ) {
        // Redirect to archive.php when viewing the posts page
        $template = locate_template( 'archive.php' );
    }
    return $template;
}
add_filter( 'home_template', 'use_archive_for_posts_page' );
/* end of archive.php for posts */

/* sidebar */
function newsroom_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Newsroom Anglisht', 'mucivi' ),
        'id'            => 'newsroom_en',
        'description'   => __( 'Add widgets here to appear in your sidebar.', 'mucivi' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
    register_sidebar( array(
        'name'          => __( 'Newsroom Frengjisht', 'mucivi' ),
        'id'            => 'newsroom_fr',
        'description'   => __( 'Add widgets here to appear in your sidebar.', 'mucivi' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
    register_sidebar( array(
        'name'          => __( 'Newsroom Gjermanisht', 'mucivi' ),
        'id'            => 'newsroom_de',
        'description'   => __( 'Add widgets here to appear in your sidebar.', 'mucivi' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
}
add_action( 'widgets_init', 'newsroom_widgets_init' );
/* end of sidebar */

// saves metas for all CPT
function save_custom_post_metas( $post_id, $metaNonce, $saveFields, $fields ) {

    // check if POST exist
    if( !$_POST )
    {
        return $post_id;
    }

    if( !isset( $_POST[$metaNonce] ) )
    {
        return $post_id;
    }

    // verify nonce
    if ( !wp_verify_nonce( $_POST[$metaNonce], $saveFields ) )
    {
        return $post_id;
    }

    // check autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
    {
        return $post_id;
    }

    // check permissions
    if ( 'page' === $_POST['post_type'] )
    {
        if ( !current_user_can( 'edit_page', $post_id ) )
        {
            return $post_id;
        }
        elseif ( !current_user_can( 'edit_post', $post_id ) )
        {
            return $post_id;
        }
    }

    $old = get_post_meta( $post_id, $fields, true );
    $new = $_POST[$fields];

    // ✅ Update or delete
    if ( $new && $new !== $old ) {
        update_post_meta( $post_id, $fields, $new );
    } elseif ( empty($new) && !empty($old) ) {
        delete_post_meta( $post_id, $fields );
    }

    return $post_id;
}
/*AJAX handler for portfolio filtering*/
function gn_filter_portfolio_callback()
{
    // Get the filter (title), page, and other parameters
    $filter = isset($_POST['filter']) ? sanitize_text_field($_POST['filter']) : 'all';
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;

    // Fetch portfolio items based on the filter and page
    $response = gn_portfolio_get_items($filter, $page);

    // Send the filtered portfolio items back to JavaScript
    wp_send_json_success($response);
}

add_action('wp_ajax_gn_filter_portfolio', 'gn_filter_portfolio_callback');
add_action('wp_ajax_nopriv_gn_filter_portfolio', 'gn_filter_portfolio_callback');


/*AJAX handler for portfolio filtering portfolio 3d computer graphics*/
function gn_filter_portfolio_3dcg_callback()
{
    // Get the filter (title), page, and other parameters
    $filter = isset($_POST['filter']) ? sanitize_text_field($_POST['filter']) : 'all';
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;

    // Fetch portfolio items based on the filter and page
    $response = gn_portfolio_3d_computer_graphics_get_items($filter, $page);

    // Send the filtered portfolio items back to JavaScript
    wp_send_json_success($response);
}

add_action('wp_ajax_gn_filter_portfolio_3dcg', 'gn_filter_portfolio_3dcg_callback');
add_action('wp_ajax_nopriv_gn_filter_portfolio_3dcg', 'gn_filter_portfolio_3dcg_callback');


// include granit utilities
include_once("gn-utilities.php");

// cpt
include_once("gn-cpt.php");
require_once(get_stylesheet_directory() . '/gn-cpt/announcements.php');

require_once(get_stylesheet_directory() . '/gn-cpt/accordion.php');
require_once(get_stylesheet_directory() . '/gn-cpt/hexagon.php');
require_once(get_stylesheet_directory() . '/gn-cpt/employee.php');
require_once(get_stylesheet_directory() . '/gn-cpt/slider.php');
require_once(get_stylesheet_directory() . '/gn-cpt/testimonials.php');
require_once(get_stylesheet_directory() . '/gn-cpt/teaser.php');
require_once(get_stylesheet_directory() . '/gn-cpt/portfolio.php');
require_once(get_stylesheet_directory() . '/gn-cpt/portfolio-3d-computer-graphics.php');

// load theme options
require_once(get_stylesheet_directory() . '/theme-options.php');

/* 3D code include */
function render_3d_viewer() {
    $iframe = '<iframe src="https://360.mucividemo.com/table3d/index.html" width="100%" height="600" style="border:0;" loading="lazy"></iframe>';

    return $iframe;
}
add_shortcode('3d_viewer', 'render_3d_viewer');



