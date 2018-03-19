<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\FriendCircle;
use App\Models\Favour;
use App\Models\Comment;
use App\Policies\FriendCirclePolicy;
use App\Policies\FavourPolicy;
use App\Policies\CommentPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        FriendCircle::class => FriendCirclePolicy::class,
        Favour::class => FavourPolicy::class,
        Comment::class => CommentPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
