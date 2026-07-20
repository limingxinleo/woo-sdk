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

class ProductImage implements JsonSerializable, JsonDeSerializable
{
    /**
     * @param null|int $id The attachment ID from the Media Library
     * @param null|string $date_created The date the image was created, in the site's timezone. READ-ONLY
     * @param null|string $date_created_gmt The date the image was created, as GMT. READ-ONLY
     * @param null|string $date_modified The date the image was last modified, in the site's timezone. READ-ONLY
     * @param null|string $date_modified_gmt The date the image was last modified, as GMT. READ-ONLY
     * @param null|string $src Image URL
     * @param null|string $name Image name
     * @param null|string $alt Image alternative text
     */
    public function __construct(
        public ?int $id = null,
        public ?string $date_created = null,
        public ?string $date_created_gmt = null,
        public ?string $date_modified = null,
        public ?string $date_modified_gmt = null,
        public ?string $src = null,
        public ?string $name = null,
        public ?string $alt = null,
    ) {
    }

    public static function jsonDeSerialize(mixed $data): static
    {
        return new static(
            int_or_null($data['id'] ?? null),
            string_or_null($data['date_created'] ?? null),
            string_or_null($data['date_created_gmt'] ?? null),
            string_or_null($data['date_modified'] ?? null),
            string_or_null($data['date_modified_gmt'] ?? null),
            string_or_null($data['src'] ?? null),
            string_or_null($data['name'] ?? null),
            string_or_null($data['alt'] ?? null),
        );
    }

    public function jsonSerialize(): mixed
    {
        return array_filter([
            'id' => $this->id,
            'date_created' => $this->date_created,
            'date_created_gmt' => $this->date_created_gmt,
            'date_modified' => $this->date_modified,
            'date_modified_gmt' => $this->date_modified_gmt,
            'src' => $this->src,
            'name' => $this->name,
            'alt' => $this->alt,
        ], static fn (mixed $value) => $value !== null);
    }
}
