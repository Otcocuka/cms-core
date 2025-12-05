<?php

namespace Modules\Content\Listeners;

use App\Events\BaseEvent;
use App\Listeners\BaseListener;
use Illuminate\Support\Facades\Log;

class LogPageActivity extends BaseListener
{
    /**
     * Без очереди - логируем сразу
     */
    public bool $shouldQueue = false;

    public function handle(BaseEvent $event): void
    {
        $context = $event->toArray();

        Log::channel('stack')->info(
            sprintf('[Content] %s', $event->getEventName()),
            $context
        );
    }
}
