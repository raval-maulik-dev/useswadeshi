<div>
    @section('title', __('messages.products_title') . ' - ' . __('messages.swadeshi_abhiyan'))
    
    <div class="min-h-screen bg-gradient-to-br from-orange-50 via-white to-green-50 py-12">
        <div class="max-w-7xl mx-auto px-4">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-6xl font-bold mb-6 bg-clip-text text-transparent bg-gradient-to-r from-orange-600 via-red-600 to-green-600">
                    {{ __('messages.local_products') }}
                </h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    {{ __('messages.discover_indian_products') }}
                </p>
            </div>

            <!-- Filters -->
            <div class="bg-white/80 backdrop-blur-md rounded-2xl p-6 shadow-lg border border-orange-100 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.search') }}</label>
                        <input wire:model.live="search" type="text" placeholder="{{ __('messages.search_products_placeholder') }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.category') }}</label>
                        <select wire:model.live="selectedCategory" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <option value="">{{ __('messages.all_categories') }}</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.brand') }}</label>
                        <select wire:model.live="selectedBrand" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <option value="">{{ __('messages.all_brands') }}</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.sort_by') }}</label>
                        <select wire:model.live="sortBy" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <option value="name">{{ __('messages.name') }}</option>
                            <option value="price">{{ __('messages.price') }}</option>
                            <option value="created_at">{{ __('messages.newest') }}</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($products as $product)
                <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-orange-100 overflow-hidden">
                    <!-- Product Image -->
                    <div class="h-48 bg-gradient-to-br from-orange-100 to-red-100 flex items-center justify-center">
                        <svg class="w-16 h-16 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    
                    <!-- Product Info -->
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs bg-orange-100 text-orange-700 px-2 py-1 rounded-full font-semibold">
                                {{ $product->product_type }}
                            </span>
                            <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full font-semibold">
                                {{ $product->brand->name ?? __('messages.local') }}
                            </span>
                        </div>
                        
                        <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $product->name }}</h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $product->description }}</p>
                        
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-orange-600">₹{{ number_format($product->price ?? 0) }}</div>
                            <button class="bg-gradient-to-r from-orange-500 to-red-600 text-white px-4 py-2 rounded-lg font-semibold hover:from-orange-600 hover:to-red-700 transition-all">
                                {{ __('messages.view_details') }}
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $products->links() }}
            </div>
            @endif

            <!-- Navigation -->
            <div class="text-center mt-8">
                <a href="{{ route('home') }}" 
                   class="bg-gradient-to-r from-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700 text-white px-8 py-4 rounded-xl font-bold text-lg transition-all duration-300 shadow-lg hover:shadow-xl">
                    🏠 {{ __('messages.back_to_home') }}
                </a>
            </div>
        </div>
    </div>
</div>
