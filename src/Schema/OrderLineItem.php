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

class OrderLineItem implements JsonSerializable, JsonDeSerializable
{
    /**
     * @param int $id Item ID. READ-ONLY
     * @param string $name Product name
     * @param null|string $parent_name Parent product name if the product is a variation; otherwise null
     * @param int $product_id Product ID
     * @param int $variation_id Variation ID, if applicable
     * @param int $quantity Quantity ordered
     * @param string $tax_class Slug of the tax class of product
     * @param string $subtotal Line subtotal (before discounts)
     * @param string $subtotal_tax Line subtotal tax (before discounts). READ-ONLY
     * @param string $total Line total (after discounts)
     * @param string $total_tax Line total tax (after discounts). READ-ONLY
     * @param OrderTaxLine[] $taxes Line taxes. READ-ONLY
     * @param OrderMetadata[] $meta_data Meta data
     * @param string $sku Product SKU. READ-ONLY
     * @param string $price Product price. READ-ONLY
     */
    public function __construct(
        public int $id = 0,
        public string $name = '',
        public ?string $parent_name = null,
        public int $product_id = 0,
        public int $variation_id = 0,
        public int $quantity = 0,
        public string $tax_class = '',
        public string $subtotal = '',
        public string $subtotal_tax = '',
        public string $total = '',
        public string $total_tax = '',
        public array $taxes = [],
        public array $meta_data = [],
        public string $sku = '',
        public string $price = '',
    ) {
    }

    public static function jsonDeSerialize(mixed $data): static
    {
        return new static(
            $data['id'] ?? 0,
            $data['name'] ?? '',
            $data['parent_name'] ?? null,
            $data['product_id'] ?? 0,
            $data['variation_id'] ?? 0,
            $data['quantity'] ?? 0,
            $data['tax_class'] ?? '',
            $data['subtotal'] ?? '',
            $data['subtotal_tax'] ?? '',
            $data['total'] ?? '',
            $data['total_tax'] ?? '',
            array_map(
                static fn (array $item) => OrderTaxLine::jsonDeSerialize($item),
                $data['taxes'] ?? [],
            ),
            array_map(
                static fn (array $item) => OrderMetadata::jsonDeSerialize($item),
                $data['meta_data'] ?? [],
            ),
            $data['sku'] ?? '',
            $data['price'] ?? '',
        );
    }

    public function jsonSerialize(): mixed
    {
        return [
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
        ];
    }
}
