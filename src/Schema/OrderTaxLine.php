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

use function Woo\bool_or_null;
use function Woo\int_or_null;
use function Woo\string_or_null;

class OrderTaxLine implements JsonSerializable, JsonDeSerializable
{
    /**
     * @param null|int $id Item ID. READ-ONLY
     * @param null|string $rate_code Tax rate code. READ-ONLY
     * @param null|int $rate_id Tax rate ID. READ-ONLY
     * @param null|string $label Tax rate label. READ-ONLY
     * @param null|bool $compound Whether or not this is a compound tax rate. READ-ONLY
     * @param null|string $tax_total Tax total (not including shipping taxes). READ-ONLY
     * @param null|string $shipping_tax_total Shipping tax total. READ-ONLY
     * @param null|OrderMetadata[] $meta_data Meta data
     */
    public function __construct(
        public ?int $id = null,
        public ?string $rate_code = null,
        public ?int $rate_id = null,
        public ?string $label = null,
        public ?bool $compound = null,
        public ?string $tax_total = null,
        public ?string $shipping_tax_total = null,
        public ?array $meta_data = null,
    ) {
    }

    public static function jsonDeSerialize(mixed $data): static
    {
        return new static(
            int_or_null($data['id'] ?? null),
            string_or_null($data['rate_code'] ?? null),
            int_or_null($data['rate_id'] ?? null),
            string_or_null($data['label'] ?? null),
            bool_or_null($data['compound'] ?? null),
            string_or_null($data['tax_total'] ?? null),
            string_or_null($data['shipping_tax_total'] ?? null),
            isset($data['meta_data']) && is_array($data['meta_data'])
                ? array_map(static fn (array $item) => OrderMetadata::jsonDeSerialize($item), $data['meta_data'])
                : null,
        );
    }

    public function jsonSerialize(): mixed
    {
        return array_filter([
            'id' => $this->id,
            'rate_code' => $this->rate_code,
            'rate_id' => $this->rate_id,
            'label' => $this->label,
            'compound' => $this->compound,
            'tax_total' => $this->tax_total,
            'shipping_tax_total' => $this->shipping_tax_total,
            'meta_data' => $this->meta_data,
        ], static fn (mixed $value) => $value !== null);
    }
}
