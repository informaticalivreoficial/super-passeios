{{--
    MINI CALENDÁRIO DE DATAS DISPONÍVEIS
    Dependências: Alpine.js (já incluso via Livewire), Tailwind CSS
    Dados esperados: $dates (collection de TourDate com campos: date (Carbon), start_time, end_time, price, available_slots)
    Uso: inclua na sidebar do tour, substituindo o @forelse de datas
--}}

@php
    // Agrupa as datas por "YYYY-MM" para navegação mensal
    $datesByMonth = $dates->groupBy(fn($d) => $d->date->format('Y-m'));
    $monthKeys    = $datesByMonth->keys()->sort()->values(); // ex: ["2025-06", "2025-07"]

    // Passa para o Alpine como JSON
    $calendarData = $datesByMonth->map(fn($group) =>
        $group->map(fn($d) => [
            'day'            => (int) $d->date->format('j'),
            'date_label'     => $d->date->translatedFormat('D, d \d\e M'),  // "Sáb, 07 de Jun"
            'start_time'     => $d->start_time,
            'end_time'       => $d->end_time ?? null,
            'price'          => number_format($d->price, 2, ',', '.'),
            'available_slots'=> $d->available_slots,
            'low_stock'      => $d->available_slots <= 4,
            'booking_url' => route('checkout', $d->id),  // substitua pela rota de reserva
        ])->keyBy('day')
    )->toJson();

    $monthLabels = $monthKeys->mapWithKeys(fn($ym) => [
        $ym => \Carbon\Carbon::createFromFormat('Y-m', $ym)->translatedFormat('F Y')
    ])->toJson();

    // Dia da semana do primeiro dia de cada mês (0 = Dom, 6 = Sáb)
    $firstWeekdays = $monthKeys->mapWithKeys(fn($ym) => [
        $ym => (int) \Carbon\Carbon::createFromFormat('Y-m', $ym)->startOfMonth()->dayOfWeek
    ])->toJson();

    // Dias totais por mês
    $daysInMonth = $monthKeys->mapWithKeys(fn($ym) => [
        $ym => (int) \Carbon\Carbon::createFromFormat('Y-m', $ym)->daysInMonth
    ])->toJson();

    $todayStr = now()->format('Y-m-d');
@endphp

<div
    x-data="tourCalendar({{ $calendarData }}, {{ $monthLabels }}, {{ $firstWeekdays }}, {{ $daysInMonth }}, '{{ $monthKeys->first() }}')"
    x-init="init()"
    class="bg-white rounded-2xl overflow-hidden"
    style="border: 1px solid #e8e4d8; box-shadow: 0 8px 40px rgba(5,30,52,0.08);"
