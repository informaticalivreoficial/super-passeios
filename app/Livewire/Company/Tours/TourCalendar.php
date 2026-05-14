<?php

namespace App\Livewire\Company\Tours;

use App\Enums\TourDateStatusEnum;
use Livewire\Component;
use Livewire\Attributes\Layout;

class TourCalendar extends Component
{
    public function getEvents()
    {
        return $this->tour
            ->dates()
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,

                    'title' => $item->available_slots . ' vagas',

                    'start' => $item->date->format('Y-m-d'),

                    'color' => match($item->status) {
                        'OPEN' => '#22c55e',
                        'BLOCKED' => '#ef4444',
                        'FULL' => '#f59e0b',
                        default => '#64748b',
                    },
                ];
            });
    }

    public function getCalendarEvents()
    {
        return $this->tour
            ->dates()
            ->get()
            ->map(function ($item) {

                return [

                    'id' => $item->id,

                    'title' => match($item->status) {

                        TourDateStatusEnum::OPEN =>
                            $item->available_slots . ' vagas',

                        TourDateStatusEnum::BLOCKED =>
                            'Bloqueado',

                        TourDateStatusEnum::FULL =>
                            'Lotado',

                        TourDateStatusEnum::CANCELLED =>
                            'Cancelado',
                    },

                    'start' => $item->date->format('Y-m-d'),

                    'backgroundColor' => $item->status->hex(),

                    'borderColor' => $item->status->hex(),
                ];
            });
    }

    #[Layout('components.layouts.company')]
    public function render()
    {
        return view('livewire.company.tours.tour-calendar');
    }
}
