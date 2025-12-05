<?php

namespace Modules\Content\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Events\EventBus;
use Modules\Content\Events\PageCreated;
use Modules\Content\Events\PageUpdated;
use Modules\Content\Events\PageDeleted;
use Modules\Content\Events\PagePublished;

class Page extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'status',
        'published_at',
        // SEO (пока без миграции)
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_title',
        'og_description',
        'og_image',
        'featured_image',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        // ========================================
        // Автозаполнение published_at при создании
        // ========================================
        static::creating(function ($page) {
            // Если status = published но published_at пустой - ставим текущее время
            if ($page->status === 'published' && !$page->published_at) {
                $page->published_at = now();
            }
        });

        // ========================================
        // Автозаполнение published_at при обновлении
        // ========================================
        static::updating(function ($page) {
            // Если меняем status на published и published_at пустой - ставим текущее время
            if ($page->status === 'published' && !$page->published_at) {
                $page->published_at = now();
            }

            // Если меняем status с published на draft/archived - очищаем published_at
            if ($page->isDirty('status') && $page->status !== 'published' && $page->getOriginal('status') === 'published') {
                $page->published_at = null;
            }
        });

        // Событие создания
        static::created(function ($page) {
            EventBus::dispatch(new PageCreated($page));
        });

        // Событие обновления
        static::updated(function ($page) {
            $changes = $page->getChanges();

            EventBus::dispatch(new PageUpdated($page, $changes));

            // Проверяем изменение статуса на published
            if (isset($changes['status']) && $changes['status'] === 'published') {
                EventBus::dispatch(new PagePublished($page));
            }
        });

        // Событие удаления
        static::deleted(function ($page) {
            EventBus::dispatch(new PageDeleted($page->id, $page->title));
        });
    }

    /**
     * Scope для поиска
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
                ->orWhere('content', 'like', "%{$search}%")
                ->orWhere('slug', 'like', "%{$search}%");
        });
    }

    /**
     * Scope для опубликованных страниц
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    /**
     * Проверка: опубликована ли страница
     */
    public function isPublished(): bool
    {
        return $this->status === 'published'
            && $this->published_at
            && $this->published_at->isPast();
    }
}
