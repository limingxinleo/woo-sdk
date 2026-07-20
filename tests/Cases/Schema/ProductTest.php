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
use Woo\Schema\Product;
use Woo\Schema\ProductAttribute;
use Woo\Schema\ProductBrand;
use Woo\Schema\ProductCategory;
use Woo\Schema\ProductDefaultAttribute;
use Woo\Schema\ProductDimensions;
use Woo\Schema\ProductImage;
use Woo\Schema\ProductMetadata;

/**
 * @internal
 * @coversNothing
 */
class ProductTest extends AbstractTestCase
{
    public function testJsonDeSerializeCastsTypes(): void
    {
        $product = Product::jsonDeSerialize($this->simpleProductData());

        // int 字段强转
        $this->assertSame(794, $product->id);
        $this->assertIsInt($product->id);
        $this->assertSame(0, $product->total_sales);
        $this->assertSame(-1, $product->download_limit);
        $this->assertSame(0, $product->parent_id);
        $this->assertSame(0, $product->menu_order);

        // bool 字段强转
        $this->assertFalse($product->featured);
        $this->assertIsBool($product->featured);
        $this->assertTrue($product->purchasable);
        $this->assertIsBool($product->purchasable);

        // string 字段
        $this->assertSame('21.99', $product->price);
        $this->assertSame('simple', $product->type);

        // 字符串数字输入强转为 int
        $casted = Product::jsonDeSerialize(['id' => '123', 'parent_id' => '5', 'menu_order' => '2']);
        $this->assertSame(123, $casted->id);
        $this->assertIsInt($casted->id);
        $this->assertSame(5, $casted->parent_id);
        $this->assertSame(2, $casted->menu_order);
    }

    public function testNestedObjectsAndArrays(): void
    {
        $product = Product::jsonDeSerialize($this->simpleProductData());

        $this->assertInstanceOf(ProductDimensions::class, $product->dimensions);
        $this->assertSame('10', $product->dimensions->length);

        $this->assertCount(2, $product->categories);
        $this->assertInstanceOf(ProductCategory::class, $product->categories[0]);
        $this->assertSame(9, $product->categories[0]->id);
        $this->assertSame('Clothing', $product->categories[0]->name);

        $this->assertInstanceOf(ProductImage::class, $product->images[0]);
        $this->assertSame(42, $product->images[0]->id);
        $this->assertSame('https://example.com/a.jpg', $product->images[0]->src);

        $this->assertInstanceOf(ProductAttribute::class, $product->attributes[0]);
        $this->assertSame(['Black', 'Green'], $product->attributes[0]->options);
        $this->assertTrue($product->attributes[0]->variation);

        $this->assertInstanceOf(ProductDefaultAttribute::class, $product->default_attributes[0]);
        $this->assertSame('black', $product->default_attributes[0]->option);

        $this->assertInstanceOf(ProductBrand::class, $product->brands[0]);
        $this->assertSame(3, $product->brands[0]->id);

        $this->assertInstanceOf(ProductMetadata::class, $product->meta_data[0]);
        $this->assertSame('custom', $product->meta_data[0]->key);

        // 标量数组保留
        $this->assertSame([53, 40, 56], $product->related_ids);

        // 嵌套对象 / 对象数组缺失时为 null
        $empty = Product::jsonDeSerialize(['id' => 1]);
        $this->assertNull($empty->dimensions);
        $this->assertNull($empty->categories);
        $this->assertNull($empty->images);
        $this->assertNull($empty->meta_data);
    }

    public function testJsonSerializeFiltersNullButKeepsFalsy(): void
    {
        $product = Product::jsonDeSerialize($this->simpleProductData());
        $json = json_decode(json_encode($product->jsonSerialize()), true);

        // null 字段被过滤
        $this->assertArrayNotHasKey('date_on_sale_from', $json);
        $this->assertArrayNotHasKey('stock_quantity', $json);

        // 空串 / 0 / false 保留
        $this->assertArrayHasKey('sku', $json);
        $this->assertSame('', $json['sku']);
        $this->assertArrayHasKey('total_sales', $json);
        $this->assertSame(0, $json['total_sales']);
        $this->assertArrayHasKey('featured', $json);
        $this->assertFalse($json['featured']);
        $this->assertArrayHasKey('download_limit', $json);
        $this->assertSame(-1, $json['download_limit']);
    }

