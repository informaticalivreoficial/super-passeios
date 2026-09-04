@foreach($tours as $tour)
    <a href="{{ route('web.site.tour', [$tour->company->slug, $tour->uuid]) }}"
        class="group bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 border border-blue-50"
    >
        <div class="relative h-48 overflow-hidden">
            <img
                src="{{ $tour->cover() }}"
                alt="{{ $tour->title }}"
                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                loading="lazy"
            >

            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

            @if($tour->tour_type)
                <div class="absolute top-3 left-3">
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-md">
                        {{ $tour->tour_type->label() }}
                    </span>
                </div>
            @endif

            <div class="absolute bottom-3 left-3">
                <span class="text-sm  px-3 py-1.5 rounded-xl bg-gradient-to-r from-amber-400 to-yellow-500 text-gray-900 shadow-lg">
                    R$ {{ number_format($tour->price, 2, ',', '.') }}
                </span>
            </div>

            <div class="absolute top-3 right-3">
                <span class="text-xs px-2.5 py-1.5 rounded-lg flex items-center gap-1 bg-black/50 backdrop-blur text-white font-medium">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                    </svg>
                    {{ number_format($tour->views) }}
                </span>
            </div>
        </div>

        <div class="p-5">
            <p class="text-xs font-bold mb-2 flex items-center gap-1 text-blue-600">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/>
                </svg>
                {{ $tour->company->city }}, {{ $tour->company->state }}
            </p>
            
            <h3 class="text-lg  leading-tight mb-4 text-gray-800 group-hover:text-blue-600 transition-colors duration-300">
                {{ $tour->title }}
            </h3>
            
            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                <div class="flex items-center gap-2">
                    @if($tour->company->logo)
                        <img src="{{ $tour->company->getLogoUrl() }}" 
                            class="w-7 h-7 rounded-lg object-cover ring-2 ring-blue-100" 
                            alt="{{ $tour->company->alias_name }}">
                    @endif
                    <span class="text-xs font-semibold text-gray-500 truncate max-w-[120px]">
                        {{ $tour->company->alias_name }}
                    </span>
                </div>
                
                @if($tour->duration)
                    <span class="text-xs font-bold flex items-center gap-1 text-blue-600 bg-blue-50 px-2 py-1 rounded-lg">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
                        </svg>
                        {{ $tour->duration }}
                    </span>
                @endif
            </div>
        </div>
    </a>
@endforeach
