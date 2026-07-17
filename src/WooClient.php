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

namespace Woo;

use Woo\Auth\Authenticator;
use Woo\Config\Config;

/**
 * WooCommerce SDK 主客户端.
 *
 * 封装 WooCommerce REST API 的认证逻辑,
 * 为各资源子客户端提供统一的认证入口.
 *
 * @method Order\OrderClient order()
 */
class WooClient
{
    /**
     * 认证器实例.
     */
    public readonly Authenticator $auth;

    /**
     * @param Config $config WooCommerce API 配置
     */
    public function __construct(public Config $config)
    {
        $this->auth = new Authenticator($this->config);
    }

    /**
     * 创建带 OAuth 签名的完整 API 请求 URL.
     *
     * @param string $method HTTP 方法
     * @param string $path   API 路径 (相对于 store URL, 如 "/wp-json/wc/v3/orders")
     * @param array  $params 请求参数
     * @return string 带 OAuth 签名的完整 URL
     */
    public function buildAuthUrl(string $method, string $path, array $params = []): string
    {
        $url = rtrim($this->config->url, '/') . $path;

        return $this->auth->generateAuthUrl($method, $url, $params);
    }

    /**
     * 生成 OAuth 认证请求头.
     *
     * @param string $method HTTP 方法
     * @param string $path   API 路径
     * @param array  $params 请求参数
     * @return string Authorization header 值
     */
    public function buildAuthHeader(string $method, string $path, array $params = []): string
    {
        $url = rtrim($this->config->url, '/') . $path;

        return $this->auth->generateAuthHeader($method, $url, $params);
    }
}
