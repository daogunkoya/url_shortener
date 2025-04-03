<?php

// app/Services/UrlShortenerService.php
namespace App\Services;

use App\DTOs\UrlDTO;
use App\Models\Url;
use App\Exceptions\UrlShortenerException;
use Illuminate\Support\Str;

class UrlShortenerService
{
    public function encodeUrl(string $originalUrl): UrlDTO
    {
        try {
            $url = Url::firstOrCreate(
                ['original_url' => $originalUrl],
                ['short_code' => $this->generateShortCode()]
            );
            
            return UrlDTO::fromModel($url); // Return DTO instead of Model
        } catch (\Exception $e) {
            throw new UrlShortenerException("Failed to encode URL: " . $e->getMessage());
        }
    }

    public function decodeUrl(string $shortCode): UrlDTO
    {
        $url = Url::where('short_code', $shortCode)->first();

        if (!$url) {
            throw new UrlShortenerException("Short URL not found", 404);
        }

        return UrlDTO::fromModel($url); // Return DTO instead of Model
    }

    protected function generateShortCode(): string
    {
        return Str::random(6);
    }
}