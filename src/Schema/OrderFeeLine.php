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

class OrderFeeLine implements JsonSerializable, JsonDeSerializable
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

    public static function jsonDeSerialize(mixed $data): static
    {
        return new static(
            $data['id'] ?? 0,
            $data['name'] ?? '',
            $data['tax_class'] ?? '',
            $data['tax_status'] ?? '',
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
        );
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'tax_class' => $this->tax_class,
            'tax_status' => $this->tax_status,
            'total' => $this->total,
            'total_tax' => $this->total_tax,
            'taxes' => $this->taxes,
            'meta_data' => $this->meta_data,
        ];
    }
}
