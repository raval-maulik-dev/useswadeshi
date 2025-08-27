<div>
    @section('title', 'Welcome to Swadeshi Abhiyan')
    <!-- Hero Section -->
        <section
            class="relative min-h-screen flex items-center justify-center bg-gradient-to-br from-orange-100 via-white to-green-100 overflow-hidden">
            <!-- Background Elements -->
            <div class="absolute inset-0">
                <div class="absolute top-10 left-10 w-32 h-32 bg-orange-200 rounded-full opacity-20 animate-bounce"></div>
                <div class="absolute bottom-20 right-20 w-24 h-24 bg-green-200 rounded-full opacity-30 animate-pulse"></div>
                <div class="absolute top-1/2 left-1/4 w-16 h-16 bg-orange-300 rounded-full opacity-25 animate-ping"></div>
            </div>

            <div class="relative z-10 text-center max-w-6xl mx-auto -mt-20">

                <!-- Main Heading -->
                @auth
                    <div class="mb-6 p-4 bg-white/80 backdrop-blur-md rounded-2xl shadow-lg border border-orange-100" style="margin-top: 17% ;">
                        <h3 class="text-2xl font-bold text-orange-600 mb-2">Welcome back, {{ auth()->user()->name }}! 👋</h3>
                        <p class="text-gray-600">Ready to test your knowledge of Indian products?</p>
                    </div>
                @endauth
                
                <h1 class="text-4xl md:text-7xl font-bold mb-6 bg-clip-text text-transparent bg-gradient-to-r from-orange-600 via-red-600 to-green-600">
                    Use Swadeshi Abhiyan
                </h1>
                <h2 class="text-1xl md:text-3xl font-semibold text-gray-700 mb-4">
                    आपका हर Swadeshi Choice = मजबूत भारत
                </h2>
                <p class="text-lg md:text-xl mb-8 text-gray-600 max-w-3xl mx-auto leading-relaxed">
                    Test your knowledge of Indian products and brands
                </p>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center mb-8">
                    @auth
                        <a href="{{ route('quiz') }}"
                           class="bg-gradient-to-r from-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700 text-white px-8 py-4 rounded-xl font-bold text-lg transition-all duration-300 shadow-lg hover:shadow-2xl transform hover:-translate-y-2 pulse-animation">
                            🚀 Start Quiz Now
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="bg-gradient-to-r from-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700 text-white px-8 py-4 rounded-xl font-bold text-lg transition-all duration-300 shadow-lg hover:shadow-2xl transform hover:-translate-y-2">
                            🚀 Register to Start Quiz
                        </a>
                    @endauth
                    <a href="{{ route('leaderboard') }}"
                       class="bg-white/90 backdrop-blur-md border-2 border-orange-300 text-orange-700 px-8 py-4 rounded-xl font-semibold text-lg hover:bg-orange-50 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        🏆 View Leaderboard
                    </a>
                </div>
                <!-- Stats -->
                <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-12 max-w-4xl mx-auto">
                    <div class="bg-white/80 backdrop-blur-md rounded-2xl p-4 shadow-lg border border-orange-100">
                        <div
                            class="text-2xl md:text-3xl font-bold text-orange-600">{{ number_format($stats['total_participants']) }}</div>
                        <div class="text-sm text-gray-600">Participants</div>
                    </div>
                    <div class="bg-white/80 backdrop-blur-md rounded-2xl p-4 shadow-lg border border-green-100">
                        <div
                            class="text-2xl md:text-3xl font-bold text-green-600">{{ number_format($stats['quizzes_completed']) }}</div>
                        <div class="text-sm text-gray-600">Completed</div>
                    </div>
                    <div class="bg-white/80 backdrop-blur-md rounded-2xl p-4 shadow-lg border border-red-100">
                        <div
                            class="text-2xl md:text-3xl font-bold text-red-600">{{ number_format($stats['certificates_generated']) }}</div>
                        <div class="text-sm text-gray-600">Certificates</div>
                    </div>
                    <div class="bg-white/80 backdrop-blur-md rounded-2xl p-4 shadow-lg border border-blue-100">
                        <div class="text-2xl md:text-3xl font-bold text-blue-600">{{ $stats['top_score'] }}</div>
                        <div class="text-sm text-gray-600">Top Score</div>
                    </div>
                    <div class="bg-white/80 backdrop-blur-md rounded-2xl p-4 shadow-lg border border-purple-100">
                        <div class="text-2xl md:text-3xl font-bold text-purple-600">{{ $stats['average_score'] }}</div>
                        <div class="text-sm text-gray-600">Avg Score</div>
                    </div>
                </div>

            </div>
        </section>

        <!-- Features Section -->
        <section class="mb-20 bg-white">
            <div class="max-w-7xl mx-auto px-4">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-5xl font-bold text-gray-800 mb-6">
                        How It Works
                    </h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        Simple steps to test your knowledge of Indian products and earn your certificate
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Step 1 -->
                    <div
                        class="bg-gradient-to-br from-orange-50 to-red-50 rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-3 border border-orange-100">
                        <div
                            class="w-16 h-16 bg-gradient-to-r from-orange-500 to-red-600 rounded-2xl flex items-center justify-center mb-6 mx-auto">
                            <span class="text-white font-bold text-2xl">1</span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4 text-center">Register</h3>
                        <p class="text-gray-600 text-center mb-6">Quick registration With name and mobile number</p>
                        <div class="flex justify-center">
                            <div class="bg-white rounded-lg p-3 shadow-md">
                                <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div
                        class="bg-gradient-to-br from-blue-50 to-green-50 rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-3 border border-blue-100">
                        <div
                            class="w-16 h-16 bg-gradient-to-r from-blue-500 to-green-600 rounded-2xl flex items-center justify-center mb-6 mx-auto">
                            <span class="text-white font-bold text-2xl">2</span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4 text-center">Take Quiz</h3>
                        <p class="text-gray-600 text-center mb-6">Answer 20 questions with 4 photo options each. 10-second
                            timer per question. Identify Indian products!</p>
                        <div class="flex justify-center">
                            <div class="bg-white rounded-lg p-3 shadow-md">
                                <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div
                        class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-3 border border-purple-100">
                        <div
                            class="w-16 h-16 bg-gradient-to-r from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center mb-6 mx-auto">
                            <span class="text-white font-bold text-2xl">3</span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4 text-center">Get Certificate</h3>
                        <p class="text-gray-600 text-center mb-6">Receive instant digital certificate with tricolor theme.
                            Share on social media with hashtags!</p>
                        <div class="flex justify-center">
                            <div class="bg-white rounded-lg p-3 shadow-md">
                                <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Showcase -->
        <section class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-5xl font-bold text-gray-800 mb-6">
                        Explore Our Platform
                    </h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        Discover all the features that make Swadeshi Abhiyan the ultimate platform for supporting local products
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Products -->
                    <div class="bg-gradient-to-br from-orange-50 to-red-50 rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-3 border border-orange-100">
                        <div class="w-16 h-16 bg-gradient-to-r from-orange-500 to-red-600 rounded-2xl flex items-center justify-center mb-6 mx-auto">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4 text-center">Local Products</h3>
                        <p class="text-gray-600 text-center mb-6">Browse and discover amazing Indian products from local businesses</p>
                        <div class="text-center">
                            <a href="{{ route('products') }}" class="bg-white text-orange-600 px-6 py-3 rounded-xl font-semibold hover:bg-orange-50 transition-all">
                                Explore Products →
                            </a>
                        </div>
                    </div>

                    <!-- Vendors -->
                    <div class="bg-gradient-to-br from-blue-50 to-green-50 rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-3 border border-blue-100">
                        <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-green-600 rounded-2xl flex items-center justify-center mb-6 mx-auto">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4 text-center">Local Vendors</h3>
                        <p class="text-gray-600 text-center mb-6">Connect with local businesses and support the community</p>
                        <div class="text-center">
                            <a href="{{ route('vendors') }}" class="bg-white text-blue-600 px-6 py-3 rounded-xl font-semibold hover:bg-blue-50 transition-all">
                                Find Vendors →
                            </a>
                        </div>
                    </div>

                    <!-- Articles -->
                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-3 border border-purple-100">
                        <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center mb-6 mx-auto">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4 text-center">Articles & Blog</h3>
                        <p class="text-gray-600 text-center mb-6">Learn more about Indian products and the Swadeshi movement</p>
                        <div class="text-center">
                            <a href="{{ route('articles') }}" class="bg-white text-purple-600 px-6 py-3 rounded-xl font-semibold hover:bg-purple-50 transition-all">
                                Read Articles →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Social Media Section -->
        <section class="py-20 bg-gradient-to-r from-orange-500 to-red-600">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <h2 class="text-3xl md:text-5xl font-bold text-white mb-6">
                    Share Your Achievement
                </h2>
                <p class="text-xl text-orange-100 max-w-3xl mx-auto mb-12">
                    Get your digital certificate and share it with the world using our hashtags
                </p>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-4xl mx-auto mb-12">
                    <div class="bg-white/20 backdrop-blur-md rounded-2xl p-6 text-center">
                        <div class="mb-2 flex justify-center">
                            <i class="bi bi-instagram text-4xl text-pink-500" style="color: #ffffff"></i>
                        </div>
                        <p class="text-white font-semibold">Instagram</p>
                    </div>
                    <div class="bg-white/20 backdrop-blur-md rounded-2xl p-6 text-center">
                        <div class="flex justify-center items-center h-10 mb-2">
                            <div class="relative">
                                <div class="absolute inset-0 rounded-full opacity-90 blur-sm"></div>
                                <i class="bi bi-whatsapp text-4xl relative z-10" style="color: #ffffff"></i>
                            </div>
                        </div>
                        <p class="text-white font-semibold">WhatsApp</p>
                    </div>
                    <div class="bg-white/20 backdrop-blur-md rounded-2xl p-6 text-center">
                        <div class="mb-2 flex justify-center">
                            <i class="bi bi-facebook text-4xl text-blue-600" style="color: #ffffff"></i>
                        </div>
                        <p class="text-white font-semibold">Facebook</p>
                    </div>
                    <div class="bg-white/20 backdrop-blur-md rounded-2xl p-6 text-center">
                        <div class="mb-2 flex justify-center">
                            <i class="bi bi-twitter-x text-4xl text-gray-300" style="color: #ffffff"></i>
                        </div>
                        <p class="text-white font-semibold">Twitter/X</p>
                    </div>
                </div>

                <div class="flex flex-wrap justify-center gap-4 mb-8">
                <span
                    class="bg-white/20 backdrop-blur-md px-6 py-3 rounded-full text-white font-semibold">#UseSwadeshi</span>
                    <span class="bg-white/20 backdrop-blur-md px-6 py-3 rounded-full text-white font-semibold">#SwadeshiAbhiyan</span>
                    <span class="bg-white/20 backdrop-blur-md px-6 py-3 rounded-full text-white font-semibold">#VocalForLocal</span>
                    <span
                        class="bg-white/20 backdrop-blur-md px-6 py-3 rounded-full text-white font-semibold">#MadeInIndia</span>
                    <span class="bg-white/20 backdrop-blur-md px-6 py-3 rounded-full text-white font-semibold">#SwadeshiWarrior</span>
                </div>

                @auth
                    <a href="#"
                       class="inline-block bg-white text-orange-600 px-8 py-4 rounded-xl font-bold text-lg hover:bg-orange-50 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        Start Your Journey Now →
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="inline-block bg-white text-orange-600 px-8 py-4 rounded-xl font-bold text-lg hover:bg-orange-50 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        Start Your Journey Now →
                    </a>
                @endauth
            </div>
        </section>

</div>
