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

class OrderMetadata implements JsonSerializable, JsonDeSerializable
{
    /**
     * @param null|int $id Meta ID. READ-ONLY
     * @param null|string $key Meta key
     * @param null|string $value Meta value
     */
    public function __construct(
        public ?int $id = null,
        public ?string $key = null,
        public ?string $value = null,
    ) {
    }

    public static function jsonDeSerialize(mixed $data): static
    {
        return new static(
            int_or_null($data['id'] ?? null),
            string_or_null($data['key'] ?? null),
            string_or_null($data['value'] ?? null),
        );
    }

    public function jsonSerialize(): mixed
    {
        return array_filter([
            'id' => $this->id,
            'key' => $this->key,
            'value' => $this->value,
        ], static fn (mixed $value) => $value !== null);
    }
}
