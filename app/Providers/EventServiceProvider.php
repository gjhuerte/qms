<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\CreateQueue' => [
            'App\Listeners\UpdateQueueList',
        ],

        'App\Events\AttendedQueue' => [
            'App\Listeners\UpdateQueueList',
        ],

        'App\Events\CallQueue' => [
            'App\Listeners\UpdateQueueList',
        ],

        // 'App\Events\Event' => [
        //     'App\Listeners\EventListener',
        // ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
