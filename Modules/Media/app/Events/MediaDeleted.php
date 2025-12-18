<?php

namespace Modules\Media\Events;

use App\Events\BaseEvent;

class MediaDeleted extends BaseEvent
{
    public int $mediaId;

    public function __construct(int $mediaId)
    {
        $this->mediaId = $mediaId;

        parent::__construct([
            'media_id' => $mediaId,
        ]);
    }

    public function getEventName(): string
    {
        return 'media.deleted';
    }
}
