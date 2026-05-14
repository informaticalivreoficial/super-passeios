<?php

namespace App\Livewire\Company\Tours;

use App\Enums\TourDateStatusEnum;
use App\Models\Tour;
use App\Models\TourDate;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class TourDates extends Component
{
    use WithPagination;

    public Tour $tour;

    public $date;
    public $start_time;
    public $end_time;
    public $available_slots;
    public $active = true;
    public $price;

    public ?string $status = null;

    public ?int $editingId = null;
    public ?int $delete_id = null;

    public bool $showModal = false;

    public string $calendarMonth;

    public function mount(Tour $tour)
    {
        $this->tour = $tour;

        $this->calendarMonth = now()->format('Y-m');

        $this->available_slots = $tour->vessel?->capacity ?? 0;

        $this->price = $tour->price ?? 0;

        $this->status = TourDateStatusEnum::OPEN->value;
    }

    protected function rules(): array
    {
        return [

            'date' => [
                'required',
                'date'
            ],

            'price' => [
                'required',
                'numeric',
                'min:0'
            ],

            'start_time' => [
                'required'
            ],

            'end_time' => [
                'nullable'
            ],

            'available_slots' => [
                'required',
                'integer',
                'min:1',
                'max:' . ($this->tour->vessel?->capacity ?? 9999),
            ],

            'active' => [
                'boolean'
            ],

            'status' => [
                'required'
            ],
        ];
    }

    public function setMonth(string $month): void
    {
        if ($this->calendarMonth === $month) {
            return; // ✅ não faz nada se o mês não mudou
        }

        $this->calendarMonth = $month;
        $this->resetPage();
    }

    public function createDate($date = null): void
    {
        $this->resetForm();

        $this->date = $date;

        $this->showModal = true;

        $this->dispatch(
            'tour-date-edit',
            date: $this->date,
            start_time: $this->start_time,
            end_time: $this->end_time,
        );
    }

    public function save(): void
    {
        $this->validate();

        // UPDATE
        if ($this->editingId) {

            $date = TourDate::findOrFail(
                $this->editingId
            );

            $this->authorize('update', $date);

            //dd($this->available_slots, $date->available_slots);

            $date->update([

                'date' => $this->date,

                'start_time' => $this->start_time,

                'end_time' => $this->end_time,

                'available_slots' => $this->available_slots,

                'price' => $this->price,

                'active' => $this->active,

                'status' => $this->status,
            ]);

            $this->dispatch(
                'swal:success',
                [
                    'title' => 'Sucesso',
                    'text' => 'Data atualizada com sucesso.',
                ]
            );

        } else {

            // CREATE
            TourDate::create([

                'tour_id' => $this->tour->id,

                'date' => $this->date,

                'start_time' => $this->start_time,

                'end_time' => $this->end_time,

                'available_slots' => $this->available_slots,

                'price' => $this->price,

                'active' => $this->active,

                'status' => $this->status,
            ]);

            $this->dispatch(
                'swal:success',
                [
                    'title' => 'Sucesso',
                    'text' => 'Data cadastrada com sucesso.',
                ]
            );
        }

        $this->refreshCalendar();

        $this->resetForm();
    }

    public function edit($id): void
    {
        $date = TourDate::findOrFail($id);

        $this->authorize('update', $date);

        $this->editingId = $date->id;

        $this->date = $date->date->format('Y-m-d');

        $this->start_time = substr($date->start_time, 0, 5);

        $this->end_time = substr($date->end_time ?? '', 0, 5);

        $this->available_slots = $date->available_slots;

        $this->price =
            $date->price;

        $this->active =
            $date->active;

        $this->status =
            $date->status->value;

        $this->showModal = true;

        $this->dispatch(
            'tour-date-edit',
            date: $this->date,
            start_time: $this->start_time,
            end_time: $this->end_time,
        );
    }

    public function resetForm(): void
    {
        $this->reset([

            'editingId',

            'date',

            'start_time',

            'end_time',

            'available_slots',

            'price',

            'active',

            'status',
        ]);

        $this->available_slots =
            $this->tour->vessel?->capacity ?? 0;

        $this->price =
            $this->tour->price ?? 0;

        $this->active = true;

        $this->status =
            TourDateStatusEnum::OPEN->value;

        $this->showModal = false;

        $this->dispatch(
            'tour-date-reset'
        );
    }

    public function setDeleteId($id): void
    {
        $this->dispatch(
            'swal:confirm',
            [
                'title' => 'Excluir Data?',
                'text' => 'Essa ação não pode ser desfeita.',
                'icon' => 'warning',
                'confirmButtonText' => 'Sim, excluir',
                'cancelButtonText' => 'Cancelar',
                'confirmEvent' => 'deleteData',
                'confirmParams' => [$id],
            ]
        );
    }

    #[On('deleteData')]
    public function deleteData($id): void
    {
        try {

            $date = TourDate::findOrFail($id);

            $this->authorize('delete', $date);

            $date->delete();            

            $this->dispatch(
                'swal:success',
                [
                    'title' => 'Excluído!',
                    'text' => 'Data removida com sucesso!',
                    'timer' => 2000,
                    'showConfirmButton' => false
                ]
            );

            $this->refreshCalendar();

        } catch (\Exception $e) {

            $this->dispatch(
                'swal:error',
                [
                    'title' => 'Erro!',
                    'text' => 'Não foi possível excluir a data.',
                ]
            );
        }
    }

    public function toggle($id): void
    {
        $date = TourDate::findOrFail($id);

        $this->authorize('update', $date);

        $date->update([
            'active' => !$date->active
        ]);

        $this->refreshCalendar();
    }

    public function refreshCalendar(): void
    {
        $this->tour->unsetRelation('dates'); // ✅ limpa o cache da relação

        $this->dispatch(
            'refresh-calendar',
            events: $this->calendarEvents()
        );
    }

    public function calendarEvents()
    {
        return $this->tour
            ->dates()
            ->select([
                'id',
                'date',
                'start_time',
                'end_time',  // ✅
                'status',
                'available_slots',
            ])
            ->get()
            ->map(function ($item) {

                return [

                    'id' => $item->id,

                    'title' => match ($item->status) {

                        TourDateStatusEnum::OPEN =>
                            $item->start_time
                            . ($item->end_time ? ' - ' . $item->end_time : '')
                            . ' · ' . $item->available_slots . ' vagas',

                        TourDateStatusEnum::BLOCKED =>
                            'Bloqueado',

                        TourDateStatusEnum::FULL =>
                            'Lotado · ' . $item->available_slots . ' vagas',

                        TourDateStatusEnum::CANCELLED =>
                            'Cancelado',
                    },

                    'start' => $item->date->format('Y-m-d'),

                    'backgroundColor' => $item->status->hex(),

                    'borderColor' => $item->status->hex(),
                ];
            })
            ->values();
    }

    #[Layout('components.layouts.company')]
    public function render()
    {
        [$year, $month] = explode('-', $this->calendarMonth);

        $dates = $this->tour
            ->dates()
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->orderBy('date')
            ->paginate(15);

        //dd($dates->total(), $dates->pluck('date')); // verifica quantos registros retornam

        return view('livewire.company.tours.tour-dates', compact('dates'));
    }
}