    public function testRoundTrip(): void
    {
        $product = Product::jsonDeSerialize($this->simpleProductData());
        $json = json_encode($product->jsonSerialize());
        $rebuilt = Product::jsonDeSerialize(json_decode($json, true));

        $this->assertSame($product->id, $rebuilt->id);
        $this->assertSame($product->name, $rebuilt->name);
        $this->assertSame($product->price, $rebuilt->price);
        $this->assertSame($product->dimensions->length, $rebuilt->dimensions->length);
        $this->assertSame($product->categories[0]->id, $rebuilt->categories[0]->id);
        $this->assertSame($product->images[0]->src, $rebuilt->images[0]->src);
        $this->assertSame($product->related_ids, $rebuilt->related_ids);
    }

    private function simpleProductData(): array
    {
        return [
            'id' => 794,
            'name' => 'Premium Quality',
            'slug' => 'premium-quality-19',
            'permalink' => 'https://example.com/product/premium-quality-19/',
            'date_created' => '2017-03-23T17:01:14',
            'date_created_gmt' => '2017-03-23T20:01:14',
            'date_modified' => '2017-03-23T17:01:14',
            'date_modified_gmt' => '2017-03-23T20:01:14',
            'type' => 'simple',
            'status' => 'publish',
            'featured' => false,
            'catalog_visibility' => 'visible',
            'description' => '<p>Pellentesque</p>',
            'short_description' => '<p>short</p>',
            'sku' => '',
            'global_unique_id' => '',
            'price' => '21.99',
            'regular_price' => '21.99',
            'sale_price' => '',
            'date_on_sale_from' => null,
            'date_on_sale_from_gmt' => null,
            'date_on_sale_to' => null,
            'date_on_sale_to_gmt' => null,
            'price_html' => '<span>21.99</span>',
            'on_sale' => false,
            'purchasable' => true,
            'total_sales' => 0,
            'virtual' => false,
            'downloadable' => false,
            'downloads' => [],
            'download_limit' => -1,
            'download_expiry' => -1,
            'external_url' => '',
            'button_text' => '',
            'tax_status' => 'taxable',
            'tax_class' => '',
            'manage_stock' => false,
            'stock_quantity' => null,
            'stock_status' => 'instock',
            'backorders' => 'no',
            'backorders_allowed' => false,
            'backordered' => false,
            'sold_individually' => false,
            'weight' => '',
            'dimensions' => ['length' => '10', 'width' => '5', 'height' => '2'],
            'shipping_required' => true,
            'shipping_taxable' => true,
            'shipping_class' => '',
            'shipping_class_id' => 0,
            'reviews_allowed' => true,
            'average_rating' => '0.00',
            'rating_count' => 0,
            'related_ids' => [53, 40, 56],
            'upsell_ids' => [],
            'cross_sell_ids' => [],
            'parent_id' => 0,
            'purchase_note' => '',
            'categories' => [
                ['id' => 9, 'name' => 'Clothing', 'slug' => 'clothing'],
                ['id' => 14, 'name' => 'T-shirts', 'slug' => 't-shirts'],
            ],
            'tags' => [],
            'brands' => [['id' => 3, 'name' => 'Acme', 'slug' => 'acme']],
            'images' => [
                ['id' => 42, 'date_created' => '2017-03-22T14:01:13', 'src' => 'https://example.com/a.jpg', 'name' => '', 'alt' => ''],
            ],
            'attributes' => [
                ['id' => 6, 'name' => 'Color', 'position' => 0, 'visible' => false, 'variation' => true, 'options' => ['Black', 'Green']],
            ],
            'default_attributes' => [
                ['id' => 6, 'name' => 'Color', 'option' => 'black'],
            ],
            'variations' => [],
            'grouped_products' => [],
            'menu_order' => 0,
            'meta_data' => [['id' => 100, 'key' => 'custom', 'value' => 'v']],
        ];
    }
}
