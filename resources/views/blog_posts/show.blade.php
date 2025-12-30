@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Post Details</span>
                    <div>
                        <a href="{{ route('posts.edit', $post) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </div>
                </div>

                <div class="card-body">
                    <h2 class="card-title">{{ $post->title }}</h2>
                    <p class="text-muted">
                        Posted by {{ $post->user->name }} on {{ $post->created_at->format('F d, Y \a\t h:i A') }}
                    </p>
                    <hr>
                    <div class="post-content">
                        {!! nl2br(e($post->content)) !!}
                    </div>
                    
                    <div class="mt-4">
                        <a href="{{ route('posts.index') }}" class="btn btn-secondary">Back to Posts</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection