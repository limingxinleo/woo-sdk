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

class OrderShippingLine implements JsonSerializable, JsonDeSerializable
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

    public static function jsonDeSerialize(mixed $data): static
    {
        return new static(
            $data['id'] ?? 0,
            $data['method_title'] ?? '',
            $data['method_id'] ?? '',
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
            'method_title' => $this->method_title,
            'method_id' => $this->method_id,
            'total' => $this->total,
            'total_tax' => $this->total_tax,
            'taxes' => $this->taxes,
            'meta_data' => $this->meta_data,
        ];
    }
}
