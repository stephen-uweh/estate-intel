<?php

namespace App\Providers;

use App\Repositories\BookRepository;
use App\Repositories\Interfaces\BookRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */

    public function boot(){
        /**Register Observer Models **/

        # register the routes


    }
    public function register()
    {
        //
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );
        $this->app->bind(
            BookRepositoryInterface::class,
            BookRepository::class
        );

    }
}
