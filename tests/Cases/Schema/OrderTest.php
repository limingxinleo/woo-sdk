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

namespace HyperfTest\Cases\Schema;

use HyperfTest\Cases\AbstractTestCase;
use Woo\Schema\Order;
use Woo\Schema\OrderBilling;
use Woo\Schema\OrderLineItem;
use Woo\Schema\OrderMetadata;
use Woo\Schema\OrderShipping;
use Woo\Schema\OrderShippingLine;

/**
 * @internal
 * @coversNothing
 */
class OrderTest extends AbstractTestCase
{
    public function testJsonDeSerializeCastsTypes(): void
    {
        $order = Order::jsonDeSerialize($this->orderData());

        // int 字段强转
        $this->assertSame(727, $order->id);
        $this->assertIsInt($order->id);
        $this->assertSame(0, $order->parent_id);
        $this->assertSame(0, $order->customer_id);

        // bool 字段强转
        $this->assertFalse($order->prices_include_tax);
        $this->assertIsBool($order->prices_include_tax);
        $this->assertTrue($order->set_paid);
        $this->assertIsBool($order->set_paid);

        // string 字段
        $this->assertSame('53.98', $order->total);
        $this->assertSame('processing', $order->status);

        // 字符串数字输入强转为 int
        $casted = Order::jsonDeSerialize(['id' => '123', 'parent_id' => '5', 'customer_id' => '9']);
        $this->assertSame(123, $casted->id);
        $this->assertIsInt($casted->id);
        $this->assertSame(5, $casted->parent_id);
        $this->assertSame(9, $casted->customer_id);
    }

    public function testNestedObjectsAndArrays(): void
    {
        $order = Order::jsonDeSerialize($this->orderData());

        $this->assertInstanceOf(OrderBilling::class, $order->billing);
        $this->assertSame('john.doe@example.com', $order->billing->email);

        $this->assertInstanceOf(OrderShipping::class, $order->shipping);
        $this->assertSame('US', $order->shipping->country);

        $this->assertCount(1, $order->line_items);
        $this->assertInstanceOf(OrderLineItem::class, $order->line_items[0]);
        $this->assertSame(93, $order->line_items[0]->product_id);
        $this->assertSame(2, $order->line_items[0]->quantity);
        $this->assertSame('21.99', $order->line_items[0]->price);

        $this->assertInstanceOf(OrderShippingLine::class, $order->shipping_lines[0]);
        $this->assertSame('flat_rate', $order->shipping_lines[0]->method_id);

        $this->assertInstanceOf(OrderMetadata::class, $order->meta_data[0]);
        $this->assertSame('is_vat_exempt', $order->meta_data[0]->key);

        // 嵌套对象 / 对象数组缺失时为 null
        $empty = Order::jsonDeSerialize(['id' => 1]);
        $this->assertNull($empty->billing);
        $this->assertNull($empty->shipping);
        $this->assertNull($empty->line_items);
        $this->assertNull($empty->meta_data);
    }

    public function testJsonSerializeFiltersNullButKeepsFalsy(): void
    {
        $order = Order::jsonDeSerialize($this->orderData());
        $json = json_decode(json_encode($order->jsonSerialize()), true);

        // null 字段被过滤
        $this->assertArrayNotHasKey('date_paid', $json);
        $this->assertArrayNotHasKey('date_completed', $json);

        // 空串 / 0 / false 保留
        $this->assertArrayHasKey('customer_note', $json);
        $this->assertSame('', $json['customer_note']);
        $this->assertArrayHasKey('customer_id', $json);
        $this->assertSame(0, $json['customer_id']);
        $this->assertArrayHasKey('prices_include_tax', $json);
        $this->assertFalse($json['prices_include_tax']);
        $this->assertArrayHasKey('set_paid', $json);
        $this->assertTrue($json['set_paid']);
    }

    public function testRoundTrip(): void
    {
        $order = Order::jsonDeSerialize($this->orderData());
        $json = json_encode($order->jsonSerialize());
        $rebuilt = Order::jsonDeSerialize(json_decode($json, true));

        $this->assertSame($order->id, $rebuilt->id);
        $this->assertSame($order->total, $rebuilt->total);
        $this->assertSame($order->status, $rebuilt->status);
        $this->assertSame($order->billing->email, $rebuilt->billing->email);
        $this->assertSame($order->shipping->country, $rebuilt->shipping->country);
        $this->assertSame($order->line_items[0]->product_id, $rebuilt->line_items[0]->product_id);
        $this->assertSame($order->line_items[0]->price, $rebuilt->line_items[0]->price);
        $this->assertSame($order->shipping_lines[0]->method_id, $rebuilt->shipping_lines[0]->method_id);
    }

    private function orderData(): array
    {
        return [
            'id' => 727,
            'parent_id' => 0,
            'number' => '727',
            'order_key' => 'wc_order_5b7ca',
            'created_via' => 'checkout',
            'version' => '3.5.1',
            'status' => 'processing',
            'currency' => 'USD',
            'date_created' => '2018-08-22T16:40:00',
            'date_created_gmt' => '2018-08-22T22:40:00',
            'date_modified' => '2018-08-22T16:40:00',
            'date_modified_gmt' => '2018-08-22T22:40:00',
            'discount_total' => '0.00',
            'discount_tax' => '0.00',
            'shipping_total' => '10.00',
            'shipping_tax' => '0.00',
            'cart_tax' => '0.00',
            'total' => '53.98',
            'total_tax' => '0.00',
            'prices_include_tax' => false,
            'customer_id' => 0,
            'customer_ip_address' => '127.0.0.1',
            'customer_user_agent' => 'Mozilla/5.0',
            'customer_note' => '',
            'billing' => [
                'first_name' => 'John', 'last_name' => 'Doe', 'company' => '',
                'address_1' => '969 Market', 'address_2' => '', 'city' => 'San Francisco',
                'state' => 'CA', 'postcode' => '94103', 'country' => 'US',
                'email' => 'john.doe@example.com', 'phone' => '(555) 555-5555',
            ],
            'shipping' => [
                'first_name' => 'John', 'last_name' => 'Doe', 'company' => '',
                'address_1' => '969 Market', 'address_2' => '', 'city' => 'San Francisco',
                'state' => 'CA', 'postcode' => '94103', 'country' => 'US',
            ],
            'payment_method' => 'bacs',
            'payment_method_title' => 'Direct Bank Transfer',
            'transaction_id' => '',
            'date_paid' => null,
            'date_paid_gmt' => null,
            'date_completed' => null,
            'date_completed_gmt' => null,
            'cart_hash' => 'abc123',
            'meta_data' => [['id' => 1, 'key' => 'is_vat_exempt', 'value' => 'no']],
            'line_items' => [
                [
                    'id' => 17, 'name' => 'Premium Quality', 'parent_name' => null,
                    'product_id' => 93, 'variation_id' => 0, 'quantity' => 2,
                    'tax_class' => '', 'subtotal' => '43.98', 'subtotal_tax' => '0.00',
                    'total' => '43.98', 'total_tax' => '0.00', 'taxes' => [], 'meta_data' => [],
                    'sku' => 'PQ-001', 'price' => '21.99',
                ],
            ],
            'tax_lines' => [],
            'shipping_lines' => [
                [
                    'id' => 18, 'method_title' => 'Flat Rate', 'method_id' => 'flat_rate',
                    'total' => '10.00', 'total_tax' => '0.00', 'taxes' => [], 'meta_data' => [],
                ],
            ],
            'fee_lines' => [],
            'coupon_lines' => [],
            'refunds' => [],
            'set_paid' => true,
        ];
    }
}
