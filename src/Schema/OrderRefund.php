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

class OrderRefund implements JsonSerializable, JsonDeSerializable
{
    /**
     * @param int $id Refund ID. READ-ONLY
     * @param string $reason Refund reason. READ-ONLY
     * @param string $total Refund total. READ-ONLY
     */
    public function __construct(
        public int $id = 0,
        public string $reason = '',
        public string $total = '',
    ) {
    }

    public static function jsonDeSerialize(mixed $data): static
    {
        return new static(
            $data['id'] ?? 0,
            $data['reason'] ?? '',
            $data['total'] ?? '',
        );
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'reason' => $this->reason,
            'total' => $this->total,
        ];
    }
}
