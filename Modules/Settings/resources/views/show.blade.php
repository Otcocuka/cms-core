@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <h1 class="text-2xl font-semibold text-gray-900">Просмотр настройки</h1>
        <p class="mt-1 text-sm text-gray-600">
            ID: {{ request()->route('setting') }}<br/>
            Данные будут доступны после интеграции модели.
        </p>
        <div class="mt-4">
            <a href="{{ route('admin.settings.index') }}" class="btn btn-secondary">← Назад</a>
        </div>
    </div>
</div>
@endsection
