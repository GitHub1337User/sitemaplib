<?php

namespace SiteMapLib\SitemapGenerator\Formatters;

interface SitemapFormatterInterface
{
    public function format(array $urls): string;
    public function save(string $content,string $filename): void;
}