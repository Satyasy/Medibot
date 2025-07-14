<?php 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeminiController;

Route::post('/generate', [GeminiController::class, 'generate']);
Route::get('/test-api', function() {
    return response()->json([
        'status' => 'success',
        'message' => 'API connection test successful',
        'timestamp' => now()
    ]);
});