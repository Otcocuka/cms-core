<?php

namespace Modules\Content\Http\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Modules\Content\Models\Page;
use Illuminate\Support\Facades\View;

#[Layout('layouts.frontend')]
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

    public function mount($slug)
    {
        \Log::info('PageShow mount called', ['slug' => $slug]);

        try {
            $this->page = Page::where('slug', $slug)
                ->published()
                ->firstOrFail();

            \Log::info('Page found', ['id' => $this->page->id, 'title' => $this->page->title]);
        } catch (\Exception $e) {
            \Log::error('Page not found', ['slug' => $slug, 'error' => $e->getMessage()]);
            throw $e;
        }

        $this->setupSeoData();
    }

    protected function setupSeoData(): void
    {
        $this->metaTitle = $this->page->meta_title ?? $this->page->title;
        $this->metaDescription = $this->page->meta_description ?? $this->page->excerpt;
        $this->metaKeywords = $this->page->meta_keywords ?? '';
        $this->ogTitle = $this->page->og_title ?? $this->page->meta_title ?? $this->page->title;
        $this->ogDescription = $this->page->og_description ?? $this->page->meta_description ?? $this->page->excerpt;
        $this->ogImage = $this->page->og_image ?? $this->page->featured_image ?? '';
    }

    public function render()
    {
        // Передаём SEO данные в layout
        View::share([
            'metaTitle' => $this->metaTitle,
            'metaDescription' => $this->metaDescription,
            'metaKeywords' => $this->metaKeywords,
            'ogTitle' => $this->ogTitle,
            'ogDescription' => $this->ogDescription,
            'ogImage' => $this->ogImage,
            'title' => $this->page->title,
        ]);

        return view('content::livewire.page-show');
    }
}
