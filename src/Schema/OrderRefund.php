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

class OrderRefund implements JsonSerializable, JsonDeSerializable
{
    /**
     * @param null|int $id Refund ID. READ-ONLY
     * @param null|string $reason Refund reason. READ-ONLY
     * @param null|string $total Refund total. READ-ONLY
     */
    public function __construct(
        public ?int $id = null,
        public ?string $reason = null,
        public ?string $total = null,
    ) {
    }

    public static function jsonDeSerialize(mixed $data): static
    {
        return new static(
            int_or_null($data['id'] ?? null),
            string_or_null($data['reason'] ?? null),
            string_or_null($data['total'] ?? null),
        );
    }

    public function jsonSerialize(): mixed
    {
        return array_filter([
            'id' => $this->id,
            'reason' => $this->reason,
            'total' => $this->total,
        ], static fn (mixed $value) => $value !== null);
    }
}
