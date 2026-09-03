<?php

namespace App\Livewire\Dashboard\Newsletter;

use App\Livewire\Concerns\WithSafeSorting;
use App\Models\Newsletter;
use App\Models\NewsletterCategory;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Newsletters extends Component
{
    use WithPagination, WithSafeSorting;

    protected $paginationTheme = 'bootstrap';

    public string $search = '';

    public string $statusFilter = '';

    public string $confirmedFilter = '';

    public string $categoryFilter = '';

    #[Locked]
    public string $sortField = 'created_at';

    #[Locked]
    public string $sortDirection = 'desc';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }

    public function updatedConfirmedFilter(): void
    {
        $this->resetPage();
    }

    public function updatedCategoryFilter(): void
    {
        $this->resetPage();
    }

    protected function sortableFields(): array
    {
        return ['email', 'name', 'created_at', 'confirmed_at'];
    }

    protected function defaultSortField(): string
    {
        return 'created_at';
    }

    public function toggleStatus(int $id): void
    {
        $newsletter = Newsletter::findOrFail($id);
        $newsletter->active = !$newsletter->active;
        $newsletter->save();

        $this->dispatch('swal:success', [
            'title' => 'Atualizado!',
            'text' => $newsletter->active ? 'Inscrição ativada.' : 'Inscrição desativada.',
            'timer' => 2000,
            'showConfirmButton' => false,
        ]);
    }

    public function setDeleteId(int $id): void
    {
        $this->dispatch('swal:confirm', [
            'title' => 'Excluir e-mail?',
            'text' => 'Essa ação não pode ser desfeita.',
            'showConfirmButton' => false,
            'icon' => 'warning',
            'confirmButtonText' => 'Sim, excluir',
            'cancelButtonText' => 'Cancelar',
            'confirmEvent' => 'deleteNewsletter',
            'confirmParams' => [$id],
        ]);
    }

    #[On('newsletter-imported')]
    public function refreshAfterImport(): void
    {
        //
    }

    #[On('deleteNewsletter')]
    public function deleteNewsletter(int $id): void
    {
        try {
            Newsletter::findOrFail($id)->delete();

            $this->dispatch('swal:success', [
                'title' => 'Excluído!',
                'text' => 'E-mail removido da newsletter.',
                'timer' => 2000,
                'showConfirmButton' => false,
            ]);
        } catch (\Exception $e) {
            $this->dispatch('swal:error', [
                'title' => 'Erro!',
                'icon' => 'error',
                'text' => 'Não foi possível excluir o e-mail.',
            ]);
        }
    }

    public function exportCsv(): StreamedResponse
    {
        $newsletters = $this->filteredQuery()->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="newsletter-' . now()->format('Y-m-d') . '.csv"',
        ];

        return response()->streamDownload(function () use ($newsletters) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");
            fputcsv($handle, ['Nome', 'E-mail', 'Cidade', 'Instagram', 'WhatsApp', 'Site', 'Categoria', 'Ativo', 'Confirmado', 'Cadastro']);

            foreach ($newsletters as $newsletter) {
                fputcsv($handle, [
                    $newsletter->name,
                    $newsletter->email,
                    $newsletter->city,
                    $newsletter->instagram,
                    $newsletter->whatsapp,
                    $newsletter->site,
                    $newsletter->category?->name ?? '',
                    $newsletter->active ? 'Sim' : 'Não',
                    $newsletter->confirmed_at ? 'Sim' : 'Não',
                    $newsletter->created_at->format('d/m/Y H:i'),
                ]);
            }

            fclose($handle);
        }, null, $headers);
    }

    public function exportXls(): StreamedResponse
    {
        $newsletters = $this->filteredQuery()->get();

        $headers = [
            'Content-Type' => 'application/vnd.ms-excel; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="newsletter-' . now()->format('Y-m-d') . '.xls"',
        ];

        return response()->streamDownload(function () use ($newsletters) {
            echo $this->xlsXml($newsletters);
        }, null, $headers);
    }

    protected function xlsXml($newsletters): string
    {
        $rows = [];
        $rows[] = ['Nome', 'E-mail', 'Cidade', 'Instagram', 'WhatsApp', 'Site', 'Categoria', 'Ativo', 'Confirmado', 'Cadastro'];

        foreach ($newsletters as $newsletter) {
            $rows[] = [
                $newsletter->name ?? '',
                $newsletter->email,
                $newsletter->city ?? '',
                $newsletter->instagram ?? '',
                $newsletter->whatsapp ?? '',
                $newsletter->site ?? '',
                $newsletter->category?->name ?? '',
                $newsletter->active ? 'Sim' : 'Não',
                $newsletter->confirmed_at ? 'Sim' : 'Não',
                $newsletter->created_at->format('d/m/Y H:i'),
            ];
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<?mso-application progid="Excel.Sheet"?>' . "\n";
        $xml .= '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet">';
        $xml .= '<Worksheet ss:Name="Newsletter"><Table>';

        foreach ($rows as $row) {
            $xml .= '<Row>';
            foreach ($row as $cell) {
                $value = htmlspecialchars((string) $cell, ENT_XML1);
                $xml .= '<Cell><Data ss:Type="String">' . $value . '</Data></Cell>';
            }
            $xml .= '</Row>';
        }

        $xml .= '</Table></Worksheet></Workbook>';

        return $xml;
    }

    protected function filteredQuery()
    {
        return Newsletter::query()
            ->with('category')
            ->when($this->search, function ($q) {
                $q->where(function ($q) {
                    $q->where('email', 'like', "%{$this->search}%")
                        ->orWhere('name', 'like', "%{$this->search}%")
                        ->orWhere('city', 'like', "%{$this->search}%")
                        ->orWhere('instagram', 'like', "%{$this->search}%")
                        ->orWhere('whatsapp', 'like', "%{$this->search}%");
                });
            })
            ->when($this->statusFilter !== '', fn ($q) => $q->where('active', $this->statusFilter === 'active'))
            ->when($this->confirmedFilter !== '', fn ($q) => $q->whereNull('confirmed_at', null, $this->confirmedFilter === 'confirmed'))
            ->when($this->categoryFilter !== '', fn ($q) => $q->where('category_id', $this->categoryFilter))
            ->orderBy($this->safeSortField(), $this->safeSortDirection());
    }

    public function render()
    {
        $newsletters = $this->filteredQuery()->paginate(20);

        $metrics = [
            'total' => Newsletter::count(),
            'active' => Newsletter::where('active', true)->count(),
            'inactive' => Newsletter::where('active', false)->count(),
            'confirmed' => Newsletter::whereNotNull('confirmed_at')->count(),
            'unconfirmed' => Newsletter::whereNull('confirmed_at')->count(),
            'today' => Newsletter::whereDate('created_at', today())->count(),
            'month' => Newsletter::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)->count(),
        ];

        $categories = NewsletterCategory::orderBy('name')->get(['id', 'name']);

        return view('livewire.dashboard.newsletter.newsletters', [
            'newsletters' => $newsletters,
            'metrics' => $metrics,
            'categories' => $categories,
        ])->with('title', 'Newsletter');
    }
}
