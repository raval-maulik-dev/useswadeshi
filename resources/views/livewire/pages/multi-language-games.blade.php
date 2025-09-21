<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <!-- Language Selector -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-gray-900">
                        {{ __('messages.game_language') }}
                    </h2>
                    
                    <div class="flex space-x-2">
                        @foreach($availableLanguages as $code => $name)
                            <button
                                wire:click="switchLanguage('{{ $code }}')"
                                class="px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200
                                    {{ $selectedLanguage === $code 
                                        ? 'bg-blue-600 text-white' 
                                        : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}"
                            >
                                {{ $name }}
                            </button>
                        @endforeach
                    </div>
                </div>
                
                <p class="mt-2 text-sm text-gray-600">
                    {{ __('messages.game_translation_help') }}
                </p>
            </div>

            <!-- Games Grid -->
            <div class="p-6">
                @if($games->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($games as $game)
                            <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                                <!-- Game Image -->
                                @if($game->image)
                                    <img src="{{ asset($game->image) }}" alt="{{ $game->localized_name }}" class="w-full h-48 object-cover rounded-t-lg">
                                @else
                                    <div class="w-full h-48 bg-gradient-to-br from-blue-500 to-purple-600 rounded-t-lg flex items-center justify-center">
                                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                @endif

                                <!-- Game Content -->
                                <div class="p-6">
                                    <h3 class="text-xl font-semibold text-gray-900 mb-2">
                                        {{ $game->localized_name }}
                                    </h3>
                                    
                                    @if($game->localized_description)
                                        <p class="text-gray-600 mb-4 line-clamp-3">
                                            {{ $game->localized_description }}
                                        </p>
                                    @endif

                                    <!-- Translation Status -->
                                    <div class="mb-4">
                                        <div class="flex items-center space-x-2 mb-2">
                                            <span class="text-sm font-medium text-gray-700">{{ __('messages.game_available_languages') }}:</span>
                                        </div>
                                        <div class="flex space-x-1">
                                            @php
                                                $translationStatus = $this->getTranslationStatus($game);
                                            @endphp
                                            @foreach(['en', 'hi', 'gu'] as $lang)
                                                <div class="flex-1">
                                                    <div class="text-xs text-center mb-1">
                                                        {{ strtoupper($lang) }}
                                                    </div>
                                                    <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                                                        <div 
                                                            class="h-full {{ $translationStatus[$lang]['completion'] >= 100 ? 'bg-green-500' : ($translationStatus[$lang]['completion'] >= 50 ? 'bg-yellow-500' : 'bg-red-500') }}"
                                                            style="width: {{ $translationStatus[$lang]['completion'] }}%"
                                                        ></div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Game Stats -->
                                    <div class="grid grid-cols-2 gap-4 mb-4 text-sm">
                                        <div>
                                            <span class="text-gray-500">{{ __('messages.total_questions') }}:</span>
                                            <span class="font-medium">{{ $game->total_questions ?? 'All' }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-500">{{ __('messages.time_taken') }}:</span>
                                            <span class="font-medium">{{ $game->per_question_time ?? 'Unlimited' }}s</span>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex space-x-2">
                                        <a 
                                            href="{{ route('quiz.start', $game->id) }}" 
                                            class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700 transition-colors duration-200 text-center"
                                        >
                                            {{ __('messages.start_quiz') }}
                                        </a>
                                        
                                        @if($game->allow_replay)
                                            <span class="text-xs text-gray-500 flex items-center">
                                                {{ __('messages.allow_replay') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">{{ __('messages.no_data') }}</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            {{ __('messages.game_translation_missing') }}
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
