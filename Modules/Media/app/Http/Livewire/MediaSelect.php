<?php

namespace Modules\Media\Http\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Modules\Media\Models\Media;

#[Layout('layouts.app')]
class MediaSelect extends Component
{
    public $selectedMediaId = null;
    public $modelType = null;
    public $modelId = null;

    protected $rules = [
        'selectedMediaId' => 'nullable|exists:media,id'
    ];

    public function updatedSelectedMediaId()
    {
        $this->dispatch('mediaSelected', $this->selectedMediaId);
    }

    public function render()
    {
        $media = Media::orderBy('created_at', 'desc')->paginate(12);

        return view('media::livewire.media-select', [
            'media' => $media
        ]);
    }
}
