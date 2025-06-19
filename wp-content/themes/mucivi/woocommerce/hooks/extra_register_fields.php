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
// Add extra register fields
add_action('woocommerce_register_form_start', 'mucivi_extra_register_fields');
function mucivi_extra_register_fields()
{
    ?>
    <!-- First name -->
    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="reg_billing_first_name"><?php _e('First name', 'woocommerce'); ?><span
                    class="required"> *</span></label>
        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="billing_first_name"
               id="reg_billing_first_name"
               maxlength="40"
               value="<?php if (!empty($_POST['billing_first_name'])) echo esc_attr($_POST['billing_first_name']); ?>"/>
    </p>

    <!-- Last name -->
    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="reg_billing_last_name"><?php _e('Last name', 'woocommerce'); ?><span
                    class="required"> *</span></label>
        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="billing_last_name"
               id="reg_billing_last_name"
               maxlength="40"
               value="<?php if (!empty($_POST['billing_last_name'])) echo esc_attr($_POST['billing_last_name']); ?>"/>
    </p>

    <!-- Company -->
    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="reg_billing_company"><?php _e('Company', 'woocommerce'); ?><span
                    class="required"> *</span></label></label>
        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="billing_company"
               id="reg_billing_company"
               maxlength="40"
               value="<?php if (!empty($_POST['billing_company'])) echo esc_attr($_POST['billing_company']); ?>"/>
    </p>

    <!-- Sales tax identification number -->
    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="reg_billing_vat">
            <?php _e('Sales tax identification number', 'woocommerce'); ?><span class="required"> *</span>
        </label>
        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="billing_vat"
               id="reg_billing_vat"
               maxlength="40"
               value="<?php if (!empty($_POST['billing_vat'])) echo esc_attr($_POST['billing_vat']); ?>"/>
        <span id="vat-error" style="color: red; display: none;"><?php _e('Invalid VAT number format', 'woocommerce'); ?></span>
    </p>

    <script>
        document.getElementById('reg_billing_vat').addEventListener('input', function () {
            const vat_number = this.value.trim().toUpperCase();
            const vat_error = document.getElementById('vat-error');

            const vat_formats = {
                'AT': /^ATU\d{8}$/,
                'BE': /^BE([01]\d{9}|\d{10})$/,
                'BG': /^BG\d{9,10}$/,
                'CY': /^CY\d{8}[A-Z]$/,
                'CZ': /^CZ\d{8,10}$/,
                'DE': /^DE\d{9}$/,
                'DK': /^DK\d{8}$/,
                'EE': /^EE\d{9}$/,
                'EL': /^EL\d{9}$/,
                'ES': /^ES[A-Z0-9]\d{7}[A-Z0-9]$/,
                'FI': /^FI\d{8}$/,
                'FR': /^FR[A-Z0-9]{2}\d{9}$/,
                'GB': /^GB(\d{9}|(GB)?(GD\d{3})|(GB)?(HA\d{3})|\d{12}|GD[0-4]\d{2}|HA[5-9]\d{2})$/,
                'HR': /^HR\d{11}$/,
                'HU': /^HU\d{8}$/,
                'IE': /^IE(\d{7}[A-Z]{1,2}|\d[A-Z]\d{5}[A-Z])$/,
                'IT': /^IT\d{11}$/,
                'LT': /^LT\d{9,12}$/,
                'LU': /^LU\d{8}$/,
                'LV': /^LV\d{11}$/,
                'MT': /^MT\d{8}$/,
                'NL': /^NL([0-9A-Z]{10}[0-9]{2}|[0-9]{9}B[0-9]{2})$/,
                'PL': /^PL\d{10}$/,
                'PT': /^PT\d{9}$/,
                'RO': /^RO\d{2,10}$/,
                'SE': /^SE\d{12}$/,
                'SI': /^SI\d{8}$/,
                'SM': /^SM\d{3,5}$/,
                'SK': /^SK\d{10}$/
            };

            const country_prefix = vat_number.slice(0, 2);
            const is_valid_format = vat_formats[country_prefix] && vat_formats[country_prefix].test(vat_number);

            if (is_valid_format) {
                vat_error.style.display = 'none'; // Hide error when valid
            } else {
                vat_error.style.display = 'inline'; // Show error when invalid
            }
        });
    </script>


    <!-- Country / Region -->
    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="reg_billing_country"><?php _e('Country / Region', 'woocommerce'); ?> <span class="required">*</span></label>
        <select class="woocommerce-Input woocommerce-Input--text input-text" name="billing_country" id="reg_billing_country">
            <option value="" disabled selected><?php _e('Select country / region ...', 'woocommerce'); ?></option>
            <?php
            $my_countries = array(
                'DE' => __('Germany', 'woocommerce'),
                'DK' => __('Denmark', 'woocommerce'),
                'FR' => __('France', 'woocommerce'),
                'IT' => __('Italy', 'woocommerce'),
                'NL' => __('Netherlands', 'woocommerce'),
                'PL' => __('Poland', 'woocommerce'),
                'SE' => __('Sweden', 'woocommerce'),
                'SI' => __('Slovenia', 'woocommerce'),
                'ES' => __('Spain', 'woocommerce'),
                'AT' => __('Austria', 'woocommerce'),
            );

            $selected_country = ( !empty($_POST['billing_country']) ) ? esc_attr($_POST['billing_country']) : '';
            foreach($my_countries as $code => $name ) {
                echo '<option value="'. $code .'" '. selected($selected_country, $code, false) .'>'. $name .'</option>';
            }
            ?>
        </select>
    </p>

    <!-- Street -->
    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="reg_billing_address_1"><?php _e('Street', 'woocommerce'); ?><span
                    class="required"> *</span></label></label>
        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="billing_address_1"
               id="reg_billing_address_1"
               maxlength="40"
               placeholder="<?php _e('Street name and house number', 'woocommerce'); ?>"
               value="<?php if (!empty($_POST['billing_address_1'])) echo esc_attr($_POST['billing_address_1']); ?>"/>
    </p>

    <!-- Postcode -->
    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="reg_billing_postcode"><?php _e('Postcode', 'woocommerce'); ?><span
                    class="required"> *</span></label></label>
        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="billing_postcode"
               id="reg_billing_postcode"
               maxlength="10"
               value="<?php if (!empty($_POST['billing_postcode'])) echo esc_attr($_POST['billing_postcode']); ?>"/>
    </p>

    <!-- City -->
    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="reg_billing_city"><?php _e('City / Place', 'woocommerce'); ?><span
                    class="required"> *</span></label></label>
        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="billing_city"
               id="reg_billing_city"
               maxlength="30"
               value="<?php if (!empty($_POST['billing_city'])) echo esc_attr($_POST['billing_city']); ?>"/>
    </p>

    <!-- State / County -->
    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="reg_billing_state"><?php _e('State / County (optional)', 'woocommerce'); ?></label>
        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="billing_state"
               id="reg_billing_state"
               maxlength="40"
               value="<?php if (!empty($_POST['billing_state'])) echo esc_attr($_POST['billing_state']); ?>"/>
    </p>

    <!-- Phone -->
    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="reg_billing_phone"><?php _e('Phone', 'woocommerce'); ?><span class="required"> *</span></label>
        <input type="tel" class="woocommerce-Input woocommerce-Input--tel input-tel" name="billing_phone"
               id="reg_billing_phone"
               maxlength="40"
               value="<?php if (!empty($_POST['billing_phone'])) echo esc_attr($_POST['billing_phone']); ?>"/>
    </p>
    <div class="clear"></div>
    <?php
}


