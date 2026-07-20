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

use function Woo\array_or_null;
use function Woo\bool_or_null;
use function Woo\int_or_null;
use function Woo\string_or_null;

/**
 * WooCommerce Product 数据模型.
 *
 * @see https://woocommerce.github.io/woocommerce-rest-api-docs/#products
 */
class Product implements JsonSerializable, JsonDeSerializable
{
    /**
     * @param null|int $id Unique identifier for the resource. READ-ONLY
     * @param null|string $name Product name
     * @param null|string $slug Product slug
     * @param null|string $permalink Product URL. READ-ONLY
     * @param null|string $date_created The date the product was created, in the site's timezone. READ-ONLY
     * @param null|string $date_created_gmt The date the product was created, as GMT. READ-ONLY
     * @param null|string $date_modified The date the product was last modified, in the site's timezone. READ-ONLY
     * @param null|string $date_modified_gmt The date the product was last modified, as GMT. READ-ONLY
     * @param null|string $type Product type. Options: simple, grouped, external and variable. Default is simple
     * @param null|string $status Product status (post status). Options: draft, pending, private and publish. Default is publish
     * @param null|bool $featured Featured product. Default is false
     * @param null|string $catalog_visibility Catalog visibility. Options: visible, catalog, search and hidden. Default is visible
     * @param null|string $description Product description
     * @param null|string $short_description Product short description
     * @param null|string $sku Unique identifier
     * @param null|string $global_unique_id GTIN, UPC, EAN or ISBN - a unique identifier for each distinct product and service that can be purchased
     * @param null|string $price Current product price. READ-ONLY
     * @param null|string $regular_price Product regular price
     * @param null|string $sale_price Product sale price
     * @param null|string $date_on_sale_from Start date of sale price, in the site's timezone
     * @param null|string $date_on_sale_from_gmt Start date of sale price, as GMT
     * @param null|string $date_on_sale_to End date of sale price, in the site's timezone
     * @param null|string $date_on_sale_to_gmt End date of sale price, as GMT
     * @param null|string $price_html Price formatted in HTML. READ-ONLY
     * @param null|bool $on_sale Shows if the product is on sale. READ-ONLY
     * @param null|bool $purchasable Shows if the product can be bought. READ-ONLY
     * @param null|int $total_sales Amount of sales. READ-ONLY
     * @param null|bool $virtual If the product is virtual. Default is false
     * @param null|bool $downloadable If the product is downloadable. Default is false
     * @param null|ProductDownload[] $downloads List of downloadable files
     * @param null|int $download_limit Number of times downloadable files can be downloaded after purchase. Default is -1
     * @param null|int $download_expiry Number of days until access to downloadable files expires. Default is -1
     * @param null|string $external_url Product external URL. Only for external products
     * @param null|string $button_text Product external button text. Only for external products
     * @param null|string $tax_status Tax status. Options: taxable, shipping and none. Default is taxable
     * @param null|string $tax_class Tax class
     * @param null|bool $manage_stock Stock management at product level. Default is false
     * @param null|int $stock_quantity Stock quantity
     * @param null|string $stock_status Controls the stock status of the product. Options: instock, outofstock, onbackorder. Default is instock
     * @param null|string $backorders If managing stock, this controls if backorders are allowed. Options: no, notify and yes. Default is no
     * @param null|bool $backorders_allowed Shows if backorders are allowed. READ-ONLY
     * @param null|bool $backordered Shows if the product is on backordered. READ-ONLY
     * @param null|bool $sold_individually Allow one item to be bought in a single order. Default is false
     * @param null|string $weight Product weight
     * @param null|ProductDimensions $dimensions Product dimensions
     * @param null|bool $shipping_required Shows if the product need to be shipped. READ-ONLY
     * @param null|bool $shipping_taxable Shows whether or not the product shipping is taxable. READ-ONLY
     * @param null|string $shipping_class Shipping class slug
     * @param null|int $shipping_class_id Shipping class ID. READ-ONLY
     * @param null|bool $reviews_allowed Allow reviews. Default is true
     * @param null|string $average_rating Reviews average rating. READ-ONLY
     * @param null|int $rating_count Amount of reviews that the product have. READ-ONLY
     * @param null|array $related_ids List of related products IDs. READ-ONLY
     * @param null|array $upsell_ids List of up-sell products IDs
     * @param null|array $cross_sell_ids List of cross-sell products IDs
     * @param null|int $parent_id Product parent ID
     * @param null|string $purchase_note Optional note to send the customer after purchase
     * @param null|ProductCategory[] $categories List of categories
     * @param null|ProductTag[] $tags List of tags
     * @param null|ProductBrand[] $brands List of product brands
     * @param null|ProductImage[] $images List of images
     * @param null|ProductAttribute[] $attributes List of attributes
     * @param null|ProductDefaultAttribute[] $default_attributes Defaults variation attributes
     * @param null|array $variations List of variations IDs. READ-ONLY
     * @param null|array $grouped_products List of grouped products ID
     * @param null|int $menu_order Menu order, used to custom sort products
     * @param null|ProductMetadata[] $meta_data Meta data
     */
    public function __construct(
        public ?int $id = null,
        public ?string $name = null,
        public ?string $slug = null,
        public ?string $permalink = null,
        public ?string $date_created = null,
        public ?string $date_created_gmt = null,
        public ?string $date_modified = null,
        public ?string $date_modified_gmt = null,
        public ?string $type = null,
        public ?string $status = null,
        public ?bool $featured = null,
        public ?string $catalog_visibility = null,
        public ?string $description = null,
        public ?string $short_description = null,
        public ?string $sku = null,
        public ?string $global_unique_id = null,
        public ?string $price = null,
        public ?string $regular_price = null,
        public ?string $sale_price = null,
        public ?string $date_on_sale_from = null,
        public ?string $date_on_sale_from_gmt = null,
        public ?string $date_on_sale_to = null,
        public ?string $date_on_sale_to_gmt = null,
        public ?string $price_html = null,
        public ?bool $on_sale = null,
        public ?bool $purchasable = null,
        public ?int $total_sales = null,
        public ?bool $virtual = null,
        public ?bool $downloadable = null,
        public ?array $downloads = null,
        public ?int $download_limit = null,
        public ?int $download_expiry = null,
        public ?string $external_url = null,
        public ?string $button_text = null,
        public ?string $tax_status = null,
        public ?string $tax_class = null,
        public ?bool $manage_stock = null,
        public ?int $stock_quantity = null,
        public ?string $stock_status = null,
        public ?string $backorders = null,
        public ?bool $backorders_allowed = null,
        public ?bool $backordered = null,
        public ?bool $sold_individually = null,
        public ?string $weight = null,
        public ?ProductDimensions $dimensions = null,
        public ?bool $shipping_required = null,
        public ?bool $shipping_taxable = null,
        public ?string $shipping_class = null,
        public ?int $shipping_class_id = null,
        public ?bool $reviews_allowed = null,
        public ?string $average_rating = null,
        public ?int $rating_count = null,
        public ?array $related_ids = null,
        public ?array $upsell_ids = null,
        public ?array $cross_sell_ids = null,
        public ?int $parent_id = null,
        public ?string $purchase_note = null,
        public ?array $categories = null,
        public ?array $tags = null,
        public ?array $brands = null,
        public ?array $images = null,
        public ?array $attributes = null,
        public ?array $default_attributes = null,
        public ?array $variations = null,
        public ?array $grouped_products = null,
        public ?int $menu_order = null,
        public ?array $meta_data = null,
    ) {
    }

