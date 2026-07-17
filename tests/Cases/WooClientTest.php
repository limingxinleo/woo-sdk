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

namespace HyperfTest\Cases;

use Woo\Config\Config;
use Woo\WooClient;

/**
 * @internal
 * @covers \Woo\WooClient
 */
class WooClientTest extends AbstractTestCase
{
    private Config $config;

    private WooClient $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->config = new Config(
            url: 'https://example.com',
            key: 'ck_abc123',
            secret: 'cs_xyz789',
        );

        $this->client = new WooClient($this->config);
    }

    /**
     * 测试 WooClient 持有 Config 和 Authenticator.
     */
    public function testClientHasConfigAndAuth(): void
    {
        $this->assertSame($this->config, $this->client->config);
        $this->assertNotNull($this->client->auth);
    }

    /**
     * 测试 buildAuthHeader 返回合法的 OAuth header.
     */
    public function testBuildAuthHeader(): void
    {
        $header = $this->client->buildAuthHeader('GET', '/wp-json/wc/v3/orders');

        $this->assertStringStartsWith('OAuth ', $header);
        $this->assertStringContainsString('oauth_consumer_key', $header);
        $this->assertStringContainsString('oauth_signature', $header);
    }

    /**
     * 测试 buildAuthUrl 返回合法的带签名 URL.
     */
    public function testBuildAuthUrl(): void
    {
        $url = $this->client->buildAuthUrl('GET', '/wp-json/wc/v3/orders');

        $this->assertStringStartsWith('https://example.com/wp-json/wc/v3/orders?', $url);
        $this->assertStringContainsString('oauth_consumer_key', $url);
        $this->assertStringContainsString('oauth_signature', $url);
    }

    /**
     * 测试 buildAuthUrl 正确处理带尾部斜杠的 store URL.
     */
    public function testBuildAuthUrlWithTrailingSlash(): void
    {
        $config = new Config(
            url: 'https://example.com/',
            key: 'ck_abc123',
            secret: 'cs_xyz789',
        );
        $client = new WooClient($config);

        $url = $client->buildAuthUrl('GET', '/wp-json/wc/v3/orders');

        // 不应出现双斜杠
        $this->assertStringStartsWith('https://example.com/wp-json/wc/v3/orders?', $url);
        $this->assertStringNotContainsString('//wp-json', $url);
    }

    /**
     * 测试 buildAuthHeader 中 store URL 拼接正确.
     */
    public function testBuildAuthHeaderWithPathConcatenation(): void
    {
        $config = new Config(
            url: 'https://example.com/store',
            key: 'ck_abc123',
            secret: 'cs_xyz789',
        );
        $client = new WooClient($config);

        $header = $this->client->buildAuthHeader('GET', '/wp-json/wc/v3/orders');

        $this->assertStringStartsWith('OAuth ', $header);
        $this->assertStringContainsString('oauth_consumer_key', $header);
    }
}
