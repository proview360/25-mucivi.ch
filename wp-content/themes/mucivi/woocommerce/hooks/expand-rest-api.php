<?php
/**
 * Copyright (c) 2024 by WebThinker GmbH
 *
 * All rights are reserved. Reproduction or transmission in whole or in part, in
 * any form or by any means, electronic, mechanical or otherwise, is prohibited
 * without the prior written consent of the copyright owner.
 *
 * Functions and definitions
 *
 * @package WordPress
 * @subpackage mucivi
 * @author Granit Nebiu
 * @since 1.0
 */



/*************************** CATEGORY ****************************/
// Allow `GDI_ID` in the category REST API requests
/*************************** CATEGORY ****************************/
// Allow `GDI_ID` in the category REST API requests
add_action('rest_api_init', function() {
    register_rest_field('product_cat', 'GDI_ID', array(
        'get_callback'    => 'get_category_gdi_id',
        'update_callback' => 'update_category_gdi_id',
        'schema'          => array(
            'description' => __('External GDI ID for the category.'),
            'type'        => 'string',
            'context'     => array('view', 'edit')
        ),
    ));
});

// Retrieve the `GDI_ID` from the category metadata
function get_category_gdi_id($object) {
    return get_term_meta($object['id'], 'gdi_id', true);
}

// Update the `GDI_ID` in category metadata
function update_category_gdi_id($value, $object, $field_name) {
    if (!empty($value)) {
        update_term_meta($object->term_id, 'gdi_id', sanitize_text_field($value));
    }
}

/*************************** POST META ****************************/
// Hook into post saving process to add `GDI_ID` from the assigned category to post meta
add_action('save_post', 'add_gdi_id_to_post_meta', 10, 3);

function add_gdi_id_to_post_meta($post_id, $post, $update) {
    // Avoid processing on auto-saves or non-product posts
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check post type (adjust 'product' to your required post type)
    if ($post->post_type !== 'product') {
        return;
    }

    // Get the assigned categories
    $categories = wp_get_post_terms($post_id, 'product_cat');

    if (!empty($categories) && !is_wp_error($categories)) {
        foreach ($categories as $category) {
            $gdi_id = get_term_meta($category->term_id, 'gdi_id', true);
            if (!empty($gdi_id)) {
                // Save the `GDI_ID` as post meta
                update_post_meta($post_id, 'gdi_id', $gdi_id);
                break; // Use the first category with a valid `GDI_ID`
            }
        }
    }
}


// Display GDI_ID as read-only in the WooCommerce category edit screen, or show a fallback message if not set
add_action('product_cat_edit_form_fields', 'show_gdi_id_category_field', 10, 2);

function show_gdi_id_category_field($term, $taxonomy) {
    // Get the GDI_ID from the term meta
    $gdi_id = get_term_meta($term->term_id, 'gdi_id', true);

    ?>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="gdi_id"><?php _e('GDI ID', 'woocommerce'); ?></label></th>
        <td>
            <?php if ($gdi_id): ?>
                <input type="text" name="gdi_id" id="gdi_id" value="<?php echo esc_attr($gdi_id); ?>" readonly>
                <p class="description"><?php _e('This is the external GDI ID for this category.', 'woocommerce'); ?></p>
            <?php else: ?>
                <p class="description"><?php _e('No GDI ID is set for this category.', 'woocommerce'); ?></p>
            <?php endif; ?>
        </td>
    </tr>
    <?php
}

// Remove the GDI_ID field from the category creation form to prevent manual input
add_action('product_cat_add_form_fields', function() {
    // Intentionally left empty to disable field on category creation
});

// Remove the saving action for the GDI_ID field to prevent it from being modified in the backend
remove_action('created_product_cat', 'save_gdi_id_category_field', 10);
remove_action('edited_product_cat', 'save_gdi_id_category_field', 10);


/***
 *** update category by id *****
 ****
 *******/
