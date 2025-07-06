<?php

namespace SiteMapLib\SitemapGenerator\Exceptions;

class FileWriteException extends SitemapException
{
    public function __construct(string $filename)
    {
        parent::__construct("Failed to write sitemap file: {$filename}");
    }
}