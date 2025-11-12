<?php

namespace App\Providers;

use App\Interfaces\Auth\LoginInterface;
use App\Interfaces\UserInterface;
use App\Services\Auth\LoginService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class InterfaceServiceProvider extends ServiceProvider
{

    /**
     * Binds interfaces to their implementations.
     * @var array<string, string>
     */
      public $bindings = [
        UserInterface::class => UserService::class,
        LoginInterface::class => LoginService::class
    ];

    /**
     * Register services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

    }
}
