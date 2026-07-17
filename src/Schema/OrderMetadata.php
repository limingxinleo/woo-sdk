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

class OrderMetadata implements JsonSerializable, JsonDeSerializable
{
    /**
     * @param int $id Meta ID. READ-ONLY
     * @param string $key Meta key
     * @param string $value Meta value
     */
    public function __construct(
        public int $id = 0,
        public string $key = '',
        public string $value = '',
    ) {
    }

    public static function jsonDeSerialize(mixed $data): static
    {
        return new static(
            $data['id'] ?? 0,
            $data['key'] ?? '',
            $data['value'] ?? '',
        );
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'key' => $this->key,
            'value' => $this->value,
        ];
    }
}
