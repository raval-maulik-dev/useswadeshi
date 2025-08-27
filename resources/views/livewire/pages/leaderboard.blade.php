<div>
    @section('title', 'Leaderboard - Swadeshi Abhiyan')

    <div class="min-h-screen bg-gradient-to-br from-orange-50 via-white to-green-50 py-16">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            
            <!-- Header -->
            <div class="text-center mb-16">
                <h1 class="text-4xl md:text-6xl font-extrabold mb-4 bg-clip-text text-transparent bg-gradient-to-r from-orange-600 via-red-600 to-green-600 drop-shadow-sm">
                    Leaderboard
                </h1>
                <p class="text-lg md:text-xl text-gray-700 max-w-2xl mx-auto leading-relaxed">
                    Track top performers and recent results in the Swadeshi Abhiyan quiz competition.
                </p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-16">
                <div class="bg-white/90 backdrop-blur rounded-2xl p-6 shadow-md border border-orange-100 flex flex-col items-center text-center">
                    <div class="text-3xl font-extrabold text-orange-600">{{ number_format($stats['total_participants']) }}</div>
                    <p class="text-gray-600 mt-2">Total Participants</p>
                </div>
                <div class="bg-white/90 backdrop-blur rounded-2xl p-6 shadow-md border border-green-100 flex flex-col items-center text-center">
                    <div class="text-3xl font-extrabold text-green-600">{{ number_format($stats['total_quizzes']) }}</div>
                    <p class="text-gray-600 mt-2">Quizzes Completed</p>
                </div>
                <div class="bg-white/90 backdrop-blur rounded-2xl p-6 shadow-md border border-blue-100 flex flex-col items-center text-center">
                    <div class="text-3xl font-extrabold text-blue-600">{{ $stats['average_score'] }}</div>
                    <p class="text-gray-600 mt-2">Average Score</p>
                </div>
                <div class="bg-white/90 backdrop-blur rounded-2xl p-6 shadow-md border border-purple-100 flex flex-col items-center text-center">
                    <div class="text-3xl font-extrabold text-purple-600">{{ $stats['highest_score'] }}</div>
                    <p class="text-gray-600 mt-2">Highest Score</p>
                </div>
            </div>

            <!-- Top Performers -->
            <div class="bg-white/95 backdrop-blur rounded-3xl p-8 shadow-xl border border-orange-100 mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-10 text-center">🏆 Top Performers</h2>
                
                <div class="space-y-5">
                    @foreach($topPerformers as $index => $performer)
                        <div class="flex items-center justify-between bg-gradient-to-r from-orange-50 to-red-50 rounded-2xl p-6 border border-orange-200 shadow-sm">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-gradient-to-r from-orange-500 to-red-600 rounded-full flex items-center justify-center text-white font-extrabold text-lg shadow-md">
                                    {{ $index + 1 }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-800 text-lg">{{ $performer->user_name }}</p>
                                    <p class="text-sm text-gray-500">{{ $performer->attempts }} attempts</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-bold text-orange-600">{{ $performer->best_score }}</p>
                                <p class="text-sm text-gray-500">Best Score</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Recent Results -->
            <div class="bg-white/80 backdrop-blur rounded-3xl p-8 border border-orange-100 shadow-md">
                <h3 class="text-2xl font-bold text-gray-800 mb-8 text-center">📊 Recent Results</h3>
                
                <div class="space-y-4">
                    @foreach($recentResults as $result)
                        <div class="flex items-center justify-between bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center shadow-sm">
                                    <span class="text-orange-600 font-bold text-sm">{{ $loop->iteration }}</span>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $result->user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $result->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-bold text-orange-600">{{ $result->score }}</p>
                                <p class="text-xs text-gray-500">points</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Navigation -->
            <div class="text-center mt-12">
                <a href="{{ route('home') }}" 
                   class="inline-block bg-gradient-to-r from-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700 text-white px-10 py-4 rounded-2xl font-bold text-lg transition-all duration-300 shadow-lg hover:shadow-xl">
                    🏠 Back to Home
                </a>
            </div>
        </div>
    </div>
</div>
