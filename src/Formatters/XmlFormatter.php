<?php

namespace SiteMapLib\SitemapGenerator\Formatters;

use SiteMapLib\SitemapGenerator\Exceptions\{
    FileWriteException,
    FormatterException,
    InvalidDataException
};

class XmlFormatter implements SitemapFormatterInterface
{
    use ValidatesSitemapFields;

    public function format(array $urls): string
    {
        try {
            $xml = '<?xml version="1.0" encoding="UTF-8"?>';
            $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

            foreach ($urls as $url) {
                $this->validateUrl($url); 
                
                $xml .= '<url>';
                $xml .= '<loc>' . htmlspecialchars($url['loc']) . '</loc>';

                if (!empty($url['lastmod'])) {
                    $xml .= '<lastmod>' . $this->formatDate($url['lastmod']) . '</lastmod>';
                }

                $xml .= '<changefreq>' . ($url['changefreq'] ?? 'monthly') . '</changefreq>';
                $xml .= '<priority>' . ($url['priority'] ?? '0.8') . '</priority>';
                $xml .= '</url>';
            }

            return $xml . '</urlset>';
        } catch (InvalidDataException $e) {
            throw $e; 
        } catch (\Throwable $e) {
            throw new FormatterException('XML generation error: ' . $e->getMessage());
        }
    }
    
    public function save(string $content, string $filepath): void
    {
        $directory = dirname($filepath);
        
        // Создаем директорию, если её нет
        if (!is_dir($directory) && !mkdir($directory, 0755, true)) {
            throw new FileWriteException("Cannot create directory: {$directory}");
        }
        
        if (file_put_contents($filepath, $content) === false) {
            throw new FileWriteException($filepath);
        }
    }
}