add_action('rest_api_init', function () {
    register_rest_route('custom-api/v1', '/categories', array(
        'methods' => WP_REST_Server::EDITABLE, // Accepts PUT or POST
        'callback' => 'update_category_by_gdi_id',
        'args' => [
            'GDI_ID' => [
                'required' => true,
                'validate_callback' => function ($param) {
                    return is_string($param);
                },
            ],
        ],
        'permission_callback' => '__return_true', // Temporary for debugging
    ));
});

function update_category_by_gdi_id(WP_REST_Request $request) {
    $gdi_id = $request->get_param('GDI_ID');
    $params = $request->get_json_params();

    // Validate GDI_ID
    if (!is_string($gdi_id) || empty($gdi_id)) {
        return new WP_Error('invalid_gdi_id', 'The GDI_ID must be a non-empty string.', array('status' => 400));
    }


    // Find category by GDI_ID
    $term_query = new WP_Term_Query(array(
        'taxonomy'   => 'product_cat',
        'meta_key'   => 'gdi_id',
        'meta_value' => $gdi_id,
        'number'     => 1,
    ));



    if (empty($term_query->terms)) {
        return new WP_Error('category_not_found', 'No category found with the provided GDI_ID.', array('status' => 404));
    }

    $category = $term_query->terms[0];
    $category_id = $category->term_id;

    // Update category fields
    if (!empty($params['name'])) {
        if (strlen($params['name']) > 100) {
            return new WP_Error('invalid_name', 'The name must be less than 100 characters.', array('status' => 400));
        }

        $update_result = wp_update_term($category_id, 'product_cat', array('name' => sanitize_text_field($params['name'])));
        if (is_wp_error($update_result)) {
            return new WP_Error('update_failed', 'Failed to update the category name.', array('status' => 500));
        }
    }

    if (!empty($params['slug'])) {
        if (!preg_match('/^[a-z0-9-]+$/', $params['slug'])) {
            return new WP_Error('invalid_slug', 'The slug contains invalid characters.', array('status' => 400));
        }

        $update_result = wp_update_term($category_id, 'product_cat', array('slug' => sanitize_text_field($params['slug'])));
        if (is_wp_error($update_result)) {
            return new WP_Error('update_failed', 'Failed to update the category slug.', array('status' => 500));
        }
    }

    if (!empty($params['image']['src'])) {
        if (!filter_var($params['image']['src'], FILTER_VALIDATE_URL)) {
            return new WP_Error('invalid_image_url', 'The image URL is invalid.', array('status' => 400));
        }

        update_term_meta($category_id, 'thumbnail_id', esc_url($params['image']['src']));
    }

    // Final response
    $response = array(
        'message' => 'Category updated successfully.',
        'category_id' => $category_id,
    );

    return new WP_REST_Response($response, 200);
}






/*************************** PRODUCT
 * Register `GDI_ID`, `ARTICLE_GDI_ID`, and `CATEGORY_GDI_ID` as top-level fields in the product REST API requests
 * Granit Nebiu
 * ****************************/

add_action('rest_api_init', function() {
    $fields = [
        'GDI_ID' => [
            'description' => __('External GDI ID for the product.'),
        ],
        'ARTICLE_GDI_ID' => [
            'description' => __('External Article GDI ID for the product.'),
        ],
        'CATEGORY_GDI_ID' => [
            'description' => __('External Category GDI ID for the product.'),
        ]
    ];

    foreach ($fields as $field_name => $schema) {
        register_rest_field('product', $field_name, array(
            'get_callback' => function($object) use ($field_name) {
                return get_product_meta_field($object, $field_name);
            },
            'update_callback' => function($value, $object) use ($field_name) {
                update_product_meta_field($value, $object, $field_name);
            },
            'schema' => array(
                'description' => $schema['description'],
                'type'        => 'string',
                'context'     => array('view', 'edit')
            ),
        ));
    }
});

