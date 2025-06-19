<?php
/**
 * Order Customer Details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details-customer.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.7.0
 */

defined('ABSPATH') || exit;

$show_shipping = !wc_ship_to_billing_address_only() && $order->needs_shipping_address();
?>
<section class="woocommerce-customer-details">

    <?php if ($show_shipping) : ?>

    <section class="woocommerce-columns woocommerce-columns--2 woocommerce-columns--addresses col2-set addresses">
        <div class="woocommerce-column woocommerce-column--1 woocommerce-column--billing-address col-1">

            <?php endif; ?>

            <h2 class="woocommerce-column__title"><?php esc_html_e('Billing address', 'woocommerce'); ?></h2>
            <address>
                <?php
                $fields = $order->get_address('billing');

                foreach ($fields as $key => $field) {
                    if ('N/A' === $field) {
                        $fields[$key] = esc_html__('N/A', 'woocommerce');
                    }
                }
                // Add custom data.
                $fields['custom_label'] = 'Custom Value';
                // Construct the formatted address string.
                $formatted_address = "";
                $formatted_address .= isset($fields['first_name']) ? '<strong>' . __('First Name: ', 'woocommerce') . '</strong>' . $fields['first_name'] . '<br>' : '';
                $formatted_address .= isset($fields['last_name']) ? '<strong>' . __('Last Name: ', 'woocommerce') . '</strong>' . $fields['last_name'] . '<br>' : '';
                $formatted_address .= isset($fields['company']) ? '<strong>' . __('Company: ', 'woocommerce') . '</strong>' . $fields['company'] . '<br>' : '';
                $formatted_address .= isset($fields['address_1']) ? '<strong>' . __('Address 1: ', 'woocommerce') . '</strong>' . $fields['address_1'] . '<br>' : '';
                $formatted_address .= isset($fields['address_2']) ? '<strong>' . __('Address 2: ', 'woocommerce') . '</strong>' . $fields['address_2'] . '<br>' : '';
                $formatted_address .= isset($fields['city']) ? '<strong>' . __('City: ', 'woocommerce') . '</strong>' . $fields['city'] . '<br>' : '';
                $formatted_address .= isset($fields['state']) ? '<strong>' . __('Federal state / district: ', 'woocommerce') . '</strong>' . $fields['state'] . '<br>' : '';
                $formatted_address .= isset($fields['postcode']) ? '<strong>' . __('Zip code: ', 'woocommerce') . '</strong>' . $fields['postcode'] . '<br>' : '';
                $formatted_address .= isset($fields['country']) ? '<strong>' . __('Country: ', 'woocommerce') . '</strong>' . $fields['country'] . '<br>' : '';

                echo '<span class="gn-order-history-user-infos">' . $formatted_address . '</span>';
                ?>
                <?php if ($order->get_billing_phone()) : ?>
                    <div class="gn-wc-icon-phone"><p> <?php echo esc_html($order->get_billing_phone()); ?></p> </a>
                    </div>

                <?php endif; ?>

                <?php if ($order->get_billing_email()) : ?>
                    <div class="gn-wc-icon-email"><p><?php echo encode_mail(esc_html($order->get_billing_email()),"")  ?></p>
                    </div>

                <?php endif; ?>

                <?php
                /**
                 * Action hook fired after an address in the order customer details.
                 *
                 * @param string $address_type Type of address (billing or shipping).
                 * @param WC_Order $order Order object.
                 * @since 8.7.0
                 */
                do_action('woocommerce_order_details_after_customer_address', 'billing', $order);
                ?>
            </address>

            <?php if ($show_shipping) : ?>

        </div><!-- /.col-1 -->

        <div class="woocommerce-column woocommerce-column--2 woocommerce-column--shipping-address col-2">
            <h2 class="woocommerce-column__title"><?php esc_html_e('Shipping address', 'woocommerce'); ?></h2>
            <address>
                <?php echo wp_kses_post($order->get_formatted_shipping_address(esc_html__('N/A', 'woocommerce'))); ?>

                <?php if ($order->get_shipping_phone()) : ?>
                    <div class="gn-wc-icon-phone"><p> <?php echo esc_html($order->get_billing_phone()); ?></p> </a>
                    </div>
                <?php endif; ?>

                <?php
                /**
                 * Action hook fired after an address in the order customer details.
                 *
                 * @param string $address_type Type of address (billing or shipping).
                 * @param WC_Order $order Order object.
                 * @since 8.7.0
                 */
                do_action('woocommerce_order_details_after_customer_address', 'shipping', $order);
                ?>
            </address>
        </div><!-- /.col-2 -->

    </section><!-- /.col2-set -->

<?php endif; ?>

    <?php do_action('woocommerce_order_details_after_customer_details', $order); ?>

</section>
