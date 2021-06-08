<?php

namespace Pixelvide\UrlShortener\Tests;

use Pixelvide\UrlShortener\AwsShortUrl;
use Pixelvide\UrlShortener\Url;
use Pixelvide\UrlShortener\Test\TestCase;

class AwsShortUrlTest extends TestCase
{
    /**
     * Test when provided URl is correct.
     *
     * @return void
     * @throws \Exception
     */
    public function testWhenUrlIsCorrect_ReturnString()
    {
        $url = 'https://www.pixelvide.com';
        $awsShortUrl = new AwsShortUrl($url);
        $url = new Url;
        $shortUrl = $url->shorten($awsShortUrl);
        $this->assertIsString($shortUrl);
    }

    /**
     * Test when provided URl is incorrect.
     *
     * @return void
     * @throws \Exception
     */
    public function testWhenUrlIsIncorrect_ThrowException()
    {
        $this->expectException(\Exception::class);
        $url = 'abcd';
        $awsShortUrl = new AwsShortUrl($url);
        $url = new Url;
        $url->shorten($awsShortUrl);
    }

    /**
     * Test when provided URl is doesnt have http/https.
     *
     * @return void
     * @throws \Exception
     */
    public function testWhenUrlDoesntHaveHttpHttps_ThrowException()
    {
        $this->expectException(\Exception::class);
        $url = 'www.pixelvide.com';
        $awsShortUrl = new AwsShortUrl($url);
        $url = new Url;
        $url->shorten($awsShortUrl);
    }
}