// Generic callback to retrieve meta fields from the product metadata
function get_product_meta_field($object, $field_name) {
    $meta_value = get_post_meta($object['id'], strtolower($field_name), true);
    return !empty($meta_value) ? $meta_value : "$field_name was not provided"; // Return message if the field is empty
}

// Generic callback to update meta fields in product metadata
function update_product_meta_field($value, $object, $field_name) {
    if (!empty($value)) {
        update_post_meta($object->get_id(), strtolower($field_name), sanitize_text_field($value));
    } else {
        delete_post_meta($object->get_id(), strtolower($field_name));
    }
}

// Ensure fields from the request are saved as product metadata
add_action('woocommerce_rest_insert_product', function ($product, $request) {
    $fields = ['gdi_id', 'article_gdi_id', 'category_gdi_id'];
    foreach ($fields as $field) {
        if (isset($request[$field])) {
            update_post_meta($product->get_id(), $field, sanitize_text_field($request[$field]));
        }
    }
}, 10, 2);

// Display fields as read-only in the WooCommerce product data panel
add_action('woocommerce_product_options_general_product_data', 'display_gdi_id_product_fields', 20);

function display_gdi_id_product_fields() {
    global $post;
    $fields = [
        'gdi_id' => __('GDI ID', 'woocommerce'),
        'article_gdi_id' => __('Article GDI ID', 'woocommerce'),
        'category_gdi_id' => __('Category GDI ID', 'woocommerce')
    ];

    echo '<div class="options_group">';
    foreach ($fields as $field_id => $field_label) {
        $field_value = get_post_meta($post->ID, $field_id, true);
        woocommerce_wp_text_input(array(
            'id' => $field_id,
            'label' => $field_label,
            'value' => !empty($field_value) ? $field_value : __($field_label . ' not provided', 'woocommerce'),
            'desc_tip' => true,
            'description' => __('This is the external ' . strtolower($field_label) . ' for this product.'),
            'custom_attributes' => array('readonly' => 'readonly') // Make it read-only
        ));
    }
    echo '</div>';
}

// image base 64
/**
 * Save the image on the server.
 */
add_action('rest_api_init', function () {
    register_rest_route('custom/v1', '/add-product', [
        'methods' => 'POST',
        'callback' => 'process_product_payload',
        'permission_callback' => '__return_true', // Adjust permissions as needed
    ]);
});

function process_product_payload(WP_REST_Request $request) {
    $product_data = $request->get_json_params();

    // Validate product data
    if (empty($product_data['images'][0]['src'])) {
        // Set a default image URL
        $default_image_url = '"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"'; // Replace with your default image URL

        // Convert the default image URL to a format compatible with your WooCommerce product API
        $product_data['images'] = [
            [
                'src' => $default_image_url,
            ],
        ];
    }


    // Process the Base64 image
    $base64_image = $product_data['images'][0]['src'];
    $uploaded_image_url = save_base64_image($base64_image, $product_data['name']);

    if (is_wp_error($uploaded_image_url)) {
        return $uploaded_image_url; // Return error if image upload fails
    }

    // Replace Base64 string with uploaded image URL
    $product_data['images'][0]['src'] = $uploaded_image_url;

    // Send product data to WooCommerce API
    $woocommerce_response = send_to_woocommerce($product_data);

    if (is_wp_error($woocommerce_response)) {
        return $woocommerce_response; // Return WooCommerce API error
    }

    return json_decode(wp_remote_retrieve_body($woocommerce_response));
}

/****
 * SUPPORT IMAGE BASE64
 */
add_filter('kses_allowed_protocols', function ($protocols) {
    $protocols[] = 'data';
    return $protocols;
});

add_action('rest_api_init', function () {
    register_rest_route('custom/v1', '/process-product', [
        'methods' => 'POST',
        'callback' => 'process_base64_product',
        'permission_callback' => '__return_true',
    ]);
});

