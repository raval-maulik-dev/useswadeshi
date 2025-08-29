<div class="relative inline-block text-left">
    <div>
        <button type="button" 
                class="inline-flex items-center justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500"
                id="language-menu-button"
                aria-expanded="true"
                aria-haspopup="true"
                wire:click="toggleDropdown">
            <span class="mr-2">{{ __('messages.language') }}</span>
            <span class="text-orange-600 font-semibold">{{ $availableLocales[$currentLocale] }}</span>
            <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
    </div>

    @if($showDropdown)
        <div class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50" 
             role="menu" 
             aria-orientation="vertical" 
             aria-labelledby="language-menu-button"
             tabindex="-1">
            <div class="py-1" role="none">
                @foreach($availableLocales as $locale => $name)
                    <button wire:click="switchLanguage('{{ $locale }}')"
                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 {{ $currentLocale === $locale ? 'bg-orange-50 text-orange-700' : '' }}"
                            role="menuitem"
                            tabindex="-1">
                        <div class="flex items-center">
                            <span class="flex-1">{{ $name }}</span>
                            @if($currentLocale === $locale)
                                <svg class="h-4 w-4 text-orange-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            @endif
                        </div>
                    </button>
                @endforeach
            </div>
        </div>
    @endif
</div>

<script>
    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const dropdown = document.querySelector('[wire\\:id*="language-switcher"]');
        const button = document.getElementById('language-menu-button');
        
        if (dropdown && !dropdown.contains(event.target) && !button.contains(event.target)) {
            window.Livewire.find(dropdown.getAttribute('wire:id')).set('showDropdown', false);
        }
    });
</script>
