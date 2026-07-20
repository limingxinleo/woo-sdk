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

use Hyperf\Codec\Json;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Woo\Order\Request\ListRequest;
use Woo\Schema\Order;
use Woo\ServerHandlerInterface;

abstract class ListHandler implements ServerHandlerInterface
{
    public function is(string $method, string $path): bool
    {
        return $method === 'GET' && $path === '/wp-json/wc/v3/orders';
    }

    public function handle(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $query = [];
        parse_str($request->getUri()->getQuery(), $query);

        $request = ListRequest::jsonDeSerialize($query);

        $result = $this->run($request);

        return $response->withBody(new SwooleStream(Json::encode($result)));
    }

    /**
     * @return Order[]
     */
    abstract public function run(ListRequest $request): array;
}