function process_base64_product(WP_REST_Request $request) {
    $product_data = $request->get_json_params();

    // Validate product data
    if (empty($product_data['images'][0]['src'])) {
        // Set a default image URL
        $default_image_url = 'data:image/png;base64,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';

        // Convert the default image URL to a format compatible with your WooCommerce product API
        $product_data['images'] = [
            [
                'src' => $default_image_url,
            ],
        ];
    }


    // Decode and upload the Base64 image
    $base64_image = $product_data['images'][0]['src'];
    $uploaded_image_url = upload_base64_image_to_media($base64_image, $product_data['name']);

    if (is_wp_error($uploaded_image_url)) {
        return $uploaded_image_url; // Return error if image upload fails
    }

    // Replace the Base64 string with the uploaded image URL
    $product_data['images'][0]['src'] = $uploaded_image_url;

    // Send updated product data to WooCommerce
    $response = send_to_woocommerce($product_data);

    if (is_wp_error($response)) {
        return $response; // Return WooCommerce API error
    }

    return json_decode(wp_remote_retrieve_body($response));
}

function upload_base64_image_to_media($base64_image, $title) {
    $upload_dir = wp_upload_dir();
    $upload_path = $upload_dir['path'] . '/';

    // Decode Base64 string
    $image_data = explode(',', $base64_image);
    if (count($image_data) === 2) {
        $image_info = explode(';', $image_data[0]);
        $mime_type = str_replace('data:', '', $image_info[0]);
        $decoded_image = base64_decode($image_data[1]);
    } else {
        return new WP_Error('invalid_base64', 'Invalid Base64 string.');
    }

    // Determine file extension based on MIME type
    $extension = '';
    switch ($mime_type) {
        case 'image/jpeg':
            $extension = 'jpg';
            break;
        case 'image/png':
            $extension = 'png';
            break;
        case 'image/gif':
            $extension = 'gif';
            break;
        default:
            return new WP_Error('unsupported_image_type', 'Unsupported image type.');
    }

    // Generate a unique filename
    $filename = sanitize_file_name($title) . '.' . $extension;
    $file_path = $upload_path . $filename;

    // Save the file to the server
    if (!file_put_contents($file_path, $decoded_image)) {
        return new WP_Error('file_save_error', 'Failed to save the image.');
    }

    // Insert the image into the Media Library
    $attachment = [
        'post_mime_type' => $mime_type,
        'post_title'     => sanitize_text_field($title),
        'post_content'   => '',
        'post_status'    => 'inherit',
    ];

    $attachment_id = wp_insert_attachment($attachment, $file_path);
    if (is_wp_error($attachment_id)) {
        return $attachment_id;
    }

    // Generate and update attachment metadata
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    $attachment_data = wp_generate_attachment_metadata($attachment_id, $file_path);
    wp_update_attachment_metadata($attachment_id, $attachment_data);

    return wp_get_attachment_url($attachment_id); // Return the image URL
}



function send_to_woocommerce($product_data) {
    global $username_woocommerce, $password_woocommerce;
    $theme_options_all  = get_option('mucivi_theme_options_all');

    //woocommerce
    $username_woocommerce  = $theme_options_all['username_woocommerce'] ?? "";
    $password_woocommerce  = $theme_options_all['password_woocommerce'] ?? "";

    $woocommerce_api_url = site_url('/wp-json/wc/v3/products');
    $api_key = $username_woocommerce; // Replace with your WooCommerce API key
    $api_secret = $password_woocommerce; // Replace with your WooCommerce API secret

    $response = wp_remote_post($woocommerce_api_url, [
        'body' => json_encode($product_data),
        'headers' => [
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic ' . base64_encode("$api_key:$api_secret"),
        ],
    ]);

    if (is_wp_error($response)) {
        return $response;
    }

    return $response;
}
/****** END OF PRODUCT API ******/
/****
 * SUPPORT GDI PUT
 */
