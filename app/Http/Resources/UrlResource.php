<?php

// app/Http/Resources/UrlResource.php
namespace App\Http\Resources;

use App\DTOs\UrlDTO;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UrlResource extends JsonResource
{
    public function __construct(UrlDTO $dto) 
    {
        parent::__construct($dto);
    }

    public function toArray(Request $request): array
    {
        /** @var UrlDTO $dto */
        $dto = $this->resource;
        
        return [
            'original_url' => $dto->originalUrl,
            'short_url' => url($dto->shortCode),
            'created_at' => $dto->createdAt, // Optional
        ];
    }
}
