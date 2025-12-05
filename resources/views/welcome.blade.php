<x-frontend-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Hero Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6 sm:p-12 text-center">
                    <h1 class="text-4xl font-bold text-gray-900 mb-4">
                        Welcome to {{ config('app.name') }}
                    </h1>
                    <p class="text-xl text-gray-600 mb-8">
                        A modern Laravel CMS with modular architecture
                    </p>
                    @auth
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700">
                            Go to Dashboard
                        </a>
                    @else
                        <div class="space-x-4">
                            <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700">
                                Log in
                            </a>
                            <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 bg-white border border-gray-300 rounded-md font-semibold text-gray-700 hover:bg-gray-50">
                                Register
                            </a>
                        </div>
                    @endauth
                </div>
            </div>

            <!-- Recent Pages -->
            @php
                $recentPages = \Modules\Content\Models\Page::published()
                    ->latest('published_at')
                    ->take(6)
                    ->get();
            @endphp

            @if($recentPages->isNotEmpty())
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Recent Pages</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($recentPages as $page)
                            <a href="{{ route('page.show', $page->slug) }}" class="block bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow duration-200">
                                @if($page->featured_image)
                                    <img src="{{ $page->featured_image }}" alt="{{ $page->title }}" class="w-full h-48 object-cover">
                                @endif
                                <div class="p-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                        {{ $page->title }}
                                    </h3>
                                    @if($page->excerpt)
                                        <p class="text-gray-600 text-sm line-clamp-3">
                                            {{ $page->excerpt }}
                                        </p>
                                    @endif
                                    <div class="mt-4 text-sm text-gray-500">
                                        {{ $page->published_at->format('M d, Y') }}
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-frontend-layout>
