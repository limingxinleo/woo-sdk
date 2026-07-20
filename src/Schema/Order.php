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

use Hyperf\Contract\JsonDeSerializable;
use JsonSerializable;

use function Woo\bool_or_null;
use function Woo\int_or_null;
use function Woo\string_or_null;

/**
 * WooCommerce Order 数据模型.
 *
 * @see https://woocommerce.github.io/woocommerce-rest-api-docs/#orders
 */
class Order implements JsonSerializable, JsonDeSerializable
{
    /**
     * @param null|int $id Unique identifier for the resource. READ-ONLY
     * @param null|int $parent_id Parent order ID
     * @param null|string $number Order number. READ-ONLY
     * @param null|string $order_key Order key. READ-ONLY
     * @param null|string $created_via Shows where the order was created. It can only be set during order creation and cannot be modified afterward
     * @param null|string $version Version of WooCommerce which last updated the order. READ-ONLY
     * @param null|string $status Order status. Options: pending, processing, on-hold, completed, cancelled, refunded, failed and trash. Default is pending
     * @param null|string $currency Currency the order was created with, in ISO format. Default is USD
     * @param null|string $date_created The date the order was created, in the site's timezone. READ-ONLY
     * @param null|string $date_created_gmt The date the order was created, as GMT. READ-ONLY
     * @param null|string $date_modified The date the order was last modified, in the site's timezone. READ-ONLY
     * @param null|string $date_modified_gmt The date the order was last modified, as GMT. READ-ONLY
     * @param null|string $discount_total Total discount amount for the order. READ-ONLY
     * @param null|string $discount_tax Total discount tax amount for the order. READ-ONLY
     * @param null|string $shipping_total Total shipping amount for the order. READ-ONLY
     * @param null|string $shipping_tax Total shipping tax amount for the order. READ-ONLY
     * @param null|string $cart_tax Sum of line item taxes only. READ-ONLY
     * @param null|string $total Grand total. READ-ONLY
     * @param null|string $total_tax Sum of all taxes. READ-ONLY
     * @param null|bool $prices_include_tax True the prices included tax during checkout. READ-ONLY
     * @param null|int $customer_id User ID who owns the order. 0 for guests. Default is 0
     * @param null|string $customer_ip_address Customer's IP address. READ-ONLY
     * @param null|string $customer_user_agent User agent of the customer. READ-ONLY
     * @param null|string $customer_note Note left by customer during checkout
     * @param null|OrderBilling $billing Billing address
     * @param null|OrderShipping $shipping Shipping address
     * @param null|string $payment_method Payment method ID
     * @param null|string $payment_method_title Payment method title
     * @param null|string $transaction_id Unique transaction ID
     * @param null|string $date_paid The date the order was paid, in the site's timezone. READ-ONLY
     * @param null|string $date_paid_gmt The date the order was paid, as GMT. READ-ONLY
     * @param null|string $date_completed The date the order was completed, in the site's timezone. READ-ONLY
     * @param null|string $date_completed_gmt The date the order was completed, as GMT. READ-ONLY
     * @param null|string $cart_hash MD5 hash of cart items to ensure orders are not modified. READ-ONLY
     * @param null|OrderMetadata[] $meta_data Meta data
     * @param null|OrderLineItem[] $line_items Line items data
     * @param null|OrderTaxLine[] $tax_lines Tax lines data. READ-ONLY
     * @param null|OrderShippingLine[] $shipping_lines Shipping lines data
     * @param null|OrderFeeLine[] $fee_lines Fee lines data
     * @param null|OrderCouponLine[] $coupon_lines Coupons line data
     * @param null|OrderRefund[] $refunds List of refunds. READ-ONLY
     * @param null|bool $set_paid Define if the order is paid. It will set the status to processing and reduce stock items. Default is false. WRITE-ONLY
     */
    public function __construct(
        public ?int $id = null,
        public ?int $parent_id = null,
        public ?string $number = null,
        public ?string $order_key = null,
        public ?string $created_via = null,
        public ?string $version = null,
        public ?string $status = null,
        public ?string $currency = null,
        public ?string $date_created = null,
        public ?string $date_created_gmt = null,
        public ?string $date_modified = null,
        public ?string $date_modified_gmt = null,
        public ?string $discount_total = null,
        public ?string $discount_tax = null,
        public ?string $shipping_total = null,
        public ?string $shipping_tax = null,
        public ?string $cart_tax = null,
        public ?string $total = null,
        public ?string $total_tax = null,
        public ?bool $prices_include_tax = null,
        public ?int $customer_id = null,
        public ?string $customer_ip_address = null,
        public ?string $customer_user_agent = null,
        public ?string $customer_note = null,
        public ?OrderBilling $billing = null,
        public ?OrderShipping $shipping = null,
        public ?string $payment_method = null,
        public ?string $payment_method_title = null,
        public ?string $transaction_id = null,
        public ?string $date_paid = null,
        public ?string $date_paid_gmt = null,
        public ?string $date_completed = null,
        public ?string $date_completed_gmt = null,
        public ?string $cart_hash = null,
        public ?array $meta_data = null,
        public ?array $line_items = null,
        public ?array $tax_lines = null,
        public ?array $shipping_lines = null,
        public ?array $fee_lines = null,
        public ?array $coupon_lines = null,
        public ?array $refunds = null,
        public ?bool $set_paid = null,
    ) {
    }

