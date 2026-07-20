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

class ProductCategory implements JsonSerializable, JsonDeSerializable
{
    /**
     * @param null|int $id Category ID
     * @param null|string $name Category name. READ-ONLY
     * @param null|string $slug Category slug. READ-ONLY
     */
    public function __construct(
        public ?int $id = null,
        public ?string $name = null,
        public ?string $slug = null,
    ) {
    }

    public static function jsonDeSerialize(mixed $data): static
    {
        return new static(
            int_or_null($data['id'] ?? null),
            string_or_null($data['name'] ?? null),
            string_or_null($data['slug'] ?? null),
        );
    }

    public function jsonSerialize(): mixed
    {
        return array_filter([
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
        ], static fn (mixed $value) => $value !== null);
    }
}
