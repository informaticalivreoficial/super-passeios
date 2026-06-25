@foreach($companies as $company)
    <div class="group bg-white rounded-2xl overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1"
         style="border: 1px solid #e8e4d8;">

        <a href="{{ route('web.site.company', $company->slug) }}" class="block">
            <div class="relative h-48 overflow-hidden bg-gray-100">
                @php
                    $cover = $company->images->firstWhere('cover', true) ?? $company->images->first();
                @endphp

                @if($cover)
                    <img src="{{ Storage::url($cover->path) }}"
                         alt="{{ $company->alias_name }}"
                         class="w-full h-full object-cover transition duration-500 group-hover:scale-105"
                         loading="lazy">
                @else
                    <div class="w-full h-full flex items-center justify-center" style="background: linear-gradient(135deg, var(--navy) 0%, #0a3358 100%);">
                        <svg class="w-16 h-16 opacity-20" fill="none" stroke="white" stroke-width="1.5" viewBox="0 0 24 24">
                            <path d="M3 17l4-8 4 4 4-6 4 10"/>
                        </svg>
                    </div>
                @endif

                @if($company->active_tours_count > 0)
                    <div class="absolute top-3 right-3">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full backdrop-blur-sm"
                              style="background: rgba(135,194,192,0.95); color: white;">
                            {{ $company->active_tours_count }} {{ Str::plural('passeio', $company->active_tours_count) }}
                        </span>
                    </div>
                @endif
            </div>
        </a>

        <div class="p-5 flex flex-col">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-12 h-12 rounded-xl overflow-hidden shrink-0 border" style="border-color: #e8e4d8;">
                    <img src="{{ $company->getLogoUrl() }}"
                         alt="{{ $company->alias_name }}"
                         class="w-full h-full object-cover">
                </div>

                <div class="overflow-hidden flex-1">
                    <a href="{{ route('web.site.company', $company->slug) }}" class="hover:opacity-70 transition">
                        <h2 class="font-display font-700 text-base truncate" style="font-family: 'Syne', sans-serif; color: var(--navy);">
                            {{ $company->alias_name }}
                        </h2>
                    </a>
                    @if($company->city)
                        <div class="flex items-center gap-1 text-xs truncate" style="color: #87c2c0;">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{ $company->city }}, {{ $company->state }}
                        </div>
                    @endif
                </div>
            </div>

            @if($company->information)
                <p class="text-sm leading-relaxed line-clamp-2 mb-4 flex-1" style="color: #87c2c0;">
                    {{ Str::limit($company->information, 120) }}
                </p>
            @endif

            <div class="flex flex-wrap items-center gap-4 pt-4" style="border-top: 1px solid #f0ece4;">
                <div class="flex items-center gap-4">
                    <span class="flex items-center gap-1.5 text-xs" style="color: #87c2c0;">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        {{ number_format($company->views, 0, ',', '.') }}
                    </span>

                    @if($company->bookings_count > 0)
                        <span class="flex items-center gap-1.5 text-xs" style="color: #87c2c0;">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            {{ number_format($company->bookings_count, 0, ',', '.') }}
                        </span>
                    @endif
                </div>

                <a href="{{ route('web.site.company', $company->slug) }}"
                   class="ml-auto flex items-center gap-1 text-xs font-semibold transition"
                   style="color: var(--teal);">
                    Ver empresa
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
@endforeach