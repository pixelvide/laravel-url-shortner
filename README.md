## Pixelvide URL Shortener

This package allows us to shorter the url easily using multiple ways i.e.

[x] AWS Based Functionless URL Shortener

## Installation

require this package with composer:

```shell
composer require pixelvide/laravel-url-shortener
```

Add following keys in .env file

| key | value |
|-----|-------|
|SHORTENER_API_URL| apigateway url |

After installing URL Shortener, you can short urls

1. Using AWS Functionless URL Shortener.
```shell
$url = 'https://www.pixelvide.com';
$awsShortUrl = new \Pixelvide\UrlShortener\AwsShortUrl($url);
$url = new \Pixelvide\UrlShortener\Url;
$shortUrl = $url->shorten($awsShortUrl);
```