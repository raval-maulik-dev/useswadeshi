<div>
    @section('title', __('messages.quiz_selection'))

    <!-- Hero Section -->
    <section class="relative py-16 bg-gradient-to-br from-orange-50 via-white to-green-50">
        <div class="max-w-7xl mx-auto px-4">
            
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-extrabold mb-4 bg-clip-text text-transparent bg-gradient-to-r from-orange-600 to-green-600">
                    {{ __('messages.choose_quiz') }}
                </h1>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    {{ __('messages.test_knowledge_indian') }}
                </p>
            </div>

            <!-- Quiz Categories -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($games as $game)
                <div class="bg-white rounded-2xl p-6 shadow-md hover:shadow-lg transition-all duration-200 border border-gray-100 flex flex-col">
                    
                    <!-- Status Badge -->
                    <div class="flex justify-end mb-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $this->getGameStatusColor($game) }}">
                            {{ $this->getGameStatusText($game) }}
                        </span>
                    </div>
                    
                    <!-- Icon -->
                    <div class="w-14 h-14 bg-gradient-to-r from-orange-500 to-red-600 rounded-xl flex items-center justify-center mb-4 mx-auto">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M8.228 9c.549-1.165 2.03-2 3.772-2 
                                   2.21 0 4 1.343 4 3 
                                   0 1.4-1.278 2.575-3.006 2.907 
                                   -.542.104-.994.54-.994 1.093m0 3h.01
                                   M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>

                    <!-- Title & Description -->
                    <h3 class="text-lg font-bold text-gray-800 mb-2 text-center">{{ $game->name }}</h3>
                    <p class="text-gray-600 text-sm text-center mb-4">{{ $game->description }}</p>

                    <!-- Stats -->
                    <div class="flex justify-center gap-8 text-center mb-6">
                        <div>
                            <div class="text-xl font-bold text-orange-600">{{ $this->getQuestionCount($game) }}</div>
                            <div class="text-xs text-gray-500">{{ __('messages.questions') }}</div>
                        </div>
                        <div>
                            <div class="text-xl font-bold text-green-600">{{ $game->per_question_time ?: '∞' }}s</div>
                            <div class="text-xs text-gray-500">{{ __('messages.per_question') }}</div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-auto flex flex-col gap-3 w-full">
                        @if($this->getUserGameStatus($game) === 'new')
                            <a 
                                href="{{ route('quiz.start', ['game' => $game->id]) }}"
                                class="w-full bg-gradient-to-r from-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700 
                                    text-white py-3 rounded-lg font-semibold text-center transition block"
                            >
                                {{ __('messages.start_quiz') }}
                            </a>
                        @elseif($this->getUserGameStatus($game) === 'completed' || $this->getUserGameStatus($game) === 'max_attempts_reached')
                            <button 
                                wire:click="selectGame({{ $game->id }})"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-semibold transition"
                            >
                                📊 View Results
                            </button>
                            <button 
                                wire:click="viewHistory({{ $game->id }})"
                                class="w-full bg-gray-600 hover:bg-gray-700 text-white py-3 rounded-lg font-semibold transition"
                            >
                                📋 View History
                            </button>
                        @elseif($this->getUserGameStatus($game) === 'played' || $this->getUserGameStatus($game) === 'attempted')
                            @if($this->canReplayGame($game))
                                <a 
                                    href="{{ route('quiz.start', ['game' => $game->id]) }}"
                                    class="w-full bg-red-600 hover:bg-red-700 text-white py-3 rounded-lg font-semibold transition block"
                                >
                                    🔄 Play Again
                                </a>
                            @endif
                            <button 
                                wire:click="viewHistory({{ $game->id }})"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-semibold transition"
                            >
                                📊 View Results
                            </button>
                        @endif
                    </div>

                </div>
                @endforeach
            </div>

            <!-- Instructions -->
            <div class="mt-16 bg-white rounded-xl p-8 border border-gray-100 shadow-md">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">How the Quiz Works</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-3 text-base font-bold text-orange-600">
                            1
                        </div>
                        <h4 class="font-semibold text-gray-800 mb-1">Select Category</h4>
                        <p class="text-gray-600 text-sm">Choose a quiz category</p>
                    </div>
                    <div class="text-center">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3 text-base font-bold text-green-600">
                            2
                        </div>
                        <h4 class="font-semibold text-gray-800 mb-1">Answer Questions</h4>
                        <p class="text-gray-600 text-sm">Complete within time</p>
                    </div>
                    <div class="text-center">
                        <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-3 text-base font-bold text-red-600">
                            3
                        </div>
                        <h4 class="font-semibold text-gray-800 mb-1">Get Certificate</h4>
                        <p class="text-gray-600 text-sm">Download instantly</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
