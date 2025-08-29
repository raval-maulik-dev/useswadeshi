<div>
    @section('title', $article->title . ' - ' . __('messages.swadeshi_abhiyan'))
    
    <div class="min-h-screen bg-gradient-to-br from-orange-50 via-white to-green-50 py-12">
        <div class="max-w-4xl mx-auto px-4">
            <!-- Article -->
            <div class="bg-white/80 backdrop-blur-md rounded-3xl p-8 shadow-2xl border border-orange-100 mb-8">
                <div class="text-center mb-8">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">{{ $article->title }}</h1>
                    <div class="text-gray-600">{{ $article->created_at->format('F d, Y') }}</div>
                </div>

                <div class="prose prose-lg max-w-none">
                    <div class="bg-gradient-to-br from-orange-100 to-red-100 rounded-2xl p-8 mb-8 flex items-center justify-center">
                        <svg class="w-24 h-24 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    
                    <div class="text-gray-700 leading-relaxed">
                        {{ $article->content }}
                    </div>
                </div>
            </div>

            <!-- Related Articles -->
            @if($relatedArticles->count() > 0)
            <div class="bg-white/60 backdrop-blur-sm rounded-2xl p-8 border border-orange-100 mb-8">
                <h3 class="text-2xl font-bold text-gray-800 mb-6">{{ __('messages.related_articles') }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedArticles as $relatedArticle)
                    <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
                        <h4 class="font-bold text-gray-800 mb-2">{{ $relatedArticle->title }}</h4>
                        <p class="text-gray-600 text-sm mb-4">{{ Str::limit($relatedArticle->content, 80) }}</p>
                        <a href="{{ route('articles.show', $relatedArticle) }}" class="text-orange-600 font-semibold hover:text-orange-700">{{ __('messages.read_more') }} →</a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Navigation -->
            <div class="text-center">
                <a href="{{ route('articles') }}" 
                   class="bg-gradient-to-r from-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700 text-white px-8 py-4 rounded-xl font-bold text-lg transition-all duration-300 shadow-lg hover:shadow-xl">
                    ← {{ __('messages.back_to_articles') }}
                </a>
            </div>
        </div>
    </div>
</div>

