<?php

namespace Modules\Settings\Http\Livewire\Admin;

use Livewire\Component;
use Modules\Settings\Models\Setting;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;

#[\Livewire\Attributes\Layout('layouts.app')]
class SettingsTable extends Component
{
    use WithPagination;

    public string $search = '';
    public string $group = 'all';

    protected $queryString = ['search', 'group'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function getGroupsProperty()
    {
        return Setting::select('group')->distinct()->pluck('group');
    }

    public function getSettingsProperty()
    {
        $query = Setting::query();

        if ($this->search) {
            $query->where('key', 'like', "%{$this->search}%");
        }

        if ($this->group !== 'all') {
            $query->where('group', $this->group);
        }

        return $query->paginate(15);
    }

    public function save(Setting $setting, $newValue)
    {
        try {
            $setting->update(['value' => $newValue]);
            Setting::clearCache();
            $this->dispatch('toast', message: 'Настройка обновлена', type: 'success');
        } catch (\Exception $e) {
            Log::error('Setting save error: ' . $e->getMessage());
            $this->dispatch('toast', message: 'Ошибка сохранения', type: 'error');
        }
    }

    public function render()
    {
        return view('settings::admin.index', [
            'settings' => $this->settings,
            'groups' => $this->groups,
        ]);
    }
}
