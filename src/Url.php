<?php

namespace Pixelvide\UrlShortener;

use Pixelvide\UrlShortener\Interfaces\ShortUrlInterface;

class Url
{
    /**
     * @param  ShortUrlInterface  $shortUrl
     * @return string
     * @throws \Exception
     */
    public function shorten(ShortUrlInterface $shortUrl)
    {
        return $shortUrl->shorten();
    }
}