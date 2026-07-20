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

use function Woo\int_or_null;
use function Woo\string_or_null;

class OrderLineItem implements JsonSerializable, JsonDeSerializable
{
    /**
     * @param null|int $id Item ID. READ-ONLY
     * @param null|string $name Product name
     * @param null|string $parent_name Parent product name if the product is a variation; otherwise null
     * @param null|int $product_id Product ID
     * @param null|int $variation_id Variation ID, if applicable
     * @param null|int $quantity Quantity ordered
     * @param null|string $tax_class Slug of the tax class of product
     * @param null|string $subtotal Line subtotal (before discounts)
     * @param null|string $subtotal_tax Line subtotal tax (before discounts). READ-ONLY
     * @param null|string $total Line total (after discounts)
     * @param null|string $total_tax Line total tax (after discounts). READ-ONLY
     * @param null|OrderTaxLine[] $taxes Line taxes. READ-ONLY
     * @param null|OrderMetadata[] $meta_data Meta data
     * @param null|string $sku Product SKU. READ-ONLY
     * @param null|string $price Product price. READ-ONLY
     */
    public function __construct(
        public ?int $id = null,
        public ?string $name = null,
        public ?string $parent_name = null,
        public ?int $product_id = null,
        public ?int $variation_id = null,
        public ?int $quantity = null,
        public ?string $tax_class = null,
        public ?string $subtotal = null,
        public ?string $subtotal_tax = null,
        public ?string $total = null,
        public ?string $total_tax = null,
        public ?array $taxes = null,
        public ?array $meta_data = null,
        public ?string $sku = null,
        public ?string $price = null,
    ) {
    }

    public static function jsonDeSerialize(mixed $data): static
    {
        return new static(
            int_or_null($data['id'] ?? null),
            string_or_null($data['name'] ?? null),
            string_or_null($data['parent_name'] ?? null),
            int_or_null($data['product_id'] ?? null),
            int_or_null($data['variation_id'] ?? null),
            int_or_null($data['quantity'] ?? null),
            string_or_null($data['tax_class'] ?? null),
            string_or_null($data['subtotal'] ?? null),
            string_or_null($data['subtotal_tax'] ?? null),
            string_or_null($data['total'] ?? null),
            string_or_null($data['total_tax'] ?? null),
            isset($data['taxes']) && is_array($data['taxes'])
                ? array_map(static fn (array $item) => OrderTaxLine::jsonDeSerialize($item), $data['taxes'])
                : null,
            isset($data['meta_data']) && is_array($data['meta_data'])
                ? array_map(static fn (array $item) => OrderMetadata::jsonDeSerialize($item), $data['meta_data'])
                : null,
            string_or_null($data['sku'] ?? null),
            string_or_null($data['price'] ?? null),
        );
    }

    public function jsonSerialize(): mixed
    {
        return array_filter([
            'id' => $this->id,
            'name' => $this->name,
            'parent_name' => $this->parent_name,
            'product_id' => $this->product_id,
            'variation_id' => $this->variation_id,
            'quantity' => $this->quantity,
            'tax_class' => $this->tax_class,
            'subtotal' => $this->subtotal,
            'subtotal_tax' => $this->subtotal_tax,
            'total' => $this->total,
            'total_tax' => $this->total_tax,
            'taxes' => $this->taxes,
            'meta_data' => $this->meta_data,
            'sku' => $this->sku,
            'price' => $this->price,
        ], static fn (mixed $value) => $value !== null);
    }
}
