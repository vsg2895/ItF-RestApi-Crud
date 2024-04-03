<?php

namespace App\Providers;

use App\Interfaces\PhoneBookInterface;
use App\Repositories\PhoneBookRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */

    private array $interfaces = [
        PhoneBookInterface::class => PhoneBookRepository::class,
    ];

    public function register(): void
    {
        foreach ($this->interfaces as $interface => $repository) {
            $this->app->singleton($interface, $repository);
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
