<?php

namespace Backpack\Generators;

use Illuminate\Support\ServiceProvider;

class GeneratorsServiceProvider extends ServiceProvider
{
    protected $commands = [
        'Backpack\Generators\Console\Commands\ModelBackpackCommand',
        'Backpack\Generators\Console\Commands\RequestBackpackCommand',
        'Backpack\Generators\Console\Commands\ViewBackpackCommand',
        'Backpack\Generators\Console\Commands\ConfigBackpackCommand',
        // Backpack\CRUD files:
        'Backpack\Generators\Console\Commands\CrudModelBackpackCommand',
        'Backpack\Generators\Console\Commands\CrudControllerBackpackCommand',
        'Backpack\Generators\Console\Commands\CrudRequestBackpackCommand',
        'Backpack\Generators\Console\Commands\CrudBackpackCommand',
    ];

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands($this->commands);
    }
}
