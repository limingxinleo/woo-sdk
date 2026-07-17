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

namespace Woo\Auth;

use Woo\Config\Config;

use function array_merge;
use function base64_encode;
use function bin2hex;
use function hash_hmac;
use function implode;
use function parse_str;
use function parse_url;
use function random_bytes;
use function rawurlencode;
use function sort;
use function strtoupper;
use function time;
use function uksort;

/**
 * WooCommerce REST API 认证器.
 *
 * 支持 OAuth 1.0a one-legged 签名和 Basic Auth 两种认证方式.
 *
 * @see https://woocommerce.github.io/woocommerce-rest-api-docs/#authentication
 */
class Authenticator
{
    /**
     * @param Config $config WooCommerce API 配置 (url, consumer key, consumer secret)
     */
    public function __construct(
        private Config $config,
    ) {
    }

    /**
     * 生成 OAuth 1.0a Authorization Header.
     *
     * @param string $method HTTP 请求方法 (GET, POST, PUT, DELETE 等)
     * @param string $url 完整的请求 URL (可含 query string)
     * @param array $params 请求体参数 (POST/PUT body params)
     * @return string Authorization header 值 (不含 "Authorization: " 前缀)
     */
    public function generateAuthHeader(string $method, string $url, array $params = []): string
    {
        $signature = $this->generateSignature($method, $url, $params);

        $oauthParams = $this->buildOAuthParams();
        $oauthParams['oauth_signature'] = $signature;

        return $this->buildHeaderString($oauthParams);
    }

    /**
     * 生成 HTTP Basic Auth Header.
     *
     * 将 consumer_key:consumer_secret 进行 base64 编码,
     * 适合在 HTTPS 环境下使用的简易认证方式.
     *
     * @return string Basic Auth header 值 (不含 "Authorization: " 前缀)
     */
    public function generateBasicAuthHeader(): string
    {
        return 'Basic ' . base64_encode($this->config->key . ':' . $this->config->secret);
    }

    /**
     * 生成带 OAuth 签名参数的完整 URL.
     *
     * 将 OAuth 签名参数附加到 URL 的 query string 中,
     * 适用于需要在 URL 中传递认证信息的场景.
     *
     * @param string $method HTTP 请求方法
     * @param string $url 原始请求 URL
     * @param array $params 请求体参数
     * @return string 带 OAuth 签名参数的完整 URL
     */
    public function generateAuthUrl(string $method, string $url, array $params = []): string
    {
        $signature = $this->generateSignature($method, $url, $params);

        $oauthParams = $this->buildOAuthParams();
        $oauthParams['oauth_signature'] = $signature;

        $queryString = $this->buildParamString($oauthParams);

        return $url . (str_contains($url, '?') ? '&' : '?') . $queryString;
    }

    /**
     * 生成 OAuth 1.0a 签名.
     */
    private function generateSignature(string $method, string $url, array $params): string
    {
        $parsedUrl = parse_url($url);
        $baseUrl = $this->normalizeBaseUrl($parsedUrl);

        // 提取 URL 中的 query params
        $queryParams = [];
        if (isset($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $queryParams);
        }

        // 合并所有参数: OAuth 参数 + URL query 参数 + 请求体参数
        $allParams = array_merge($this->buildOAuthParams(), $queryParams, $params);

        // 构建签名基串
        $baseString = strtoupper($method)
            . '&' . rawurlencode($baseUrl)
            . '&' . rawurlencode($this->buildParamString($allParams));

        // 签名密钥: consumer_secret + '&' (token secret 为空)
        $signingKey = rawurlencode($this->config->secret) . '&';

        return base64_encode(hash_hmac('sha256', $baseString, $signingKey, true));
    }

    /**
     * 构建 OAuth 基础参数 (不含 signature).
     *
     * @return array<string, string>
     */
    private function buildOAuthParams(): array
    {
        return [
            'oauth_consumer_key' => $this->config->key,
            'oauth_nonce' => $this->generateNonce(),
            'oauth_signature_method' => 'HMAC-SHA256',
            'oauth_timestamp' => (string) time(),
        ];
    }

    /**
     * 将参数数组编码为排序后的参数字符串.
     *
     * 按 key=value 对进行字典序排序后以 & 连接,
     * 符合 OAuth 1.0a 规范 (RFC 5849).
     *
     * @param array<string, string> $params
     */
    private function buildParamString(array $params): string
    {
        $pairs = [];

        foreach ($params as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $item) {
                    $pairs[] = rawurlencode($key) . '=' . rawurlencode((string) $item);
                }
            } else {
                $pairs[] = rawurlencode($key) . '=' . rawurlencode((string) $value);
            }
        }

        sort($pairs); // 按编码后的字符串字典序排序

        return implode('&', $pairs);
    }

    /**
     * 将 OAuth 参数数组构建为 Authorization header 字符串.
     *
     * @param array<string, string> $oauthParams
     */
    private function buildHeaderString(array $oauthParams): string
    {
        $parts = [];

        // 按参数名排序以保证输出一致性
        uksort($oauthParams, 'strcmp');

        foreach ($oauthParams as $key => $value) {
            $parts[] = rawurlencode($key) . '="' . rawurlencode($value) . '"';
        }

        return 'OAuth ' . implode(', ', $parts);
    }

    /**
     * 规范化 Base URL.
     *
     * 去除默认端口 (443 for https, 80 for http),
     * 将 scheme 和 host 转为小写.
     *
     * @param array<string, mixed> $parsedUrl parse_url() 的返回值
     */
    private function normalizeBaseUrl(array $parsedUrl): string
    {
        $scheme = strtolower($parsedUrl['scheme'] ?? 'https');
        $host = strtolower($parsedUrl['host'] ?? '');
        $port = $parsedUrl['port'] ?? null;
        $path = $parsedUrl['path'] ?? '/';

        // 去除默认端口
        if (($scheme === 'https' && (string) $port === '443')
            || ($scheme === 'http' && (string) $port === '80')
        ) {
            $port = null;
        }

        $baseUrl = $scheme . '://' . $host;

        if ($port !== null) {
            $baseUrl .= ':' . $port;
        }

        $baseUrl .= $path;

        return $baseUrl;
    }

    /**
     * 生成安全的随机 nonce.
     */
    private function generateNonce(): string
    {
        return bin2hex(random_bytes(16));
    }
}
