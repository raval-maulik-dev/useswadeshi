<div>
    @section('title', 'Quiz - Swadeshi Abhiyan')

    <div class="min-h-screen bg-gradient-to-br from-orange-50 via-white to-green-50">
        <!-- Header -->
        <div class="bg-white/80 backdrop-blur-md border-b border-orange-100 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">{{ $game->name }}</h1>
                        <p class="text-gray-600">Question {{ $this->currentQuestionNumber }} of {{ $totalQuestions }}</p>
                    </div>

                    <!-- Timer -->
                    <div class="text-center">
                        <div class="text-3xl font-bold text-red-600" id="timer">{{ $this->timeLeftFormatted }}</div>
                        <div class="text-sm text-gray-600">Time Left</div>
                    </div>

                    <!-- Progress -->
                    <div class="w-32">
                        <div class="bg-gray-200 rounded-full h-2">
                            <div class="bg-gradient-to-r from-orange-500 to-red-600 h-2 rounded-full transition-all duration-300"
                                 style="width: {{ $this->progressPercentage }}%"></div>
                        </div>
                        <div class="text-xs text-gray-600 text-center mt-1">{{ $this->progressPercentage }}%</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quiz Content -->
        @if($this->currentQuestion)
        <div class="max-w-4xl mx-auto px-4 py-8">
            @php $currentQuestion = $this->currentQuestion; @endphp

            <!-- Question -->
            <div class="bg-white/80 backdrop-blur-md rounded-3xl p-8 shadow-lg mb-8 border border-orange-100">
                <div class="mb-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                        @if($currentQuestion->type === 'mcq') bg-blue-100 text-blue-800
                        @elseif($currentQuestion->type === 'multi_select') bg-purple-100 text-purple-800
                        @else bg-green-100 text-green-800
                        @endif">
                        {{ ucfirst(str_replace('_', ' ', $currentQuestion->type)) }}
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium ml-2
                        @if($currentQuestion->difficulty === 'easy') bg-green-100 text-green-800
                        @elseif($currentQuestion->difficulty === 'medium') bg-yellow-100 text-yellow-800
                        @else bg-red-100 text-red-800
                        @endif">
                        {{ ucfirst($currentQuestion->difficulty) }}
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium ml-2 bg-orange-100 text-orange-800">
                        {{ $currentQuestion->points }} pts
                    </span>
                </div>

                <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 text-center">
                    {{ $currentQuestion->question }}
                </h2>

                <!-- Options Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($this->currentOptions as $index => $option)
                    <button wire:click="answerQuestion({{ $option->id }})"
                            class="bg-white border-2 rounded-2xl p-6 text-left transition-all duration-300 hover:shadow-lg
                                @if($this->isOptionSelected($option->id))
                                    border-orange-500 bg-orange-50
                                @else
                                    border-orange-200 hover:border-orange-500 hover:bg-orange-50
                                @endif">
                        <div class="flex items-center space-x-4">
                            @if($currentQuestion->type === 'multi_select')
                                <div class="w-6 h-6 border-2 border-orange-300 rounded flex items-center justify-center
                                    @if($this->isOptionSelected($option->id)) bg-orange-500 border-orange-500 @endif">
                                    @if($this->isOptionSelected($option->id))
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    @endif
                                </div>
                            @else
                                <div class="w-8 h-8 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center font-bold">
                                    {{ chr(65 + $index) }}
                                </div>
                            @endif
                            <div class="font-semibold text-gray-800">
                                @if($option->option_text)
                                    {{ $option->option_text }}
                                @elseif($option->optionable)
                                    @if($option->optionable_type === 'App\Models\Product')
                                        {{ $option->optionable->name }} (Product)
                                    @elseif($option->optionable_type === 'App\Models\Brand')
                                        {{ $option->optionable->name }} (Brand)
                                    @else
                                        {{ $option->optionable->name ?? 'Unknown' }}
                                    @endif
                                @else
                                    Option {{ $index + 1 }}
                                @endif
                            </div>
                        </div>
                    </button>
                    @endforeach
                </div>

                <!-- Next Button -->
                @if($showNextButton || $currentQuestion->type === 'multi_select')
                <div class="mt-6 text-center">
                    <button wire:click="nextQuestion" 
                            class="bg-gradient-to-r from-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700 text-white px-8 py-3 rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        @if($this->currentQuestionNumber === $totalQuestions)
                            Finish Quiz →
                        @else
                            Next Question →
                        @endif
                    </button>
                </div>
                @endif

                <!-- Question Navigation -->
                <div class="mt-6 flex justify-between items-center">
                    <div class="text-sm text-gray-600">
                        @if($this->currentQuestionNumber > 1)
                            <button wire:click="previousQuestion" class="text-orange-600 hover:text-orange-800">
                                ← Previous
                            </button>
                        @endif
                    </div>
                    
                    <div class="text-sm text-gray-600">
                        Question {{ $this->currentQuestionNumber }} of {{ $totalQuestions }}
                    </div>
                    
                    <div class="text-sm text-gray-600">
                        @if($this->currentQuestionNumber < $totalQuestions)
                            <button wire:click="nextQuestion" class="text-orange-600 hover:text-orange-800">
                                Next →
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Question Progress -->
            <div class="bg-white/60 backdrop-blur-sm rounded-2xl p-6 border border-orange-100">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Question Progress</h3>
                <div class="grid grid-cols-5 md:grid-cols-10 gap-2">
                    @for($i = 0; $i < $totalQuestions; $i++)
                        <div class="relative">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-medium
                                @if($i < $this->currentQuestionIndex)
                                    bg-green-500 text-white
                                @elseif($i === $this->currentQuestionIndex)
                                    bg-orange-500 text-white
                                @else
                                    bg-gray-200 text-gray-600
                                @endif">
                                {{ $i + 1 }}
                            </div>
                            @if($answeredQuestions[$i] ?? false)
                                <div class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full"></div>
                            @endif
                        </div>
                    @endfor
                </div>
                <div class="mt-4 flex justify-between text-sm text-gray-600">
                    <span>Answered: {{ count(array_filter($answeredQuestions)) }}</span>
                    <span>Remaining: {{ $totalQuestions - count(array_filter($answeredQuestions)) }}</span>
                </div>
            </div>
        </div>
        @endif

        <!-- Loading State -->
        @if($isLoading)
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div class="bg-white rounded-3xl p-8 text-center">
                <div class="animate-spin w-12 h-12 border-4 border-orange-500 border-t-transparent rounded-full mx-auto mb-4"></div>
                <h3 class="text-xl font-bold text-gray-800">Processing Results...</h3>
                <p class="text-gray-600 mt-2">Calculating your score and generating certificate...</p>
            </div>
        </div>
        @endif
    </div>

    <script>
        let timer;
        let timeLeft = {{ $game->per_question_time ?: 10 }};

        function startTimer() {
            timeLeft = {{ $game->per_question_time ?: 10 }};
            updateTimerDisplay();

            timer = setInterval(() => {
                timeLeft--;
                updateTimerDisplay();

                if (timeLeft <= 0) {
                    clearInterval(timer);
                    // Auto-submit or move to next question
                    @this.nextQuestion();
                }
            }, 1000);
        }

        function updateTimerDisplay() {
            const timerElement = document.getElementById('timer');
            if (timerElement) {
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                timerElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

                // Change color based on time left
                if (timeLeft <= 3) {
                    timerElement.classList.add('text-red-600');
                    timerElement.classList.remove('text-orange-600', 'text-green-600');
                } else if (timeLeft <= Math.floor({{ $game->per_question_time ?: 10 }} * 0.3)) {
                    timerElement.classList.add('text-orange-600');
                    timerElement.classList.remove('text-red-600', 'text-green-600');
                } else {
                    timerElement.classList.add('text-green-600');
                    timerElement.classList.remove('text-red-600', 'text-orange-600');
                }
            }
        }

        // Listen for Livewire events
        document.addEventListener('livewire:init', () => {
            Livewire.on('startTimer', () => {
                clearInterval(timer);
                startTimer();
            });
        });

        // Start timer on page load
        document.addEventListener('DOMContentLoaded', () => {
            startTimer();
        });
    </script>
</div>
