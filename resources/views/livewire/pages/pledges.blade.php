<div>
    @section('title', 'Pledges - Swadeshi Abhiyan')
    
    <div class="min-h-screen bg-gradient-to-br from-orange-50 via-white to-green-50 py-12">
        <div class="max-w-7xl mx-auto px-4">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-6xl font-bold mb-6 bg-clip-text text-transparent bg-gradient-to-r from-orange-600 via-red-600 to-green-600">
                    Make a Pledge
                </h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Commit to supporting local products and businesses
                </p>
            </div>

            <!-- Create Pledge -->
            <div class="bg-white/80 backdrop-blur-md rounded-2xl p-8 shadow-lg border border-orange-100 mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Create Your Pledge</h2>
                
                <form wire:submit.prevent="createPledge">
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Your Pledge</label>
                        <textarea wire:model="pledgeText" rows="4" 
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                  placeholder="I pledge to support local products by..."></textarea>
                        @error('pledgeText') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Select Products to Support</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($products as $product)
                            <label class="flex items-center space-x-3 p-4 border border-gray-200 rounded-lg hover:bg-orange-50 cursor-pointer">
                                <input type="checkbox" wire:model="selectedProducts" value="{{ $product->id }}" class="text-orange-600">
                                <span class="font-medium text-gray-800">{{ $product->name }}</span>
                            </label>
                            @endforeach
                        </div>
                        @error('selectedProducts') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" 
                            class="bg-gradient-to-r from-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700 text-white px-8 py-4 rounded-xl font-bold text-lg transition-all duration-300 shadow-lg hover:shadow-xl">
                        🤝 Make Pledge
                    </button>
                </form>
            </div>

            <!-- User Pledges -->
            <div class="bg-white/80 backdrop-blur-md rounded-2xl p-8 shadow-lg border border-orange-100 mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Your Pledges</h2>
                <div class="space-y-4">
                    @foreach($userPledges as $pledge)
                    <div class="bg-orange-50 rounded-xl p-6 border border-orange-200">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <p class="text-gray-800 mb-2">{{ $pledge->pledge_text }}</p>
                                <div class="text-sm text-gray-600">{{ $pledge->created_at->format('M d, Y') }}</div>
                            </div>
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">
                                {{ $pledge->status }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- All Pledges -->
            <div class="bg-white/60 backdrop-blur-sm rounded-2xl p-8 border border-orange-100 mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Community Pledges</h2>
                <div class="space-y-4">
                    @foreach($allPledges as $pledge)
                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <p class="text-gray-800 mb-2">{{ $pledge->pledge_text }}</p>
                                <div class="text-sm text-gray-600">
                                    By {{ $pledge->user->name }} • {{ $pledge->created_at->format('M d, Y') }}
                                </div>
                            </div>
                            <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-sm font-semibold">
                                {{ $pledge->status }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Navigation -->
            <div class="text-center">
                <a href="{{ route('home') }}" 
                   class="bg-gradient-to-r from-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700 text-white px-8 py-4 rounded-xl font-bold text-lg transition-all duration-300 shadow-lg hover:shadow-xl">
                    🏠 Back to Home
                </a>
            </div>
        </div>
    </div>
</div>

