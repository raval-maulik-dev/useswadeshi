<div>
    @section('title', 'Quiz Result - Swadeshi Abhiyan')

    <div class="min-h-screen bg-gradient-to-br from-orange-50 via-white to-green-50 py-12">
        <div class="max-w-4xl mx-auto px-4">
            <!-- Result Card -->
            <div class="bg-white/80 backdrop-blur-md rounded-3xl p-8 shadow-2xl border border-orange-100 mb-8">
                <div class="text-center mb-8">
                    <div class="w-20 h-20 bg-gradient-to-r from-orange-500 to-red-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h1 class="text-4xl font-bold text-gray-800 mb-2">Quiz Complete!</h1>
                    <p class="text-gray-600">Great job completing the {{ $game->name }} quiz</p>
                    <div class="mt-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-{{ $this->performanceColor }}-100 text-{{ $this->performanceColor }}-800">
                            Grade: {{ $this->performanceGrade }}
                        </span>
                    </div>
                </div>

                <!-- Score Display -->
                <div class="bg-gradient-to-r from-orange-500 to-red-600 rounded-2xl p-8 text-white text-center mb-8">
                    <div class="text-6xl font-bold mb-2">{{ $result->score }}/{{ $result->total_questions }}</div>
                    <div class="text-2xl mb-2">{{ $result->accuracy_percentage }}%</div>
                    <div class="text-lg opacity-90">
                        @if($result->accuracy_percentage >= 80)
                            🏆 Excellent! You're a Swadeshi expert!
                        @elseif($result->accuracy_percentage >= 60)
                            🎯 Good job! You know your Indian products well!
                        @elseif($result->accuracy_percentage >= 40)
                            👍 Nice effort! Keep learning about local products!
                        @else
                            📚 Keep practicing! Learn more about Indian brands!
                        @endif
                    </div>
                </div>

                <!-- Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-orange-50 rounded-2xl p-6 text-center">
                        <div class="text-3xl font-bold text-orange-600">{{ $userRank }}</div>
                        <div class="text-gray-600">Your Rank</div>
                    </div>
                    <div class="bg-green-50 rounded-2xl p-6 text-center">
                        <div class="text-3xl font-bold text-green-600">{{ $totalParticipants }}</div>
                        <div class="text-gray-600">Total Participants</div>
                    </div>
                    <div class="bg-blue-50 rounded-2xl p-6 text-center">
                        <div class="text-3xl font-bold text-blue-600">{{ $result->correct_answers }}</div>
                        <div class="text-gray-600">Correct Answers</div>
                    </div>
                    <div class="bg-purple-50 rounded-2xl p-6 text-center">
                        <div class="text-3xl font-bold text-purple-600">{{ $result->total_points }}</div>
                        <div class="text-gray-600">Points Earned</div>
                    </div>
                </div>

                <!-- Additional Stats -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-yellow-50 rounded-2xl p-6 text-center">
                        <div class="text-2xl font-bold text-yellow-600">{{ $result->getFormattedTimeTaken() }}</div>
                        <div class="text-gray-600">Time Taken</div>
                    </div>
                    <div class="bg-indigo-50 rounded-2xl p-6 text-center">
                        <div class="text-2xl font-bold text-indigo-600">{{ $result->attempt_number }}</div>
                        <div class="text-gray-600">Attempt #</div>
                    </div>
                    <div class="bg-pink-50 rounded-2xl p-6 text-center">
                        <div class="text-2xl font-bold text-pink-600">{{ $result->incorrect_answers }}</div>
                        <div class="text-gray-600">Incorrect</div>
                    </div>
                </div>

                <!-- Action Buttons -->
{{--                <div class="flex flex-col sm:flex-row gap-4 justify-center">--}}
{{--                    <button wire:click="showCertificate"--}}
{{--                            class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-8 py-4 rounded-xl font-bold text-lg transition-all duration-300 shadow-lg hover:shadow-xl">--}}
{{--                        📄 View Certificate--}}
{{--                    </button>--}}
{{--                    <!-- Removed PDF download as per requirement -->--}}
{{--                    <div class="flex gap-2">--}}
{{--                        <button wire:click="share('instagram')"--}}
{{--                                class="bg-gradient-to-r from-pink-500 to-purple-600 hover:from-pink-600 hover:to-purple-700 text-white px-6 py-4 rounded-xl font-bold text-lg transition-all duration-300 shadow-lg hover:shadow-xl">--}}
{{--                            📷 Instagram--}}
{{--                        </button>--}}
{{--                        <button wire:click="share('whatsapp')"--}}
{{--                                class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-6 py-4 rounded-xl font-bold text-lg transition-all duration-300 shadow-lg hover:shadow-xl">--}}
{{--                            💬 WhatsApp--}}
{{--                        </button>--}}
{{--                        <button wire:click="share('facebook')"--}}
{{--                                class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-4 rounded-xl font-bold text-lg transition-all duration-300 shadow-lg hover:shadow-xl">--}}
{{--                            📘 Facebook--}}
{{--                        </button>--}}
{{--                        <button wire:click="share('twitter')"--}}
{{--                                class="bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white px-6 py-4 rounded-xl font-bold text-lg transition-all duration-300 shadow-lg hover:shadow-xl">--}}
{{--                            🐦 Twitter--}}
{{--                        </button>--}}
{{--                    </div>--}}
{{--                </div>--}}

                <!-- Navigation Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center mt-6">
                    @if($this->canReplay)
                        <button wire:click="playAgain"
                                class="bg-gradient-to-r from-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700 text-white px-8 py-3 rounded-xl font-semibold text-lg transition-all duration-300 shadow-lg hover:shadow-xl">
                            🔄 {{ $this->replayButtonText }}
                        </button>
                    @endif
                    <button wire:click="viewProfile"
                            class="bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white px-8 py-3 rounded-xl font-semibold text-lg transition-all duration-300 shadow-lg hover:shadow-xl">
                        👤 View Profile
                    </button>
                    <button wire:click="backToQuizzes"
                            class="bg-white border-2 border-orange-300 text-orange-700 px-8 py-3 rounded-xl font-semibold text-lg hover:bg-orange-50 transition-all duration-300 shadow-lg hover:shadow-xl">
                        📋 All Quizzes
                    </button>
                </div>
            </div>

            <!-- Performance Breakdown -->
            @if(count($this->enrichedQuestionBreakdown) > 0)
            <div class="bg-white/80 backdrop-blur-md rounded-3xl p-8 shadow-2xl border border-orange-100 mb-8">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">Question Breakdown</h3>
                <div class="space-y-4">
                    @foreach($this->enrichedQuestionBreakdown as $index => $question)
                    <div class="bg-gray-50 rounded-xl p-4">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center space-x-3">
                                <span class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold
                                    @if($question['is_correct']) bg-green-500 text-white @elseif($question['user_answered'] ?? true) bg-red-500 text-white @else bg-orange-500 text-white @endif">
                                    {{ $index + 1 }}
                                </span>
                                <span class="font-medium text-gray-800">{{ \Illuminate\Support\Str::limit($question['question_text'] ?? 'Question', 140) }}</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-gray-600">{{ $question['time_taken'] ?? '—' }}s</span>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                    @if($question['is_correct']) bg-green-100 text-green-800 @elseif($question['user_answered'] ?? true) bg-red-100 text-red-800 @else bg-orange-100 text-orange-800 @endif">
                                    {{ $question['earned_points'] ?? 0 }}/{{ $question['points'] ?? 0 }} pts
                                </span>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-3">
                            <div class="bg-white rounded-lg p-3 border">
                                <div class="text-xs text-gray-500">Your Answer</div>
                                @php($userAnswers = $question['user_answer_texts'] ?? [])
                                @php($userAnswered = $question['user_answered'] ?? true)
                                @if($userAnswered && count($userAnswers) > 0)
                                    <ul class="list-disc list-inside text-sm font-medium @if(($question['is_correct'] ?? false)) text-green-700 @else text-red-700 @endif">
                                        @foreach($userAnswers as $ua)
                                            <li>{{ $ua }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <div class="text-sm text-orange-600 font-medium">⏰ No answer selected</div>
                                @endif
                            </div>
                            <div class="bg-white rounded-lg p-3 border">
                                <div class="text-xs text-gray-500">Correct Answer</div>
                                @php($correctAnswers = $question['correct_answer_texts'] ?? [])
                                @if(count($correctAnswers) > 0)
                                    <ul class="list-disc list-inside text-sm font-medium text-green-700">
                                        @foreach($correctAnswers as $ca)
                                            <li>{{ $ca }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <div class="text-sm text-gray-500">Unavailable</div>
                                @endif
                            </div>
                            <div class="bg-white rounded-lg p-3 border">
                                <div class="text-xs text-gray-500">Result</div>
                                <div class="text-sm font-medium">
                                    @if($question['is_correct'] ?? false)
                                        ✅ Correct
                                    @elseif($question['user_answered'] ?? true)
                                        ❌ Incorrect
                                    @else
                                        ⏰ Unanswered
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Social Sharing (helper block and hashtags) -->
            <div class="bg-white/60 backdrop-blur-sm rounded-2xl p-8 border border-orange-100 mb-8">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">Share Your Achievement</h3>
                <p class="text-center text-gray-600 mb-4">Let your friends know about your achievement. We prepare the text for you.</p>
                <div class="flex flex-wrap justify-center gap-2">
                    <span class="bg-orange-100 text-orange-700 px-4 py-2 rounded-full font-semibold">#UseSwadeshi</span>
                    <span class="bg-red-100 text-red-700 px-4 py-2 rounded-full font-semibold">#SwadeshiAbhiyan</span>
                    <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full font-semibold">#VocalForLocal</span>
                    <span class="bg-blue-100 text-blue-700 px-4 py-2 rounded-full font-semibold">#MadeInIndia</span>
                </div>
            </div>

            <!-- Navigation -->
            <div class="text-center mt-8">
                <a href="{{ route('home') }}"
                   class="bg-gradient-to-r from-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700 text-white px-8 py-4 rounded-xl font-bold text-lg transition-all duration-300 shadow-lg hover:shadow-xl">
                    🏠 Back to Home
                </a>
            </div>
        </div>
    </div>

    <!-- Redesigned certificate as an on-page card (no PDF/print) -->
{{--    <div class="max-w-4xl mx-auto mt-8">--}}
{{--        <div class="bg-white border-8 border-yellow-200 rounded-3xl shadow-xl">--}}
{{--            <div class="border-4 border-yellow-400 rounded-2xl p-8 md:p-12">--}}
{{--                <div class="text-center">--}}
{{--                    <div class="text-3xl md:text-4xl font-extrabold text-yellow-800">Certificate of Achievement</div>--}}
{{--                    <div class="text-sm md:text-base text-yellow-700 mt-1">Swadeshi Abhiyan</div>--}}
{{--                </div>--}}
{{--                <div class="mt-8 text-center">--}}
{{--                    <div class="text-gray-600">This is to certify that</div>--}}
{{--                    <div class="text-2xl md:text-3xl font-semibold text-gray-900 mt-1">{{ $result->user->name }}</div>--}}
{{--                    <div class="text-gray-600 mt-2">has successfully completed the quiz</div>--}}
{{--                    <div class="text-xl md:text-2xl font-medium text-yellow-800 mt-1">{{ $game->name }}</div>--}}
{{--                </div>--}}
{{--                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 mt-8">--}}
{{--                    <div class="text-center">--}}
{{--                        <div class="text-xs text-gray-500">Score</div>--}}
{{--                        <div class="text-2xl font-bold text-gray-900">{{ $result->score }}/{{ $result->total_questions }}</div>--}}
{{--                    </div>--}}
{{--                    <div class="text-center">--}}
{{--                        <div class="text-xs text-gray-500">Accuracy</div>--}}
{{--                        <div class="text-2xl font-bold text-gray-900">{{ $result->accuracy_percentage }}%</div>--}}
{{--                    </div>--}}
{{--                    <div class="text-center">--}}
{{--                        <div class="text-xs text-gray-500">Grade</div>--}}
{{--                        <div class="text-2xl font-bold text-{{ $result->getPerformanceColor() }}-600">{{ $result->getPerformanceGrade() }}</div>--}}
{{--                    </div>--}}
{{--                    <div class="text-center">--}}
{{--                        <div class="text-xs text-gray-500">Date</div>--}}
{{--                        <div class="text-lg font-medium text-gray-900">{{ $result->created_at->format('M d, Y') }}</div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="mt-10 grid grid-cols-2 gap-6 items-end">--}}
{{--                    <div class="text-center">--}}
{{--                        <div class="h-12 border-b-2 border-gray-300 mx-10"></div>--}}
{{--                        <div class="text-xs text-gray-500 mt-2">Signature</div>--}}
{{--                    </div>--}}
{{--                    <div class="text-center">--}}
{{--                        <div class="h-12 border-b-2 border-gray-300 mx-10"></div>--}}
{{--                        <div class="text-xs text-gray-500 mt-2">Authorized Stamp</div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="mt-6 text-xs text-gray-500 text-center">Certificate ID: {{ $result->certificate_id ?: 'Not generated yet' }}</div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

    <!-- Certificate Modal -->
    @if($showCertificateModal)
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" wire:click="closeCertificateModal">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white" wire:click.stop>
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Certificate - {{ $game->name }}</h3>
                    <button wire:click="closeCertificateModal" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="bg-gradient-to-br from-blue-50 to-indigo-100 border-2 border-blue-200 rounded-lg p-8 text-center">
                    <div class="mb-6">
                        <h2 class="text-3xl font-bold text-blue-900 mb-2">Certificate of Achievement</h2>
                        <p class="text-blue-700">This is to certify that</p>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-2xl font-semibold text-gray-900 mb-2">{{ $result->user->name }}</h3>
                        <p class="text-gray-600">has successfully completed</p>
                        <h4 class="text-xl font-medium text-blue-800 mt-2">{{ $game->name }}</h4>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="text-center">
                            <p class="text-sm text-gray-600">Score</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $result->score }}/{{ $result->total_questions }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-sm text-gray-600">Accuracy</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $result->accuracy_percentage }}%</p>
                        </div>
                        <div class="text-center">
                            <p class="text-sm text-gray-600">Grade</p>
                            <p class="text-2xl font-bold text-{{ $result->getPerformanceColor() }}-600">{{ $result->getPerformanceGrade() }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-sm text-gray-600">Date</p>
                            <p class="text-lg font-medium text-gray-900">{{ $result->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>

                    <div class="text-sm text-gray-600">
                        <p>Certificate ID: {{ $result->certificate_id ?: 'Not generated yet' }}</p>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 mt-6">
                    <!-- Removed PDF download as per requirement -->
                    <div class="flex gap-2">
                        <button wire:click="share('whatsapp')" class="bg-green-600 text-white px-3 py-2 rounded-md hover:bg-green-700">WhatsApp</button>
                        <button wire:click="share('facebook')" class="bg-blue-600 text-white px-3 py-2 rounded-md hover:bg-blue-700">Facebook</button>
                        <button wire:click="share('twitter')" class="bg-gray-700 text-white px-3 py-2 rounded-md hover:bg-gray-800">Twitter</button>
                    </div>
                    <button wire:click="closeCertificateModal" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<script>
document.addEventListener('livewire:init', function () {
    // Share handler using Web Share API or fallback to platform URLs
    Livewire.on('share', ({ platform, text, url }) => {
        const shareData = { title: 'My Quiz Result', text, url };
        const encodedText = encodeURIComponent(text);
        const encodedUrl = encodeURIComponent(url);
        const links = {
            whatsapp: `https://wa.me/?text=${encodedText}%20${encodedUrl}`,
            facebook: `https://www.facebook.com/sharer/sharer.php?u=${encodedUrl}&quote=${encodedText}`,
            twitter: `https://twitter.com/intent/tweet?text=${encodedText}&url=${encodedUrl}`,
            instagram: null, // Instagram doesn't support direct text share via URL from web
        };

        if (navigator.share) {
            navigator.share(shareData).catch(() => {
                if (links[platform]) { window.open(links[platform], '_blank'); }
            });
        } else {
            if (platform === 'instagram') {
                alert('Instagram sharing is limited on web. Copy the text and share manually.');
                navigator.clipboard && navigator.clipboard.writeText(`${text} ${url}`);
                return;
            }
            if (links[platform]) {
                window.open(links[platform], '_blank');
            }
        }
    });

    // No PDF/print required anymore
});
</script>