    public static function jsonDeSerialize(mixed $data): static
    {
        return new static(
            int_or_null($data['id'] ?? null),
            string_or_null($data['name'] ?? null),
            string_or_null($data['slug'] ?? null),
            string_or_null($data['permalink'] ?? null),
            string_or_null($data['date_created'] ?? null),
            string_or_null($data['date_created_gmt'] ?? null),
            string_or_null($data['date_modified'] ?? null),
            string_or_null($data['date_modified_gmt'] ?? null),
            string_or_null($data['type'] ?? null),
            string_or_null($data['status'] ?? null),
            bool_or_null($data['featured'] ?? null),
            string_or_null($data['catalog_visibility'] ?? null),
            string_or_null($data['description'] ?? null),
            string_or_null($data['short_description'] ?? null),
            string_or_null($data['sku'] ?? null),
            string_or_null($data['global_unique_id'] ?? null),
            string_or_null($data['price'] ?? null),
            string_or_null($data['regular_price'] ?? null),
            string_or_null($data['sale_price'] ?? null),
            string_or_null($data['date_on_sale_from'] ?? null),
            string_or_null($data['date_on_sale_from_gmt'] ?? null),
            string_or_null($data['date_on_sale_to'] ?? null),
            string_or_null($data['date_on_sale_to_gmt'] ?? null),
            string_or_null($data['price_html'] ?? null),
            bool_or_null($data['on_sale'] ?? null),
            bool_or_null($data['purchasable'] ?? null),
            int_or_null($data['total_sales'] ?? null),
            bool_or_null($data['virtual'] ?? null),
            bool_or_null($data['downloadable'] ?? null),
            isset($data['downloads']) && is_array($data['downloads'])
                ? array_map(static fn (array $item) => ProductDownload::jsonDeSerialize($item), $data['downloads'])
                : null,
            int_or_null($data['download_limit'] ?? null),
            int_or_null($data['download_expiry'] ?? null),
            string_or_null($data['external_url'] ?? null),
            string_or_null($data['button_text'] ?? null),
            string_or_null($data['tax_status'] ?? null),
            string_or_null($data['tax_class'] ?? null),
            bool_or_null($data['manage_stock'] ?? null),
            int_or_null($data['stock_quantity'] ?? null),
            string_or_null($data['stock_status'] ?? null),
            string_or_null($data['backorders'] ?? null),
            bool_or_null($data['backorders_allowed'] ?? null),
            bool_or_null($data['backordered'] ?? null),
            bool_or_null($data['sold_individually'] ?? null),
            string_or_null($data['weight'] ?? null),
            isset($data['dimensions']) && is_array($data['dimensions']) ? ProductDimensions::jsonDeSerialize($data['dimensions']) : null,
            bool_or_null($data['shipping_required'] ?? null),
            bool_or_null($data['shipping_taxable'] ?? null),
            string_or_null($data['shipping_class'] ?? null),
            int_or_null($data['shipping_class_id'] ?? null),
            bool_or_null($data['reviews_allowed'] ?? null),
            string_or_null($data['average_rating'] ?? null),
            int_or_null($data['rating_count'] ?? null),
            array_or_null($data['related_ids'] ?? null),
            array_or_null($data['upsell_ids'] ?? null),
            array_or_null($data['cross_sell_ids'] ?? null),
            int_or_null($data['parent_id'] ?? null),
            string_or_null($data['purchase_note'] ?? null),
            isset($data['categories']) && is_array($data['categories'])
                ? array_map(static fn (array $item) => ProductCategory::jsonDeSerialize($item), $data['categories'])
                : null,
            isset($data['tags']) && is_array($data['tags'])
                ? array_map(static fn (array $item) => ProductTag::jsonDeSerialize($item), $data['tags'])
                : null,
            isset($data['brands']) && is_array($data['brands'])
                ? array_map(static fn (array $item) => ProductBrand::jsonDeSerialize($item), $data['brands'])
                : null,
            isset($data['images']) && is_array($data['images'])
                ? array_map(static fn (array $item) => ProductImage::jsonDeSerialize($item), $data['images'])
                : null,
            isset($data['attributes']) && is_array($data['attributes'])
                ? array_map(static fn (array $item) => ProductAttribute::jsonDeSerialize($item), $data['attributes'])
                : null,
            isset($data['default_attributes']) && is_array($data['default_attributes'])
                ? array_map(static fn (array $item) => ProductDefaultAttribute::jsonDeSerialize($item), $data['default_attributes'])
                : null,
            array_or_null($data['variations'] ?? null),
            array_or_null($data['grouped_products'] ?? null),
            int_or_null($data['menu_order'] ?? null),
            isset($data['meta_data']) && is_array($data['meta_data'])
                ? array_map(static fn (array $item) => ProductMetadata::jsonDeSerialize($item), $data['meta_data'])
                : null,
        );
    }

