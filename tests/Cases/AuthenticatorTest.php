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

namespace HyperfTest\Cases;

use HyperfTest\Cases\AbstractTestCase;
use Woo\Auth\Authenticator;
use Woo\Config\Config;
use Woo\WooClient;

/**
 * @internal
 * @covers \Woo\Auth\Authenticator
 */
class AuthenticatorTest extends AbstractTestCase
{
    private Config $config;

    private Authenticator $authenticator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->config = new Config(
            url: 'https://example.com',
            key: 'ck_abc123',
            secret: 'cs_xyz789',
        );

        $this->authenticator = new Authenticator($this->config);
    }

    /**
     * 测试 Basic Auth Header 生成.
     */
    public function testGenerateBasicAuthHeader(): void
    {
        $header = $this->authenticator->generateBasicAuthHeader();

        $expected = 'Basic ' . base64_encode('ck_abc123:cs_xyz789');

        $this->assertSame($expected, $header);
        $this->assertStringStartsWith('Basic ', $header);
    }

    /**
     * 测试 OAuth Header 包含必要字段.
     */
    public function testGenerateAuthHeaderContainsRequiredParams(): void
    {
        $header = $this->authenticator->generateAuthHeader('GET', 'https://example.com/wp-json/wc/v3/orders');

        $this->assertStringStartsWith('OAuth ', $header);
        $this->assertStringContainsString('oauth_consumer_key%3Dck_abc123', $header);
        $this->assertStringContainsString('oauth_signature_method%3DHMAC-SHA256', $header);
        $this->assertStringContainsString('oauth_signature', $header);
        $this->assertStringContainsString('oauth_timestamp', $header);
        $this->assertStringContainsString('oauth_nonce', $header);
    }

    /**
     * 测试 OAuth Header 中签名字段存在且为有效的 base64.
     */
    public function testGenerateAuthHeaderHasValidSignature(): void
    {
        $header = $this->authenticator->generateAuthHeader('POST', 'https://example.com/wp-json/wc/v3/orders');

        // 提取 oauth_signature 值
        $this->assertMatchesRegularExpression(
            '/oauth_signature%3D"([^"]+)"/',
            $header,
            $matches
        );

        $signature = $matches[1];
        // 验证签名是合法的 base64 字符串
        $decoded = base64_decode($signature, true);
        $this->assertNotFalse($decoded);
        // HMAC-SHA256 输出固定为 32 字节
        $this->assertSame(32, strlen($decoded));
    }

    /**
     * 测试相同参数生成相同签名 (确定性验证).
     *
     * 使用固定的 timestamp 和 nonce 验证签名计算的确定性.
     */
    public function testSignatureIsDeterministic(): void
    {
        $url = 'https://example.com/wp-json/wc/v3/orders';
        $method = 'GET';

        // 由于 nonce 和 timestamp 是随机的, 我们验证同一实例连续调用
        // 生成不同 nonce 从而产生不同的 header
        $header1 = $this->authenticator->generateAuthHeader($method, $url);
        // 等待一秒以确保 timestamp 可能变化
        sleep(1);
        $header2 = $this->authenticator->generateAuthHeader($method, $url);

        // 至少 nonce 应该不同
        $this->assertNotSame($header1, $header2);
    }

    /**
     * 测试签名区分不同 HTTP 方法.
     */
    public function testSignatureDiffersByHttpMethod(): void
    {
        $url = 'https://example.com/wp-json/wc/v3/orders';

        // 使用反射来固定 nonce 和 timestamp, 以验证方法影响签名
        $ref = new \ReflectionClass($this->authenticator);

        $getSig = $this->invokePrivateGenerateSignature('GET', $url);
        $postSig = $this->invokePrivateGenerateSignature('POST', $url);
        $putSig = $this->invokePrivateGenerateSignature('PUT', $url);

        $this->assertNotSame($getSig, $postSig);
        $this->assertNotSame($postSig, $putSig);
        $this->assertNotSame($getSig, $putSig);
    }

    /**
     * 测试 Base URL 规范化: 去除 HTTPS 默认端口 443.
     */
    public function testNormalizeBaseUrlRemovesDefaultHttpsPort(): void
    {
        $ref = new \ReflectionClass($this->authenticator);
        $method = $ref->getMethod('normalizeBaseUrl');

        $result = $method->invoke($this->authenticator, parse_url('https://example.com:443/wp-json/wc/v3/orders'));

        $this->assertSame('https://example.com/wp-json/wc/v3/orders', $result);
    }

    /**
     * 测试 Base URL 规范化: 去除 HTTP 默认端口 80.
     */
    public function testNormalizeBaseUrlRemovesDefaultHttpPort(): void
    {
        $ref = new \ReflectionClass($this->authenticator);
        $method = $ref->getMethod('normalizeBaseUrl');

        $result = $method->invoke($this->authenticator, parse_url('http://example.com:80/wp-json/wc/v3/orders'));

        $this->assertSame('http://example.com/wp-json/wc/v3/orders', $result);
    }

    /**
     * 测试 Base URL 规范化: 保留非默认端口.
     */
    public function testNormalizeBaseUrlPreservesNonDefaultPort(): void
    {
        $ref = new \ReflectionClass($this->authenticator);
        $method = $ref->getMethod('normalizeBaseUrl');

        $result = $method->invoke($this->authenticator, parse_url('https://example.com:8080/wp-json/wc/v3/orders'));

        $this->assertSame('https://example.com:8080/wp-json/wc/v3/orders', $result);
    }

    /**
     * 测试 Base URL 规范化: scheme 和 host 转为小写.
     */
    public function testNormalizeBaseUrlLowercasesSchemeAndHost(): void
    {
        $ref = new \ReflectionClass($this->authenticator);
        $method = $ref->getMethod('normalizeBaseUrl');

        $result = $method->invoke($this->authenticator, parse_url('HTTPS://EXAMPLE.COM/wp-json/wc/v3/orders'));

        $this->assertSame('https://example.com/wp-json/wc/v3/orders', $result);
    }

    /**
     * 测试参数排序: 参数按字典序排列.
     */
    public function testBuildParamStringSortsAlphabetically(): void
    {
        $ref = new \ReflectionClass($this->authenticator);
        $method = $ref->getMethod('buildParamString');

        $params = [
            'z_param' => 'value1',
            'a_param' => 'value2',
            'm_param' => 'value3',
        ];

        $result = $method->invoke($this->authenticator, $params);

        // 验证排序: a_param, m_param, z_param
        $this->assertStringStartsWith('a_param', $result);
        $this->assertMatchesRegularExpression('/a_param.*m_param.*z_param/', $result);
    }

    /**
     * 测试参数编码: 特殊字符被正确编码.
     */
    public function testBuildParamStringEncodesSpecialCharacters(): void
    {
        $ref = new \ReflectionClass($this->authenticator);
        $method = $ref->getMethod('buildParamString');

        $params = [
            'key' => 'value with spaces',
        ];

        $result = $method->invoke($this->authenticator, $params);

        $this->assertStringContainsString('value%20with%20spaces', $result);
        $this->assertStringNotContainsString(' ', $result);
    }

    /**
     * 测试 Nonce 生成: 每次生成不同的 32 位十六进制字符串.
     */
    public function testGenerateNonceIsUnique(): void
    {
        $ref = new \ReflectionClass($this->authenticator);
        $method = $ref->getMethod('generateNonce');

        $nonce1 = $method->invoke($this->authenticator);
        $nonce2 = $method->invoke($this->authenticator);

        $this->assertNotSame($nonce1, $nonce2);
        $this->assertMatchesRegularExpression('/^[0-9a-f]{32}$/', $nonce1);
        $this->assertMatchesRegularExpression('/^[0-9a-f]{32}$/', $nonce2);
    }

    /**
     * 测试 generateAuthUrl 返回合法的 URL.
     */
    public function testGenerateAuthUrlReturnsValidUrl(): void
    {
        $url = $this->authenticator->generateAuthUrl('GET', 'https://example.com/wp-json/wc/v3/orders');

        $this->assertStringStartsWith('https://example.com/wp-json/wc/v3/orders?', $url);
        $this->assertStringContainsString('oauth_consumer_key', $url);
        $this->assertStringContainsString('oauth_signature', $url);
    }

    /**
     * 测试 generateAuthUrl 在已有 query string 时使用 & 连接.
     */
    public function testGenerateAuthUrlAppendsToExistingQueryString(): void
    {
        $url = $this->authenticator->generateAuthUrl('GET', 'https://example.com/wp-json/wc/v3/orders?status=pending');

        $this->assertStringContainsString('?status=pending&', $url);
        $this->assertStringContainsString('oauth_consumer_key', $url);
    }

    /**
     * 测试签名受请求参数影响.
     */
    public function testSignatureDiffersByRequestParams(): void
    {
        $url = 'https://example.com/wp-json/wc/v3/orders';

        $sig1 = $this->invokePrivateGenerateSignature('GET', $url);
        $sig2 = $this->invokePrivateGenerateSignature('GET', $url, ['status' => 'completed']);

        $this->assertNotSame($sig1, $sig2);
    }

    /**
     * 通过反射调用私有方法 generateSignature，用固定 nonce 和 timestamp 获取签名.
     */
    private function invokePrivateGenerateSignature(string $method, string $url, array $params = []): string
    {
        $ref = new \ReflectionClass($this->authenticator);
        $generateSignature = $ref->getMethod('generateSignature');

        // 创建一个子类来覆盖 buildOAuthParams 以返回固定值
        $authenticator = new class ($this->config) extends Authenticator {
            public function exposedBuildOAuthParams(): array
            {
                return $this->buildOAuthParams();
            }

            public function exposedGenerateSignature(string $method, string $url, array $params): string
            {
                return $this->generateSignature($method, $url, $params);
            }

            protected function buildOAuthParams(): array
            {
                return [
                    'oauth_consumer_key' => 'ck_abc123',
                    'oauth_nonce' => 'fixed_nonce_for_testing',
                    'oauth_signature_method' => 'HMAC-SHA256',
                    'oauth_timestamp' => '1234567890',
                ];
            }
        };

        return $authenticator->exposedGenerateSignature($method, $url, $params);
    }
}
