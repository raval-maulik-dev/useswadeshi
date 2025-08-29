<div>
    @section('title', __('messages.articles_title') . ' - ' . __('messages.swadeshi_abhiyan'))
    
    <div class="min-h-screen bg-gradient-to-br from-orange-50 via-white to-green-50 py-12">
        <div class="max-w-7xl mx-auto px-4">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-6xl font-bold mb-6 bg-clip-text text-transparent bg-gradient-to-r from-orange-600 via-red-600 to-green-600">
                    {{ __('messages.articles_and_blog') }}
                </h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    {{ __('messages.learn_more_swadeshi') }}
                </p>
            </div>

            <!-- Featured Articles -->
            @if($featuredArticles->count() > 0)
            <div class="mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">🌟 {{ __('messages.featured_articles') }}</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($featuredArticles as $article)
                    <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-orange-100 overflow-hidden">
                        <div class="h-48 bg-gradient-to-br from-orange-100 to-red-100 flex items-center justify-center">
                            <svg class="w-16 h-16 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $article->title }}</h3>
                            <p class="text-gray-600 text-sm mb-4">{{ Str::limit($article->content, 100) }}</p>
                            <a href="{{ route('articles.show', $article) }}" class="text-orange-600 font-semibold hover:text-orange-700">{{ __('messages.read_more') }} →</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Search -->
            <div class="bg-white/80 backdrop-blur-md rounded-2xl p-6 shadow-lg border border-orange-100 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.search_articles') }}</label>
                        <input wire:model.live="search" type="text" placeholder="{{ __('messages.search_articles_placeholder') }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.category') }}</label>
                        <select wire:model.live="selectedCategory" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <option value="">{{ __('messages.all_categories') }}</option>
                            <option value="swadeshi">{{ __('messages.swadeshi_movement') }}</option>
                            <option value="products">{{ __('messages.indian_products') }}</option>
                            <option value="business">{{ __('messages.local_business') }}</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Articles Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($articles as $article)
                <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-orange-100 overflow-hidden">
                    <div class="h-48 bg-gradient-to-br from-orange-100 to-red-100 flex items-center justify-center">
                        <svg class="w-16 h-16 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $article->title }}</h3>
                        <p class="text-gray-600 text-sm mb-4">{{ Str::limit($article->content, 100) }}</p>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-500">{{ $article->created_at->format('M d, Y') }}</span>
                            <a href="{{ route('articles.show', $article) }}" class="text-orange-600 font-semibold hover:text-orange-700">{{ __('messages.read_more') }} →</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($articles->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $articles->links() }}
            </div>
            @endif

            <!-- Navigation -->
            <div class="text-center mt-8">
                <a href="{{ route('home') }}" 
                   class="bg-gradient-to-r from-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700 text-white px-8 py-4 rounded-xl font-bold text-lg transition-all duration-300 shadow-lg hover:shadow-xl">
                    🏠 {{ __('messages.back_to_home') }}
                </a>
            </div>
        </div>
    </div>
</div>