/* Validation during registration process */
// Validate VAT number during registration
add_filter('woocommerce_registration_errors', 'mucivi_validate_vat_number', 10, 3);
function mucivi_validate_vat_number($errors, $username, $email) {
    if (empty($_POST['billing_vat'])) {
        $errors->add('billing_vat_error', __('Sales tax identification number is required.', 'woocommerce'));
    } else {
        $vat_number = strtoupper(trim($_POST['billing_vat']));
        $vat_formats = array(
            'AT' => '/^ATU\d{8}$/',
            'BE' => '/^BE([01]\d{9}|\d{10})$/',
            'BG' => '/^BG\d{9,10}$/',
            'CY' => '/^CY\d{8}[A-Z]$/',
            'CZ' => '/^CZ\d{8,10}$/',
            'DE' => '/^DE\d{9}$/',
            'DK' => '/^DK\d{8}$/',
            'EE' => '/^EE\d{9}$/',
            'EL' => '/^EL\d{9}$/',
            'ES' => '/^ES[A-Z0-9]\d{7}[A-Z0-9]$/',
            'FI' => '/^FI\d{8}$/',
            'FR' => '/^FR[A-Z0-9]{2}\d{9}$/',
            'GB' => '/^GB(\d{9}|(GB)?(GD\d{3})|(GB)?(HA\d{3})|\d{12}|GD[0-4]\d{2}|HA[5-9]\d{2})$/',
            'HR' => '/^HR\d{11}$/',
            'HU' => '/^HU\d{8}$/',
            'IE' => '/^IE(\d{7}[A-Z]{1,2}|\d[A-Z]\d{5}[A-Z])$/',
            'IT' => '/^IT\d{11}$/',
            'LT' => '/^LT\d{9,12}$/',
            'LU' => '/^LU\d{8}$/',
            'LV' => '/^LV\d{11}$/',
            'MT' => '/^MT\d{8}$/',
            'NL' => '/^NL([0-9A-Z]{10}[0-9]{2}|[0-9]{9}B[0-9]{2})$/',
            'PL' => '/^PL\d{10}$/',
            'PT' => '/^PT\d{9}$/',
            'RO' => '/^RO\d{2,10}$/',
            'SE' => '/^SE\d{12}$/',
            'SI' => '/^SI\d{8}$/',
            'SM' => '/^SM\d{3,5}$/',
            'SK' => '/^SK\d{10}$/'
        );

        $country_prefix = substr($vat_number, 0, 2);

        if (!isset($vat_formats[$country_prefix]) || !preg_match($vat_formats[$country_prefix], $vat_number)) {
            $errors->add('billing_vat_error', __('Invalid Sales tax identification number format.', 'woocommerce'));
        }
    }

    return $errors;
}


