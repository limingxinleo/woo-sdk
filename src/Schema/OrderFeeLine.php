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

class OrderFeeLine
{
    /**
     * @param int $id Item ID. READ-ONLY
     * @param string $name Fee name
     * @param string $tax_class Tax class of fee
     * @param string $tax_status Tax status of fee. Options: taxable, none
     * @param string $total Line total (after discounts)
     * @param string $total_tax Line total tax (after discounts). READ-ONLY
     * @param OrderTaxLine[] $taxes Line taxes. READ-ONLY
     * @param OrderMetadata[] $meta_data Meta data
     */
    public function __construct(
        public int $id = 0,
        public string $name = '',
        public string $tax_class = '',
        public string $tax_status = '',
        public string $total = '',
        public string $total_tax = '',
        public array $taxes = [],
        public array $meta_data = [],
    ) {
    }
}
