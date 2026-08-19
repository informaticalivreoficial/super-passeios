<?php

namespace App\Livewire\Dashboard\Reports;

use App\Models\Post;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Posts extends Component
{
    use WithPagination;

    public $period = '30';

    public $type = 'all';

    public $search = '';

    public $totalPosts = 0;

    public $totalArtigos = 0;

    public $totalNoticias = 0;

    public $totalViews = 0;

    public array $labels = [];

    public array $data = [];

    public function mount()
    {
        $this->loadData();
    }

    public function updatedPeriod(): void
    {
        $this->loadData();
    }

    public function updatedType(): void
    {
        $this->loadData();
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function loadData()
    {
        $startDate = now()->subDays((int) $this->period)->startOfDay();
        $endDate   = now()->endOfDay();

        $baseQuery = Post::whereBetween('created_at', [$startDate, $endDate]);

        $this->totalPosts    = (clone $baseQuery)->count();
        $this->totalArtigos  = (clone $baseQuery)->where('type', 'artigo')->count();
        $this->totalNoticias = (clone $baseQuery)->where('type', 'noticia')->count();
        $this->totalViews    = (clone $baseQuery)->sum('views');

        $posts = (clone $baseQuery)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupByRaw('DATE(created_at)')
            ->orderBy('date')
            ->get();

        $this->labels = $posts->pluck('date')
            ->map(fn ($d) => Carbon::parse($d)->format('d/m'))
            ->values()
            ->all();

        $this->data = $posts->pluck('total')->values()->all();

        $this->dispatch('updateChart', [
            'labels' => $this->labels,
            'data'   => $this->data,
        ]);
    }

    public function render()
    {
        $startDate = now()->subDays((int) $this->period)->startOfDay();

        $posts = Post::query()
            ->when($this->search, fn ($q) => $q->where('title', 'like', "%{$this->search}%"))
            ->when($this->type !== 'all', fn ($q) => $q->where('type', $this->type))
            ->where('created_at', '>=', $startDate)
            ->latest()
            ->paginate(15);

        return view('livewire.dashboard.reports.posts', [
            'posts' => $posts,
        ])->with('title', 'Relatório de Posts');
    }
}