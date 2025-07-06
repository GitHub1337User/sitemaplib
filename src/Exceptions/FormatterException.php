<?php


namespace SiteMapLib\SitemapGenerator\Exceptions;

class FormatterException extends SitemapException
{
    public function __construct(string $message)
    {
        parent::__construct("Formatter error: {$message}");
    }
}