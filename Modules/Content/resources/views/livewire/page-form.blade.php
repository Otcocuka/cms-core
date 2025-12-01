<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">
                        {{ $isEditing ? 'Edit Page' : 'Create New Page' }}
                    </h2>
                    <a href="{{ route('content.pages.index') }}"
                       class="bg-red-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Back to List
                    </a>
                </div>

                <!-- Flash Messages -->
                @if (session()->has('message'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('message') }}</span>
                    </div>
                @endif

                @if (session()->has('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                <!-- Form -->
                <form wire:submit="save" class="space-y-6">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">
                            Title <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            wire:model.live="title"
                            id="title"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            placeholder="Enter page title"
                            required
                        >
                        @error('title')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Slug -->
                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700">
                            Slug <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <input
                                type="text"
                                wire:model="slug"
                                id="slug"
                                class="flex-1 rounded-none rounded-l-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                placeholder="auto-generated-from-title"
                                required
                            >
                            <button
                                type="button"
                                wire:click="generateSlug"
                                class="inline-flex items-center rounded-r-md border border-l-0 border-gray-300 bg-gray-50 px-3 text-sm text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            >
                                Generate
                            </button>
                        </div>
                        @error('slug')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">URL-friendly version of the title</p>
                    </div>

                    <!-- Excerpt -->
                    <div>
                        <label for="excerpt" class="block text-sm font-medium text-gray-700">
                            Excerpt
                        </label>
                        <textarea
                            wire:model="excerpt"
                            id="excerpt"
                            rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            placeholder="Brief description (max 500 characters)"
                        ></textarea>
                        @error('excerpt')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">{{ strlen($excerpt) }}/500 characters</p>
                    </div>

                    <!-- Content -->
                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700">
                            Content
                        </label>
                        <textarea
                            wire:model="content"
                            id="content"
                            rows="10"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            placeholder="Enter page content..."
                        ></textarea>
                        @error('content')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Status and Published Date -->
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select
                                wire:model="status"
                                id="status"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            >
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                                <option value="archived">Archived</option>
                            </select>
                            @error('status')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Published At -->
                        <div>
                            <label for="published_at" class="block text-sm font-medium text-gray-700">
                                Published At
                            </label>
                            <input
                                type="datetime-local"
                                wire:model="published_at"
                                id="published_at"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            >
                            @error('published_at')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Leave empty to use current date/time</p>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex items-center justify-end space-x-3 pt-4">
                        <a href="{{ route('content.pages.index') }}"
                           class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            Cancel
                        </a>
                        <button
                            type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                            {{ $isEditing ? 'Update Page' : 'Create Page' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
