<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Blog App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h1 class="mb-4">Welcome to Laravel Blog Posting App</h1>
                @if (Route::has('login'))
                    <div class="d-flex justify-content-center gap-3">
                        @auth
                            <a href="{{ url('/home') }}" class="btn btn-primary">Go to Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-success">Register</a>
                            @endif
                        @endauth
                    </div>
                @endif
                
                <div class="mt-5">
                    <h4>Features:</h4>
                    <ul class="list-unstyled">
                        <li>✔ View all users' posts on dashboard</li>
                        <li>✔ Edit/delete only your own posts</li>
                        <li>✔ User Registration & Authentication</li>
                        <li>✔ Full CRUD for blog posts</li>
                        <li>✔ Profile Management</li>
                        <li>✔ RESTful JSON API endpoints</li>
                        <li>✔ Complete API documentation</li>
                    </ul>
                </div>

                <div class="mt-4">
                    <a href="{{ url('/api/posts') }}" class="btn btn-info me-2" target="_blank">
                        <i class="fas fa-code me-1"></i> Test API
                    </a>
                    <a href="{{ url('/api/api-docs') }}" class="btn btn-outline-info" target="_blank">
                        <i class="fas fa-book me-1"></i> API Documentation
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>