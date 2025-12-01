<?php

namespace Modules\Content\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Modules\Content\Models\Page;

#[Layout('layouts.app')]
class PageIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {


        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

    }

    public function delete($id)
    {

        try {
            $page = Page::findOrFail($id);


            $page->delete();

            session()->flash('message', 'Page deleted successfully.');

            // Обновить текущую страницу пагинации если она стала пустой
            $this->resetPage();

        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete page: ' . $e->getMessage());
        }
    }

    public function render()
    {

        $pages = Page::query()
            ->when($this->search, function ($query) {
                $query->search($this->search);
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('content::livewire.page-index', [
            'pages' => $pages,
        ]);
    }
}
