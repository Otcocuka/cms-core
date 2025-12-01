<?php

namespace Modules\Content\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

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
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Автогенерация slug из title
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($page) {
            if (empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
        });

        static::updating(function ($page) {
            if ($page->isDirty('title') && empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
        });
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
                ->orWhere('content', 'like', "%{$search}%")
                ->orWhere('slug', 'like', "%{$search}%");
        });
    }

    // Accessors
    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'published' => '<span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Published</span>',
            'draft' => '<span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Draft</span>',
            'archived' => '<span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">Archived</span>',
            default => '<span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">Unknown</span>',
        };
    }

    public function isPublished(): bool
    {
        return $this->status === 'published'
            && $this->published_at
            && $this->published_at->isPast();
    }

    // Mutators
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;

        // Автогенерация excerpt если пустой
        if (empty($this->attributes['excerpt']) && !empty($this->attributes['content'])) {
            $this->attributes['excerpt'] = Str::limit(strip_tags($this->attributes['content']), 150);
        }
    }
}