// Save the extra register fields values
add_action('woocommerce_created_customer', 'mucivi_save_extra_register_fields');
function mucivi_save_extra_register_fields($customer_id)
{
    if (isset($_POST['billing_first_name'])) {
        update_user_meta($customer_id, 'billing_first_name', sanitize_text_field($_POST['billing_first_name']));
        update_user_meta($customer_id, 'first_name', sanitize_text_field($_POST['billing_first_name']));
    }
    if (isset($_POST['billing_last_name'])) {
        update_user_meta($customer_id, 'billing_last_name', sanitize_text_field($_POST['billing_last_name']));
        update_user_meta($customer_id, 'last_name', sanitize_text_field($_POST['billing_last_name']));
    }
    if (isset($_POST['billing_company'])) {
        update_user_meta($customer_id, 'billing_company', sanitize_text_field($_POST['billing_company']));
    }
    if (isset($_POST['billing_vat'])) {
        update_user_meta($customer_id, 'billing_vat', sanitize_text_field($_POST['billing_vat']));
    }
    if (isset($_POST['billing_country'])) {
        update_user_meta($customer_id, 'billing_country', sanitize_text_field($_POST['billing_country']));
    }
    if (isset($_POST['billing_address_1'])) {
        update_user_meta($customer_id, 'billing_address_1', sanitize_text_field($_POST['billing_address_1']));
    }
    if (isset($_POST['billing_postcode'])) {
        update_user_meta($customer_id, 'billing_postcode', sanitize_text_field($_POST['billing_postcode']));
    }
    if (isset($_POST['billing_city'])) {
        update_user_meta($customer_id, 'billing_city', sanitize_text_field($_POST['billing_city']));
    }
    if (isset($_POST['billing_state'])) {
        update_user_meta($customer_id, 'billing_state', sanitize_text_field($_POST['billing_state']));
    }
    if (isset($_POST['billing_phone'])) {
        update_user_meta($customer_id, 'billing_phone', sanitize_text_field($_POST['billing_phone']));
    }
}


