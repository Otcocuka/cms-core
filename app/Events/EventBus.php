<?php

namespace App\Events;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Event;

class EventBus
{
    /**
     * Отправить событие
     */
    public static function dispatch(BaseEvent $event): void
    {
        // Логируем событие если нужно
        if ($event->shouldLog()) {
            self::logEvent($event);
        }

        // Отправляем событие в Laravel Event Dispatcher
        Event::dispatch($event);
    }

    /**
     * Логирование события
     */
    protected static function logEvent(BaseEvent $event): void
    {
        $context = $event->toArray();

        Log::channel('stack')->info(
            sprintf('[EventBus] %s', $event->getEventName()),
            $context
        );
    }

    /**
     * Подписаться на событие
     */
    public static function listen(string $event, string|array $listeners): void
    {
        Event::listen($event, $listeners);
    }

    /**
     * Отписаться от события
     */
    public static function forget(string $event): void
    {
        Event::forget($event);
    }

    /**
     * Получить всех слушателей события
     */
    public static function getListeners(string $event): array
    {
        return Event::getListeners($event);
    }
}
