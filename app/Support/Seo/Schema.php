<?php

namespace App\Support\Seo;

class Schema
{
    public static function organization(): array
    {
        return [
            "@context" => "https://schema.org",
            "@type" => "Organization",
            "name" => config('app.name'),
            "url" => config('app.url'),
            "logo" => asset('media/logo.png'),
        ];
    }

    public static function website(): array
    {
        return [
            "@context" => "https://schema.org",
            "@type" => "WebSite",
            "name" => config('app.name'),
            "url" => config('app.url'),
        ];
    }
}