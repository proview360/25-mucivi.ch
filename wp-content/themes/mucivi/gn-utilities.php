<?php
// Add custom field to menu item (icon URL input)
add_action('wp_nav_menu_item_custom_fields', function($item_id, $item, $depth, $args) {
    $icon_url = get_post_meta($item_id, '_menu_item_icon_url', true);
    ?>
    <p class="description description-wide">
        <label for="edit-menu-item-icon-url-<?php echo $item_id; ?>">
            <?php _e('Icon URL'); ?><br>
            <input type="text" id="edit-menu-item-icon-url-<?php echo $item_id; ?>" class="widefat code edit-menu-item-custom" name="menu-item-icon-url[<?php echo $item_id; ?>]" value="<?php echo esc_attr($icon_url); ?>" />
        </label>
    </p>
    <?php
}, 10, 4);

// Save the custom icon URL field
add_action('wp_update_nav_menu_item', function($menu_id, $menu_item_db_id, $args) {
    if (isset($_POST['menu-item-icon-url'][$menu_item_db_id])) {
        update_post_meta($menu_item_db_id, '_menu_item_icon_url', sanitize_text_field($_POST['menu-item-icon-url'][$menu_item_db_id]));
    }
}, 10, 3);


// Display icon before menu item title
add_filter('wp_nav_menu_objects', function($items, $args) {
    foreach ($items as &$item) {
        $icon_url = get_post_meta($item->ID, '_menu_item_icon_url', true);
        if (!empty($icon_url)) {
            $item->title = '<img src="' . esc_url($icon_url) . '" class="menu-icon" style="width: 18px; height: 18px; margin-right: 20px; vertical-align: middle; background: transparent">' . $item->title;
        }
    }
    return $items;
}, 10, 2);


//add special menu

add_action('admin_menu', 'custom_all_portfolios_menu');

function custom_all_portfolios_menu() {
    add_menu_page(
        'All Portfolios',              // Page title
        'All Portfolios',              // Menu title
        'manage_options',              // Capability
        'all-portfolios',              // Menu slug
        'render_selected_cpts_page',   // Callback function
        'dashicons-portfolio',         // Icon
        6                              // Position
    );
}

function render_selected_cpts_page() {
    $selected_post_types = [
        'portfolios' => 'Main Portfolio',
        'portfolio3dcg'   => 'Portfolio 3d Computer Graphics',
        'cases'      => 'Case Studies',
    ];

    echo '<div class="portfolio-grid-backend">';
    foreach ($selected_post_types as $slug => $label) {
        $link = admin_url('edit.php?post_type=' . $slug);
        echo '<div class="portfolio-box-backend">';
        echo '<a href="' . esc_url($link) . '">' . esc_html($label) . '</a>';
        echo '</div>';
    }
    echo '</div>'; // .portfolio-grid
    echo '</div>'; // .wrap
}

