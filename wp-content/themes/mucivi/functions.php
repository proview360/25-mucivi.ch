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
            'mobile-menu' => __('Mobile Menu'),
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
	    array("name" => "announcements_block", "block-name" => "announcements-block", "deps" => array("wp-block-editor","wp-blocks","wp-element","wp-data")),
	    array("name" => "headline_block", "block-name" => "headline-block", "deps" => array("wp-block-editor","wp-blocks","wp-element","wp-data")),
	    array("name" => "hero_section_block", "block-name" => "hero-section-block", "deps" => array("wp-block-editor","wp-blocks","wp-element","wp-data")),
	    array("name" => "iframe_block", "block-name" => "iframe-block", "deps" => array("wp-block-editor","wp-blocks","wp-element","wp-data")),
	    array("name" => "image_block", "block-name" => "image-block", "deps" => array("wp-block-editor","wp-blocks","wp-element","wp-data")),
	    array("name" => "image_gallery_block", "block-name" => "image-gallery-block", "deps" => array("wp-block-editor","wp-blocks","wp-element","wp-data")),
	    array("name" => "image_text_block", "block-name" => "image-text-block", "deps" => array("wp-block-editor","wp-blocks","wp-element","wp-data")),
	    array("name" => "showcase_block", "block-name" => "showcase-block", "deps" => array("wp-block-editor","wp-blocks","wp-element","wp-data")),
	    array("name" => "split_block", "block-name" => "split-block", "deps" => array("wp-block-editor","wp-blocks","wp-element","wp-data")),
	    array("name" => "text_block", "block-name" => "text-block", "deps" => array("wp-block-editor","wp-blocks","wp-element","wp-data")),
	 );

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

// include granit utilities
include_once("gn-utilities.php");

// cpt
include_once("gn-cpt.php");
require_once(get_stylesheet_directory() . '/gn-cpt/announcements.php');

// load theme options
require_once(get_stylesheet_directory() . '/theme-options.php');



