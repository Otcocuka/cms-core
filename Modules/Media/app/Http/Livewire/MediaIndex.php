<?php

namespace Modules\Media\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Modules\Media\Models\Media;

#[Layout('layouts.app')]
class MediaIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 20;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function updatingSearch()
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
            $media = Media::findOrFail($id);
            $media->delete();
            session()->flash('message', 'Media deleted successfully.');
            $this->resetPage();
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete media: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $media = Media::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', "%{$this->search}%");
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('media::livewire.media-index', [
            'media' => $media,
        ]);
    }
}
