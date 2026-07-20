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

class ProductDownload implements JsonSerializable, JsonDeSerializable
{
    /**
     * @param null|string $id File ID
     * @param null|string $name File name
     * @param null|string $file File URL
     */
    public function __construct(
        public ?string $id = null,
        public ?string $name = null,
        public ?string $file = null,
    ) {
    }

    public static function jsonDeSerialize(mixed $data): static
    {
        return new static(
            string_or_null($data['id'] ?? null),
            string_or_null($data['name'] ?? null),
            string_or_null($data['file'] ?? null),
        );
    }

    public function jsonSerialize(): mixed
    {
        return array_filter([
            'id' => $this->id,
            'name' => $this->name,
            'file' => $this->file,
        ], static fn (mixed $value) => $value !== null);
    }
}
