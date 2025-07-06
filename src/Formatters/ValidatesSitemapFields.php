<?php

namespace SiteMapLib\SitemapGenerator\Formatters;

use SiteMapLib\SitemapGenerator\Exceptions\InvalidDataException;
use DateTimeInterface;

trait ValidatesSitemapFields
{
    /**
     * @throws InvalidDataException
     */
    protected function validateUrl(array $url): void
    {
        // Обязательное поле 'loc'
        if (empty($url['loc'])) {
            throw new InvalidDataException('loc', $url['loc'] ?? null, 'URL is required');
        }

        // Валидация URL
        if (!filter_var($url['loc'], FILTER_VALIDATE_URL)) {
            throw new InvalidDataException('loc', $url['loc'], 'Must be a valid URL');
        }

        // Валидация lastmod
        if (isset($url['lastmod']) && !$this->isValidDate($url['lastmod']) || empty($url['lastmod'])) {
            throw new InvalidDataException('lastmod', $url['lastmod'], 'Must be a valid date (YYYY-MM-DD)');
        }

        // Обязательное поле 'priority'
        if (empty($url['priority'])) {
            throw new InvalidDataException('priority', $url['priority'] ?? null, 'Priority is required');
        }

        // Валидация priority (если указан)
        if (isset($url['priority'])) {
            if (!is_numeric($url['priority'])) {
                throw new InvalidDataException('priority', $url['priority'], 'Must be a number');
            }
            if ($url['priority'] < 0 || $url['priority'] > 1) {
                throw new InvalidDataException('priority', $url['priority'], 'Must be between 0.0 and 1.0');
            }
        }

        // Обязательное поле 'changefreq'
        if (empty($url['changefreq'])) {
            throw new InvalidDataException('changefreq', $url['changefreq'] ?? null, 'Changefreq is required');
        }

        // Валидация changefreq (если указан)
        if (isset($url['changefreq'])) {
            $validFrequencies = ['always', 'hourly', 'daily', 'weekly', 'monthly', 'yearly', 'never'];
            if (!in_array(strtolower($url['changefreq']), $validFrequencies)) {
                throw new InvalidDataException('changefreq', $url['changefreq'], 'Invalid frequency value');
            }
        }
    }

    private function isValidDate($date): bool
    {
        if ($date instanceof DateTimeInterface) {
            return true;
        }

        return (bool)strtotime($date);
    }

    private function formatDate($date): string
    {
        if ($date instanceof DateTimeInterface) {
            return $date->format('Y-m-d');
        }

        return date('Y-m-d', strtotime($date));
    }
}