>

    {{-- Preço --}}
    <div class="p-6" style="border-bottom: 1px solid #f0ece4;">
        <p class="text-xs mb-1" style="color: #87c2c0;">A partir de</p>
        <p class="font-display font-800 text-3xl" style="font-family: 'Syne', sans-serif; color: var(--navy);">
            R$ {{ number_format($tour->price, 2, ',', '.') }}
        </p>
        <p class="text-xs mt-1" style="color: #87c2c0;">por pessoa</p>
    </div>

    <div class="p-5">

        {{-- Cabeçalho do calendário: mês + navegação --}}
        <div class="flex items-center justify-between mb-4">
            <button
                @click="prevMonth()"
                :disabled="!hasPrev()"
                :class="hasPrev() ? 'hover:bg-gray-100 cursor-pointer' : 'opacity-30 cursor-not-allowed'"
                class="w-8 h-8 rounded-lg flex items-center justify-center transition"
                style="border: 1px solid #e8e4d8;"
                aria-label="Mês anterior"
            >
                <svg class="w-4 h-4" style="color: var(--navy);" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6"/></svg>
            </button>

            <span class="text-sm font-600 capitalize" style="font-family: 'Syne', sans-serif; color: var(--navy);" x-text="currentMonthLabel()"></span>

            <button
                @click="nextMonth()"
                :disabled="!hasNext()"
                :class="hasNext() ? 'hover:bg-gray-100 cursor-pointer' : 'opacity-30 cursor-not-allowed'"
                class="w-8 h-8 rounded-lg flex items-center justify-center transition"
                style="border: 1px solid #e8e4d8;"
                aria-label="Próximo mês"
            >
                <svg class="w-4 h-4" style="color: var(--navy);" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
            </button>
        </div>

        {{-- Dias da semana --}}
        <div class="grid grid-cols-7 mb-1">
            @foreach(['D','S','T','Q','Q','S','S'] as $dow)
                <div class="text-center text-xs pb-2" style="color: #b0bcc8; font-family: 'Syne', sans-serif;">{{ $dow }}</div>
            @endforeach
        </div>

        {{-- Grade de dias --}}
        <div class="grid grid-cols-7 gap-y-1">
            <template x-for="cell in calendarCells()" :key="cell.key">
                <div class="flex justify-center">
                    {{-- Célula vazia (offset) --}}
                    <div x-show="cell.empty" class="w-8 h-8"></div>

                    {{-- Dia com passeio --}}
                    <button
                        x-show="!cell.empty && cell.hasTour"
                        @click="selectDay(cell.day)"
                        :class="selectedDay === cell.day ? 'selected-day' : 'available-day'"
                        class="w-8 h-8 rounded-lg text-sm font-600 transition-all duration-150 relative"
                        style="font-family: 'Syne', sans-serif;"
                        :aria-label="`Selecionar dia ${cell.day}`"
                    >
                        <span x-text="cell.day"></span>
                        {{-- Pontinho indicador --}}
                        <span
                            x-show="selectedDay !== cell.day"
                            class="absolute bottom-1 left-1/2 -translate-x-1/2 w-1 h-1 rounded-full"
                            :class="cell.lowStock ? 'bg-amber-400' : 'bg-teal-400'"
                        ></span>
                    </button>

                    {{-- Dia sem passeio --}}
                    <div
                        x-show="!cell.empty && !cell.hasTour"
                        class="w-8 h-8 rounded-lg flex items-center justify-center text-sm"
                        style="color: #d0d5dd;"
                        x-text="cell.day"
                    ></div>
                </div>
            </template>
        </div>

        {{-- Legenda --}}
        <div class="flex items-center gap-4 mt-3 mb-4">
            <span class="flex items-center gap-1.5 text-xs" style="color: #87c2c0;">
                <span class="w-2 h-2 rounded-full bg-teal-400 inline-block"></span> Disponível
            </span>
            <span class="flex items-center gap-1.5 text-xs" style="color: #87c2c0;">
                <span class="w-2 h-2 rounded-full bg-amber-400 inline-block"></span> Últimas vagas
            </span>
        </div>

        {{-- Detalhe da data selecionada --}}
        <div
            x-show="selectedDay !== null"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-1"
            x-transition:enter-end="opacity-100 translate-y-0"
            class="rounded-xl p-4 mb-4"
            style="background: #f4f9f9; border: 1px solid #c8e8e6;"
        >
            <p class="text-xs font-600 uppercase mb-3" style="color: #87c2c0; font-family: 'Syne', sans-serif; letter-spacing: 0.05em;">Data selecionada</p>

            <p class="text-sm font-700 mb-3 capitalize" style="font-family: 'Syne', sans-serif; color: var(--navy);" x-text="selectedData()?.date_label"></p>

            <div class="space-y-1.5">
                <div class="flex items-center justify-between text-sm">
                    <span class="flex items-center gap-2" style="color: #87c2c0;">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                        Horário
                    </span>
                    <span class="font-600" style="color: var(--navy); font-family: 'Syne', sans-serif;">
                        <span x-text="selectedData()?.start_time"></span>
                        <template x-if="selectedData()?.end_time">
                            <span> — <span x-text="selectedData()?.end_time"></span></span>
                        </template>
                    </span>
                </div>

                <div class="flex items-center justify-between text-sm">
                    <span class="flex items-center gap-2" style="color: #87c2c0;">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                        Preço
                    </span>
                    <span class="font-700" style="color: var(--navy); font-family: 'Syne', sans-serif;">
                        R$ <span x-text="selectedData()?.price"></span>
                    </span>
                </div>

                <div class="flex items-center justify-between text-sm">
                    <span class="flex items-center gap-2" style="color: #87c2c0;">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                        Vagas
                    </span>
                    <span
                        class="font-600 text-xs px-2 py-0.5 rounded-full"
                        :class="selectedData()?.low_stock
                            ? 'bg-amber-50 text-amber-700 border border-amber-200'
                            : 'bg-teal-50 text-teal-700 border border-teal-200'"
                        style="font-family: 'Syne', sans-serif;"
                    >
                        <span x-text="selectedData()?.available_slots"></span>
                        <span x-text="selectedData()?.low_stock ? ' — últimas!' : ' disponíveis'"></span>
                    </span>
                </div>
            </div>
        </div>

        {{-- Placeholder quando nenhum dia selecionado --}}
        <div
            x-show="selectedDay === null"
            class="rounded-xl p-4 mb-4 text-center"
            style="background: #f8f6f2; border: 1px dashed #d4cfc3;"
        >
            <svg class="w-6 h-6 mx-auto mb-2" style="color: #d4cfc3;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
            <p class="text-xs" style="color: #b0bcc8;">Selecione um dia disponível no calendário</p>
        </div>

        {{-- Botão de reserva --}}
        <a
            :href="selectedData()?.booking_url ?? '#'"
            :class="selectedDay ? 'opacity-100 cursor-pointer' : 'opacity-40 pointer-events-none'"
            class="btn-primary w-full justify-center py-3 transition-opacity duration-200"
        >
            Reservar agora
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>

    </div>
