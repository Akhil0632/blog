@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Dashboard - All Blog Posts</span>
                    <a href="{{ route('posts.create') }}" class="btn btn-primary btn-sm">Create New Post</a>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="text-center mb-4">
                        <h4>Welcome, {{ Auth::user()->name }}!</h4>
                        <p class="text-muted">View all blog posts below. You can only edit or delete your own posts.</p>
                    </div>

                    @if ($posts->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Author</th>
                                        <th>Created</th>
                                        <th>Updated</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($posts as $post)
                                        <tr>
                                            <td>
                                                <a href="{{ route('posts.show', $post) }}" class="text-decoration-none">
                                                    {{ $post->title }}
                                                </a>
                                            </td>
                                            <td>
                                                @if ($post->user_id == Auth::id())
                                                    <span class="badge bg-primary">You</span>
                                                @else
                                                    {{ $post->user->name }}
                                                @endif
                                            </td>
                                            <td>{{ $post->created_at->format('M d, Y') }}</td>
                                            <td>{{ $post->updated_at->format('M d, Y') }}</td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="{{ route('posts.show', $post) }}" class="btn btn-info">View</a>
                                                    
                                                    @if ($post->user_id == Auth::id())
                                                        <a href="{{ route('posts.edit', $post) }}" class="btn btn-warning">Edit</a>
                                                        <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger" 
                                                                    onclick="return confirm('Are you sure you want to delete this post?')">
                                                                Delete
                                                            </button>
                                                        </form>
                                                    @else
                                                        <button class="btn btn-warning" disabled title="You can only edit your own posts">Edit</button>
                                                        <button class="btn btn-danger" disabled title="You can only delete your own posts">Delete</button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        @if ($posts->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination mb-0">
                                        @if ($posts->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link">&laquo; Previous</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $posts->previousPageUrl() }}" rel="prev">&laquo; Previous</a>
                                            </li>
                                        @endif

                                        @php
                                            $currentPage = $posts->currentPage();
                                            $lastPage = $posts->lastPage();
                                            $startPage = max($currentPage - 2, 1);
                                            $endPage = min($currentPage + 2, $lastPage);
                                        @endphp

                                        @if ($startPage > 1)
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $posts->url(1) }}">1</a>
                                            </li>
                                            @if ($startPage > 2)
                                                <li class="page-item disabled">
                                                    <span class="page-link">...</span>
                                                </li>
                                            @endif
                                        @endif

                                        @for ($page = $startPage; $page <= $endPage; $page++)
                                            @if ($page == $currentPage)
                                                <li class="page-item active" aria-current="page">
                                                    <span class="page-link">{{ $page }}</span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $posts->url($page) }}">{{ $page }}</a>
                                                </li>
                                            @endif
                                        @endfor

                                        @if ($endPage < $lastPage)
                                            @if ($endPage < $lastPage - 1)
                                                <li class="page-item disabled">
                                                    <span class="page-link">...</span>
                                                </li>
                                            @endif
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $posts->url($lastPage) }}">{{ $lastPage }}</a>
                                            </li>
                                        @endif

                                        @if ($posts->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $posts->nextPageUrl() }}" rel="next">Next &raquo;</a>
                                            </li>
                                        @else
                                            <li class="page-item disabled">
                                                <span class="page-link">Next &raquo;</span>
                                            </li>
                                        @endif
                                    </ul>
                                </nav>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <h4>No posts yet</h4>
                            <p class="text-muted">Be the first to create a blog post!</p>
                            <a href="{{ route('posts.create') }}" class="btn btn-primary">Create Your First Post</a>
                        </div>
                    @endif

                    <div class="row mt-5">
                        <div class="col-md-6 mb-3">
                            <div class="card text-center h-100">
                                <div class="card-body">
                                    <h5 class="card-title">My Posts</h5>
                                    <p class="card-text">View and manage only your posts</p>
                                    <a href="{{ route('posts.index') }}" class="btn btn-primary">Go to My Posts</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card text-center h-100">
                                <div class="card-body">
                                    <h5 class="card-title">Profile</h5>
                                    <p class="card-text">Update your profile information</p>
                                    <a href="{{ route('profile') }}" class="btn btn-success">Edit Profile</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    @php
                        use App\Models\BlogPost;

                        $myPostsCount = Auth::user()->blogPosts()->count();
                        $totalPostsCount = BlogPost::count();
                    @endphp

                    <div class="mt-4">
                        <div class="card">
                            <div class="card-header">Statistics</div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-file-alt fa-2x text-primary"></i>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h5 class="mb-0">{{ $totalPostsCount }}</h5>
                                                <p class="text-muted mb-0">Total Posts</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-user fa-2x text-success"></i>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h5 class="mb-0">{{ $myPostsCount }}</h5>
                                                <p class="text-muted mb-0">My Posts</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .btn-group .btn {
        margin-right: 5px;
    }
    .btn-group .btn:last-child {
        margin-right: 0;
    }
    .table td {
        vertical-align: middle;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteForms = document.querySelectorAll('form[action*="posts"]');
        deleteForms.forEach(form => {
            const deleteButton = form.querySelector('button[type="submit"]');
            if (deleteButton) {
                deleteButton.addEventListener('click', function(e) {
                    if (!confirm('Are you sure you want to delete this post?')) {
                        e.preventDefault();
                    }
                });
            }
        });
    });
</script>
@endpush
@endsection