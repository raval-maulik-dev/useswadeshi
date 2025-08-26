<div class="space-y-4 p-4 bg-gray-50 rounded-lg border">
    <div class="text-sm font-medium text-gray-700 mb-2">Question Preview</div>
    
    @if($question)
        <div class="bg-white p-4 rounded-lg border shadow-sm">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ $question }}</h3>
            
            @if($type)
                <div class="mb-3">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                        @if($type === 'mcq') bg-blue-100 text-blue-800
                        @elseif($type === 'multi_select') bg-purple-100 text-purple-800
                        @else bg-green-100 text-green-800
                        @endif">
                        {{ ucfirst(str_replace('_', ' ', $type)) }}
                    </span>
                </div>
            @endif
            
            @if($options && count($options) > 0)
                <div class="space-y-2">
                    @foreach($options as $index => $option)
                        @if($option['option_text'] || $option['optionable_id'])
                            <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg border-l-4 
                                @if($option['is_correct'] ?? false) border-green-500 bg-green-50
                                @else border-gray-300
                                @endif">
                                
                                @if($type === 'mcq')
                                    <input type="radio" name="preview_option" class="text-blue-600" disabled>
                                @elseif($type === 'multi_select')
                                    <input type="checkbox" class="text-purple-600" disabled>
                                @else
                                    <input type="radio" name="preview_option" class="text-green-600" disabled>
                                @endif
                                
                                <span class="text-sm text-gray-700">
                                    @if($option['option_text'])
                                        {{ $option['option_text'] }}
                                    @else
                                        <span class="text-gray-500 italic">
                                            @if($option['option_type'] === 'product')
                                                [Product: {{ $option['optionable_id'] ?? 'Selected' }}]
                                            @elseif($option['option_type'] === 'brand')
                                                [Brand: {{ $option['optionable_id'] ?? 'Selected' }}]
                                            @else
                                                [Option {{ $index + 1 }}]
                                            @endif
                                        </span>
                                    @endif
                                </span>
                                
                                @if($option['is_correct'] ?? false)
                                    <span class="ml-auto">
                                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </span>
                                @endif
                            </div>
                        @endif
                    @endforeach
                </div>
            @else
                <div class="text-gray-500 text-sm italic">No options added yet</div>
            @endif
        </div>
    @else
        <div class="text-gray-500 text-sm italic">Enter a question to see preview</div>
    @endif
</div>
