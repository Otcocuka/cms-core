<?php

namespace Modules\Content\Events;

use App\Events\BaseEvent;
use Modules\Content\Models\Page;

class PagePublished extends BaseEvent
{
    public Page $page;

    public function __construct(Page $page)
    {
        $this->page = $page;

        parent::__construct([
            'page_id' => $page->id,
            'title' => $page->title,
            'slug' => $page->slug,
            'published_at' => $page->published_at?->toIso8601String(),
        ]);
    }

    public function getEventName(): string
    {
        return 'page.published';
    }
}
