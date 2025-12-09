<div>
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-bold">Настройки системы</h1>
    </div>

    <div class="mb-4 flex flex-wrap gap-4">
        <input wire:model.live.debounce.300ms="search" placeholder="Поиск по ключу..."
            class="w-64 rounded border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />

        <select wire:model.live="group" class="rounded border px-3 py-2">
            <option value="all">Все группы</option>
            @foreach ($groups as $group)
                <option value="{{ $group }}">{{ ucfirst($group) }}</option>
            @endforeach
        </select>
    </div>

    <div class="overflow-hidden rounded-lg border bg-white shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Ключ</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Значение
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Группа
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Тип</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse($settings as $setting)
                    <tr>
                        <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">
                            {{ $setting->key }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            @if (in_array($setting->type, ['string', 'integer', 'boolean']))
                                <input type="{{ $setting->type === 'boolean' ? 'checkbox' : 'text' }}"
                                    wire:change="save({{ $setting->id }}, $event.target.value)"
                                    @if ($setting->type === 'boolean') {{ $setting->value ? 'checked' : '' }}
                                        wire:change="save({{ $setting->id }}, $event.target.checked ? '1' : '0')"
                                    @else
                                        value="{{ $setting->value }}" @endif
                                    class="w-full rounded border px-2 py-1" />
                            @else
                                <pre class="max-w-xs overflow-x-auto text-xs">{{ json_encode($setting->value, JSON_PRETTY_PRINT) }}</pre>
                            @endif
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                            {{ ucfirst($setting->group) }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                            {{ $setting->type }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                            Нет настроек
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $settings->links() }}
    </div>
</div>
