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

class OrderTaxLine implements JsonSerializable, JsonDeSerializable
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

    public static function jsonDeSerialize(mixed $data): static
    {
        return new static(
            $data['id'] ?? 0,
            $data['rate_code'] ?? '',
            $data['rate_id'] ?? 0,
            $data['label'] ?? '',
            $data['compound'] ?? false,
            $data['tax_total'] ?? '',
            $data['shipping_tax_total'] ?? '',
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
            'rate_code' => $this->rate_code,
            'rate_id' => $this->rate_id,
            'label' => $this->label,
            'compound' => $this->compound,
            'tax_total' => $this->tax_total,
            'shipping_tax_total' => $this->shipping_tax_total,
            'meta_data' => $this->meta_data,
        ];
    }
}
