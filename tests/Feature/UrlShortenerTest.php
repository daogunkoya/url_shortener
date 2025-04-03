<?php

// tests/Feature/UrlShortenerTest.php
use App\Models\Url;
use Illuminate\Support\Facades\Cache;
use function Pest\Laravel\postJson;

describe('URL Shortener API', function () {
    beforeEach(function () {
        Url::truncate(); // Reset DB between tests
    });

    it('encodes a URL and returns DTO-mapped response', function () {
        $response = postJson('/api/v1/encode', [
            'url' => 'https://example.com'
        ]);

        $response
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'original_url',
                    'short_url',
                    'created_at'
                ]
            ])
            ->assertJsonMissing(['id', 'updated_at']) // Ensure DTO hides model fields
            ->assertJson([
                'data' => [
                    'original_url' => 'https://example.com',
                    'short_url' => url($response->json('data.short_url'))
                ]
            ]);
    });

    it('decodes a short URL to original', function () {
        // Create a URL directly since factories aren't set up
        $url = Url::create([
            'original_url' => 'https://example.com',
            'short_code' => 'abc123'
        ]);

        postJson('/api/v1/decode', [
            'short_url' => url('abc123')
        ])
            ->assertOk()
            ->assertJson([
                'data' => [
                    'original_url' => 'https://example.com',
                    'short_url' => url('abc123')
                ]
            ]);
    });

    it('rejects invalid URLs during encoding', function () {
        postJson('/api/v1/encode', ['url' => 'not-a-url'])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['url']);
    });

    it('returns 404 for non-existent short URLs', function () {
        postJson('/api/v1/decode', ['short_url' => url('invalid')])
            ->assertStatus(404)
            ->assertJson(['error' => 'Short URL not found']);
    });

    it('returns same short URL for duplicate original URLs', function () {
        $firstResponse = postJson('/api/v1/encode', ['url' => 'https://example.com']);
        $secondResponse = postJson('/api/v1/encode', ['url' => 'https://example.com']);

        expect($secondResponse->json('data.short_url'))
            ->toBe($firstResponse->json('data.short_url'));
    });

    // it('handles database errors gracefully', function () {
    //     // Mock the Url model to throw an exception
    //     $mock = $this->mock(Url::class, function ($mock) {
    //         $mock->shouldReceive('firstOrCreate')->andThrow(new \Exception('DB failure'));
    //     });
    //     app()->instance(Url::class, $mock);

    //     postJson('/api/v1/encode', ['url' => 'https://example.com'])
    //         ->assertStatus(400)
    //         ->assertJson(['error' => 'Failed to encode URL: DB failure']);
    // });
});