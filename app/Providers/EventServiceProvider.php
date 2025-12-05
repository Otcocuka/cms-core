<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Карта событий и их слушателей
     */
    protected $listen = [
        // Здесь автоматически подключатся события из модулей
    ];

    /**
     * Регистрация любых событий для приложения
     */
    public function boot(): void
    {
        parent::boot();
    }

    /**
     * Определить должен ли провайдер автоматически находить события
     */
    public function shouldDiscoverEvents(): bool
    {
        return true;
    }

    /**
     * Получить директории для автоопределения событий
     */
    protected function discoverEventsWithin(): array
    {
        return [
            $this->app->path('Listeners'),
        ];
    }
}
