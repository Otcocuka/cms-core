<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

abstract class BaseEvent
{
    use Dispatchable, SerializesModels;

    public array $payload;
    public Carbon $occurredAt;
    public ?int $userId;

    public function __construct(array $payload = [])
    {
        $this->payload = $payload;
        $this->occurredAt = Carbon::now();
        $this->userId = auth()->id();
    }

    /**
     * Название события для логирования
     */
    abstract public function getEventName(): string;

    /**
     * Данные события в читаемом формате
     */
    public function toArray(): array
    {
        return [
            'event' => $this->getEventName(),
            'payload' => $this->payload,
            'occurred_at' => $this->occurredAt->toIso8601String(),
            'user_id' => $this->userId,
        ];
    }

    /**
     * Должно ли событие логироваться
     */
    public function shouldLog(): bool
    {
        return true;
    }
}
