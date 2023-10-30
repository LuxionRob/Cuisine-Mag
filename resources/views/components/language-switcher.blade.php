<div class="flex justify-center items-center">
    <x-dropdown align="right" width="48">
        <x-slot name="trigger">
            <button class="flex items-center justify-end">
                <div class="w-32 scale-50 flex items-center">
                    @if ($current_locale === 'vi')
                        <svg xmlns="http://www.w3.org/2000/svg" width="100" height="66.6" viewBox="0 0 30 20"
                            version="1.1">
                            <rect width="30" height="20" fill="#da251d" />
                            <polygon points="15,4 11.47,14.85 20.71,8.15 9.29,8.15 18.53,14.85" fill="#ff0" />
                        </svg>
                    @elseif ($current_locale === 'en')
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 30" width="100" height="60">
                            <clipPath id="t">
                                <path d="M25,15h25v15zv15h-25zh-25v-15zv-15h25z" />
                            </clipPath>
                            <path d="M0,0v30h50v-30z" fill="#012169" />
                            <path d="M0,0 50,30M50,0 0,30" stroke="#fff" stroke-width="6" />
                            <path d="M0,0 50,30M50,0 0,30" clip-path="url(#t)" stroke="#C8102E" stroke-width="4" />
                            <path d="M-1 11h22v-12h8v12h22v8h-22v12h-8v-12h-22z" fill="#C8102E" stroke="#FFF"
                                stroke-width="2" />
                        </svg>
                    @endif
                    <svg class="h-4 w-4 fill-current scale-[2] ml-4" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </div>

            </button>
        </x-slot>
        <x-slot name="content">
            @foreach ($available_locales as $locale_name => $available_locale)
                <x-dropdown-link class="-mt-2" href="{{ route('changeLanguage', $available_locale) }}">
                    {{ __($locale_name) }}
                </x-dropdown-link>
            @endforeach
        </x-slot>
    </x-dropdown>
</div>
