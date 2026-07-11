<?php

namespace App\Support\Seo;

class SeoData
{
    public function __construct(
        public string $title,
        public string $description,
        public string $url,
        public string $image,
        public string $type = 'website',
        public bool $index = true,
        public array $schemas = [],
    ) {}
}