add_action('rest_api_init', function () {
    register_rest_route('wc/v3', '/products', [
        'methods' => 'PUT',
        'callback' => 'update_product_by_GDI_ID',
        'permission_callback' => function () {
            return current_user_can('edit_products');
        },
        'args' => [
            'GDI_ID' => [
                'required' => true,
                'type' => 'string',
                'description' => 'The GDI_ID of the product to update.',
            ],
        ],
    ]);
});

function update_product_by_GDI_ID(WP_REST_Request $request) {
    global $wpdb;

    $GDI_ID = $request->get_param('GDI_ID');
    $product_data = $request->get_json_params();

    // Validate GDI_ID
    if (empty($GDI_ID)) {
        return new WP_Error('missing_GDI_ID', 'GDI_ID is required.', ['status' => 400]);
    }

    // Query product by GDI_ID as a product field, not meta_key
    $product_id = $wpdb->get_var($wpdb->prepare(
        "SELECT ID FROM {$wpdb->posts} p
        INNER JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id
        WHERE p.post_type = 'product' AND pm.meta_key = 'GDI_ID' AND pm.meta_value = %s",
        $GDI_ID
    ));

    if (!$product_id) {
        return new WP_Error('product_not_found', 'No product found with this GDI_ID.', ['status' => 404]);
    }

    $product = wc_get_product($product_id);

    // Validate product object
    if (!$product) {
        return new WP_Error('product_error', 'Failed to retrieve the product.', ['status' => 500]);
    }

    // Update product fields
    if (isset($product_data['name'])) {
        $product->set_name(sanitize_text_field($product_data['name']));
    }
    if (isset($product_data['regular_price'])) {
        $product->set_regular_price(floatval($product_data['regular_price']));
    }
    if (isset($product_data['description'])) {
        $product->set_description(wp_kses_post($product_data['description']));
    }

    // Update GDI_ID
    if (isset($product_data['GDI_ID'])) {
        update_post_meta($product_id, 'GDI_ID', sanitize_text_field($product_data['GDI_ID']));
    }

    // Handle images
    if (isset($product_data['images']) && is_array($product_data['images'])) {
        $gallery_image_ids = [];
        foreach ($product_data['images'] as $image) {
            if (isset($image['src'])) {
                $src = $image['src'];

                // Check if the source is Base64 or a URL
                if (strpos($src, 'data:image/') === 0) {
                    // Extract MIME type from Base64 data
                    preg_match('/^data:image\/(\w+);base64,/', $src, $matches);
                    $mime_type = $matches[1] ?? '';

                    // Determine file extension based on MIME type
                    $extension = '';
                    switch ($mime_type) {
                        case 'jpeg':
                        case 'jpg':
                            $extension = 'jpg';
                            break;
                        case 'png':
                            $extension = 'png';
                            break;
                        case 'gif':
                            $extension = 'gif';
                            break;
                        default:
                            return new WP_Error('unsupported_image_type', 'Unsupported image type.');
                    }

                    // Decode Base64 and save the file
                    $image_data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $src));
                    $upload_dir = wp_upload_dir();
                    $filename = uniqid() . '.' . $extension;
                    $file_path = $upload_dir['path'] . '/' . $filename;

                    if (file_put_contents($file_path, $image_data)) {
                        // Insert image into Media Library
                        $attachment_id = wp_insert_attachment([
                            'post_mime_type' => 'image/' . $extension,
                            'post_title'     => sanitize_file_name($filename),
                            'post_content'   => '',
                            'post_status'    => 'inherit'
                        ], $file_path);

                        if (!is_wp_error($attachment_id)) {
                            require_once(ABSPATH . 'wp-admin/includes/image.php');
                            $attachment_data = wp_generate_attachment_metadata($attachment_id, $file_path);
                            wp_update_attachment_metadata($attachment_id, $attachment_data);

                            $gallery_image_ids[] = $attachment_id;
                        }
                    }
                } elseif (filter_var($src, FILTER_VALIDATE_URL)) {
                    // Handle URL image
                    $attachment_id = attachment_url_to_postid($src);
                    if (!$attachment_id) {
                        // Download and insert the image into the Media Library if not already added
                        $image_response = wp_remote_get($src);
                        if (is_wp_error($image_response)) {
                            continue; // Skip this image if download fails
                        }

                        $image_data = wp_remote_retrieve_body($image_response);
                        $upload_dir = wp_upload_dir();
                        $filename = uniqid() . '.jpg'; // Assuming URL image is a jpg
                        $file_path = $upload_dir['path'] . '/' . $filename;

                        if (file_put_contents($file_path, $image_data)) {
                            $attachment_id = wp_insert_attachment([
                                'post_mime_type' => 'image/jpeg',
                                'post_title'     => sanitize_file_name($filename),
                                'post_content'   => '',
                                'post_status'    => 'inherit'
                            ], $file_path);

                            if (!is_wp_error($attachment_id)) {
                                require_once(ABSPATH . 'wp-admin/includes/image.php');
                                $attachment_data = wp_generate_attachment_metadata($attachment_id, $file_path);
                                wp_update_attachment_metadata($attachment_id, $attachment_data);

                                $gallery_image_ids[] = $attachment_id;
                            }
                        }
                    } else {
                        // If already uploaded, use the existing attachment ID
                        $gallery_image_ids[] = $attachment_id;
                    }
                }
            }
        }

        if (!empty($gallery_image_ids)) {
            $product->set_gallery_image_ids($gallery_image_ids);
            $product->set_image_id($gallery_image_ids[0]);
        }
    }

    // Save the product
    $product->save();

    return [
        'success' => true,
        'message' => 'Product updated successfully.',
        'product_id' => $product_id,
        'GDI_ID' => $product_data['GDI_ID'] ?? $GDI_ID
    ];
}



