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

class OrderFeeLine implements JsonSerializable, JsonDeSerializable
{
    /**
     * @param null|int $id Item ID. READ-ONLY
     * @param null|string $name Fee name
     * @param null|string $tax_class Tax class of fee
     * @param null|string $tax_status Tax status of fee. Options: taxable and none
     * @param null|string $total Line total (after discounts)
     * @param null|string $total_tax Line total tax (after discounts). READ-ONLY
     * @param null|OrderTaxLine[] $taxes Line taxes. READ-ONLY
     * @param null|OrderMetadata[] $meta_data Meta data
     */
    public function __construct(
        public ?int $id = null,
        public ?string $name = null,
        public ?string $tax_class = null,
        public ?string $tax_status = null,
        public ?string $total = null,
        public ?string $total_tax = null,
        public ?array $taxes = null,
        public ?array $meta_data = null,
    ) {
    }

    public static function jsonDeSerialize(mixed $data): static
    {
        return new static(
            int_or_null($data['id'] ?? null),
            string_or_null($data['name'] ?? null),
            string_or_null($data['tax_class'] ?? null),
            string_or_null($data['tax_status'] ?? null),
            string_or_null($data['total'] ?? null),
            string_or_null($data['total_tax'] ?? null),
            isset($data['taxes']) && is_array($data['taxes'])
                ? array_map(static fn (array $item) => OrderTaxLine::jsonDeSerialize($item), $data['taxes'])
                : null,
            isset($data['meta_data']) && is_array($data['meta_data'])
                ? array_map(static fn (array $item) => OrderMetadata::jsonDeSerialize($item), $data['meta_data'])
                : null,
        );
    }

    public function jsonSerialize(): mixed
    {
        return array_filter([
            'id' => $this->id,
            'name' => $this->name,
            'tax_class' => $this->tax_class,
            'tax_status' => $this->tax_status,
            'total' => $this->total,
            'total_tax' => $this->total_tax,
            'taxes' => $this->taxes,
            'meta_data' => $this->meta_data,
        ], static fn (mixed $value) => $value !== null);
    }
}
