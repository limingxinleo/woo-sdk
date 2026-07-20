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

class ProductDefaultAttribute implements JsonSerializable, JsonDeSerializable
{
    /**
     * @param null|int $id Attribute ID
     * @param null|string $name Attribute name
     * @param null|string $option Selected attribute term name
     */
    public function __construct(
        public ?int $id = null,
        public ?string $name = null,
        public ?string $option = null,
    ) {
    }

    public static function jsonDeSerialize(mixed $data): static
    {
        return new static(
            int_or_null($data['id'] ?? null),
            string_or_null($data['name'] ?? null),
            string_or_null($data['option'] ?? null),
        );
    }

    public function jsonSerialize(): mixed
    {
        return array_filter([
            'id' => $this->id,
            'name' => $this->name,
            'option' => $this->option,
        ], static fn (mixed $value) => $value !== null);
    }
}
