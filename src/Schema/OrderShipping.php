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

class OrderShipping
{
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
}
