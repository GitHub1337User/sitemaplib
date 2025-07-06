<?php

namespace SiteMapLib\SitemapGenerator\Exceptions;

class InvalidDataException extends SitemapException
{
    public function __construct(
        string $field,
        $value,
        string $message = ''
    ) {
        $valueStr = is_scalar($value) ? $value : gettype($value);
        $defaultMessage = sprintf(
            'Invalid sitemap data: field "%s" contains invalid value "%s"',
            $field,
            $valueStr
        );
        
        parent::__construct($message ? "$defaultMessage ($message)" : $defaultMessage);
    }
}