/* edit profile in backend */
// Add VAT field to the user profile edit page
add_action( 'woocommerce_edit_account_form', 'add_vat_field_to_edit_profile' );
function add_vat_field_to_edit_profile() {
    $user_id = get_current_user_id();
    $billing_vat = get_user_meta( $user_id, 'billing_vat', true );
    ?>
    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="billing_vat"><?php _e('Sales tax identification number', 'woocommerce'); ?><span class="required"> *</span></label>
        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="billing_vat" id="billing_vat" value="<?php echo esc_attr( $billing_vat ); ?>" />
        <span id="vat-error" style="color: red; display: none;"><?php _e('Invalid VAT number format', 'woocommerce'); ?></span>
    </p>
    <?php
}

// Save the VAT field value when the user updates their profile
add_action( 'woocommerce_save_account_details', 'save_vat_field_in_profile', 10, 1 );
function save_vat_field_in_profile( $user_id ) {
    if ( isset( $_POST['billing_vat'] ) ) {
        update_user_meta( $user_id, 'billing_vat', sanitize_text_field( $_POST['billing_vat'] ) );
    }
}

// Validate the VAT field when the user updates their profile
add_action( 'woocommerce_save_account_details_errors', 'validate_vat_field', 10, 1 );
function validate_vat_field( $args ) {
    if ( empty( $_POST['billing_vat'] ) ) {
        $args->add( 'error', __( 'Please provide your Sales tax identification number.', 'woocommerce' ) );
    }
}


// Save VAT field on registration
add_action( 'woocommerce_created_customer', 'save_vat_field_on_registration' );
function save_vat_field_on_registration( $customer_id ) {
    if ( isset( $_POST['billing_vat'] ) ) {
        update_user_meta( $customer_id, 'billing_vat', sanitize_text_field( $_POST['billing_vat'] ) );
    }
}

// Validation for VAT Format in Edit profile
add_action( 'wp_footer', 'vat_field_validation_script' );
function vat_field_validation_script() {
    if ( is_account_page() ) {
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                $('#billing_vat, #reg_billing_vat').on('input', function() {
                    var vat_number = $(this).val().trim().toUpperCase();
                    var vat_error = $('#vat-error');

                    var vat_formats = {
                        'AT': /^ATU\d{8}$/,
                        'BE': /^BE([01]\d{9}|\d{10})$/,
                        'BG': /^BG\d{9,10}$/,
                        'CY': /^CY\d{8}[A-Z]$/,
                        'CZ': /^CZ\d{8,10}$/,
                        'DE': /^DE\d{9}$/,
                        'DK': /^DK\d{8}$/,
                        'EE': /^EE\d{9}$/,
                        'EL': /^EL\d{9}$/,
                        'ES': /^ES[A-Z0-9]\d{7}[A-Z0-9]$/,
                        'FI': /^FI\d{8}$/,
                        'FR': /^FR[A-Z0-9]{2}\d{9}$/,
                        'GB': /^GB(\d{9}|(GB)?(GD\d{3})|(GB)?(HA\d{3})|\d{12}|GD[0-4]\d{2}|HA[5-9]\d{2})$/,
                        'HR': /^HR\d{11}$/,
                        'HU': /^HU\d{8}$/,
                        'IE': /^IE(\d{7}[A-Z]{1,2}|\d[A-Z]\d{5}[A-Z])$/,
                        'IT': /^IT\d{11}$/,
                        'LT': /^LT\d{9,12}$/,
                        'LU': /^LU\d{8}$/,
                        'LV': /^LV\d{11}$/,
                        'MT': /^MT\d{8}$/,
                        'NL': /^NL([0-9A-Z]{10}[0-9]{2}|[0-9]{9}B[0-9]{2})$/,
                        'PL': /^PL\d{10}$/,
                        'PT': /^PT\d{9}$/,
                        'RO': /^RO\d{2,10}$/,
                        'SE': /^SE\d{12}$/,
                        'SI': /^SI\d{8}$/,
                        'SM': /^SM\d{3,5}$/,
                        'SK': /^SK\d{10}$/
                    };

                    var country_prefix = vat_number.slice(0, 2);
                    var is_valid_format = vat_formats[country_prefix] && vat_formats[country_prefix].test(vat_number);

                    if (!is_valid_format) {
                        vat_error.show();
                    } else {
                        vat_error.hide();
                    }
                });
            });
        </script>
        <?php
    }
}

