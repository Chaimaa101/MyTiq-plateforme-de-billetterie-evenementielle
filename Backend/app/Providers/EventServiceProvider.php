<?php

namespace App\Providers;

use App\Events\NewsletterSubscribed;
use App\Events\TicketCreated;
use App\Events\UserRegistered;
use App\Listeners\SendWelcomeEmail;
use App\Listeners\UpdateEventCapacity;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
    UserRegistered::class => [
        SendWelcomeEmail::class,
    ],
    NewsletterSubscribed::class => [
        NewsletterSubscribed::class,
    ],
    TicketCreated::class => [
        UpdateEventCapacity::class,
    ],
];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
