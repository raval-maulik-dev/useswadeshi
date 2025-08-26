<div>
    @section('title', 'Quiz - Swadeshi Abhiyan')

    <div class="min-h-screen bg-gradient-to-br from-orange-50 via-white to-green-50">
        <!-- Header -->
        <div class="bg-white/80 backdrop-blur-md border-b border-orange-100 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">{{ $game->name }}</h1>
                        <p class="text-gray-600">Question {{ $currentQuestionIndex + 1 }} of {{ $totalQuestions }}</p>
                    </div>

                    <!-- Timer -->
                    <div class="text-center">
                        <div class="text-3xl font-bold text-red-600" id="timer">{{ $timeLeft }}</div>
                        <div class="text-sm text-gray-600">Seconds Left</div>
                    </div>

                    <!-- Progress -->
                    <div class="w-32">
                        <div class="bg-gray-200 rounded-full h-2">
                            <div class="bg-gradient-to-r from-orange-500 to-red-600 h-2 rounded-full transition-all duration-300"
                                 style="width: {{ (($currentQuestionIndex + 1) / $totalQuestions) * 100 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quiz Content -->
        @if($questions->count() > 0 && $currentQuestionIndex < $questions->count())
        <div class="max-w-4xl mx-auto px-4 py-8">
            @php $currentQuestion = $questions[$currentQuestionIndex]; @endphp

            <!-- Question -->
            <div class="bg-white/80 backdrop-blur-md rounded-3xl p-8 shadow-lg mb-8 border border-orange-100">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 text-center">
                    {{ $currentQuestion->question }}
                </h2>

                <!-- Options Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($currentQuestion->options as $index => $option)
                    <button wire:click="answerQuestion('{{ $option }}')"
                            class="bg-white border-2 border-orange-200 hover:border-orange-500 hover:bg-orange-50 rounded-2xl p-6 text-left transition-all duration-300 hover:shadow-lg">
                        <div class="flex items-center space-x-4">
                            <div class="w-8 h-8 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center font-bold">
                                {{ chr(65 + $index) }}
                            </div>
                            <div class="font-semibold text-gray-800">{{ $option }}</div>
                        </div>
                    </button>
                    @endforeach
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
            </div>
        </div>
        @endif
    </div>

    <script>
        let timer;
        let timeLeft = {{ $timeLeft }};

        function startTimer() {
            timeLeft = 10;
            updateTimerDisplay();

            timer = setInterval(() => {
                timeLeft--;
                updateTimerDisplay();

                if (timeLeft <= 0) {
                    clearInterval(timer);
                    // Auto-submit or move to next question
                    @this.answerQuestion('');
                }
            }, 1000);
        }

        function updateTimerDisplay() {
            const timerElement = document.getElementById('timer');
            if (timerElement) {
                timerElement.textContent = timeLeft;

                // Change color based on time left
                if (timeLeft <= 3) {
                    timerElement.classList.add('text-red-600');
                    timerElement.classList.remove('text-orange-600');
                } else if (timeLeft <= 5) {
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
