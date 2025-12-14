<?php

namespace Modules\Content\Http\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Modules\Content\Models\Page;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

#[Layout('content::components.layouts.master')]
class PageShow extends Component
{
    public Page $page;

    // SEO данные
    public $metaTitle;
    public $metaDescription;
    public $metaKeywords;
    public $ogTitle;
    public $ogDescription;
    public $ogImage;

    public function mount($slug): void
    {
        try {
            $this->page = Page::where('slug', $slug)
                ->where('status', 'published')
                ->firstOrFail();

            $this->setupSeoData();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
    }

    protected function setupSeoData(): void
    {
        $this->metaTitle = $this->page->meta_title ?? $this->page->title;
        $this->metaDescription = $this->page->meta_description ?? $this->page->excerpt;
        $this->metaKeywords = $this->page->meta_keywords ?? '';
        $this->ogTitle = $this->page->og_title ?? $this->metaTitle;
        $this->ogDescription = $this->page->og_description ?? $this->metaDescription;
        $this->ogImage = asset('storage/' . ($this->page->meta['featured_image'] ?? ''));
    }

    public function render()
    {
        // Передаём SEO данные в layout
        View::share([
            'title' => $this->metaTitle,
            'description' => $this->metaDescription,
            'keywords' => $this->metaKeywords,
            'ogTitle' => $this->ogTitle,
            'ogDescription' => $this->ogDescription,
            'ogImage' => $this->ogImage,
        ]);

        return view('content::livewire.page-show');
    }
}
