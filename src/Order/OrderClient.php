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

namespace Woo\Order;

use Woo\WooClient;

/**
 * WooCommerce Orders API 客户端.
 *
 * @see https://woocommerce.github.io/woocommerce-rest-api-docs/#orders
 */
class OrderClient
{
    public function __construct(
        private WooClient $client,
    ) {
    }
}
