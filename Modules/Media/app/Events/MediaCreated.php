<?php

namespace Modules\Media\Events;

use App\Events\BaseEvent;
use Modules\Media\Models\Media;

class MediaCreated extends BaseEvent
{
    public Media $media;

    public function __construct(Media $media)
    {
        $this->media = $media;

        parent::__construct([
            'media_id' => $media->id,
            'name' => $media->name,
            'file_name' => $media->file_name,
        ]);
    }

    public function getEventName(): string
    {
        return 'media.created';
    }
}
