<?php

namespace SiteMapLib\SitemapGenerator\Formatters;

use SiteMapLib\SitemapGenerator\Exceptions\{
    InvalidDataException,
    FileWriteException,
    FormatterException
};

class CsvFormatter implements SitemapFormatterInterface
{

    use ValidatesSitemapFields;

    public function format(array $urls): string
    {
        try {
            $output = fopen('php://temp', 'r+');
            
            
            fputcsv($output, ['loc', 'lastmod', 'priority', 'changefreq'], ';');
            
            
            foreach ($urls as $url) {
                
                $this->validateUrl($url);
                
                fputcsv($output, [
                    $url['loc'],
                    $url['lastmod'] ?? '',
                    $url['priority'] ?? '0.8',
                    $url['changefreq'] ?? 'monthly'
                ], ';');
            }
            
            rewind($output);
            return stream_get_contents($output);
        }catch (InvalidDataException $e) {
            throw $e; 
        } catch (\Throwable $e) {
            throw new FormatterException($e->getMessage());
        } finally {
            if (isset($output) && is_resource($output)) {
                fclose($output);
            }
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