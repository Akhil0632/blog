<?php

namespace App\Providers;

use App\Models\BlogPost;
use App\Policies\BlogPostPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        BlogPost::class => BlogPostPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}