<!DOCTYPE html>
<html lang="{{ session('locale', 'en') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Swadeshi Abhiyan Mehsana 2025 - Cultural Quiz Event">
    <meta name="keywords" content="Swadeshi, Quiz, Indian Products, Vocal for Local">
    <title>@yield('title', 'Swadeshi Abhiyan - Mehsana 2025')</title>

    <!-- PWA Meta Tags -->
    <meta name="theme-color" content="#FF6B35">
    <link rel="manifest" href="/manifest.json">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Custom Styles -->
    <style>
        .tricolor-gradient {
            background: linear-gradient(to bottom, #FF9933 33.33%, #FFFFFF 33.33%, #FFFFFF 66.66%, #138808 66.66%);
        }
        .flag-animation {
            animation: wave 2s ease-in-out infinite;
        }
        @keyframes wave {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(1deg); }
            75% { transform: rotate(-1deg); }
        }
        .pulse-animation {
            animation: pulse 2s infinite;
        }
        .bounce-in {
            animation: bounceIn 0.8s ease-out;
        }
        @keyframes bounceIn {
            0% { transform: scale(0.3); opacity: 0; }
            50% { transform: scale(1.05); }
            70% { transform: scale(0.9); }
            100% { transform: scale(1); opacity: 1; }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-orange-50 via-white to-green-50 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <!-- Logo and Title -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" wire:navigate class="block">
                        <img src="{{ asset('asset/useswadeshi-remove-bg-logo.png') }}" alt="Swadeshi Abhiyan Logo" class="w-40 h-auto hover:opacity-90 transition-opacity">
                    </a>
                </div>

                <!-- Navigation -->
                <nav class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-orange-600 font-medium transition-colors">{{ __('messages.home') }}</a>
                    <a href="{{ route('quiz') }}" class="text-gray-700 hover:text-orange-600 font-medium transition-colors">{{ __('messages.quiz') }}</a>
                    <a href="{{ route('leaderboard') }}" class="text-gray-700 hover:text-orange-600 font-medium transition-colors">{{ __('messages.leaderboard') }}</a>
                    <a href="{{ route('products') }}" class="text-gray-700 hover:text-orange-600 font-medium transition-colors">{{ __('messages.products') }}</a>
                    <a href="{{ route('vendors') }}" class="text-gray-700 hover:text-orange-600 font-medium transition-colors">{{ __('messages.vendors') }}</a>
                    <a href="{{ route('articles') }}" class="text-gray-700 hover:text-orange-600 font-medium transition-colors">{{ __('messages.articles') }}</a>

                    <!-- Language Switcher -->
                    <div class="ml-4">
                        @livewire('language-switcher')
                    </div>

                    @auth
                        <!-- Profile Dropdown -->
                        <div x-data="{ open: false }" class="relative">
                            <!-- Avatar Button -->
                            <button @click="open = !open" class="border border-2 border-danger w-10 h-10 flex items-center rounded-full justify-center text-gray-700 hover:text-orange-600 font-medium transition-colors">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </button>

                            <!-- Dropdown Menu -->
                            <div
                                x-show="open"
                                @click.away="open = false"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50"
                            >
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-gray-700 hover:text-orange-600 font-medium transition-colors">{{ __('messages.dashboard') }}</a>
                                <a href="{{ route('user.profile') }}" class="block px-4 py-2 text-gray-700 hover:text-orange-600 font-medium transition-colors">{{ __('messages.profile') }}</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left block px-4 py-2 text-gray-700 hover:text-orange-600 font-medium transition-colors">
                                        {{ __('messages.logout') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" wire:navigate class="bg-gradient-to-r from-orange-500 to-red-600 text-white px-4 py-2 rounded-lg font-medium hover:from-orange-600 hover:to-red-700 transition-all">{{ __('messages.login') }}</a>
                    @endauth
                </nav>

                <!-- Language Switcher -->
                <div class="flex items-center space-x-2">
                    <div class="relative">
                        @livewire('language-switcher')
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <button class="md:hidden p-2" id="mobileMenuBtn">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div class="md:hidden hidden" id="mobileMenu">
                <div class="px-2 pt-2 pb-3 space-y-1 bg-white border-t">
                    <a href="{{ route('home') }}" class="block px-3 py-2 text-gray-700 hover:bg-orange-50 rounded-md">Home</a>
                    <a href="{{ route('quiz') }}" class="block px-3 py-2 text-gray-700 hover:bg-orange-50 rounded-md">Quiz</a>
                    <a href="{{ route('leaderboard') }}" class="block px-3 py-2 text-gray-700 hover:bg-orange-50 rounded-md">Leaderboard</a>
                    <a href="{{ route('products') }}" class="block px-3 py-2 text-gray-700 hover:bg-orange-50 rounded-md">Products</a>
                    <a href="{{ route('vendors') }}" class="block px-3 py-2 text-gray-700 hover:bg-orange-50 rounded-md">Vendors</a>
                    <a href="{{ route('articles') }}" class="block px-3 py-2 text-gray-700 hover:bg-orange-50 rounded-md">Articles</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="block px-3 py-2 text-gray-700 hover:bg-orange-50 rounded-md">Dashboard</a>
                        <a href="{{ route('user.profile') }}" class="block px-3 py-2 text-gray-700 hover:bg-orange-50 rounded-md">Profile</a>
                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <button type="submit" class="w-full text-left px-3 py-2 text-gray-700 hover:bg-orange-50 rounded-md">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="block px-3 py-2 bg-orange-500 text-white rounded-md text-center">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-gray-900 to-gray-800 text-white py-16">
        <div class="max-w-7xl mx-auto px-4">
            <!-- Four Column Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">

                <!-- Column 1: Event Info -->
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <img src="{{ asset('asset/useswadeshi-remove-bg-logo.png') }}" alt="Swadeshi Abhiyan Logo" class="w-40 h-auto -my-20 -ml-7">
                    </div>
                    <p class="text-gray-300 text-sm mb-4 leading-relaxed">
                        Promoting Indian products and supporting Vocal for Local initiative through interactive cultural quiz.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.1.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.746-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24.009c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001.012.001z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Column 2: Quick Links -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">Home</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">Register</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">Leaderboard</a></li>
                        <!-- <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">Lucky Draw</a></li> -->
                    </ul>
                </div>

                <!-- Column 3: Features -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Features</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">Interactive Quiz</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">Digital Certificates</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">Real-time Leaderboard</a></li>
                    </ul>
                </div>

                <!-- Column 4: Contact Info -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Event Contact</h3>
                    <div class="space-y-3">
                        <div class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            </svg>
                            <div>
                                <p class="text-gray-300 text-sm">VELLAXY TECH PRIVATE LIMITED</p>
                                <p class="text-gray-300 text-sm">E-709, Ganesh Glory 11, Jagatpur, Ahmedabad, Gujarat, India, 382470</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 7.89a2 2 0 002.83 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-gray-300 text-sm">info@useswadeshi.com</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Border and Copyright -->
            <div class="border-t border-gray-700 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <!-- Left: Copyright -->
                    <div class="text-sm text-gray-400 mb-4 md:mb-0">
                        &copy; {{ date('Y') }} Use Swadeshi Abhiyan. All rights reserved by VELLAXY TECH PRIVATE LIMITED
                    </div>

                    <!-- Center: Hashtags -->
                    <div class="flex space-x-4 mb-4 md:mb-0">

                        <span class="text-gray-400 text-sm">#UseSwadeshi</span>
                        <span class="text-gray-400 text-sm">#SwadeshiAbhiyan</span>
                        <span class="text-gray-400 text-sm">#VocalForLocal</span>
                        <!-- <span class="text-gray-400 text-sm">#MadeInIndia</span> -->
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        $(document).ready(function() {
            // Mobile menu toggle
            $('#mobileMenuBtn').click(function() {
                $('#mobileMenu').toggleClass('hidden');
            });

            // Language switcher
            $('#languageSelector').change(function() {
                const selectedLang = $(this).val();
                window.location.href = `/lang/${selectedLang}`;
            });

            // PWA Install Prompt
            let deferredPrompt;
            window.addEventListener('beforeinstallprompt', (e) => {
                deferredPrompt = e;
                // Show install button if needed
            });

            // Smooth scrolling for anchor links
            $('a[href^="#"]').on('click', function(event) {
                var target = $(this.getAttribute('href'));
                if( target.length ) {
                    event.preventDefault();
                    $('html, body').stop().animate({
                        scrollTop: target.offset().top - 100
                    }, 1000);
                }
            });
        });

        // Service Worker Registration for PWA
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js')
                    .then(function(registration) {
                        console.log('SW registered: ', registration);
                    })
                    .catch(function(registrationError) {
                        console.log('SW registration failed: ', registrationError);
                    });
            });
        }
    </script>

    <!-- Alpine.js is now imported via Vite -->

    <!-- Livewire Redirect Listener -->
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('redirect', (event) => {
                window.location.href = event.url;
            });
        });
    </script>
</body>
</html>
