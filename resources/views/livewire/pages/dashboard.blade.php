<div>
    @section('title', __('labels.dashboard_title') . ' - ' . __('labels.swadeshi_abhiyan'))
    
    <div class="min-h-screen bg-gradient-to-br from-orange-50 via-white to-green-50 py-12">
        <div class="max-w-7xl mx-auto px-4">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-6xl font-bold mb-6 bg-clip-text text-transparent bg-gradient-to-r from-orange-600 via-red-600 to-green-600">
                    {{ __('labels.your_dashboard') }}
                </h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    {{ __('labels.track_progress_achievements') }}
                </p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-12">
                <div class="bg-white/80 backdrop-blur-md rounded-2xl p-6 shadow-lg border border-orange-100">
                    <div class="text-3xl font-bold text-orange-600">{{ $userStats['total_quizzes'] }}</div>
                    <div class="text-gray-600">{{ __('labels.quizzes_taken') }}</div>
                </div>
                <div class="bg-white/80 backdrop-blur-md rounded-2xl p-6 shadow-lg border border-green-100">
                    <div class="text-3xl font-bold text-green-600">{{ $userStats['best_score'] }}</div>
                    <div class="text-gray-600">{{ __('labels.best_score') }}</div>
                </div>
                <div class="bg-white/80 backdrop-blur-md rounded-2xl p-6 shadow-lg border border-blue-100">
                    <div class="text-3xl font-bold text-blue-600">{{ $userStats['average_score'] }}</div>
                    <div class="text-gray-600">{{ __('labels.average_score') }}</div>
                </div>
                <div class="bg-white/80 backdrop-blur-md rounded-2xl p-6 shadow-lg border border-purple-100">
                    <div class="text-3xl font-bold text-purple-600">{{ $userStats['rank'] }}</div>
                    <div class="text-gray-600">{{ __('labels.your_rank') }}</div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
                <!-- Recent Quiz Results -->
                <div class="bg-white/80 backdrop-blur-md rounded-2xl p-8 shadow-lg border border-orange-100">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">{{ __('labels.recent_quiz_results') }}</h2>
                    <div class="space-y-4">
                        @foreach($recentResults as $result)
                        <div class="flex items-center justify-between bg-orange-50 rounded-xl p-4">
                            <div>
                                <div class="font-semibold text-gray-800">{{ $result->game->name }}</div>
                                <div class="text-sm text-gray-600">{{ $result->created_at->format('M d, Y') }}</div>
                            </div>
                            <div class="text-right">
                                <div class="text-xl font-bold text-orange-600">{{ $result->score }}</div>
                                <div class="text-sm text-gray-600">{{ __('labels.points') }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Achievements -->
                <div class="bg-white/80 backdrop-blur-md rounded-2xl p-8 shadow-lg border border-orange-100">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">🏆 {{ __('labels.achievements') }}</h2>
                    <div class="space-y-4">
                        @foreach($achievements as $achievement)
                        <div class="flex items-center space-x-4 bg-green-50 rounded-xl p-4">
                            <div class="text-3xl">{{ $achievement['icon'] }}</div>
                            <div>
                                <div class="font-semibold text-gray-800">{{ $achievement['name'] }}</div>
                                <div class="text-sm text-gray-600">{{ $achievement['description'] }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white/60 backdrop-blur-sm rounded-2xl p-8 border border-orange-100 mb-8">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">{{ __('labels.quick_actions') }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <a href="{{ route('quiz') }}" class="bg-gradient-to-r from-orange-500 to-red-600 text-white p-6 rounded-2xl text-center hover:shadow-lg transition-all">
                        <div class="text-3xl mb-2">🎯</div>
                        <div class="font-bold">{{ __('buttons.take_quiz') }}</div>
                    </a>
                    <a href="{{ route('pledges') }}" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6 rounded-2xl text-center hover:shadow-lg transition-all">
                        <div class="text-3xl mb-2">🤝</div>
                        <div class="font-bold">{{ __('buttons.make_pledge') }}</div>
                    </a>
                    <a href="{{ route('leaderboard') }}" class="bg-gradient-to-r from-purple-500 to-pink-600 text-white p-6 rounded-2xl text-center hover:shadow-lg transition-all">
                        <div class="text-3xl mb-2">🏆</div>
                        <div class="font-bold">{{ __('buttons.view_leaderboard') }}</div>
                    </a>
                </div>
            </div>

            <!-- Navigation -->
            <div class="text-center">
                <a href="{{ route('home') }}" 
                   class="bg-gradient-to-r from-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700 text-white px-8 py-4 rounded-xl font-bold text-lg transition-all duration-300 shadow-lg hover:shadow-xl">
                    🏠 {{ __('buttons.back_to_home') }}
                </a>
            </div>
        </div>
    </div>
</div>