/* backend VAT Nummer in admin panel of user profile */
function validate_vat_number( $vat_number ) {

    // Example:
    $vat_formats = array(
        'AT' => '/^ATU\d{8}$/',
        'BE' => '/^BE([01]\d{9}|\d{10})$/',
        'BG' => '/^BG\d{9,10}$/',
        'CY' => '/^CY\d{8}[A-Z]$/',
        'CZ' => '/^CZ\d{8,10}$/',
        'DE' => '/^DE\d{9}$/',
        'DK' => '/^DK\d{8}$/',
        'EE' => '/^EE\d{9}$/',
        'EL' => '/^EL\d{9}$/',
        'ES' => '/^ES[A-Z0-9]\d{7}[A-Z0-9]$/',
        'FI' => '/^FI\d{8}$/',
        'FR' => '/^FR[A-Z0-9]{2}\d{9}$/',
        'GB' => '/^GB(\d{9}|(GB)?(GD\d{3})|(GB)?(HA\d{3})|\d{12}|GD[0-4]\d{2}|HA[5-9]\d{2})$/',
        'HR' => '/^HR\d{11}$/',
        'HU' => '/^HU\d{8}$/',
        'IE' => '/^IE(\d{7}[A-Z]{1,2}|\d[A-Z]\d{5}[A-Z])$/',
        'IT' => '/^IT\d{11}$/',
        'LT' => '/^LT\d{9,12}$/',
        'LU' => '/^LU\d{8}$/',
        'LV' => '/^LV\d{11}$/',
        'MT' => '/^MT\d{8}$/',
        'NL' => '/^NL([0-9A-Z]{10}[0-9]{2}|[0-9]{9}B[0-9]{2})$/',
        'PL' => '/^PL\d{10}$/',
        'PT' => '/^PT\d{9}$/',
        'RO' => '/^RO\d{2,10}$/',
        'SE' => '/^SE\d{12}$/',
        'SI' => '/^SI\d{8}$/',
        'SM' => '/^SM\d{3,5}$/',
        'SK' => '/^SK\d{10}$/'
    );


    $country_prefix = substr($vat_number, 0, 2);
    return isset($vat_formats[$country_prefix]) && preg_match($vat_formats[$country_prefix], $vat_number) === 1;
}

add_action('show_user_profile', 'show_vat_field_in_admin', 20);
add_action('edit_user_profile', 'show_vat_field_in_admin', 20);

function show_vat_field_in_admin($user) {
    $billing_vat = get_the_author_meta('billing_vat', $user->ID);

    echo '<table class="form-table">
        <tr>
            <th><label for="billing_vat">'. __('Sales tax identification number', 'mucivi') .'</label></th>
            <td><input type="text" name="billing_vat" id="billing_vat" value="'. esc_attr( $billing_vat ) .'" class="regular-text" /><br /></td>
        </tr>
    </table>';
}

add_action( 'user_profile_update_errors', 'save_vat_field_from_admin', 10, 3 );

function save_vat_field_from_admin( &$errors, $update, &$user ) {
    if ( !current_user_can( 'edit_user', $user->ID ) )
        return false;

    if ( isset($_POST['billing_vat']) ) {
        $vat = sanitize_text_field($_POST['billing_vat']);
        if (!validate_vat_number($vat))
        {
            // Add our error
            $errors->add( 'invalid_vat', '<strong>ERROR</strong>: ' . __( 'Invalid VAT number format', 'woocommerce' ) );
        }
        else
        {
            update_user_meta($user->ID, 'billing_vat', $vat);
        }
    }
}

// Hook into WooCommerce to add maxlength attributes to the registration form fields
add_action( 'woocommerce_register_form', 'custom_add_maxlength_to_registration_fields' );

// Function to add maxlength attributes to the registration form fields
function custom_add_maxlength_to_registration_fields() {
    ?>
    <script type="text/javascript">
        // Add maxlength attribute to the username field (maximum 40 characters)
        document.getElementById('reg_username').setAttribute('maxlength', '40');

        // Add maxlength attribute to the email field (maximum 255 characters)
        document.getElementById('reg_email').setAttribute('maxlength', '255');
    </script>
    <?php
}



