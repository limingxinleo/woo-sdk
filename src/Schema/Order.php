<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace Woo\Schema;

/**
 * WooCommerce Order 数据模型.
 *
 * @see https://woocommerce.github.io/woocommerce-rest-api-docs/#orders
 */
class Order
{
    /**
     * @param int $id Unique identifier for the resource. READ-ONLY
     * @param int $parent_id Parent order ID
     * @param string $number Order number. READ-ONLY
     * @param string $order_key Order key. READ-ONLY
     * @param string $created_via Shows where the order was created
     * @param string $version Version of WooCommerce which last updated the order. READ-ONLY
     * @param string $status Order status: pending, processing, on-hold, completed, cancelled, refunded, failed, trash
     * @param string $currency Currency the order was created with, in ISO format
     * @param string $date_created The date the order was created, in the site's timezone. READ-ONLY
     * @param string $date_created_gmt The date the order was created, as GMT. READ-ONLY
     * @param string $date_modified The date the order was last modified, in the site's timezone. READ-ONLY
     * @param string $date_modified_gmt The date the order was last modified, as GMT. READ-ONLY
     * @param string $discount_total Total discount amount for the order. READ-ONLY
     * @param string $discount_tax Total discount tax amount for the order. READ-ONLY
     * @param string $shipping_total Total shipping amount for the order. READ-ONLY
     * @param string $shipping_tax Total shipping tax amount for the order. READ-ONLY
     * @param string $cart_tax Sum of line item taxes only. READ-ONLY
     * @param string $total Grand total. READ-ONLY
     * @param string $total_tax Sum of all taxes. READ-ONLY
     * @param bool $prices_include_tax True if prices included tax during checkout. READ-ONLY
     * @param int $customer_id User ID who owns the order. 0 for guests
     * @param string $customer_ip_address Customer's IP address. READ-ONLY
     * @param string $customer_user_agent User agent of the customer. READ-ONLY
     * @param string $customer_note Note left by customer during checkout
     * @param null|OrderBilling $billing Billing address
     * @param null|OrderShipping $shipping Shipping address
     * @param string $payment_method Payment method ID
     * @param string $payment_method_title Payment method title
     * @param string $transaction_id Unique transaction ID
     * @param string $date_paid The date the order was paid, in the site's timezone. READ-ONLY
     * @param string $date_paid_gmt The date the order was paid, as GMT. READ-ONLY
     * @param string $date_completed The date the order was completed, in the site's timezone. READ-ONLY
     * @param string $date_completed_gmt The date the order was completed, as GMT. READ-ONLY
     * @param string $cart_hash MD5 hash of cart items. READ-ONLY
     * @param OrderMetadata[] $meta_data Meta data
     * @param OrderLineItem[] $line_items Line items data
     * @param OrderTaxLine[] $tax_lines Tax lines data. READ-ONLY
     * @param OrderShippingLine[] $shipping_lines Shipping lines data
     * @param OrderFeeLine[] $fee_lines Fee lines data
     * @param OrderCouponLine[] $coupon_lines Coupons line data
     * @param OrderRefund[] $refunds List of refunds. READ-ONLY
     * @param bool $set_paid Define if the order is paid. WRITE-ONLY
     */
    public function __construct(
        public int $id = 0,
        public int $parent_id = 0,
        public string $number = '',
        public string $order_key = '',
        public string $created_via = '',
        public string $version = '',
        public string $status = '',
        public string $currency = '',
        public string $date_created = '',
        public string $date_created_gmt = '',
        public string $date_modified = '',
        public string $date_modified_gmt = '',
        public string $discount_total = '',
        public string $discount_tax = '',
        public string $shipping_total = '',
        public string $shipping_tax = '',
        public string $cart_tax = '',
        public string $total = '',
        public string $total_tax = '',
        public bool $prices_include_tax = false,
        public int $customer_id = 0,
        public string $customer_ip_address = '',
        public string $customer_user_agent = '',
        public string $customer_note = '',
        public ?OrderBilling $billing = null,
        public ?OrderShipping $shipping = null,
        public string $payment_method = '',
        public string $payment_method_title = '',
        public string $transaction_id = '',
        public string $date_paid = '',
        public string $date_paid_gmt = '',
        public string $date_completed = '',
        public string $date_completed_gmt = '',
        public string $cart_hash = '',
        public array $meta_data = [],
        public array $line_items = [],
        public array $tax_lines = [],
        public array $shipping_lines = [],
        public array $fee_lines = [],
        public array $coupon_lines = [],
        public array $refunds = [],
        public bool $set_paid = false,
    ) {
    }
}