/***
 *
 * get product by id GDI
 *
 */
add_action('rest_api_init', function () {
    register_rest_route('custom-api/v1', '/products-by-gdi', array(
        'methods' => 'GET',
        'callback' => 'get_products_by_gdi_id',
        'args' => array(
            'GDI_ID' => array(
                'required' => true,
                'validate_callback' => function ($param) {
                    return is_string($param) && !empty($param);
                },
                'description' => 'The GDI_ID of the products to fetch.',
            ),
        ),
        'permission_callback' => '__return_true', // Adjust permissions if needed
    ));
});
function get_products_by_gdi_id(WP_REST_Request $request) {
    // Get the GDI_ID parameter from the request
    $gdi_id = sanitize_text_field($request->get_param('GDI_ID'));

    // Query products where meta key `gdi_id` matches the given value
    $args = array(
        'post_type'  => 'product',
        'meta_query' => array(
            array(
                'key'     => 'gdi_id',
                'value'   => $gdi_id,
                'compare' => '='
            )
        ),
        'posts_per_page' => -1, // Return all matching products
    );

    $query = new WP_Query($args);

    // Check if products are found
    if (!$query->have_posts()) {
        return new WP_REST_Response(array(
            'success' => false,
            'message' => 'No products found with the specified GDI_ID.',
        ), 404);
    }

    // Prepare response
    $products = [];
    foreach ($query->posts as $post) {
        $product = wc_get_product($post->ID);

        // Fetch all product details
        $products[] = [
            'id'               => $product->get_id(),
            'name'             => $product->get_name(),
            'type'             => $product->get_type(),
            'sku'              => $product->get_sku(),
            'price'            => $product->get_price(),
            'regular_price'    => $product->get_regular_price(),
            'sale_price'       => $product->get_sale_price(),
            'status'           => $product->get_status(),
            'stock_quantity'   => $product->get_stock_quantity(),
            'stock_status'     => $product->get_stock_status(),
            'total_sales'      => $product->get_total_sales(),
            'weight'           => $product->get_weight(),
            'dimensions'       => [
                'length' => $product->get_length(),
                'width'  => $product->get_width(),
                'height' => $product->get_height(),
            ],
            'categories'       => wp_get_post_terms($post->ID, 'product_cat', ['fields' => 'names']),
            'tags'             => wp_get_post_terms($post->ID, 'product_tag', ['fields' => 'names']),
            'images'           => $product->get_gallery_image_ids(), // Array of image IDs
            'featured_image'   => wp_get_attachment_url($product->get_image_id()), // Featured image URL
            'short_description'=> $product->get_short_description(),
            'description'      => $product->get_description(),
            'permalink'        => get_permalink($product->get_id()),
            'attributes'       => $product->get_attributes(),
            'GDI_ID'   => get_post_meta($product->get_id(), 'gdi_id', true),
            'CATEGORY_GDI_ID'   => get_post_meta($product->get_id(), 'category_gdi_id', true),
            'ARTICLE_GDI_ID'   => get_post_meta($product->get_id(), 'article_gdi_id', true),
        ];
    }


    return new WP_REST_Response(array(
        'success'  => true,
        'products' => $products,
    ), 200);
}

