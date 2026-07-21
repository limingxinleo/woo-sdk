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

use function Woo\bool_or_null;
use function Woo\int_or_null;
use function Woo\string_or_null;

/**
 * WooCommerce Order Note 数据模型.
 *
 * @see https://woocommerce.github.io/woocommerce-rest-api-docs/#order-notes
 */
class OrderNote implements JsonSerializable, JsonDeSerializable
{
    /**
     * @param null|int $id Unique identifier for the resource. READ-ONLY
     * @param null|string $author Order note author. READ-ONLY
     * @param null|string $date_created The date the order note was created, in the site's timezone. READ-ONLY
     * @param null|string $date_created_gmt The date the order note was created, as GMT. READ-ONLY
     * @param null|string $note Order note content. MANDATORY
     * @param null|bool $customer_note If true, the note will be shown to customers and they will be notified. If false, the note will be for admin reference only. Default is false
     * @param null|bool $added_by_user If true, this note will be attributed to the current user. If false, the note will be attributed to the system. Default is false
     */
    public function __construct(
        public ?int $id = null,
        public ?string $author = null,
        public ?string $date_created = null,
        public ?string $date_created_gmt = null,
        public ?string $note = null,
        public ?bool $customer_note = null,
        public ?bool $added_by_user = null,
    ) {
    }

    public static function jsonDeSerialize(mixed $data): static
    {
        return new static(
            int_or_null($data['id'] ?? null),
            string_or_null($data['author'] ?? null),
            string_or_null($data['date_created'] ?? null),
            string_or_null($data['date_created_gmt'] ?? null),
            string_or_null($data['note'] ?? null),
            bool_or_null($data['customer_note'] ?? null),
            bool_or_null($data['added_by_user'] ?? null),
        );
    }

    public function jsonSerialize(): mixed
    {
        return array_filter([
            'id' => $this->id,
            'author' => $this->author,
            'date_created' => $this->date_created,
            'date_created_gmt' => $this->date_created_gmt,
            'note' => $this->note,
            'customer_note' => $this->customer_note,
            'added_by_user' => $this->added_by_user,
        ], static fn (mixed $value) => $value !== null);
    }
}
