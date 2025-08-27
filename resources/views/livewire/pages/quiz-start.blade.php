
<div x-data="quizState()" x-init="init()">
    @section('title', 'Quiz - Swadeshi Abhiyan')

    <div class="min-h-screen bg-gradient-to-br from-orange-50 via-white to-green-50">
        <!-- Header -->
        <div class="bg-white/80 backdrop-blur-md border-b border-orange-100 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">{{ $this->game->name }}</h1>
                        <p class="text-gray-600">Question <span x-text="currentIndex + 1"></span> of <span x-text="totalQuestions"></span></p>
                    </div>

                    <!-- Timer -->
                    <div class="text-center">
                        <div class="text-3xl font-bold text-red-600" x-text="formattedTime"></div>
                        <div class="text-sm text-gray-600">Time Left</div>
                    </div>

                    <!-- Progress -->
                    <div class="w-32">
                        <div class="bg-gray-200 rounded-full h-2">
                            <div class="bg-gradient-to-r from-orange-500 to-red-600 h-2 rounded-full transition-all duration-300"
                                 :style="`width: ${progressPercentage}%`"></div>
                        </div>
                        <div class="text-xs text-gray-600 text-center mt-1" x-text="progressPercentage + '%' "></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quiz Content -->
        <div class="max-w-4xl mx-auto px-4 py-8">
            @foreach($this->questions as $qIndex => $q)
            <div x-show="currentIndex === {{ $qIndex }}">

            <!-- Question -->
            <div class="bg-white/80 backdrop-blur-md rounded-3xl p-8 shadow-lg mb-8 border border-orange-100">
                <div class="mb-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                        @if($q->type === 'mcq') bg-blue-100 text-blue-800
                        @elseif($q->type === 'multi_select') bg-purple-100 text-purple-800
                        @else bg-green-100 text-green-800
                        @endif">
                        {{ ucfirst(str_replace('_', ' ', $q->type)) }}
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium ml-2
                        @if($q->difficulty === 'easy') bg-green-100 text-green-800
                        @elseif($q->difficulty === 'medium') bg-yellow-100 text-yellow-800
                        @else bg-red-100 text-red-800
                        @endif">
                        {{ ucfirst($q->difficulty) }}
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium ml-2 bg-orange-100 text-orange-800">
                        {{ $q->points }} pts
                    </span>
                </div>

                <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 text-center">
                    {{ $q->question }}
                </h2>

                <!-- Options Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($q->options->sortBy('sort_order') as $index => $option)
                    <button @click.prevent="select({{ $option->id }}, '{{ $q->type }}')"
                            class="bg-white border-2 rounded-2xl p-6 text-left transition-all duration-300 hover:shadow-lg
                                "
                            :class="isSelected({{ $qIndex }}, {{ $option->id }}) ? 'border-orange-500 bg-orange-50' : 'border-orange-200 hover:border-orange-500 hover:bg-orange-50'">
                        <div class="flex items-center space-x-4">
                            @if($q->type === 'multi_select')
                                <div class="w-6 h-6 border-2 border-orange-300 rounded flex items-center justify-center
                                    " :class="isSelected({{ $qIndex }}, {{ $option->id }}) ? 'bg-orange-500 border-orange-500' : ''">
                                    <template x-if="isSelected({{ $qIndex }}, {{ $option->id }})">
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
                <div class="mt-6 text-center">
                    <button @click.prevent="next()"
                            class="bg-gradient-to-r from-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700 text-white px-8 py-3 rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        <span x-show="currentIndex === totalQuestions - 1">Finish Quiz →</span>
                        <span x-show="currentIndex !== totalQuestions - 1">Next Question →</span>
                    </button>
                </div>

                <!-- Question Navigation -->
                <div class="mt-6 flex justify-between items-center">
                    <div class="text-sm text-gray-600">
                        <button x-show="currentIndex > 0" @click.prevent="prev()" class="text-orange-600 hover:text-orange-800">
                            ← Previous
                        </button>
                    </div>

                    <div class="text-sm text-gray-600">
                        Question <span x-text="currentIndex + 1"></span> of {{ $this->totalQuestions }}
                    </div>

                    <div class="text-sm text-gray-600">
                        <button x-show="currentIndex < totalQuestions - 1" @click.prevent="next()" class="text-orange-600 hover:text-orange-800">
                            Next →
                        </button>
                    </div>
                </div>
            </div>

            <!-- Question Progress -->
            <div class="bg-white/60 backdrop-blur-sm rounded-2xl p-6 border border-orange-100">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Question Progress</h3>
                <div class="grid grid-cols-5 md:grid-cols-10 gap-2">
                    @for($i = 0; $i < $this->totalQuestions; $i++)
                        <div class="relative">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-medium"
                                 :class="{{$i}} < currentIndex ? 'bg-green-500 text-white' : ({{$i}} === currentIndex ? 'bg-orange-500 text-white' : 'bg-gray-200 text-gray-600')">
                                {{ $i + 1 }}
                            </div>
                            <div x-show="answered[{{$i}}]" class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full"></div>
                        </div>
                    @endfor
                </div>
                <div class="mt-4 flex justify-between text-sm text-gray-600">
                    <span>Answered: <span x-text="answered.filter(Boolean).length"></span></span>
                    <span>Remaining: <span x-text="totalQuestions - answered.filter(Boolean).length"></span></span>
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
                <h3 class="text-xl font-bold text-gray-800">Processing Results...</h3>
                <p class="text-gray-600 mt-2">Calculating your score and generating certificate...</p>
            </div>
        </div>
        @endif
    </div>

    <script>
        function quizState() {
            return {
                currentIndex: 0,
                totalQuestions: {{ $this->totalQuestions }},
                perQuestionTime: {{ $this->game->per_question_time ?: 10 }},
                timeLeft: {{ $this->game->per_question_time ?: 10 }},
                timerId: null,
                questionStartTs: null,
                answered: Array({{ $this->totalQuestions }}).fill(false),
                answers: Array({{ $this->totalQuestions }}).fill().map(() => []),
                questionTimes: Array({{ $this->totalQuestions }}).fill(0),
                get formattedTime() {
                    const m = Math.floor(this.timeLeft / 60).toString().padStart(2, '0');
                    const s = (this.timeLeft % 60).toString().padStart(2, '0');
                    return `${m}:${s}`;
                },
                get progressPercentage() {
                    return Math.round(((this.currentIndex + 1) / this.totalQuestions) * 100);
                },
                init() {
                    this.resetTimer();
                },
                resetTimer() {
                    if (this.timerId) clearInterval(this.timerId);
                    this.timeLeft = this.perQuestionTime;
                    this.questionStartTs = Date.now();
                    this.timerId = setInterval(() => {
                        this.timeLeft--;
                        if (this.timeLeft <= 0) {
                            this.timeLeft = 0;
                            clearInterval(this.timerId);
                            if (this.currentIndex < this.totalQuestions - 1) {
                                this.next();
                            } else {
                                this.finish();
                            }
                        }
                    }, 1000);
                },
                select(optionId, type) {
                    const idx = this.currentIndex;
                    if (type === 'multi_select') {
                        const exists = this.answers[idx].includes(optionId);
                        this.answers[idx] = exists
                            ? this.answers[idx].filter((id) => id !== optionId)
                            : [...this.answers[idx], optionId];
                    } else {
                        this.answers[idx] = [optionId];
                    }
                    this.answered[idx] = this.answers[idx].length > 0;
                },
                isSelected(qIdx, optionId) {
                    return this.answers[qIdx].includes(optionId);
                },
                commitTime() {
                    const elapsed = Math.floor((Date.now() - this.questionStartTs) / 1000);
                    this.questionTimes[this.currentIndex] = elapsed;
                },
                next() {
                    this.commitTime();
                    if (this.currentIndex < this.totalQuestions - 1) {
                        this.currentIndex++;
                        this.resetTimer();
                    } else {
                        this.finish();
                    }
                },
                prev() {
                    if (this.currentIndex > 0) {
                        this.commitTime();
                        this.currentIndex--;
                        this.resetTimer();
                    }
                },
                finish() {
                    this.commitTime();
                    if (this.$wire?.set) {
                        this.$wire.set('isLoading', true);
                    }
                    this.$wire.submitResults({
                        answers: this.answers,
                        questionTimes: this.questionTimes,
                        answeredQuestions: this.answered,
                    });
                },
            };
        }
    </script>
</div>
