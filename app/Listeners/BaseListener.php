<?php

namespace App\Listeners;

use App\Events\BaseEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

abstract class BaseListener implements ShouldQueue
{
    /**
     * Количество попыток выполнения
     */
    public int $tries = 3;

    /**
     * Таймаут выполнения (секунды)
     */
    public int $timeout = 60;

    /**
     * Обработать событие
     */
    abstract public function handle(BaseEvent $event): void;

    /**
     * Обработка ошибки
     */
    public function failed(BaseEvent $event, \Throwable $exception): void
    {
        Log::error(sprintf(
            '[%s] Failed to handle event: %s',
            class_basename($this),
            $event->getEventName()
        ), [
            'event' => $event->toArray(),
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
        ]);
    }
}
