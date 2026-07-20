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

class OrderCouponLine implements JsonSerializable, JsonDeSerializable
{
    /**
     * @param null|int $id Item ID. READ-ONLY
     * @param null|string $code Coupon code
     * @param null|string $discount Discount total. READ-ONLY
     * @param null|string $discount_tax Discount total tax. READ-ONLY
     * @param null|OrderMetadata[] $meta_data Meta data
     */
    public function __construct(
        public ?int $id = null,
        public ?string $code = null,
        public ?string $discount = null,
        public ?string $discount_tax = null,
        public ?array $meta_data = null,
    ) {
    }

    public static function jsonDeSerialize(mixed $data): static
    {
        return new static(
            int_or_null($data['id'] ?? null),
            string_or_null($data['code'] ?? null),
            string_or_null($data['discount'] ?? null),
            string_or_null($data['discount_tax'] ?? null),
            isset($data['meta_data']) && is_array($data['meta_data'])
                ? array_map(static fn (array $item) => OrderMetadata::jsonDeSerialize($item), $data['meta_data'])
                : null,
        );
    }

    public function jsonSerialize(): mixed
    {
        return array_filter([
            'id' => $this->id,
            'code' => $this->code,
            'discount' => $this->discount,
            'discount_tax' => $this->discount_tax,
            'meta_data' => $this->meta_data,
        ], static fn (mixed $value) => $value !== null);
    }
}