</div>

{{-- Alpine.js component --}}
@once
@push('scripts')
<script>
function tourCalendar(data, labels, firstWeekdays, daysInMonth, initialMonth) {
    return {
        data,           // { "2025-06": { 7: {...}, 14: {...} }, ... }
        labels,         // { "2025-06": "junho 2025", ... }
        firstWeekdays,  // { "2025-06": 6, ... }  (0=Dom)
        daysInMonth,    // { "2025-06": 30, ... }
        monthKeys: Object.keys(labels).sort(),
        currentMonthIndex: 0,
        selectedDay: null,

        init() {
            this.currentMonthIndex = this.monthKeys.indexOf(initialMonth);
        },

        get currentMonth() {
            return this.monthKeys[this.currentMonthIndex];
        },

        currentMonthLabel() {
            return this.labels[this.currentMonth];
        },

        hasPrev() { return this.currentMonthIndex > 0; },
        hasNext() { return this.currentMonthIndex < this.monthKeys.length - 1; },

        prevMonth() {
            if (this.hasPrev()) {
                this.currentMonthIndex--;
                this.selectedDay = null;
            }
        },

        nextMonth() {
            if (this.hasNext()) {
                this.currentMonthIndex++;
                this.selectedDay = null;
            }
        },

        calendarCells() {
            const month     = this.currentMonth;
            const offset    = this.firstWeekdays[month];  // células vazias no início
            const total     = this.daysInMonth[month];
            const monthData = this.data[month] || {};
            const cells     = [];

            // células de offset
            for (let i = 0; i < offset; i++) {
                cells.push({ key: `e${i}`, empty: true });
            }

            // dias do mês
            for (let d = 1; d <= total; d++) {
                const info = monthData[d] || null;
                cells.push({
                    key:      `d${d}`,
                    empty:    false,
                    day:      d,
                    hasTour:  !!info,
                    lowStock: info?.low_stock ?? false,
                });
            }

            return cells;
        },

        selectDay(day) {
            this.selectedDay = this.selectedDay === day ? null : day;
        },

        selectedData() {
            if (!this.selectedDay) return null;
            return (this.data[this.currentMonth] || {})[this.selectedDay] ?? null;
        },
    };
}
</script>
@endpush
@endonce

{{-- Estilos locais do calendário --}}
@once
    @push('styles')
    <style>
    .available-day {
        background: rgba(22, 163, 183, 0.10);
        color: #0f6e56;
    }
    .available-day:hover {
        background: rgba(22, 163, 183, 0.22);
    }
    .selected-day {
        background: var(--navy, #051e34);
        color: #ffffff;
    }
    </style>
    @endpush
@endonce