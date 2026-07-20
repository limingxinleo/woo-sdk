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

use function Woo\array_or_null;
use function Woo\bool_or_null;
use function Woo\int_or_null;
use function Woo\string_or_null;

class ProductAttribute implements JsonSerializable, JsonDeSerializable
{
    /**
     * @param null|int $id Attribute ID
     * @param null|string $name Attribute name
     * @param null|int $position Attribute position
     * @param null|bool $visible Define if the attribute is visible on the "Additional information" tab in the product's page. Default is false
     * @param null|bool $variation Define if the attribute can be used as variation. Default is false
     * @param null|array $options List of available term names of the attribute
     */
    public function __construct(
        public ?int $id = null,
        public ?string $name = null,
        public ?int $position = null,
        public ?bool $visible = null,
        public ?bool $variation = null,
        public ?array $options = null,
    ) {
    }

    public static function jsonDeSerialize(mixed $data): static
    {
        return new static(
            int_or_null($data['id'] ?? null),
            string_or_null($data['name'] ?? null),
            int_or_null($data['position'] ?? null),
            bool_or_null($data['visible'] ?? null),
            bool_or_null($data['variation'] ?? null),
            array_or_null($data['options'] ?? null),
        );
    }

    public function jsonSerialize(): mixed
    {
        return array_filter([
            'id' => $this->id,
            'name' => $this->name,
            'position' => $this->position,
            'visible' => $this->visible,
            'variation' => $this->variation,
            'options' => $this->options,
        ], static fn (mixed $value) => $value !== null);
    }
}