/***
 *
 * get product by ARTICLE_GDI_ID
 *
 */
add_action('rest_api_init', function () {
    register_rest_route('custom-api/v1', '/products-by-article-gdi', array(
        'methods' => 'GET',
        'callback' => 'get_products_by_article_gdi_id',
        'args' => array(
            'ARTICLE_GDI_ID' => array(
                'required' => true,
                'validate_callback' => function ($param) {
                    return is_string($param) && !empty($param);
                },
                'description' => 'The ARTICLE_GDI_ID of the products to fetch.',
            ),
        ),
        'permission_callback' => '__return_true', // Adjust permissions if needed
    ));
});

function get_products_by_article_gdi_id(WP_REST_Request $request) {
    // Get the ARTICLE_GDI_ID parameter from the request
    $article_gdi_id = sanitize_text_field($request->get_param('ARTICLE_GDI_ID'));

    // Query products where meta key `article_gdi_id` matches the given value
    $args = array(
        'post_type'  => 'product',
        'meta_query' => array(
            array(
                'key'     => 'article_gdi_id',
                'value'   => $article_gdi_id,
                'compare' => '='
            )
        ),
        'posts_per_page' => -1, // Return all matching products
    );

    $query = new WP_Query($args);

    // Check if products are found
    if (!$query->have_posts()) {
        return new WP_REST_Response(array(
            'success' => false,
            'message' => 'No products found with the specified ARTICLE_GDI_ID.',
        ), 404);
    }

    // Prepare response
    $products = [];
    foreach ($query->posts as $post) {
        $product = wc_get_product($post->ID);

        // Fetch all product details
        $products[] = [
            'id'               => $product->get_id(),
            'name'             => $product->get_name(),
            'type'             => $product->get_type(),
            'sku'              => $product->get_sku(),
            'price'            => $product->get_price(),
            'regular_price'    => $product->get_regular_price(),
            'sale_price'       => $product->get_sale_price(),
            'status'           => $product->get_status(),
            'stock_quantity'   => $product->get_stock_quantity(),
            'stock_status'     => $product->get_stock_status(),
            'total_sales'      => $product->get_total_sales(),
            'weight'           => $product->get_weight(),
            'dimensions'       => [
                'length' => $product->get_length(),
                'width'  => $product->get_width(),
                'height' => $product->get_height(),
            ],
            'categories'       => wp_get_post_terms($post->ID, 'product_cat', ['fields' => 'names']),
            'tags'             => wp_get_post_terms($post->ID, 'product_tag', ['fields' => 'names']),
            'images'           => $product->get_gallery_image_ids(), // Array of image IDs
            'featured_image'   => wp_get_attachment_url($product->get_image_id()), // Featured image URL
            'short_description'=> $product->get_short_description(),
            'description'      => $product->get_description(),
            'permalink'        => get_permalink($product->get_id()),
            'attributes'       => $product->get_attributes(),
            'GDI_ID'   => get_post_meta($product->get_id(), 'gdi_id', true),
            'CATEGORY_GDI_ID'   => get_post_meta($product->get_id(), 'category_gdi_id', true),
            'ARTICLE_GDI_ID'   => get_post_meta($product->get_id(), 'article_gdi_id', true),
        ];
    }

    return new WP_REST_Response(array(
        'success'  => true,
        'products' => $products,
    ), 200);
}


