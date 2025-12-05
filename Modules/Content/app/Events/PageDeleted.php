<?php

namespace Modules\Content\Events;

use App\Events\BaseEvent;

class PageDeleted extends BaseEvent
{
    public int $pageId;
    public string $title;

    public function __construct(int $pageId, string $title)
    {
        $this->pageId = $pageId;
        $this->title = $title;

        parent::__construct([
            'page_id' => $pageId,
            'title' => $title,
        ]);
    }

    public function getEventName(): string
    {
        return 'page.deleted';
    }
}
