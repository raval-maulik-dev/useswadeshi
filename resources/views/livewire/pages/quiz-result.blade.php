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
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <button wire:click="showCertificate"
                            class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-8 py-4 rounded-xl font-bold text-lg transition-all duration-300 shadow-lg hover:shadow-xl">
                        📄 View Certificate
                    </button>
                    <button wire:click="downloadCertificate"
                            class="bg-gradient-to-r from-red-500 to-indigo-600 text-white px-8 py-4 rounded-xl font-bold text-lg transition-all duration-300 shadow-lg">
                        💾 Download PDF
                    </button>
                    <button wire:click="shareResult"
                            class="bg-gradient-to-r from-purple-500 to-pink-600 hover:from-purple-600 hover:to-pink-700 text-white px-8 py-4 rounded-xl font-bold text-lg transition-all duration-300 shadow-lg hover:shadow-xl">
                        📤 Share Result
                    </button>
                </div>

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
            @if(count($this->questionBreakdown) > 0)
            <div class="bg-white/80 backdrop-blur-md rounded-3xl p-8 shadow-2xl border border-orange-100 mb-8">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">Question Breakdown</h3>
                <div class="space-y-4">
                    @foreach($this->questionBreakdown as $index => $question)
                    <div class="bg-gray-50 rounded-xl p-4">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center space-x-3">
                                <span class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold
                                    @if($question['is_correct']) bg-green-500 text-white @else bg-red-500 text-white @endif">
                                    {{ $index + 1 }}
                                </span>
                                <span class="font-medium text-gray-800">{{ Str::limit($question['question_text'], 100) }}</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-gray-600">{{ $question['time_taken'] }}s</span>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                    @if($question['is_correct']) bg-green-100 text-green-800 @else bg-red-100 text-red-800 @endif">
                                    {{ $question['earned_points'] }}/{{ $question['points'] }} pts
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Social Sharing -->
            <div class="bg-white rounded-3xl shadow-2xl border border-orange-100 p-8 mt-20">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">Share Your Achievement</h3>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                    <a href="https://www.instagram.com/use.swadeshi?igsh=MTczd3FwdHNucTU0bQ==" target="_blank" class="flex flex-col items-center p-4 bg-gradient-to-br from-pink-50 to-pink-100 rounded-2xl border border-pink-200 hover:border-pink-400 transition-all duration-300 hover:scale-105">
                        <i class="bi bi-instagram text-3xl mb-2" style="background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
                        <span class="text-pink-700 font-semibold">Instagram</span>
                    </a>
                    <a href="https://wa.me/919054966947" target="_blank" class="flex flex-col items-center p-4 bg-gradient-to-br from-green-50 to-green-100 rounded-2xl border border-green-200 hover:border-green-400 transition-all duration-300 hover:scale-105">
                        <i class="bi bi-whatsapp text-3xl mb-2" style="color: #25D366"></i>
                        <span class="text-green-700 font-semibold">WhatsApp</span>
                    </a>
                    <a href="https://www.facebook.com/" target="_blank" class="flex flex-col items-center p-4 bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl border border-blue-200 hover:border-blue-400 transition-all duration-300 hover:scale-105">
                        <i class="bi bi-facebook text-3xl mb-2" style="color: #1877F2"></i>
                        <span class="text-blue-700 font-semibold">Facebook</span>
                    </a>
                    <a href="https://twitter.com/" target="_blank" class="flex flex-col items-center p-4 bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl border border-gray-200 hover:border-gray-400 transition-all duration-300 hover:scale-105">
                        <i class="bi bi-twitter-x text-3xl mb-2" style="color: #1DA1F2"></i>
                        <span class="text-gray-700 font-semibold">Twitter/X</span>
                    </a>
                </div>

                <div class="text-center">
                    <p class="text-gray-600 mb-4">Use these hashtags when sharing:</p>
                    <div class="flex flex-wrap justify-center gap-2">
                        <span class="bg-amber-100 text-amber-700 px-4 py-2 rounded-full text-sm font-semibold">#UseSwadeshi</span>
                        <span class="bg-orange-100 text-orange-700 px-4 py-2 rounded-full text-sm font-semibold">#SwadeshiAbhiyan</span>
                        <span class="bg-pink-100 text-green-700 px-4 py-2 rounded-full text-sm font-semibold">#VocalForLocal</span>
                        <span class="bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-sm font-semibold">#MadeInIndia</span>
                        <span class="bg-red-100 text-red-700 px-4 py-2 rounded-full text-sm font-semibold">#SwadeshiWarrior</span>
                    </div>
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
                    <button wire:click="downloadCertificate" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                        Download PDF
                    </button>
                    <button wire:click="shareResult" class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700">
                        Share
                    </button>
                    <button wire:click="closeCertificateModal" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
