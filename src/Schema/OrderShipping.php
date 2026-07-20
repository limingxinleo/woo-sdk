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

class OrderShipping implements JsonSerializable, JsonDeSerializable
{
    /**
     * @param null|string $first_name First name
     * @param null|string $last_name Last name
     * @param null|string $company Company name
     * @param null|string $address_1 Address line 1
     * @param null|string $address_2 Address line 2
     * @param null|string $city City name
     * @param null|string $state ISO code or name of the state, province or district
     * @param null|string $postcode Postal code
     * @param null|string $country Country code in ISO 3166-1 alpha-2 format
     */
    public function __construct(
        public ?string $first_name = null,
        public ?string $last_name = null,
        public ?string $company = null,
        public ?string $address_1 = null,
        public ?string $address_2 = null,
        public ?string $city = null,
        public ?string $state = null,
        public ?string $postcode = null,
        public ?string $country = null,
    ) {
    }

    public static function jsonDeSerialize(mixed $data): static
    {
        return new static(
            string_or_null($data['first_name'] ?? null),
            string_or_null($data['last_name'] ?? null),
            string_or_null($data['company'] ?? null),
            string_or_null($data['address_1'] ?? null),
            string_or_null($data['address_2'] ?? null),
            string_or_null($data['city'] ?? null),
            string_or_null($data['state'] ?? null),
            string_or_null($data['postcode'] ?? null),
            string_or_null($data['country'] ?? null),
        );
    }

    public function jsonSerialize(): mixed
    {
        return array_filter([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'company' => $this->company,
            'address_1' => $this->address_1,
            'address_2' => $this->address_2,
            'city' => $this->city,
            'state' => $this->state,
            'postcode' => $this->postcode,
            'country' => $this->country,
        ], static fn (mixed $value) => $value !== null);
    }
}
