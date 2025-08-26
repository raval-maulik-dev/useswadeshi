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
                <div class="bg-white/80 backdrop-blur-md rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-3 border border-orange-100 relative">
                    
                    <!-- Status Badge -->
                    <div class="absolute top-4 right-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $this->getGameStatusColor($game) }}">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @if($this->getUserGameStatus($game) === 'completed')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                @elseif($this->getUserGameStatus($game) === 'max_attempts_reached')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                @elseif($this->getUserGameStatus($game) === 'attempted')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                @elseif($this->getUserGameStatus($game) === 'played')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                @endif
                            </svg>
                            {{ $this->getGameStatusText($game) }}
                        </span>
                    </div>
                    
                    <div class="w-16 h-16 bg-gradient-to-r from-orange-500 to-red-600 rounded-2xl flex items-center justify-center mb-6 mx-auto">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>

                    <h3 class="text-2xl font-bold text-gray-800 mb-4 text-center">{{ $game->name }}</h3>
                    <p class="text-gray-600 text-center mb-6">{{ $game->description }}</p>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-orange-600">{{ $this->getQuestionCount($game) }}</div>
                            <div class="text-sm text-gray-600">Questions</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">{{ $game->per_question_time ?: '∞' }}s</div>
                            <div class="text-sm text-gray-600">Per Question</div>
                        </div>
                    </div>

                    <!-- Game Configuration Info -->
                    @if($game->total_questions || $game->max_attempts)
                    <div class="mb-6 p-3 bg-gray-50 rounded-lg">
                        <div class="text-xs text-gray-600 space-y-1">
                            @if($game->total_questions)
                                <div>• {{ $game->total_questions }} questions per attempt</div>
                            @endif
                            @if($game->max_attempts)
                                <div>• Max {{ $game->max_attempts }} attempts</div>
                            @elseif(!$game->allow_replay)
                                <div>• One-time game</div>
                            @endif
                            @if($game->allow_replay && !$game->max_attempts)
                                <div>• Unlimited attempts</div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Action Buttons -->
                    @if($this->getUserGameStatus($game) === 'new')
                        <button wire:click="selectGame({{ $game->id }})" 
                                class="w-full bg-gradient-to-r from-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700 text-white py-3 px-6 rounded-xl font-semibold text-center transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            🚀 Start Quiz
                        </button>
                    @elseif($this->getUserGameStatus($game) === 'completed' || $this->getUserGameStatus($game) === 'max_attempts_reached')
                        <div class="space-y-2">
                            <button wire:click="selectGame({{ $game->id }})" 
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-6 rounded-xl font-semibold text-center transition-all duration-300">
                                📊 View Results
                            </button>
                            <button wire:click="viewHistory({{ $game->id }})" 
                                    class="w-full bg-gray-600 hover:bg-gray-700 text-white py-2 px-6 rounded-lg text-sm font-medium text-center transition-all duration-300">
                                📋 View History
                            </button>
                        </div>
                    @elseif($this->getUserGameStatus($game) === 'played' || $this->getUserGameStatus($game) === 'attempted')
                        <div class="space-y-2">
                            @if($this->canReplayGame($game))
                                <button wire:click="selectGame({{ $game->id }})" 
                                        class="w-full bg-green-600 hover:bg-green-700 text-white py-3 px-6 rounded-xl font-semibold text-center transition-all duration-300">
                                    🔄 Play Again
                                </button>
                            @endif
                            <button wire:click="viewHistory({{ $game->id }})" 
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-6 rounded-lg text-sm font-medium text-center transition-all duration-300">
                                📊 View Results
                            </button>
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
                        <p class="text-gray-600 text-sm">Answer questions within the time limit</p>
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

    <!-- Result Modal -->
    @if($showResultModal && $selectedResult)
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" wire:click="closeResultModal">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white" wire:click.stop>
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Your Best Result - {{ $selectedGame->name }}</h3>
                    <button wire:click="closeResultModal" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="bg-gradient-to-br from-blue-50 to-indigo-100 border-2 border-blue-200 rounded-lg p-6 text-center">
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <p class="text-sm text-gray-600">Score</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $selectedResult->score }}/{{ $selectedResult->total_questions }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Accuracy</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $selectedResult->accuracy_percentage }}%</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Grade</p>
                            <p class="text-2xl font-bold text-{{ $selectedResult->getPerformanceColor() }}-600">{{ $selectedResult->getPerformanceGrade() }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Date</p>
                            <p class="text-lg font-medium text-gray-900">{{ $selectedResult->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 mt-6">
                    @if($this->canReplayGame($selectedGame))
                        <button wire:click="replayGame" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                            Play Again
                        </button>
                    @endif
                    <button wire:click="viewHistory({{ $selectedGame->id }})" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        View History
                    </button>
                    <button wire:click="closeResultModal" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
