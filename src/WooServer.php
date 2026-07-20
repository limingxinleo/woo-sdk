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

namespace Woo;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class WooServer
{
    /**
     * @var ServerHandlerInterface[]
     */
    public array $handlers = [];

    public function run(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $path = $request->getUri()->getPath();
        $method = strtoupper($request->getMethod());

        foreach ($this->handlers as $handler) {
            if ($handler->is($method, $path)) {
                return $handler->handle($request, $response);
            }
        }

        return $response;
    }

    public function register(ServerHandlerInterface $handler): static
    {
        $this->handlers[] = $handler;
        return $this;
    }
}
