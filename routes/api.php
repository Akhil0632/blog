<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('posts')->group(function () {
    Route::get('/', [PostController::class, 'index'])->name('api.posts.index');
    Route::get('/{id}', [PostController::class, 'show'])->name('api.posts.show')->where('id', '[0-9]+');
});

Route::get('/users/{userId}/posts', [PostController::class, 'getUserPosts'])->name('api.users.posts')->where('userId', '[0-9]+');

Route::get('/api-docs', function () {
    return view('api-docs');
})->name('api.docs');

Route::fallback(function () {
    return response()->json([
        'success' => false,
        'message' => 'API endpoint not found',
        'error' => 'The requested API endpoint does not exist'
    ], 404);
});