    public static function jsonDeSerialize(mixed $data): static
    {
        return new static(
            int_or_null($data['id'] ?? null),
            int_or_null($data['parent_id'] ?? null),
            string_or_null($data['number'] ?? null),
            string_or_null($data['order_key'] ?? null),
            string_or_null($data['created_via'] ?? null),
            string_or_null($data['version'] ?? null),
            string_or_null($data['status'] ?? null),
            string_or_null($data['currency'] ?? null),
            string_or_null($data['date_created'] ?? null),
            string_or_null($data['date_created_gmt'] ?? null),
            string_or_null($data['date_modified'] ?? null),
            string_or_null($data['date_modified_gmt'] ?? null),
            string_or_null($data['discount_total'] ?? null),
            string_or_null($data['discount_tax'] ?? null),
            string_or_null($data['shipping_total'] ?? null),
            string_or_null($data['shipping_tax'] ?? null),
            string_or_null($data['cart_tax'] ?? null),
            string_or_null($data['total'] ?? null),
            string_or_null($data['total_tax'] ?? null),
            bool_or_null($data['prices_include_tax'] ?? null),
            int_or_null($data['customer_id'] ?? null),
            string_or_null($data['customer_ip_address'] ?? null),
            string_or_null($data['customer_user_agent'] ?? null),
            string_or_null($data['customer_note'] ?? null),
            isset($data['billing']) && is_array($data['billing']) ? OrderBilling::jsonDeSerialize($data['billing']) : null,
            isset($data['shipping']) && is_array($data['shipping']) ? OrderShipping::jsonDeSerialize($data['shipping']) : null,
            string_or_null($data['payment_method'] ?? null),
            string_or_null($data['payment_method_title'] ?? null),
            string_or_null($data['transaction_id'] ?? null),
            string_or_null($data['date_paid'] ?? null),
            string_or_null($data['date_paid_gmt'] ?? null),
            string_or_null($data['date_completed'] ?? null),
            string_or_null($data['date_completed_gmt'] ?? null),
            string_or_null($data['cart_hash'] ?? null),
            isset($data['meta_data']) && is_array($data['meta_data'])
                ? array_map(static fn (array $item) => OrderMetadata::jsonDeSerialize($item), $data['meta_data'])
                : null,
            isset($data['line_items']) && is_array($data['line_items'])
                ? array_map(static fn (array $item) => OrderLineItem::jsonDeSerialize($item), $data['line_items'])
                : null,
            isset($data['tax_lines']) && is_array($data['tax_lines'])
                ? array_map(static fn (array $item) => OrderTaxLine::jsonDeSerialize($item), $data['tax_lines'])
                : null,
            isset($data['shipping_lines']) && is_array($data['shipping_lines'])
                ? array_map(static fn (array $item) => OrderShippingLine::jsonDeSerialize($item), $data['shipping_lines'])
                : null,
            isset($data['fee_lines']) && is_array($data['fee_lines'])
                ? array_map(static fn (array $item) => OrderFeeLine::jsonDeSerialize($item), $data['fee_lines'])
                : null,
            isset($data['coupon_lines']) && is_array($data['coupon_lines'])
                ? array_map(static fn (array $item) => OrderCouponLine::jsonDeSerialize($item), $data['coupon_lines'])
                : null,
            isset($data['refunds']) && is_array($data['refunds'])
                ? array_map(static fn (array $item) => OrderRefund::jsonDeSerialize($item), $data['refunds'])
                : null,
            bool_or_null($data['set_paid'] ?? null),
        );
    }

    public function jsonSerialize(): mixed
    {
        return array_filter([
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'number' => $this->number,
            'order_key' => $this->order_key,
            'created_via' => $this->created_via,
            'version' => $this->version,
            'status' => $this->status,
            'currency' => $this->currency,
            'date_created' => $this->date_created,
            'date_created_gmt' => $this->date_created_gmt,
            'date_modified' => $this->date_modified,
            'date_modified_gmt' => $this->date_modified_gmt,
            'discount_total' => $this->discount_total,
            'discount_tax' => $this->discount_tax,
            'shipping_total' => $this->shipping_total,
            'shipping_tax' => $this->shipping_tax,
            'cart_tax' => $this->cart_tax,
            'total' => $this->total,
            'total_tax' => $this->total_tax,
            'prices_include_tax' => $this->prices_include_tax,
            'customer_id' => $this->customer_id,
            'customer_ip_address' => $this->customer_ip_address,
            'customer_user_agent' => $this->customer_user_agent,
            'customer_note' => $this->customer_note,
            'billing' => $this->billing,
            'shipping' => $this->shipping,
            'payment_method' => $this->payment_method,
            'payment_method_title' => $this->payment_method_title,
            'transaction_id' => $this->transaction_id,
            'date_paid' => $this->date_paid,
            'date_paid_gmt' => $this->date_paid_gmt,
            'date_completed' => $this->date_completed,
            'date_completed_gmt' => $this->date_completed_gmt,
            'cart_hash' => $this->cart_hash,
            'meta_data' => $this->meta_data,
            'line_items' => $this->line_items,
            'tax_lines' => $this->tax_lines,
            'shipping_lines' => $this->shipping_lines,
            'fee_lines' => $this->fee_lines,
            'coupon_lines' => $this->coupon_lines,
            'refunds' => $this->refunds,
            'set_paid' => $this->set_paid,
        ], static fn (mixed $value) => $value !== null);
    }
}
