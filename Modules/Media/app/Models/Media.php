<?php

namespace Modules\Media\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Modules\Media\Events\MediaCreated;
use Modules\Media\Events\MediaDeleted;

class Media extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'description',
        'custom_properties',
    ];

    protected $casts = [
        'custom_properties' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($media) {
            event(new MediaCreated($media));
        });

        static::deleted(function ($media) {
            event(new MediaDeleted($media->id));
        });
    }

    /**
     * Создать медиа из файла
     */
    public static function createFromRequest($file, $name = null)
    {
        $media = new static();
        $media->name = $name ?? $file->getClientOriginalName();
        $media->description = '';
        $media->save();

        $media->addMedia($file)->toMediaCollection('default');

        return $media;
    }

    /**
     * Получить путь к изображению
     */
    public function getPublicPath()
    {
        $media = $this->getFirstMedia('default');
        return $media ? $media->getUrl() : null;
    }
}
