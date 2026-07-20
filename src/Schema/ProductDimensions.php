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

use function Woo\string_or_null;

class ProductDimensions implements JsonSerializable, JsonDeSerializable
{
    /**
     * @param null|string $length Product length
     * @param null|string $width Product width
     * @param null|string $height Product height
     */
    public function __construct(
        public ?string $length = null,
        public ?string $width = null,
        public ?string $height = null,
    ) {
    }

    public static function jsonDeSerialize(mixed $data): static
    {
        return new static(
            string_or_null($data['length'] ?? null),
            string_or_null($data['width'] ?? null),
            string_or_null($data['height'] ?? null),
        );
    }

    public function jsonSerialize(): mixed
    {
        return array_filter([
            'length' => $this->length,
            'width' => $this->width,
            'height' => $this->height,
        ], static fn (mixed $value) => $value !== null);
    }
}
