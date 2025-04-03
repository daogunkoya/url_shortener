<?php

// app/DTOs/UrlDTO.php
namespace App\DTOs;

use App\Models\Url;

class UrlDTO
{
    public function __construct(
        public string $originalUrl,
        public string $shortCode,
        public ?string $createdAt = null
    ) {}

    // Optional: Create from Model
    public static function fromModel(Url $url): self
    {
        return new self(
            originalUrl: $url->original_url,
            shortCode: $url->short_code,
            createdAt: $url->created_at?->toIso8601String()
        );
    }
}