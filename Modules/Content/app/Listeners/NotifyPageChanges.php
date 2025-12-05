<?php

namespace Modules\Content\Listeners;

use App\Events\BaseEvent;
use App\Listeners\BaseListener;
use Illuminate\Support\Facades\Log;

class NotifyPageChanges extends BaseListener
{
    public function handle(BaseEvent $event): void
    {
        // TODO: Отправка уведомлений (email, Slack, etc.)
        // Пока просто логируем

        Log::info('[Notification] Page change detected', [
            'event' => $event->getEventName(),
            'data' => $event->toArray(),
        ]);

        // В будущем здесь:
        // - Mail::to($admins)->send(new PageChangedNotification($event->page));
        // - Slack::send("Page {$event->page->title} was updated");
        // - WebSocket::broadcast('page.changed', $event->toArray());
    }
}
