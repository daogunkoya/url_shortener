<?php

// app/Http/Controllers/UrlController.php
namespace App\Http\Controllers;

use App\Http\Requests\DecodeUrlRequest;
use App\Http\Requests\EncodeUrlRequest;
use App\Http\Resources\UrlResource;
use App\Services\UrlShortenerService;

class UrlController extends Controller
{
    public function __construct(
        protected UrlShortenerService $urlService
    ) {}

    public function encode(EncodeUrlRequest $request): UrlResource
    {
        return new UrlResource(
            $this->urlService->encodeUrl($request->validated('url'))
        );
    }

    public function decode(DecodeUrlRequest $request): UrlResource
    {
        return new UrlResource(
            $this->urlService->decodeUrl(
                basename($request->validated('short_url'))
            )
        );
    }
}
