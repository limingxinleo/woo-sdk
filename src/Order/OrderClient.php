<?php

declare(strict_types=1);
/**
 * This file is part of limingxinleo/woo-sdk.
 *
 * @link     https://github.com/limingxinleo/woo-sdk
 * @document https://github.com/limingxinleo/woo-sdk
 * @contact  limingxinleo@gmail.com
 * @license  https://github.com/limingxinleo/woo-sdk/blob/master/LICENSE
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
