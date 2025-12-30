<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Documentation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .api-endpoint {
            background-color: white;
            border-left: 4px solid #0d6efd;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .method-get {
            border-left-color: #28a745;
        }
        .method-post {
            border-left-color: #fd7e14;
        }
        .method-put {
            border-left-color: #17a2b8;
        }
        .method-delete {
            border-left-color: #dc3545;
        }
        .badge-method {
            font-size: 0.8em;
            padding: 4px 8px;
        }
        pre {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 4px;
            overflow-x: auto;
        }
        .code-block {
            position: relative;
        }
        .copy-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            opacity: 0.7;
            transition: opacity 0.3s;
        }
        .copy-btn:hover {
            opacity: 1;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h1 class="h3 mb-0"><i class="fas fa-code me-2"></i>Blog API Documentation</h1>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Base URL:</strong> <code>{{ url('/api') }}</code>
                        </div>

                        <h2 class="h4 mt-4 mb-3">Available Endpoints</h2>

                        <div class="api-endpoint method-get">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="mb-0">Get All Posts (with Pagination)</h5>
                                <span class="badge bg-success badge-method">GET</span>
                            </div>
                            <p class="text-muted mb-2">Retrieve all blog posts with pagination support.</p>
                            <p class="mb-2"><strong>Endpoint:</strong> <code>/api/posts</code></p>
                            <p class="mb-2"><strong>Query Parameters:</strong></p>
                            <ul class="mb-2">
                                <li><code>page</code> (optional) - Page number (default: 1)</li>
                                <li><code>per_page</code> (optional) - Items per page (default: 15, max: 100)</li>
                            </ul>
                            <p class="mb-3"><strong>Authentication:</strong> Not required</p>
                            
                            <h6 class="mb-2">Example Request:</h6>
                            <div class="code-block mb-3">
                                <pre id="code1"># Get first page with 15 items per page (default)
                        curl -X GET "{{ url('/api/posts') }}" \
                            -H "Accept: application/json"

                        # Get second page with 10 items per page
                        curl -X GET "{{ url('/api/posts') }}?page=2&per_page=10" \
                            -H "Accept: application/json"</pre>
                                <button class="btn btn-sm btn-outline-secondary copy-btn" onclick="copyCode('code1')">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>

                            <h6 class="mb-2">Example Response with Pagination:</h6>
                            <div class="code-block">
                                <pre id="code2">{
                        "success": true,
                        "message": "Posts retrieved successfully",
                        "data": [...],
                        "meta": {
                            "current_page": 1,
                            "total": 45,
                            "per_page": 15,
                            "last_page": 3,
                            "from": 1,
                            "to": 15
                        },
                        "links": {
                            "first": "{{ url('/api/posts?page=1') }}",
                            "last": "{{ url('/api/posts?page=3') }}",
                            "prev": null,
                            "next": "{{ url('/api/posts?page=2') }}"
                        }
                        }</pre>
                                <button class="btn btn-sm btn-outline-secondary copy-btn" onclick="copyCode('code2')">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>

                            <h6 class="mb-2">Example Response:</h6>
                            <div class="code-block">
                                <pre id="code2">{
  "success": true,
  "message": "Posts retrieved successfully",
  "data": [
    {
      "id": 1,
      "title": "First Post",
      "content": "This is the content of the first post.",
      "author": {
        "id": 1,
        "name": "John Doe"
      },
      "created_at": "2024-01-15T10:30:00.000000Z",
      "updated_at": "2024-01-15T10:30:00.000000Z",
      "links": {
        "self": "{{ url('/api/posts/1') }}",
        "author_posts": "{{ url('/api/users/1/posts') }}"
      }
    }
  ],
  "meta": {
    "total": 1,
    "timestamp": "2024-01-15T10:30:00.000000Z"
  }
}</pre>
                                <button class="btn btn-sm btn-outline-secondary copy-btn" onclick="copyCode('code2')">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>

                        <div class="api-endpoint method-get">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="mb-0">Get Single Post</h5>
                                <span class="badge bg-success badge-method">GET</span>
                            </div>
                            <p class="text-muted mb-2">Retrieve a specific post by ID.</p>
                            <p class="mb-2"><strong>Endpoint:</strong> <code>/api/posts/{id}</code></p>
                            <p class="mb-2"><strong>Parameters:</strong> <code>id</code> (integer, required)</p>
                            <p class="mb-3"><strong>Authentication:</strong> Not required</p>
                            
                            <h6 class="mb-2">Example Request:</h6>
                            <div class="code-block mb-3">
                                <pre id="code3">curl -X GET "{{ url('/api/posts/1') }}" \
     -H "Accept: application/json"</pre>
                                <button class="btn btn-sm btn-outline-secondary copy-btn" onclick="copyCode('code3')">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>

                        <div class="api-endpoint method-get">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="mb-0">Get Posts by User</h5>
                                <span class="badge bg-success badge-method">GET</span>
                            </div>
                            <p class="text-muted mb-2">Retrieve all posts by a specific user.</p>
                            <p class="mb-2"><strong>Endpoint:</strong> <code>/api/users/{userId}/posts</code></p>
                            <p class="mb-2"><strong>Parameters:</strong> <code>userId</code> (integer, required)</p>
                            <p class="mb-3"><strong>Authentication:</strong> Not required</p>
                            
                            <h6 class="mb-2">Example Request:</h6>
                            <div class="code-block">
                                <pre id="code4">curl -X GET "{{ url('/api/users/1/posts') }}" \
     -H "Accept: application/json"</pre>
                                <button class="btn btn-sm btn-outline-secondary copy-btn" onclick="copyCode('code4')">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mt-5">
                            <h3 class="h4 mb-3">Test the API</h3>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">Get All Posts</h5>
                                            <a href="{{ url('/api/posts') }}" target="_blank" class="btn btn-primary">
                                                Test Endpoint <i class="fas fa-external-link-alt ms-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">Get Single Post</h5>
                                            <div class="input-group">
                                                <input type="number" id="postId" class="form-control" placeholder="Post ID" value="1" min="1">
                                                <button class="btn btn-primary" onclick="testSinglePost()">
                                                    Test <i class="fas fa-external-link-alt ms-1"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">Get User Posts</h5>
                                            <div class="input-group">
                                                <input type="number" id="userId" class="form-control" placeholder="User ID" value="1" min="1">
                                                <button class="btn btn-primary" onclick="testUserPosts()">
                                                    Test <i class="fas fa-external-link-alt ms-1"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">Test Pagination</h5>
                                            <div class="input-group mb-2">
                                                <span class="input-group-text">Page</span>
                                                <input type="number" id="pageNum" class="form-control" value="1" min="1">
                                                <span class="input-group-text">Per Page</span>
                                                <input type="number" id="perPage" class="form-control" value="5" min="1" max="100">
                                            </div>
                                            <button class="btn btn-primary" onclick="testPagination()">
                                                Test <i class="fas fa-external-link-alt ms-1"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5">
                            <h3 class="h4 mb-3">Response Format</h3>
                            <p>All API responses follow this standard format:</p>
                            <div class="code-block">
                                <pre id="code5">{
  "success": true|false,
  "message": "Descriptive message",
  "data": {}, // or [] for collections
  "meta": {}, // optional metadata
  "error": "Error message" // only present when success is false
}</pre>
                                <button class="btn btn-sm btn-outline-secondary copy-btn" onclick="copyCode('code5')">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="mt-5">
                            <h3 class="h4 mb-3">HTTP Status Codes</h3>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Code</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><span class="badge bg-success">200</span></td>
                                            <td>Success - Request completed successfully</td>
                                        </tr>
                                        <tr>
                                            <td><span class="badge bg-danger">404</span></td>
                                            <td>Not Found - The requested resource doesn't exist</td>
                                        </tr>
                                        <tr>
                                            <td><span class="badge bg-danger">500</span></td>
                                            <td>Server Error - Something went wrong on the server</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-muted text-center">
                        <p class="mb-0">API Version 1.0 | Last Updated: {{ date('Y-m-d') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyCode(elementId) {
            const codeElement = document.getElementById(elementId);
            const text = codeElement.textContent;
            
            navigator.clipboard.writeText(text).then(() => {
                const btn = codeElement.nextElementSibling;
                const originalHTML = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-check"></i>';
                btn.classList.remove('btn-outline-secondary');
                btn.classList.add('btn-success');
                
                setTimeout(() => {
                    btn.innerHTML = originalHTML;
                    btn.classList.remove('btn-success');
                    btn.classList.add('btn-outline-secondary');
                }, 2000);
            });
        }

        function testSinglePost() {
            const postId = document.getElementById('postId').value;
            if (postId && postId > 0) {
                window.open(`/api/posts/${postId}`, '_blank');
            }
        }

        function testUserPosts() {
            const userId = document.getElementById('userId').value;
            if (userId && userId > 0) {
                window.open(`/api/users/${userId}/posts`, '_blank');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('pre').forEach(pre => {
                pre.style.maxHeight = '400px';
                pre.style.overflowY = 'auto';
            });
        });

        function testPagination() {
            const page = document.getElementById('pageNum').value;
            const perPage = document.getElementById('perPage').value;
            
            if (page && perPage && page > 0 && perPage > 0) {
                window.open(`/api/posts?page=${page}&per_page=${perPage}`, '_blank');
            }
        }
    </script>
</body>
</html>