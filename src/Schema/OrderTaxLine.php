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

class OrderTaxLine
{
    /**
     * @param int $id Item ID. READ-ONLY
     * @param string $rate_code Tax rate code. READ-ONLY
     * @param int $rate_id Tax rate ID. READ-ONLY
     * @param string $label Tax rate label. READ-ONLY
     * @param bool $compound Whether or not this is a compound tax rate. READ-ONLY
     * @param string $tax_total Tax total (not including shipping taxes). READ-ONLY
     * @param string $shipping_tax_total Shipping tax total. READ-ONLY
     * @param OrderMetadata[] $meta_data Meta data
     */
    public function __construct(
        public int $id = 0,
        public string $rate_code = '',
        public int $rate_id = 0,
        public string $label = '',
        public bool $compound = false,
        public string $tax_total = '',
        public string $shipping_tax_total = '',
        public array $meta_data = [],
    ) {
    }
}
