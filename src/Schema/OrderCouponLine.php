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

class OrderCouponLine implements JsonSerializable, JsonDeSerializable
{
    /**
     * @param int $id Item ID. READ-ONLY
     * @param string $code Coupon code
     * @param string $discount Discount total. READ-ONLY
     * @param string $discount_tax Discount total tax. READ-ONLY
     * @param OrderMetadata[] $meta_data Meta data
     */
    public function __construct(
        public int $id = 0,
        public string $code = '',
        public string $discount = '',
        public string $discount_tax = '',
        public array $meta_data = [],
    ) {
    }

    public static function jsonDeSerialize(mixed $data): static
    {
        return new static(
            $data['id'] ?? 0,
            $data['code'] ?? '',
            $data['discount'] ?? '',
            $data['discount_tax'] ?? '',
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
            'code' => $this->code,
            'discount' => $this->discount,
            'discount_tax' => $this->discount_tax,
            'meta_data' => $this->meta_data,
        ];
    }
}
