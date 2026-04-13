<?php

namespace App\Providers;

use App\Models\Task;
use App\Models\Category;
use App\Models\Tag;
use App\Policies\TaskPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\TagPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Task::class     => TaskPolicy::class,
        Category::class => CategoryPolicy::class,
        Tag::class      => TagPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
