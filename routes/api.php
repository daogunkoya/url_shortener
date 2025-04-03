<?php
// routes/api.php
use App\Http\Controllers\UrlController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('/encode', [UrlController::class, 'encode']);
    Route::post('/decode', [UrlController::class, 'decode']);
});