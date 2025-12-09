@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <h1 class="text-2xl font-semibold text-gray-900">Создание | Редактирование настройки</h1>
        <p class="mt-1 text-sm text-gray-600">
            Этот раздел не реализован. Используйте UI управления: <a href="{{ route('admin.settings.ui') }}" class="text-indigo-600 hover:underline">Открыть</a>.
        </p>
        <div class="mt-4">
            <a href="{{ route('admin.settings.index') }}" class="btn btn-secondary">← Назад</a>
        </div>
    </div>
</div>
@endsection
