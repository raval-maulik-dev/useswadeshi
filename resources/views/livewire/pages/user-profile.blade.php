<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">{{ __('labels.my_profile') }}</h1>
            <p class="mt-2 text-gray-600">{{ __('labels.manage_profile_history') }}</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">{{ __('labels.total_attempts') }}</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $this->userStats['total_attempts'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">{{ __('labels.games_played') }}</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $this->userStats['total_games_played'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">{{ __('labels.avg_accuracy') }}</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $this->userStats['average_accuracy'] }}%</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m-9 0h10m-10 0a2 2 0 00-2 2v14a2 2 0 002 2h10a2 2 0 002-2V6a2 2 0 00-2-2"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">{{ __('labels.certificates') }}</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $this->userStats['certificates_earned'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">{{ __('labels.total_points') }}</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $this->userStats['total_points_earned'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-indigo-500 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">{{ __('labels.best_score') }}</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $this->userStats['best_score'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="bg-white rounded-lg shadow">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                    <button wire:click="setActiveTab('profile')" class="py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'profile' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        {{ __('labels.profile') }}
                    </button>
                    <button wire:click="setActiveTab('history')" class="py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'history' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        {{ __('labels.quiz_history') }}
                    </button>
                    <button wire:click="setActiveTab('certificates')" class="py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'certificates' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        {{ __('labels.certificates') }}
                    </button>
                </nav>
            </div>

            <div class="p-6">
                <!-- Profile Tab -->
                @if($activeTab === 'profile')
                <div>
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">{{ __('labels.profile_information') }}</h3>
                        <button wire:click="toggleEditMode" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                            {{ $editMode ? __('buttons.cancel') : __('buttons.edit_profile') }}
                        </button>
                    </div>

                    @if($editMode)
                    <form wire:submit.prevent="updateProfile" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">{{ __('labels.name') }}</label>
                                <input type="text" wire:model="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">{{ __('labels.email') }}</label>
                                <input type="email" wire:model="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">{{ __('labels.phone') }}</label>
                                <input type="text" wire:model="phone" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">{{ __('labels.city') }}</label>
                                <input type="text" wire:model="city" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('city') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">{{ __('labels.state') }}</label>
                                <input type="text" wire:model="state" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('state') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">{{ __('labels.country') }}</label>
                                <input type="text" wire:model="country" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('country') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700">
                                {{ __('buttons.save_changes') }}
                            </button>
                        </div>
                    </form>
                    @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Name</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $name }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $email }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Phone</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $phone ?: __('labels.not_provided') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">City</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $city ?: __('labels.not_provided') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">State</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $state ?: __('labels.not_provided') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Country</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $country ?: __('labels.not_provided') }}</p>
                        </div>
                    </div>
                    @endif
                </div>
                @endif

                <!-- History Tab -->
                @if($activeTab === 'history')
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Quiz History</h3>
                    
                    @if($this->userResults->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('labels.game') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('labels.score') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('labels.accuracy') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('labels.time') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('labels.date') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('labels.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($this->userResults as $result)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $result->game->name }}</div>
                                        <div class="text-sm text-gray-500">{{ __('labels.attempt') }} #{{ $result->attempt_number }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $result->score }}/{{ $result->total_questions }}</div>
                                        <div class="text-sm text-gray-500">{{ $result->total_points }} {{ __('labels.points') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $result->getPerformanceColor() }}-100 text-{{ $result->getPerformanceColor() }}-800">
                                            {{ $result->accuracy_percentage }}%
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $result->getFormattedTimeTaken() }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $result->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <button wire:click="showCertificate({{ $result->id }})" class="text-blue-600 hover:text-blue-900">{{ __('buttons.view') }}</button>
                                            <button wire:click="downloadCertificate({{ $result->id }})" class="text-green-600 hover:text-green-900">{{ __('buttons.download') }}</button>
                                            <button wire:click="shareResult({{ $result->id }})" class="text-purple-600 hover:text-purple-900">{{ __('buttons.share') }}</button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $this->userResults->links() }}
                    </div>
                    @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">{{ __('labels.no_quiz_history') }}</h3>
                        <p class="mt-1 text-sm text-gray-500">{{ __('labels.start_playing_quizzes') }}</p>
                        <div class="mt-6">
                            <a href="{{ route('quiz') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                Start Playing
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
                @endif

                <!-- Certificates Tab -->
                @if($activeTab === 'certificates')
<div>
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Certificates</h3>
                    
                    @if($this->userResults->whereNotNull('certificate_id')->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($this->userResults->whereNotNull('certificate_id') as $result)
                        <div class="bg-white border border-gray-200 rounded-lg p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-lg font-medium text-gray-900">{{ $result->game->name }}</h4>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    {{ $result->getPerformanceGrade() }}
                                </span>
                            </div>
                            
                            <div class="space-y-2 mb-4">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Score:</span>
                                    <span class="font-medium">{{ $result->score }}/{{ $result->total_questions }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Accuracy:</span>
                                    <span class="font-medium">{{ $result->accuracy_percentage }}%</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Date:</span>
                                    <span class="font-medium">{{ $result->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                            
                            <div class="flex space-x-2">
                                <button wire:click="showCertificate({{ $result->id }})" class="flex-1 bg-blue-600 text-white px-3 py-2 rounded-md text-sm hover:bg-blue-700">
                                    View
                                </button>
                                <button wire:click="downloadCertificate({{ $result->id }})" class="flex-1 bg-green-600 text-white px-3 py-2 rounded-md text-sm hover:bg-green-700">
                                    Download
                                </button>
                                <button wire:click="shareResult({{ $result->id }})" class="flex-1 bg-purple-600 text-white px-3 py-2 rounded-md text-sm hover:bg-purple-700">
                                    Share
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m-9 0h10m-10 0a2 2 0 00-2 2v14a2 2 0 002 2h10a2 2 0 002-2V6a2 2 0 00-2-2"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No certificates yet</h3>
                        <p class="mt-1 text-sm text-gray-500">Complete quizzes to earn certificates.</p>
                        <div class="mt-6">
                            <a href="{{ route('quiz') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                Start Playing
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Certificate Modal -->
    @if($showCertificateModal && $selectedResult)
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" wire:click="closeCertificateModal">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white" wire:click.stop>
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Certificate - {{ $selectedResult->game->name }}</h3>
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
                        <h3 class="text-2xl font-semibold text-gray-900 mb-2">{{ $selectedResult->user->name }}</h3>
                        <p class="text-gray-600">has successfully completed</p>
                        <h4 class="text-xl font-medium text-blue-800 mt-2">{{ $selectedResult->game->name }}</h4>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="text-center">
                            <p class="text-sm text-gray-600">Score</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $selectedResult->score }}/{{ $selectedResult->total_questions }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-sm text-gray-600">Accuracy</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $selectedResult->accuracy_percentage }}%</p>
                        </div>
                        <div class="text-center">
                            <p class="text-sm text-gray-600">Grade</p>
                            <p class="text-2xl font-bold text-{{ $selectedResult->getPerformanceColor() }}-600">{{ $selectedResult->getPerformanceGrade() }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-sm text-gray-600">Date</p>
                            <p class="text-lg font-medium text-gray-900">{{ $selectedResult->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                    
                    <div class="text-sm text-gray-600">
                        <p>Certificate ID: {{ $selectedResult->certificate_id ?: 'Not generated yet' }}</p>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 mt-6">
                    <button wire:click="downloadCertificate({{ $selectedResult->id }})" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                        Download PDF
                    </button>
                    <button wire:click="shareResult({{ $selectedResult->id }})" class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700">
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
