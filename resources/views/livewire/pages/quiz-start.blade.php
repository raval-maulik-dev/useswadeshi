
<div x-data="quizApp()" x-init="init()">
    <div class="min-h-screen bg-gradient-to-br from-orange-50 via-white to-green-50">
        <!-- Header -->
        <div class="bg-white/80 backdrop-blur-md border-b border-orange-100 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">{{ $this->game->name }}</h1>
                        <p class="text-gray-600">{{ __('labels.question') }} <span x-text="currentIndex + 1"></span> {{ __('labels.of') }} {{ $this->totalQuestions }}</p>
                    </div>

                    <!-- Timer -->
                    <div class="text-center">
                        <div class="text-3xl font-bold"
                             :class="timeLeft <= 10 ? 'text-red-600' : 'text-orange-600'"
                             x-text="formattedTime"></div>
                        <div class="text-sm text-gray-600">{{ __('labels.time_left') }}</div>
                    </div>

                    <!-- Progress -->
                    <div class="w-32">
                        <div class="bg-gray-200 rounded-full h-2">
                            <div class="bg-gradient-to-r from-orange-500 to-red-600 h-2 rounded-full transition-all duration-300"
                                 :style="`width: ${progressPercentage}%`"></div>
                        </div>
                        <div class="text-xs text-gray-600 text-center mt-1" x-text="progressPercentage + '%'"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quiz Content -->
        <div class="max-w-4xl mx-auto px-4 py-8">
            @foreach($this->questions as $qIndex => $question)
            <div x-show="currentIndex === {{ $qIndex }}"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform translate-x-4"
                 x-transition:enter-end="opacity-100 transform translate-x-0">

                <!-- Question Card -->
                <div class="bg-white/80 backdrop-blur-md rounded-3xl p-8 shadow-lg mb-8 border border-orange-100">
                    <!-- Question Header -->
                    <div class="mb-4 flex flex-wrap gap-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                            @if($question->type === 'mcq') bg-blue-100 text-blue-800
                            @elseif($question->type === 'multi_select') bg-purple-100 text-purple-800
                            @else bg-green-100 text-green-800
                            @endif">
                            {{ __('labels.question_type_' . $question->type) }}
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                            @if($question->difficulty === 'easy') bg-green-100 text-green-800
                            @elseif($question->difficulty === 'medium') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ __('labels.difficulty_' . $question->difficulty) }}
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                            {{ $question->points }} {{ __('labels.points') }}
                        </span>
                    </div>

                    <!-- Question Text -->
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 text-center">
                        {{ $question->question }}
                    </h2>

                    <!-- Options Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($question->options as $index => $option)
                        <button @click="selectOption({{ $qIndex }}, {{ $option->id }}, '{{ $question->type }}')"
                                class="bg-white border-2 rounded-2xl p-6 text-left transition-all duration-300 hover:shadow-lg"
                                :class="isOptionSelected({{ $qIndex }}, {{ $option->id }}) ? 'border-orange-500 bg-orange-50 shadow-lg' : 'border-orange-200 hover:border-orange-500 hover:bg-orange-50'"
                                :disabled="timerExpired">
                            <div class="flex items-center space-x-4">
                                @if($question->type === 'multi_select')
                                    <div class="w-6 h-6 border-2 border-orange-300 rounded flex items-center justify-center"
                                         :class="isOptionSelected({{ $qIndex }}, {{ $option->id }}) ? 'bg-orange-500 border-orange-500' : ''">
                                        <template x-if="isOptionSelected({{ $qIndex }}, {{ $option->id }})">
                                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                        </template>
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
                                            {{ $option->optionable->name }} ({{ __('messages.product') }})
                                        @elseif($option->optionable_type === 'App\Models\Brand')
                                            {{ $option->optionable->name }} ({{ __('messages.brand') }})
                                        @else
                                            {{ $option->optionable->name ?? __('messages.unknown') }}
                                        @endif
                                    @else
                                        {{ __('messages.option') }} {{ $index + 1 }}
                                    @endif
                                </div>
                            </div>
                        </button>
                        @endforeach
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="mt-6 flex justify-between items-center">
                        <button x-show="currentIndex > 0" @click="previousQuestion()"
                                class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition-colors"
                                :disabled="timerExpired">
                            ← {{ __('messages.previous') }}
                        </button>

                        <div class="text-center">
                            <button @click="nextQuestion()"
                                    class="bg-gradient-to-r from-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700 text-white px-8 py-3 rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 disabled:opacity-50 disabled:cursor-not-allowed"
                                    :disabled="timerExpired">
                                <span x-show="currentIndex === {{ $this->totalQuestions - 1 }}">{{ __('messages.finish_quiz') }} →</span>
                                <span x-show="currentIndex !== {{ $this->totalQuestions - 1 }}">{{ __('messages.next_question') }} →</span>
                            </button>
                        </div>

                        <button x-show="currentIndex < {{ $this->totalQuestions - 1 }}" @click="nextQuestion()"
                                class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition-colors"
                                :disabled="timerExpired">
                            {{ __('messages.next') }} →
                        </button>
                    </div>
                </div>

                <!-- Question Progress -->
                <div class="bg-white/60 backdrop-blur-sm rounded-2xl p-6 border border-orange-100">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">{{ __('messages.question_progress') }}</h3>
                    <div class="grid grid-cols-5 md:grid-cols-10 gap-2">
                        @for($i = 0; $i < $this->totalQuestions; $i++)
                            <div class="relative">
                                <button @click="goToQuestion({{ $i }})"
                                        class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-medium transition-all duration-200 hover:scale-110 disabled:opacity-50 disabled:cursor-not-allowed"
                                        :class="{{$i}} < currentIndex ? 'bg-green-500 text-white hover:bg-green-600' : ({{$i}} === currentIndex ? 'bg-orange-500 text-white hover:bg-orange-600' : 'bg-gray-200 text-gray-600 hover:bg-gray-300')"
                                        :disabled="timerExpired">
                                    {{ $i + 1 }}
                                </button>
                                <div x-show="isQuestionAnswered({{$i}})" style="margin-left: 30px" class="absolute -top-1 w-3 h-3 bg-green-500 rounded-full"></div>
                            </div>
                        @endfor
                    </div>
                    <div class="mt-4 flex justify-between text-sm text-gray-600">
                        <span>{{ __('messages.answered') }}: <span x-text="answeredCount"></span></span>
                        <span>{{ __('messages.remaining') }}: <span x-text="remainingCount"></span></span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Loading State -->
        @if($this->isLoading)
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div class="bg-white rounded-3xl p-8 text-center">
                <div class="animate-spin w-12 h-12 border-4 border-orange-500 border-t-transparent rounded-full mx-auto mb-4"></div>
                <h3 class="text-xl font-bold text-gray-800">{{ __('messages.processing_results') }}</h3>
                <p class="text-gray-600 mt-2">{{ __('messages.calculating_score') }}</p>
            </div>
        </div>
        @endif
    </div>

    <script>
        function quizApp() {
            return {
                // Quiz state
                currentIndex: 0,
                totalQuestions: {{ $this->totalQuestions }},
                perQuestionTime: {{ $this->perQuestionTime }},
                timeLeft: {{ $this->perQuestionTime }},
                timerId: null,
                questionStartTime: null,
                quizStartTime: Date.now(),

                // User answers and progress
                answers: Array({{ $this->totalQuestions }}).fill().map(() => []),
                questionTimes: Array({{ $this->totalQuestions }}).fill(0),
                answeredQuestions: Array({{ $this->totalQuestions }}).fill(false),

                // UI state
                timerExpired: false,
                isPaused: false,

                // Computed properties
                get formattedTime() {
                    const minutes = Math.floor(this.timeLeft / 60);
                    const seconds = this.timeLeft % 60;
                    return `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                },

                get progressPercentage() {
                    return Math.round(((this.currentIndex + 1) / this.totalQuestions) * 100);
                },

                get answeredCount() {
                    return this.answeredQuestions.filter(Boolean).length;
                },

                get remainingCount() {
                    return this.totalQuestions - this.answeredCount;
                },

                // Initialization
                init() {
                    this.startTimer();
                    this.questionStartTime = Date.now();
                },

                // Timer management
                startTimer() {
                    this.clearTimer();
                    this.timeLeft = this.perQuestionTime;
                    this.questionStartTime = Date.now();
                    this.timerExpired = false;
                    this.isPaused = false;

                    this.timerId = setInterval(() => {
                        if (!this.isPaused && this.timeLeft > 0) {
                            this.timeLeft--;
                            if (this.timeLeft <= 0) {
                                this.handleTimerExpired();
                            }
                        }
                    }, 1000);
                },

                clearTimer() {
                    if (this.timerId) {
                        clearInterval(this.timerId);
                        this.timerId = null;
                    }
                },

                handleTimerExpired() {
                    this.timerExpired = true;
                    this.recordQuestionTime();
                    this.clearTimer();

                    // Auto-advance to next question or finish quiz
                    if (this.currentIndex < this.totalQuestions - 1) {
                        setTimeout(() => this.nextQuestion(), 1000);
                    } else {
                        setTimeout(() => this.finishQuiz(), 1000);
                    }
                },

                // Question navigation
                nextQuestion() {
                    // if (this.timerExpired) return;

                    this.recordQuestionTime();

                    if (this.currentIndex < this.totalQuestions - 1) {
                        this.currentIndex++;
                        this.startTimer();
                    } else {
                        this.finishQuiz();
                    }
                },

                previousQuestion() {
                    if (this.currentIndex > 0) {
                        this.recordQuestionTime();
                        this.currentIndex--;
                        this.startTimer();
                    }
                },

                goToQuestion(questionIndex) {
                    if (this.timerExpired) return;

                    if (questionIndex >= 0 && questionIndex < this.totalQuestions) {
                        this.recordQuestionTime();
                        this.currentIndex = questionIndex;
                        this.startTimer();
                    }
                },

                // Answer selection
                selectOption(questionIndex, optionId, questionType) {
                    if (this.timerExpired) return;

                    if (questionType === 'multi_select') {
                        // Toggle selection for multi-select
                        const index = this.answers[questionIndex].indexOf(optionId);
                        if (index > -1) {
                            this.answers[questionIndex].splice(index, 1);
                        } else {
                            this.answers[questionIndex].push(optionId);
                        }
                    } else {
                        // Single selection for other types
                        this.answers[questionIndex] = [optionId];
                    }

                    // Mark as answered if has any answers
                    this.answeredQuestions[questionIndex] = this.answers[questionIndex].length > 0;
                },

                isOptionSelected(questionIndex, optionId) {
                    return this.answers[questionIndex].includes(optionId);
                },

                isQuestionAnswered(questionIndex) {
                    return this.answeredQuestions[questionIndex];
                },

                // Time tracking
                recordQuestionTime() {
                    if (this.questionStartTime) {
                        const elapsed = Math.floor((Date.now() - this.questionStartTime) / 1000);
                        this.questionTimes[this.currentIndex] = elapsed;
                    }
                },

                // Quiz completion
                finishQuiz() {
                    this.recordQuestionTime();
                    this.clearTimer();
                    this.timerExpired = true;

                    const totalTimeTaken = Math.floor((Date.now() - this.quizStartTime) / 1000);

                    // Single server call with all data
                    @this.submitQuizResults({
                        answers: this.answers,
                        questionTimes: this.questionTimes,
                        answeredQuestions: this.answeredQuestions,
                        totalTimeTaken: totalTimeTaken
                    });
                },

                // Pause/resume functionality
                pauseTimer() {
                    this.isPaused = true;
                },

                resumeTimer() {
                    this.isPaused = false;
                }
            };
        }
    </script>
</div>
