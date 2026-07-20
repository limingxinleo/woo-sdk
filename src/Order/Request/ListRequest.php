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

namespace Woo\Order\Request;

use Hyperf\Contract\JsonDeSerializable;
use JsonSerializable;

use function Woo\array_or_null;
use function Woo\bool_or_null;
use function Woo\int_or_null;
use function Woo\string_or_null;

class ListRequest implements JsonSerializable, JsonDeSerializable
{
    /**
     * @param null|string $context Scope under which the request is made; determines fields present in response. Options: view and edit. Default is view.
     * @param null|int $page Current page of the collection. Default is 1.
     * @param null|int $per_page Maximum number of items to be returned in result set. Default is 10.
     * @param null|string $search limit results to those matching a string
     * @param null|string $after limit response to resources published after a given ISO8601 compliant date
     * @param null|string $before limit response to resources published before a given ISO8601 compliant date
     * @param null|string $modified_after limit response to resources modified after a given ISO8601 compliant date
     * @param null|string $modified_before limit response to resources modified before a given ISO8601 compliant date
     * @param null|bool $dates_are_gmt whether to interpret dates as GMT when limiting response by published or modified date
     * @param null|array $exclude ensure result set excludes specific IDs
     * @param null|array $include limit result set to specific ids
     * @param null|int $offset offset the result set by a specific number of items
     * @param null|string $order Order sort attribute ascending or descending. Options: asc and desc. Default is desc.
     * @param null|string $orderby Sort collection by object attribute. Options: date, modified, id, include, title and slug. Default is date.
     * @param null|array $parent limit result set to those of particular parent IDs
     * @param null|array $parent_exclude limit result set to all items except those of a particular parent ID
     * @param null|array $status Limit result set to orders assigned a specific status. Options: any, pending, processing, on-hold, completed, cancelled, refunded, failed and trash. Default is any.
     * @param null|int $customer limit result set to orders assigned a specific customer
     * @param null|int $product limit result set to orders assigned a specific product
     * @param null|int $dp Number of decimal points to use in each resource. Default is 2.
     * @param null|string $created_via Limit result set to orders created via specific sources (e.g. checkout, store-api). Multiple options can be provided as a comma-separated list.
     */
    public function __construct(
        public ?string $context = null,
        public ?int $page = null,
        public ?int $per_page = null,
        public ?string $search = null,
        public ?string $after = null,
        public ?string $before = null,
        public ?string $modified_after = null,
        public ?string $modified_before = null,
        public ?bool $dates_are_gmt = null,
        public ?array $exclude = null,
        public ?array $include = null,
        public ?int $offset = null,
        public ?string $order = null,
        public ?string $orderby = null,
        public ?array $parent = null,
        public ?array $parent_exclude = null,
        public ?array $status = null,
        public ?int $customer = null,
        public ?int $product = null,
        public ?int $dp = null,
        public ?string $created_via = null,
    ) {
    }

    public static function jsonDeSerialize(mixed $data): static
    {
        return new static(
            string_or_null($data['context'] ?? null),
            int_or_null($data['page'] ?? null),
            int_or_null($data['per_page'] ?? null),
            string_or_null($data['search'] ?? null),
            string_or_null($data['after'] ?? null),
            string_or_null($data['before'] ?? null),
            string_or_null($data['modified_after'] ?? null),
            string_or_null($data['modified_before'] ?? null),
            bool_or_null($data['dates_are_gmt'] ?? null),
            array_or_null($data['exclude'] ?? null),
            array_or_null($data['include'] ?? null),
            int_or_null($data['offset'] ?? null),
            string_or_null($data['order'] ?? null),
            string_or_null($data['orderby'] ?? null),
            array_or_null($data['parent'] ?? null),
            array_or_null($data['parent_exclude'] ?? null),
            array_or_null($data['status'] ?? null),
            int_or_null($data['customer'] ?? null),
            int_or_null($data['product'] ?? null),
            int_or_null($data['dp'] ?? null),
            string_or_null($data['created_via'] ?? null),
        );
    }

    public function jsonSerialize(): mixed
    {
        return array_filter([
            'context' => $this->context,
            'page' => $this->page,
            'per_page' => $this->per_page,
            'search' => $this->search,
            'after' => $this->after,
            'before' => $this->before,
            'modified_after' => $this->modified_after,
            'modified_before' => $this->modified_before,
            'dates_are_gmt' => $this->dates_are_gmt,
            'exclude' => $this->exclude,
            'include' => $this->include,
            'offset' => $this->offset,
            'order' => $this->order,
            'orderby' => $this->orderby,
            'parent' => $this->parent,
            'parent_exclude' => $this->parent_exclude,
            'status' => $this->status,
            'customer' => $this->customer,
            'product' => $this->product,
            'dp' => $this->dp,
            'created_via' => $this->created_via,
        ], static fn (mixed $value) => $value !== null);
    }
}
