

## Laravel URL Shortener API

A high-performance URL shortening service built with Laravel, implementing SOLID principles and DTO pattern.

## Features
- ✅  URL encoding/decoding with Base62 algorithm
- ✅ RESTful JSON API with proper HTTP status codes
- ✅ Data validation and exception handling
- ✅ Unit and feature tests with PestPHP
- ✅ DTO-based response formatting
- ✅ Database persistence with MySQL/PostgreSQL

## Requirements
- PHP 8.2+
- Laravel 12.x
- Composer 2.x
- MySQL 8.0+ or PostgreSQL 13+


## Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/yourusername/url-shortener.git
   cd url-shortener


   composer install


   cp .env.example .env
    php artisan key:generate   

    php artisan migrate


   ###  Encode a URL
POST /api/v1/encode     

Request:

{
  "url": "https://example.com/very/long/url"
}


### Success Response (200):

{
  "data": {
    "original_url": "https://example.com/very/long/url",
    "short_url": "http://yourdomain.com/abc123",
    "created_at": "2024-05-20T12:00:00Z"
  }
}

### Decode a Short URL

POST /api/v1/decode
Request
{
  "short_url": "http://yourdomain.com/abc123"
}


### Success Response (200):

{
  "data": {
    "original_url": "https://example.com/very/long/url",
    "short_url": "http://yourdomain.com/abc123"
  }
}


## Development Setup

### Running Tests

php artisan test

### Code Style Fixing
composer run lint
composer run fix

### Architecture
#### Core Components

- ✅ DTOs: app/DTOs/UrlDTO.php - Data transfer objects

- ✅ Services: app/Services/UrlShortenerService.php - Business logic

- ✅ Exceptions: app/Exceptions/UrlShortenerException.php - Custom exceptions

Resources: app/Http/Resources/UrlResource.php - API response formatting



### Deployment
#### Production Requirements

- ✅ Queue worker for async jobs

- ✅ Redis for caching

- ✅ Database backups

Deployment Steps
Configure production .env

Run migrations: