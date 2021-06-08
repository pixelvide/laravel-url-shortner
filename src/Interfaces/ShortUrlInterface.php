<?php

namespace Pixelvide\UrlShortener\Interfaces;

interface ShortUrlInterface
{
    /**
     * @return string
     * @throws \Exception
     */
    public function shorten(): string;
}