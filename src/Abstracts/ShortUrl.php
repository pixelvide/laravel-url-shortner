<?php

namespace Pixelvide\UrlShortener\Abstracts;

use Illuminate\Support\Str;
use Pixelvide\UrlShortener\Interfaces\ShortUrlInterface;

abstract class ShortUrl implements ShortUrlInterface
{
    /**
     * @var string URL to be shortened
     */
    protected $url;
    /**
     * @var int Max length of the hash
     */
    protected $maxHashLength;

    /**
     * ShortUrl constructor.
     *
     * @param  string  $url
     * @param  int  $maxHashLength
     */
    public function __construct(string $url, int $maxHashLength = 10)
    {
        $this->url           = $url;
        $this->maxHashLength = $maxHashLength;
    }

    /**
     * @return string
     */
    protected function hash(): string
    {
        return Str::random($this->maxHashLength);
    }

    /**
     * @return string
     */
    abstract function shorten(): string;
}