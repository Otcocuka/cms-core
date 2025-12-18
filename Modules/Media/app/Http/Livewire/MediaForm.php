<?php

namespace Modules\Media\Http\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use Modules\Media\Models\Media;
use Illuminate\Support\Facades\Log;

#[Layout('layouts.app')]
class MediaForm extends Component
{
    use WithFileUploads;

    public ?Media $media = null;
    public $name = '';
    public $description = '';
    public $file;
    public $isEditing = false;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|image|max:2048',
        ];
    }

    public function mount(?Media $media = null)
    {
        if ($media && $media->exists) {
            $this->media = $media;
            $this->isEditing = true;
            $this->name = $media->name;
            $this->description = $media->description;
        }
    }

    public function save()
    {
        $this->validate();

        try {
            if ($this->isEditing) {
                $this->media->update([
                    'name' => $this->name,
                    'description' => $this->description,
                ]);
                if ($this->file) {
                    $this->media->clearMediaCollection('default');
                    $this->media->addMedia($this->file)->toMediaCollection('default');
                }
                session()->flash('message', 'Media updated successfully.');
            } else {
                $media = Media::create([
                    'name' => $this->name,
                    'description' => $this->description,
                ]);
                if ($this->file) {
                    $media->addMedia($this->file)->toMediaCollection('default');
                }
                session()->flash('message', 'Media created successfully.');
            }

            return redirect()->route('media.index');

        } catch (\Exception $e) {
            Log::error('Media save error: ' . $e->getMessage());
            session()->flash('error', 'Failed to save media.');
        }
    }

    public function render()
    {
        return view('media::livewire.media-form');
    }
}
