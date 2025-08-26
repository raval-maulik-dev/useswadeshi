<div>
    @section('title', 'Leaderboard - Swadeshi Abhiyan')
    
    <div class="min-h-screen bg-gradient-to-br from-orange-50 via-white to-green-50 py-12">
        <div class="max-w-7xl mx-auto px-4">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-6xl font-bold mb-6 bg-clip-text text-transparent bg-gradient-to-r from-orange-600 via-red-600 to-green-600">
                    Leaderboard
                </h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    See who's leading the Swadeshi Abhiyan quiz competition
                </p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-12">
                <div class="bg-white/80 backdrop-blur-md rounded-2xl p-6 shadow-lg border border-orange-100">
                    <div class="text-3xl font-bold text-orange-600">{{ number_format($stats['total_participants']) }}</div>
                    <div class="text-gray-600">Total Participants</div>
                </div>
                <div class="bg-white/80 backdrop-blur-md rounded-2xl p-6 shadow-lg border border-green-100">
                    <div class="text-3xl font-bold text-green-600">{{ number_format($stats['total_quizzes']) }}</div>
                    <div class="text-gray-600">Quizzes Completed</div>
                </div>
                <div class="bg-white/80 backdrop-blur-md rounded-2xl p-6 shadow-lg border border-blue-100">
                    <div class="text-3xl font-bold text-blue-600">{{ $stats['average_score'] }}</div>
                    <div class="text-gray-600">Average Score</div>
                </div>
                <div class="bg-white/80 backdrop-blur-md rounded-2xl p-6 shadow-lg border border-purple-100">
                    <div class="text-3xl font-bold text-purple-600">{{ $stats['highest_score'] }}</div>
                    <div class="text-gray-600">Highest Score</div>
                </div>
            </div>

            <!-- Top Performers -->
            <div class="bg-white/80 backdrop-blur-md rounded-3xl p-8 shadow-2xl border border-orange-100 mb-8">
                <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">🏆 Top Performers</h2>
                
                <div class="space-y-4">
                    @foreach($topPerformers as $index => $performer)
                    <div class="flex items-center justify-between bg-gradient-to-r from-orange-50 to-red-50 rounded-2xl p-6 border border-orange-200">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-gradient-to-r from-orange-500 to-red-600 rounded-full flex items-center justify-center text-white font-bold text-xl">
                                {{ $index + 1 }}
                            </div>
                            <div>
                                <div class="font-bold text-gray-800">{{ $performer->user_name }}</div>
                                <div class="text-sm text-gray-600">{{ $performer->attempts }} attempts</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-bold text-orange-600">{{ $performer->best_score }}</div>
                            <div class="text-sm text-gray-600">Best Score</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Recent Results -->
            <div class="bg-white/60 backdrop-blur-sm rounded-2xl p-8 border border-orange-100">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">📊 Recent Results</h3>
                
                <div class="space-y-3">
                    @foreach($recentResults as $result)
                    <div class="flex items-center justify-between bg-white rounded-xl p-4 shadow-sm">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center">
                                <span class="text-orange-600 font-bold text-sm">{{ $loop->iteration }}</span>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-800">{{ $result->user->name }}</div>
                                <div class="text-sm text-gray-600">{{ $result->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="font-bold text-orange-600">{{ $result->score }}</div>
                            <div class="text-sm text-gray-600">points</div>
                        </div>
                    </div>
                    @endforeach
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

