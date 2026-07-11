<?php

namespace App\Support\Seo;

class Seo
{
    protected string $title = '';

    protected string $description = '';

    protected string $image = '';

    protected string $url = '';

    protected string $type = 'website';

    protected bool $index = true;

    protected array $schemas = [];

    public static function make(): static
    {
        return new static();
    }

    public function title(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function description(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function image(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function url(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function type(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function noIndex(): static
    {
        $this->index = false;

        return $this;
    }

    public function schema(array $schema): static
    {
        $this->schemas[] = $schema;

        return $this;
    }

    public function build(): SeoData
    {
        return new SeoData(
            title: $this->title ?: config('seo.title'),
            description: $this->description ?: config('seo.description'),
            url: $this->url ?: url()->current(),
            image: asset(
                $this->image ?: config('seo.image')
            ),
            type: $this->type,
            index: $this->index,
            schemas: $this->schemas
        );
    }
}