<?php


namespace SiteMapLib\SitemapGenerator\Formatters;

use SiteMapLib\SitemapGenerator\Exceptions\{
    InvalidDataException,
    FileWriteException,
    FormatterException
};

class JsonFormatter implements SitemapFormatterInterface
{
    use ValidatesSitemapFields;

    public function format(array $urls): string
    {
        try {
            foreach ($urls as $url) {
                $this->validateUrl($url);
            }

            return json_encode($urls, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);
        } catch (InvalidDataException $e) {
            throw $e;
        } catch (\JsonException $e) {
            throw new FormatterException('JSON encoding error: ' . $e->getMessage());
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
