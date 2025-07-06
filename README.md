# Sitemap Generator for PHP 8+

PHP библиотека для генерации sitemap (карты сайта) в различных форматах.

## Установка

Установка через Composer:

```bash
composer require sitemaplib/sitemap-generator
```
## Использование 
```php

require __DIR__ . '/vendor/autoload.php';

use SiteMapLib\SitemapGenerator\SitemapGenerator;
use SiteMapLib\SitemapGenerator\Exceptions\SitemapException;

$validPages = [
    [
        'loc' => 'https://example.com/',
        'lastmod' => '2024-01-01',
        'changefreq' => 'daily',
        'priority' => 1.0
    ],
    [
        'loc' => 'https://example.com/about',
        'lastmod' => '2023-12-15',
        'changefreq' => 'monthly',
        'priority' => 0.8
    ],
    [
        'loc' => 'https://example.com/contact',
        'lastmod' => '2024-01-10',
        'changefreq' => 'yearly',
        'priority' => 0.5
    ],
    [
        'loc' => 'https://example.com/blog/post-1',
        'lastmod' => '2024-02-20',
        'changefreq' => 'weekly',
        'priority' => 0.7
    ],
    [
        'loc' => 'https://example.com/blog/post-1',
        'lastmod' =>  '2024-02-20',
        'changefreq' => 'weekly',
        'priority' => 1
    ]
];

// Генерация CSV
SitemapGenerator::generate(
    urls: $validPages, // Массив данных
    format: 'csv', // Формат (Опционально)
    path: 'csv/test.csv', // Путь сохранения (формат и формат в имени файла должны совпадать) (Опционально)
    useGzip: true // Сжатие (по дефолту отключено) (Опционально)
);

// Генерация JSON
SitemapGenerator::generate(
    urls: $validPages, // Массив данных
    format: 'json', // Формат (Опционально)
    path: 'json/test.json', // Путь сохранения (формат и формат в имени файла должны совпадать) (Опционально)
    useGzip: true // Сжатие (по дефолту отключено) (Опционально)
);

// Генерация XML
SitemapGenerator::generate(
    urls: $validPages, // Массив данных 
    format: 'xml', // Формат (Опционально)
    path: 'xml/test.xml', // Путь сохранения (формат и формат в имени файла должны совпадать) (Опционально)
    useGzip: true // Сжатие (по дефолту отключено) (Опционально)
);


```

## Допустимые значения для changefreq:

always

hourly

daily

weekly

monthly

yearly

never

## Для priority:

1.0 - высший приоритет

0.5 - средний

0.1 - низкий

## Обработка ошибок

```php
try {
    SitemapGenerator::generate($invalidPages);
} catch (SitemapException $e) {
    echo 'Ошибка генерации sitemap: ' . $e->getMessage();
}
```

## Поддерживаемые форматы
XML 

JSON 

CSV 
