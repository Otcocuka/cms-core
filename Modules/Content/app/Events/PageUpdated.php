<?php

namespace Modules\Content\Events;

use App\Events\BaseEvent;
use Modules\Content\Models\Page;

class PageUpdated extends BaseEvent
{
    public Page $page;
    public array $changes;

    public function __construct(Page $page, array $changes = [])
    {
        $this->page = $page;
        $this->changes = $changes;

        parent::__construct([
            'page_id' => $page->id,
            'title' => $page->title,
            'slug' => $page->slug,
            'status' => $page->status,
            'changes' => $changes,
        ]);
    }

    public function getEventName(): string
    {
        return 'page.updated';
    }
}
