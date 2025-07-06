<?php

namespace SiteMapLib\SitemapGenerator;

use SiteMapLib\SitemapGenerator\Exceptions\{
    InvalidFormatException,
    SitemapException,
    FileWriteException
};
use SiteMapLib\SitemapGenerator\Formatters\{
    XmlFormatter,
    JsonFormatter,
    CsvFormatter,
    SitemapFormatterInterface
};

class SitemapGenerator
{
    public static function generate(
        array $urls,
        string $format = 'xml',
        // ?string $filename = 'sitemap',
        ?string $path = null,
        bool $useGzip = false
    ): void {
        try {
            $formatter = self::getFormatter($format);
            $content = $formatter->format($urls);

            $targetFile = $path ?? "sitemap.{$format}";
            $formatter->save($content, $targetFile);

            if ($useGzip) {
                self::compressFile($targetFile);
            }
        } catch (SitemapException $e) {
            throw $e;
        } catch (\Throwable $e) {
            throw new SitemapException(
                "Sitemap generation failed: " . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    private static function getFormatter(string $format): SitemapFormatterInterface
    {
        return match (strtolower($format)) {
            'xml' => new XmlFormatter(),
            'json' => new JsonFormatter(),
            'csv' => new CsvFormatter(),
            default => throw new InvalidFormatException($format),
        };
    }

    private static function compressFile(string $filename): void
    {
        if (!function_exists('gzencode')) {
            throw new \RuntimeException('Gzip compression is not available');
        }

        $content = file_get_contents($filename);
        if ($content === false) {
            throw new FileWriteException($filename);
        }

        $compressed = gzencode($content, 9);
        if (file_put_contents("{$filename}.gz", $compressed) === false) {
            throw new FileWriteException("{$filename}.gz");
        }
    }
}
