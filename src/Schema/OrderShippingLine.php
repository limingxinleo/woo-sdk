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

class OrderShippingLine
{
    /**
     * @param int $id Item ID. READ-ONLY
     * @param string $method_title Shipping method name
     * @param string $method_id Shipping method ID
     * @param string $total Line total (after discounts)
     * @param string $total_tax Line total tax (after discounts). READ-ONLY
     * @param OrderTaxLine[] $taxes Line taxes. READ-ONLY
     * @param OrderMetadata[] $meta_data Meta data
     */
    public function __construct(
        public int $id = 0,
        public string $method_title = '',
        public string $method_id = '',
        public string $total = '',
        public string $total_tax = '',
        public array $taxes = [],
        public array $meta_data = [],
    ) {
    }
}
