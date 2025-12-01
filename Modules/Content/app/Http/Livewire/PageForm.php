<?php

namespace Modules\Content\Http\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Modules\Content\Models\Page;
use Illuminate\Support\Str;

#[Layout('layouts.app')]
class PageForm extends Component
{
    public ?Page $page = null;
    public $title = '';
    public $slug = '';
    public $content = '';
    public $excerpt = '';
    public $status = 'draft';
    public $published_at = '';
    public $isEditing = false;

    protected function rules()
    {
        $pageId = $this->page?->id;

        return [
            'title' => 'required|string|max:255',
            'slug' => "required|string|max:255|unique:pages,slug,{$pageId}",
            'content' => 'nullable|string',
            'excerpt' => 'nullable|string|max:500',
            'status' => 'required|in:draft,published,archived',
            'published_at' => 'nullable|date',
        ];
    }

    public function mount(?Page $page = null)
    {
        if ($page && $page->exists) {
            $this->page = $page;
            $this->isEditing = true;
            $this->title = $page->title;
            $this->slug = $page->slug;
            $this->content = $page->content ?? '';
            $this->excerpt = $page->excerpt ?? '';
            $this->status = $page->status;
            $this->published_at = $page->published_at?->format('Y-m-d\TH:i') ?? '';
        }
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updatedTitle($value)
    {
        // Автогенерация slug только при создании новой страницы
        if (!$this->isEditing || empty($this->slug)) {
            $this->slug = Str::slug($value);
        }
    }

    public function generateSlug()
    {
        if (empty($this->title)) {
            session()->flash('error', 'Please enter a title first.');
            return;
        }

        $this->slug = Str::slug($this->title);

        // Проверка уникальности и добавление счётчика если нужно
        $originalSlug = $this->slug;
        $counter = 1;

        while (
            Page::where('slug', $this->slug)
                ->when($this->page, fn($q) => $q->where('id', '!=', $this->page->id))
                ->exists()
        ) {
            $this->slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        session()->flash('message', 'Slug generated successfully.');
    }

    public function save()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'excerpt' => $this->excerpt,
            'status' => $this->status,
            'published_at' => $this->published_at ?: null,
        ];

        if ($this->isEditing) {
            $this->page->update($data);
            session()->flash('message', 'Page updated successfully.');
        } else {
            Page::create($data);
            session()->flash('message', 'Page created successfully.');
        }

        return redirect()->route('content.pages.index');
    }

    public function render()
    {
        return view('content::livewire.page-form');
    }
}
