<?php


namespace SiteMapLib\SitemapGenerator\Exceptions;

class InvalidFormatException extends SitemapException
{
    public function __construct(string $format)
    {
        parent::__construct("Unsupported format: {$format}");
    }
}