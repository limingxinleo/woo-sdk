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
use Woo\Schema\OrderBilling;
use Woo\Schema\OrderCouponLine;
use Woo\Schema\OrderFeeLine;
use Woo\Schema\OrderLineItem;
use Woo\Schema\OrderMetadata;
use Woo\Schema\OrderRefund;
use Woo\Schema\OrderShipping;
use Woo\Schema\OrderShippingLine;
use Woo\Schema\OrderTaxLine;

/**
 * @internal
 * @coversNothing
 */
class OrderLeafTest extends AbstractTestCase
{
    public function testOrderBilling(): void
    {
        $data = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'company' => 'Acme',
            'address_1' => '969 Market',
            'address_2' => '',
            'city' => 'San Francisco',
            'state' => 'CA',
            'postcode' => '94103',
            'country' => 'US',
            'email' => 'john.doe@example.com',
            'phone' => '(555) 555-5555',
        ];
        $obj = OrderBilling::jsonDeSerialize($data);

        $this->assertSame('John', $obj->first_name);
        $this->assertSame('Doe', $obj->last_name);
        $this->assertSame('john.doe@example.com', $obj->email);
        $this->assertSame('(555) 555-5555', $obj->phone);

        // 空串保留（仅过滤 null）
        $this->assertSame('', $obj->address_2);
        $json = json_decode(json_encode($obj->jsonSerialize()), true);
        $this->assertArrayHasKey('address_2', $json);
        $this->assertSame('', $json['address_2']);
    }

    public function testOrderShipping(): void
    {
        $data = [
            'first_name' => 'John', 'last_name' => 'Doe', 'company' => '',
            'address_1' => '969 Market', 'address_2' => '', 'city' => 'San Francisco',
            'state' => 'CA', 'postcode' => '94103', 'country' => 'US',
        ];
        $obj = OrderShipping::jsonDeSerialize($data);

        $this->assertSame('John', $obj->first_name);
        $this->assertSame('US', $obj->country);
        // shipping 不含 email/phone
        $this->assertFalse(property_exists($obj, 'email'));
        $this->assertFalse(property_exists($obj, 'phone'));
    }

    public function testOrderMetadata(): void
    {
        $obj = OrderMetadata::jsonDeSerialize(['id' => '15', 'key' => 'shipping_method', 'value' => 'flat_rate']);

        $this->assertSame(15, $obj->id);
        $this->assertIsInt($obj->id);
        $this->assertSame('shipping_method', $obj->key);
        $this->assertSame('flat_rate', $obj->value);
    }

    public function testOrderTaxLine(): void
    {
        $data = [
            'id' => '1', 'rate_code' => 'US-CA-STATE TAX-1', 'rate_id' => '1',
            'label' => 'State Tax', 'compound' => false,
            'tax_total' => '1.50', 'shipping_tax_total' => '0.30',
            'meta_data' => [['id' => '10', 'key' => 'k', 'value' => 'v']],
        ];
        $obj = OrderTaxLine::jsonDeSerialize($data);

        $this->assertSame(1, $obj->id);
        $this->assertSame(1, $obj->rate_id);
        $this->assertIsInt($obj->rate_id);
        $this->assertSame('State Tax', $obj->label);
        $this->assertFalse($obj->compound);
        $this->assertIsArray($obj->meta_data);
        $this->assertCount(1, $obj->meta_data);
        $this->assertInstanceOf(OrderMetadata::class, $obj->meta_data[0]);
        $this->assertSame(10, $obj->meta_data[0]->id);

        // meta_data 缺失 -> null
        $this->assertNull(OrderTaxLine::jsonDeSerialize(['id' => 1])->meta_data);
    }

    public function testOrderLineItem(): void
    {
        $data = [
            'id' => '17', 'name' => 'Premium Quality', 'parent_name' => null,
            'product_id' => '93', 'variation_id' => '0', 'quantity' => '2',
            'tax_class' => '', 'subtotal' => '43.98', 'subtotal_tax' => '0.00',
            'total' => '43.98', 'total_tax' => '0.00',
            'taxes' => [['id' => '1', 'rate_code' => 'X', 'rate_id' => '1', 'label' => 'Tax', 'compound' => false, 'tax_total' => '0', 'shipping_tax_total' => '0']],
            'meta_data' => [['id' => '20', 'key' => 'pa_color', 'value' => 'black']],
            'sku' => 'PQ-001', 'price' => '21.99',
        ];
        $obj = OrderLineItem::jsonDeSerialize($data);

        $this->assertSame(17, $obj->id);
        $this->assertSame(93, $obj->product_id);
        $this->assertIsInt($obj->product_id);
        $this->assertSame(2, $obj->quantity);
        $this->assertIsInt($obj->quantity);
        $this->assertNull($obj->parent_name);
        $this->assertSame('21.99', $obj->price);
        $this->assertInstanceOf(OrderTaxLine::class, $obj->taxes[0]);
        $this->assertInstanceOf(OrderMetadata::class, $obj->meta_data[0]);

        // parent_name 为 null 时序列化不输出
        $json = json_decode(json_encode($obj->jsonSerialize()), true);
        $this->assertArrayNotHasKey('parent_name', $json);
    }

    public function testOrderShippingLine(): void
    {
        $data = [
            'id' => '18', 'method_title' => 'Flat Rate', 'method_id' => 'flat_rate',
            'total' => '10.00', 'total_tax' => '0.00',
            'taxes' => [], 'meta_data' => [],
        ];
        $obj = OrderShippingLine::jsonDeSerialize($data);

        $this->assertSame(18, $obj->id);
        $this->assertSame('Flat Rate', $obj->method_title);
        $this->assertSame('flat_rate', $obj->method_id);
        // 空数组保留（仅过滤 null）
        $this->assertSame([], $obj->taxes);
        $this->assertSame([], $obj->meta_data);
    }

    public function testOrderFeeLine(): void
    {
        $data = [
            'id' => '19', 'name' => 'Handling', 'tax_class' => 'standard', 'tax_status' => 'taxable',
            'total' => '5.00', 'total_tax' => '0.00', 'taxes' => [], 'meta_data' => [],
        ];
        $obj = OrderFeeLine::jsonDeSerialize($data);

        $this->assertSame(19, $obj->id);
        $this->assertSame('Handling', $obj->name);
        $this->assertSame('taxable', $obj->tax_status);
    }

    public function testOrderCouponLine(): void
    {
        $data = [
            'id' => '20', 'code' => 'SUMMER10', 'discount' => '5.00', 'discount_tax' => '0.00',
            'meta_data' => [['id' => '1', 'key' => 'k', 'value' => 'v']],
        ];
        $obj = OrderCouponLine::jsonDeSerialize($data);

        $this->assertSame(20, $obj->id);
        $this->assertSame('SUMMER10', $obj->code);
        $this->assertSame('5.00', $obj->discount);
        $this->assertInstanceOf(OrderMetadata::class, $obj->meta_data[0]);

        // meta_data 缺失 -> null
        $this->assertNull(OrderCouponLine::jsonDeSerialize(['code' => 'X'])->meta_data);
    }

    public function testOrderRefund(): void
    {
        $obj = OrderRefund::jsonDeSerialize(['id' => '21', 'reason' => 'Customer request', 'total' => '-10.00']);

        $this->assertSame(21, $obj->id);
        $this->assertIsInt($obj->id);
        $this->assertSame('Customer request', $obj->reason);
        $this->assertSame('-10.00', $obj->total);
    }
}
