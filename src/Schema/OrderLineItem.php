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

class OrderLineItem
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
}