// Hook into WooCommerce to modify the checkout fields
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );

// Function to override WooCommerce default checkout fields and set character limits
function custom_override_checkout_fields( $fields ) {

    // Limit for billing fields
    $fields['billing']['billing_first_name']['maxlength'] = 40;
    $fields['billing']['billing_last_name']['maxlength'] = 40;
    $fields['billing']['billing_company']['maxlength'] = 40;
    $fields['billing']['billing_address_1']['maxlength'] = 40;
    $fields['billing']['billing_address_2']['maxlength'] = 40;
    $fields['billing']['billing_city']['maxlength'] = 30;
    $fields['billing']['billing_postcode']['maxlength'] = 10;
    $fields['billing']['billing_country']['maxlength'] = 2;
    $fields['billing']['billing_email']['maxlength'] = 255;
    $fields['billing']['billing_phone']['maxlength'] = 40;
    $fields['billing']['billing_title']['maxlength'] = 20;

    // Limit for shipping fields if applicable (you can repeat the same for shipping fields)
    $fields['shipping']['shipping_first_name']['maxlength'] = 40;
    $fields['shipping']['shipping_last_name']['maxlength'] = 40;
    $fields['shipping']['shipping_company']['maxlength'] = 40;
    $fields['shipping']['shipping_address_1']['maxlength'] = 40;
    $fields['shipping']['shipping_address_2']['maxlength'] = 40;
    $fields['shipping']['shipping_city']['maxlength'] = 30;
    $fields['shipping']['shipping_postcode']['maxlength'] = 10;
    $fields['shipping']['shipping_country']['maxlength'] = 2;

    return $fields;
}


// Hook into WooCommerce to modify the billing fields in My Account
add_filter( 'woocommerce_billing_fields', 'custom_override_billing_fields_in_my_account' );

// Function to override WooCommerce default billing fields and set character limits in My Account
function custom_override_billing_fields_in_my_account( $fields ) {

    // Limit for billing fields in My Account
    $fields['billing_first_name']['maxlength'] = 40;
    $fields['billing_last_name']['maxlength'] = 40;
    $fields['billing_company']['maxlength'] = 40;
    $fields['billing_address_1']['maxlength'] = 40;
    $fields['billing_address_2']['maxlength'] = 40;
    $fields['billing_city']['maxlength'] = 30;
    $fields['billing_postcode']['maxlength'] = 10;
    $fields['billing_country']['maxlength'] = 2;
    $fields['billing_email']['maxlength'] = 255;
    $fields['billing_phone']['maxlength'] = 40;
    $fields['billing_title']['maxlength'] = 20;

    return $fields;
}

// Hook into WooCommerce to modify the shipping fields in My Account
add_filter( 'woocommerce_shipping_fields', 'custom_override_shipping_fields_in_my_account' );

// Function to override WooCommerce default shipping fields and set character limits in My Account
function custom_override_shipping_fields_in_my_account( $fields ) {

    // Limit for shipping fields in My Account
    $fields['shipping_first_name']['maxlength'] = 40;
    $fields['shipping_last_name']['maxlength'] = 40;
    $fields['shipping_company']['maxlength'] = 40;
    $fields['shipping_address_1']['maxlength'] = 40;
    $fields['shipping_address_2']['maxlength'] = 40;
    $fields['shipping_city']['maxlength'] = 30;
    $fields['shipping_postcode']['maxlength'] = 10;
    $fields['shipping_country']['maxlength'] = 2;

    return $fields;
}


/* remove billing title */
// Remove billing_title field from the WooCommerce checkout
add_filter( 'woocommerce_checkout_fields', 'remove_billing_title_field' );

function remove_billing_title_field( $fields ) {
    if ( isset( $fields['billing']['billing_title'] ) ) {
        unset( $fields['billing']['billing_title'] );
    }

    return $fields;
}


// Remove a billing field in My Account
add_filter( 'woocommerce_billing_fields', 'custom_remove_billing_fields_in_my_account' );

function custom_remove_billing_fields_in_my_account( $fields ) {
    // Remove the 'billing_title' field
    if ( isset( $fields['billing_title'] ) ) {
        unset( $fields['billing_title'] );
    }

    return $fields;
}


