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
                </div>

                <!-- Score Display -->
                <div class="bg-gradient-to-r from-orange-500 to-red-600 rounded-2xl p-8 text-white text-center mb-8">
                    <div class="text-6xl font-bold mb-2">{{ $score }}/{{ $totalQuestions }}</div>
                    <div class="text-2xl mb-2">{{ $percentage }}%</div>
                    <div class="text-lg opacity-90">
                        @if($percentage >= 80)
                            🏆 Excellent! You're a Swadeshi expert!
                        @elseif($percentage >= 60)
                            🎯 Good job! You know your Indian products well!
                        @elseif($percentage >= 40)
                            👍 Nice effort! Keep learning about local products!
                        @else
                            📚 Keep practicing! Learn more about Indian brands!
                        @endif
                    </div>
                </div>

                <!-- Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-orange-50 rounded-2xl p-6 text-center">
                        <div class="text-3xl font-bold text-orange-600">{{ $userRank }}</div>
                        <div class="text-gray-600">Your Rank</div>
                    </div>
                    <div class="bg-green-50 rounded-2xl p-6 text-center">
                        <div class="text-3xl font-bold text-green-600">{{ $totalParticipants }}</div>
                        <div class="text-gray-600">Total Participants</div>
                    </div>
                    <div class="bg-blue-50 rounded-2xl p-6 text-center">
                        <div class="text-3xl font-bold text-blue-600">{{ $score }}</div>
                        <div class="text-gray-600">Correct Answers</div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <button wire:click="shareResult"
                            class="bg-gradient-to-r from-green-500 to-blue-600 hover:from-green-600 hover:to-blue-700 text-orange-700 px-8 py-4 rounded-xl font-bold text-lg transition-all duration-300 shadow-lg hover:shadow-xl">
                        📤 Share Result
                    </button>
                    <button wire:click="downloadCertificate"
                            class="bg-gradient-to-r from-purple-500 to-pink-600 hover:from-purple-600 hover:to-pink-700 text-white px-8 py-4 rounded-xl font-bold text-lg transition-all duration-300 shadow-lg hover:shadow-xl">
                        📄 Download Certificate
                    </button>
                    <a href="{{ route('quiz') }}"
                       class="bg-white border-2 border-orange-300 text-orange-700 px-8 py-4 rounded-xl font-semibold text-lg hover:bg-orange-50 transition-all duration-300 shadow-lg hover:shadow-xl text-center">
                        🔄 Take Another Quiz
                    </a>
                </div>
            </div>

            <!-- Social Sharing -->
            <div class="bg-white/60 backdrop-blur-sm rounded-2xl p-8 border border-orange-100 mb-8">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">Share Your Achievement</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <button class="bg-gradient-to-r from-pink-500 to-purple-600 text-white p-4 rounded-2xl hover:shadow-lg transition-all">
                        <div class="text-2xl mb-2">📷</div>
                        <div class="font-semibold">Instagram</div>
                    </button>
                    <button class="bg-gradient-to-r from-green-500 to-green-600 text-white p-4 rounded-2xl hover:shadow-lg transition-all">
                        <div class="text-2xl mb-2">💬</div>
                        <div class="font-semibold">WhatsApp</div>
                    </button>
                    <button class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-4 rounded-2xl hover:shadow-lg transition-all">
                        <div class="text-2xl mb-2">📘</div>
                        <div class="font-semibold">Facebook</div>
                    </button>
                    <button class="bg-gradient-to-r from-gray-500 to-gray-600 text-white p-4 rounded-2xl hover:shadow-lg transition-all">
                        <div class="text-2xl mb-2">🐦</div>
                        <div class="font-semibold">Twitter</div>
                    </button>
                </div>

                <!-- Hashtags -->
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
</div>