    public function jsonSerialize(): mixed
    {
        return array_filter([
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'permalink' => $this->permalink,
            'date_created' => $this->date_created,
            'date_created_gmt' => $this->date_created_gmt,
            'date_modified' => $this->date_modified,
            'date_modified_gmt' => $this->date_modified_gmt,
            'type' => $this->type,
            'status' => $this->status,
            'featured' => $this->featured,
            'catalog_visibility' => $this->catalog_visibility,
            'description' => $this->description,
            'short_description' => $this->short_description,
            'sku' => $this->sku,
            'global_unique_id' => $this->global_unique_id,
            'price' => $this->price,
            'regular_price' => $this->regular_price,
            'sale_price' => $this->sale_price,
            'date_on_sale_from' => $this->date_on_sale_from,
            'date_on_sale_from_gmt' => $this->date_on_sale_from_gmt,
            'date_on_sale_to' => $this->date_on_sale_to,
            'date_on_sale_to_gmt' => $this->date_on_sale_to_gmt,
            'price_html' => $this->price_html,
            'on_sale' => $this->on_sale,
            'purchasable' => $this->purchasable,
            'total_sales' => $this->total_sales,
            'virtual' => $this->virtual,
            'downloadable' => $this->downloadable,
            'downloads' => $this->downloads,
            'download_limit' => $this->download_limit,
            'download_expiry' => $this->download_expiry,
            'external_url' => $this->external_url,
            'button_text' => $this->button_text,
            'tax_status' => $this->tax_status,
            'tax_class' => $this->tax_class,
            'manage_stock' => $this->manage_stock,
            'stock_quantity' => $this->stock_quantity,
            'stock_status' => $this->stock_status,
            'backorders' => $this->backorders,
            'backorders_allowed' => $this->backorders_allowed,
            'backordered' => $this->backordered,
            'sold_individually' => $this->sold_individually,
            'weight' => $this->weight,
            'dimensions' => $this->dimensions,
            'shipping_required' => $this->shipping_required,
            'shipping_taxable' => $this->shipping_taxable,
            'shipping_class' => $this->shipping_class,
            'shipping_class_id' => $this->shipping_class_id,
            'reviews_allowed' => $this->reviews_allowed,
            'average_rating' => $this->average_rating,
            'rating_count' => $this->rating_count,
            'related_ids' => $this->related_ids,
            'upsell_ids' => $this->upsell_ids,
            'cross_sell_ids' => $this->cross_sell_ids,
            'parent_id' => $this->parent_id,
            'purchase_note' => $this->purchase_note,
            'categories' => $this->categories,
            'tags' => $this->tags,
            'brands' => $this->brands,
            'images' => $this->images,
            'attributes' => $this->attributes,
            'default_attributes' => $this->default_attributes,
            'variations' => $this->variations,
            'grouped_products' => $this->grouped_products,
            'menu_order' => $this->menu_order,
            'meta_data' => $this->meta_data,
        ], static fn (mixed $value) => $value !== null);
    }
}
