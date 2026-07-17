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

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Woo\ServerHandlerInterface;

class CreateHandler implements ServerHandlerInterface
{
    public function is(string $method, string $path): bool
    {
        return $method === 'POST' && $path === '/wp-json/wc/v3/orders';
    }

    public function handle(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // {
        //   "payment_method": "bacs",
        //   "payment_method_title": "Direct Bank Transfer",
        //   "set_paid": true,
        //   "billing": {
        //     "first_name": "John",
        //     "last_name": "Doe",
        //     "address_1": "969 Market",
        //     "address_2": "",
        //     "city": "San Francisco",
        //     "state": "CA",
        //     "postcode": "94103",
        //     "country": "US",
        //     "email": "john.doe@example.com",
        //     "phone": "(555) 555-5555"
        //   },
        //   "shipping": {
        //     "first_name": "John",
        //     "last_name": "Doe",
        //     "address_1": "969 Market",
        //     "address_2": "",
        //     "city": "San Francisco",
        //     "state": "CA",
        //     "postcode": "94103",
        //     "country": "US"
        //   },
        //   "line_items": [
        //     {
        //       "product_id": 93,
        //       "quantity": 2
        //     },
        //     {
        //       "product_id": 22,
        //       "variation_id": 23,
        //       "quantity": 1
        //     }
        //   ],
        //   "shipping_lines": [
        //     {
        //       "method_id": "flat_rate",
        //       "method_title": "Flat Rate",
        //       "total": "10.00"
        //     }
        //   ]
        // }
        return $response;
    }
}
