<div>
    @section('title', 'Quiz Selection - Swadeshi Abhiyan')
    
    <!-- Hero Section -->
    <section class="relative py-20 bg-gradient-to-br from-orange-50 via-white to-green-50 overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0">
            <div class="absolute top-10 left-10 w-32 h-32 bg-orange-200 rounded-full opacity-20 animate-bounce"></div>
            <div class="absolute bottom-20 right-20 w-24 h-24 bg-green-200 rounded-full opacity-30 animate-pulse"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-6xl font-bold mb-6 bg-clip-text text-transparent bg-gradient-to-r from-orange-600 via-red-600 to-green-600">
                    Choose Your Quiz
                </h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Test your knowledge of Indian products and brands
                </p>
            </div>

            <!-- Quiz Categories -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($games as $game)
                <div class="bg-white/80 backdrop-blur-md rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-3 border border-orange-100 cursor-pointer"
                     wire:click="selectGame({{ $game->id }})">
                    
                    <div class="w-16 h-16 bg-gradient-to-r from-orange-500 to-red-600 rounded-2xl flex items-center justify-center mb-6 mx-auto">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>

                    <h3 class="text-2xl font-bold text-gray-800 mb-4 text-center">{{ $game->name }}</h3>
                    <p class="text-gray-600 text-center mb-6">{{ $game->description }}</p>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-orange-600">{{ $game->gameQuestions->count() }}</div>
                            <div class="text-sm text-gray-600">Questions</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">10s</div>
                            <div class="text-sm text-gray-600">Per Question</div>
                        </div>
                    </div>

                    @if($selectedGame && $selectedGame->id === $game->id)
                    <div class="bg-gradient-to-r from-orange-500 to-red-600 text-white py-3 px-6 rounded-xl font-semibold text-center">
                        ✓ Selected
                    </div>
                    @else
                    <div class="bg-gray-100 text-gray-600 py-3 px-6 rounded-xl font-semibold text-center hover:bg-orange-50 hover:text-orange-600 transition-colors">
                        Select Quiz
                    </div>
                    @endif
                </div>
                @endforeach
            </div>

            @if($selectedGame)
            <div class="text-center mt-12">
                <button wire:click="startQuiz" 
                        class="bg-gradient-to-r from-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700 text-white px-12 py-4 rounded-xl font-bold text-xl transition-all duration-300 shadow-lg hover:shadow-2xl transform hover:-translate-y-2">
                    🚀 Start {{ $selectedGame->name }} Quiz
                </button>
            </div>
            @endif

            <!-- Instructions -->
            <div class="mt-16 bg-white/60 backdrop-blur-sm rounded-2xl p-8 border border-orange-100">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">How the Quiz Works</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-2xl">1</span>
                        </div>
                        <h4 class="font-semibold text-gray-800 mb-2">Select Category</h4>
                        <p class="text-gray-600 text-sm">Choose from different quiz categories</p>
                    </div>
                    <div class="text-center">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-2xl">2</span>
                        </div>
                        <h4 class="font-semibold text-gray-800 mb-2">Answer Questions</h4>
                        <p class="text-gray-600 text-sm">10 seconds per question with 4 options</p>
                    </div>
                    <div class="text-center">
                        <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-2xl">3</span>
                        </div>
                        <h4 class="font-semibold text-gray-800 mb-2">Get Certificate</h4>
                        <p class="text-gray-600 text-sm">Receive your digital certificate instantly</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
