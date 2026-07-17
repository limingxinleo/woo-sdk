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

class OrderShipping implements JsonSerializable, JsonDeSerializable
{
    /**
     * @param string $first_name First name
     * @param string $last_name Last name
     * @param string $company Company name
     * @param string $address_1 Address line 1
     * @param string $address_2 Address line 2
     * @param string $city City
     * @param string $state State or county
     * @param string $postcode Postcode or ZIP
     * @param string $country Country ISO 3166-1 alpha-2 code
     */
    public function __construct(
        public string $first_name = '',
        public string $last_name = '',
        public string $company = '',
        public string $address_1 = '',
        public string $address_2 = '',
        public string $city = '',
        public string $state = '',
        public string $postcode = '',
        public string $country = '',
    ) {
    }

    public static function jsonDeSerialize(mixed $data): static
    {
        return new static(
            $data['first_name'] ?? '',
            $data['last_name'] ?? '',
            $data['company'] ?? '',
            $data['address_1'] ?? '',
            $data['address_2'] ?? '',
            $data['city'] ?? '',
            $data['state'] ?? '',
            $data['postcode'] ?? '',
            $data['country'] ?? '',
        );
    }

    public function jsonSerialize(): mixed
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'company' => $this->company,
            'address_1' => $this->address_1,
            'address_2' => $this->address_2,
            'city' => $this->city,
            'state' => $this->state,
            'postcode' => $this->postcode,
            'country' => $this->country,
        ];
    }
}
