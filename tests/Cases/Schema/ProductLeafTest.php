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
use Woo\Schema\ProductAttribute;
use Woo\Schema\ProductBrand;
use Woo\Schema\ProductCategory;
use Woo\Schema\ProductDefaultAttribute;
use Woo\Schema\ProductDimensions;
use Woo\Schema\ProductDownload;
use Woo\Schema\ProductImage;
use Woo\Schema\ProductMetadata;
use Woo\Schema\ProductTag;

/**
 * @internal
 * @coversNothing
 */
class ProductLeafTest extends AbstractTestCase
{
    public function testProductDownload(): void
    {
        $data = ['id' => 'manual', 'name' => 'User Manual', 'file' => 'https://example.com/manual.pdf'];
        $obj = ProductDownload::jsonDeSerialize($data);

        $this->assertSame('manual', $obj->id);
        $this->assertSame('User Manual', $obj->name);
        $this->assertSame('https://example.com/manual.pdf', $obj->file);

        // 缺失字段反序列化为 null，且 jsonSerialize 过滤 null
        $partial = ProductDownload::jsonDeSerialize(['id' => 'manual']);
        $this->assertNull($partial->name);
        $this->assertNull($partial->file);
        $json = json_decode(json_encode($partial->jsonSerialize()), true);
        $this->assertArrayHasKey('id', $json);
        $this->assertArrayNotHasKey('name', $json);
        $this->assertArrayNotHasKey('file', $json);
    }

    public function testProductDimensions(): void
    {
        $data = ['length' => '10', 'width' => '5', 'height' => '2'];
        $obj = ProductDimensions::jsonDeSerialize($data);

        $this->assertSame('10', $obj->length);
        $this->assertSame('5', $obj->width);
        $this->assertSame('2', $obj->height);

        // 仅 length 存在时，序列化只输出 length
        $json = json_decode(json_encode(ProductDimensions::jsonDeSerialize(['length' => '10'])->jsonSerialize()), true);
        $this->assertSame(['length' => '10'], $json);
    }

    public function testProductCategory(): void
    {
        // id 为字符串数字时应强转为 int
        $obj = ProductCategory::jsonDeSerialize(['id' => '9', 'name' => 'Clothing', 'slug' => 'clothing']);

        $this->assertSame(9, $obj->id);
        $this->assertIsInt($obj->id);
        $this->assertSame('Clothing', $obj->name);
        $this->assertSame('clothing', $obj->slug);
    }

    public function testProductTag(): void
    {
        $obj = ProductTag::jsonDeSerialize(['id' => '7', 'name' => 'New', 'slug' => 'new']);

        $this->assertSame(7, $obj->id);
        $this->assertIsInt($obj->id);
        $this->assertSame('New', $obj->name);
        $this->assertSame('new', $obj->slug);
    }

    public function testProductBrand(): void
    {
        $obj = ProductBrand::jsonDeSerialize(['id' => '3', 'name' => 'Acme', 'slug' => 'acme']);

        $this->assertSame(3, $obj->id);
        $this->assertIsInt($obj->id);
        $this->assertSame('Acme', $obj->name);
        $this->assertSame('acme', $obj->slug);
    }

    public function testProductImage(): void
    {
        $data = [
            'id' => '42',
            'date_created' => '2017-03-22T14:01:13',
            'date_created_gmt' => '2017-03-22T20:01:13',
            'date_modified' => '2017-03-22T14:01:13',
            'date_modified_gmt' => '2017-03-22T20:01:13',
            'src' => 'https://example.com/a.jpg',
            'name' => 'Front',
            'alt' => 'Front view',
        ];
        $obj = ProductImage::jsonDeSerialize($data);

        $this->assertSame(42, $obj->id);
        $this->assertIsInt($obj->id);
        $this->assertSame('2017-03-22T14:01:13', $obj->date_created);
        $this->assertSame('https://example.com/a.jpg', $obj->src);
        $this->assertSame('Front', $obj->name);
        $this->assertSame('Front view', $obj->alt);

        // 仅传 id 与 src 时序列化只输出这两个字段
        $json = json_decode(json_encode(ProductImage::jsonDeSerialize(['id' => 42, 'src' => 'x'])->jsonSerialize()), true);
        $this->assertSame(['id' => 42, 'src' => 'x'], $json);
    }

    public function testProductAttribute(): void
    {
        $data = [
            'id' => '6',
            'name' => 'Color',
            'position' => '0',
            'visible' => false,
            'variation' => true,
            'options' => ['Black', 'Green'],
        ];
        $obj = ProductAttribute::jsonDeSerialize($data);

        $this->assertSame(6, $obj->id);
        $this->assertIsInt($obj->id);
        $this->assertSame(0, $obj->position);
        $this->assertIsInt($obj->position);
        $this->assertSame('Color', $obj->name);
        $this->assertFalse($obj->visible);
        $this->assertTrue($obj->variation);
        $this->assertSame(['Black', 'Green'], $obj->options);

        // options 缺失 -> null，序列化不输出
        $partial = ProductAttribute::jsonDeSerialize(['name' => 'Size']);
        $this->assertNull($partial->options);
        $this->assertNull($partial->id);
        $json = json_decode(json_encode($partial->jsonSerialize()), true);
        $this->assertArrayNotHasKey('options', $json);
        $this->assertArrayNotHasKey('id', $json);
        $this->assertSame('Size', $json['name']);
    }

    public function testProductDefaultAttribute(): void
    {
        $obj = ProductDefaultAttribute::jsonDeSerialize(['id' => '6', 'name' => 'Color', 'option' => 'black']);

        $this->assertSame(6, $obj->id);
        $this->assertIsInt($obj->id);
        $this->assertSame('Color', $obj->name);
        $this->assertSame('black', $obj->option);
    }

    public function testProductMetadata(): void
    {
        $obj = ProductMetadata::jsonDeSerialize(['id' => '12', 'key' => 'custom_key', 'value' => 'custom_value']);

        $this->assertSame(12, $obj->id);
        $this->assertIsInt($obj->id);
        $this->assertSame('custom_key', $obj->key);
        $this->assertSame('custom_value', $obj->value);
    }
}
