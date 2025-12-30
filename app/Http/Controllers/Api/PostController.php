<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        try {
            $posts = BlogPost::with('user:id,name')
                ->select('id', 'user_id', 'title', 'content', 'created_at', 'updated_at')
                ->latest()
                ->get();

            $formattedPosts = $posts->map(function ($post) {
                return [
                    'id' => $post->id,
                    'title' => $post->title,
                    'content' => $post->content,
                    'author' => [
                        'id' => $post->user->id,
                        'name' => $post->user->name,
                    ],
                    'created_at' => $post->created_at->toISOString(),
                    'updated_at' => $post->updated_at->toISOString(),
                    'links' => [
                        'self' => url("/api/posts/{$post->id}"),
                        'author_posts' => url("/api/users/{$post->user_id}/posts"),
                    ]
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Posts retrieved successfully',
                'data' => $formattedPosts,
                'meta' => [
                    'total' => $posts->count(),
                    'timestamp' => now()->toISOString(),
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve posts',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $post = BlogPost::with('user:id,name')
                ->select('id', 'user_id', 'title', 'content', 'created_at', 'updated_at')
                ->find($id);

            if (!$post) {
                return response()->json([
                    'success' => false,
                    'message' => 'Post not found',
                    'error' => 'No post found with ID ' . $id
                ], 404);
            }

            $formattedPost = [
                'id' => $post->id,
                'title' => $post->title,
                'content' => $post->content,
                'author' => [
                    'id' => $post->user->id,
                    'name' => $post->user->name,
                ],
                'created_at' => $post->created_at->toISOString(),
                'updated_at' => $post->updated_at->toISOString(),
                'links' => [
                    'all_posts' => url('/api/posts'),
                    'author_posts' => url("/api/users/{$post->user_id}/posts"),
                ]
            ];

            return response()->json([
                'success' => true,
                'message' => 'Post retrieved successfully',
                'data' => $formattedPost
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve post',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getUserPosts(Request $request, $userId)
    {
        try {
            $perPage = $request->get('per_page', 15);
            $page = $request->get('page', 1);
            
            $posts = BlogPost::with('user:id,name')
                ->select('id', 'user_id', 'title', 'content', 'created_at', 'updated_at')
                ->where('user_id', $userId)
                ->latest()
                ->paginate($perPage, ['*'], 'page', $page);

            if ($posts->isEmpty()) {
                return response()->json([
                    'success' => true,
                    'message' => 'No posts found for this user',
                    'data' => [],
                    'meta' => [
                        'user_id' => $userId,
                        'total' => 0,
                        'current_page' => $page,
                        'per_page' => $perPage,
                        'last_page' => 0
                    ]
                ], 200);
            }

            $formattedPosts = $posts->map(function ($post) {
                return [
                    'id' => $post->id,
                    'title' => $post->title,
                    'content' => $post->content,
                    'created_at' => $post->created_at->toISOString(),
                    'updated_at' => $post->updated_at->toISOString(),
                    'links' => [
                        'self' => url("/api/posts/{$post->id}"),
                        'author' => url("/api/users/{$post->user_id}"),
                    ]
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'User posts retrieved successfully',
                'data' => $formattedPosts,
                'meta' => [
                    'user_id' => $userId,
                    'total' => $posts->total(),
                    'current_page' => $posts->currentPage(),
                    'per_page' => $posts->perPage(),
                    'last_page' => $posts->lastPage(),
                    'from' => $posts->firstItem(),
                    'to' => $posts->lastItem(),
                    'user_name' => $posts->first()->user->name
                ],
                'links' => [
                    'first' => $posts->url(1),
                    'last' => $posts->url($posts->lastPage()),
                    'prev' => $posts->previousPageUrl(),
                    'next' => $posts->nextPageUrl(),
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve user posts',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