/***
 *
 * get product by CATEGORY_GDI_ID
 *
 */
add_action('rest_api_init', function () {
    register_rest_route('custom-api/v1', '/products-by-category-gdi', array(
        'methods' => 'GET',
        'callback' => 'get_products_by_category_gdi_id',
        'args' => array(
            'CATEGORY_GDI_ID' => array(
                'required' => true,
                'validate_callback' => function ($param) {
                    return is_string($param) && !empty($param);
                },
                'description' => 'The CATEGORY_GDI_ID of the products to fetch.',
            ),
        ),
        'permission_callback' => '__return_true', // Adjust permissions if needed
    ));
});

function get_products_by_category_gdi_id(WP_REST_Request $request) {
    // Get the CATEGORY_GDI_ID parameter from the request
    $category_gdi_id = sanitize_text_field($request->get_param('CATEGORY_GDI_ID'));

    // Query products where meta key `category_gdi_id` matches the given value
    $args = array(
        'post_type'  => 'product',
        'meta_query' => array(
            array(
                'key'     => 'category_gdi_id',
                'value'   => $category_gdi_id,
                'compare' => '='
            )
        ),
        'posts_per_page' => -1, // Return all matching products
    );

    $query = new WP_Query($args);

    // Check if products are found
    if (!$query->have_posts()) {
        return new WP_REST_Response(array(
            'success' => false,
            'message' => 'No products found with the specified CATEGORY_GDI_ID.',
        ), 404);
    }

    // Prepare response
    $products = [];
    foreach ($query->posts as $post) {
        $product = wc_get_product($post->ID);

        // Fetch all product details
        $products[] = [
            'id'               => $product->get_id(),
            'name'             => $product->get_name(),
            'type'             => $product->get_type(),
            'sku'              => $product->get_sku(),
            'price'            => $product->get_price(),
            'regular_price'    => $product->get_regular_price(),
            'sale_price'       => $product->get_sale_price(),
            'status'           => $product->get_status(),
            'stock_quantity'   => $product->get_stock_quantity(),
            'stock_status'     => $product->get_stock_status(),
            'total_sales'      => $product->get_total_sales(),
            'weight'           => $product->get_weight(),
            'dimensions'       => [
                'length' => $product->get_length(),
                'width'  => $product->get_width(),
                'height' => $product->get_height(),
            ],
            'categories'       => wp_get_post_terms($post->ID, 'product_cat', ['fields' => 'names']),
            'tags'             => wp_get_post_terms($post->ID, 'product_tag', ['fields' => 'names']),
            'images'           => $product->get_gallery_image_ids(), // Array of image IDs
            'featured_image'   => wp_get_attachment_url($product->get_image_id()), // Featured image URL
            'short_description'=> $product->get_short_description(),
            'description'      => $product->get_description(),
            'permalink'        => get_permalink($product->get_id()),
            'attributes'       => $product->get_attributes(),
            'GDI_ID'   => get_post_meta($product->get_id(), 'gdi_id', true),
            'CATEGORY_GDI_ID'   => get_post_meta($product->get_id(), 'category_gdi_id', true),
            'ARTICLE_GDI_ID'   => get_post_meta($product->get_id(), 'article_gdi_id', true),
        ];
    }

    return new WP_REST_Response(array(
        'success'  => true,
        'products' => $products,
    ), 200);
}
