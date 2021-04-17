<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\PublishRepositoryInterface; 
use App\Repositories\TweetRepository; 

class RepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(PublishRepositoryInterface::class,TweetRepository::class);
    }
}
